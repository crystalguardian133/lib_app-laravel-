// === GLOBAL STATE ===
let selectedBookId = null;
let hasUnsavedChanges = false;
let originalBookData = null;

// === EXPOSE FUNCTIONS TO GLOBAL SCOPE (Critical for onclick="...") ===
window.manageBooks = manageBooks;
window.saveChanges = saveChanges;
window.deleteBook = deleteBook;
window.closeModal = closeModal;

/**
 * Opens the edit modal with pre-filled book data
 * Only works when exactly one book is selected
 */
function manageBooks() {
  const selectedCards = document.querySelectorAll('.book-card.selected');
  
  // Validation
  if (selectedCards.length === 0) {
    showToast("Please select a book first to edit.", "error");
    return;
  }
  
  if (selectedCards.length > 1) {
    showToast("Please select only one book at a time for editing.", "warning");
    return;
  }

  const card = selectedCards[0];
  selectedBookId = card.dataset.id;
  
  // Extract data from the card
  const bookData = extractBookData(card);
  
  // Store original data for unsaved changes check
  originalBookData = { ...bookData };
  hasUnsavedChanges = false;
  
  // Fill modal with book data
  fillEditModal(bookData);
  
  // Show the modal
  document.getElementById("manage-modal").style.display = "flex";
  
  // Auto-focus title field
  setTimeout(() => {
    document.getElementById("edit-title").focus();
  }, 300);
  
  // Setup drag & drop
  setupCoverDragDrop();
}

/**
 * Extracts book data from the card element
 * @param {HTMLElement} card - The selected book card
 * @returns {Object} Book data object
 */
function extractBookData(card) {
  // Parse availability (convert "Yes" to 1, "No" to 0)
  const availabilityText = card.querySelector('.book-meta > div:nth-child(3)').textContent.split(':')[1].trim();
  const availability = availabilityText.toLowerCase() === 'yes' ? '1' : '0';
  
  return {
    id: card.dataset.id,
    title: card.dataset.title,
    author: card.dataset.author,
    genre: card.querySelector('.book-meta > div:nth-child(2)').textContent.split('•')[0].trim(),
    published_year: card.querySelector('.book-meta > div:nth-child(2)').textContent.split('•')[1].trim(),
    availability: availability,
    cover_image: card.querySelector('.book-cover')?.src || '/images/no-cover.png'
  };
}

/**
 * Populates the edit modal with book data
 * @param {Object} bookData - Book information to fill
 */
function fillEditModal(bookData) {
  // Fill form fields
  document.getElementById("edit-title").value = bookData.title;
  document.getElementById("edit-author").value = bookData.author;
  document.getElementById("edit-genre").value = bookData.genre;
  document.getElementById("edit-published-year").value = bookData.published_year;
  document.getElementById("edit-availability").value = bookData.availability;
  
  // Update cover preview
  updateCoverPreview(bookData.cover_image);
  
  // Reset unsaved changes flag
  hasUnsavedChanges = false;
  
  // Setup change detection
  setupChangeDetection();
}

/**
 * Updates the cover preview in the edit modal
 * @param {string} imageUrl - URL of the cover image
 */
function updateCoverPreview(imageUrl) {
  const coverPreview = document.getElementById("cover-preview-content");
  const uploadIcon = document.getElementById("cover-upload-icon");
  const previewText = document.getElementById("cover-preview-text");
  
  // Reset styles first
  coverPreview.style.backgroundImage = "none";
  coverPreview.style.color = "";
  uploadIcon.style.display = "block";
  previewText.style.color = "var(--gray)";
  
  // Set new image if available
  if (imageUrl && imageUrl !== '/images/no-cover.png') {
    coverPreview.style.backgroundImage = `url(${imageUrl})`;
    coverPreview.style.backgroundSize = "cover";
    coverPreview.style.backgroundPosition = "center";
    uploadIcon.style.display = "none";
    previewText.textContent = "Click or drag to change image";
    previewText.style.color = "rgba(255, 255, 255, 0.85)";
    const small = previewText.querySelector('small');
    if (small) small.remove();
  }
}

/**
 * Sets up drag & drop functionality for cover image
 */
function setupCoverDragDrop() {
  const coverArea = document.getElementById("cover-preview-area");
  const coverInput = document.getElementById("cover-input");
  
  // Prevent default drag behaviors
  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    coverArea.addEventListener(eventName, preventDefaults, false);
    document.body.addEventListener(eventName, preventDefaults, false);
  });
  
  // Highlight drop area when item is dragged over it
  ['dragenter', 'dragover'].forEach(eventName => {
    coverArea.addEventListener(eventName, highlight, false);
  });
  
  ['dragleave', 'drop'].forEach(eventName => {
    coverArea.addEventListener(eventName, unhighlight, false);
  });
  
  // Handle dropped files
  coverArea.addEventListener('drop', handleDrop, false);
  
  // Handle file input change
  coverInput.addEventListener('change', handleCoverSelection, false);
}

/**
 * Prevents default drag behaviors
 * @param {Event} e - Drag event
 */
function preventDefaults(e) {
  e.preventDefault();
  e.stopPropagation();
}

/**
 * Highlights the drop area
 */
function highlight() {
  document.getElementById("cover-preview-area").classList.add('drag-over');
}

/**
 * Removes highlight from drop area
 */
function unhighlight() {
  document.getElementById("cover-preview-area").classList.remove('drag-over');
}

/**
 * Handles file drop event
 * @param {Event} e - Drop event
 */
function handleDrop(e) {
  const dt = e.dataTransfer;
  const files = dt.files;
  
  if (files.length) {
    handleCoverSelection(e);
  }
}

/**
 * Handles cover image selection
 * @param {Event} event - File selection event
 */
function handleCoverSelection(event) {
  const file = event.target.files?.[0] || event.dataTransfer.files?.[0];
  
  if (!file) return;
  
  // Validate file type
  if (!file.type.match('image.*')) {
    showToast("Please select an image file (JPG, PNG, etc.)", "error");
    return;
  }
  
  // Validate file size (max 5MB)
  if (file.size > 5 * 1024 * 1024) {
    showToast("Image size must be less than 5MB", "error");
    return;
  }
  
  const reader = new FileReader();
  
  reader.onload = function(e) {
    updateCoverPreview(e.target.result);
    hasUnsavedChanges = true;
  };
  
  reader.readAsDataURL(file);
}

/**
 * Sets up change detection for unsaved changes warning
 */
function setupChangeDetection() {
  const formFields = [
    'edit-title',
    'edit-author',
    'edit-genre',
    'edit-published-year',
    'edit-availability'
  ];
  
  formFields.forEach(fieldId => {
    const field = document.getElementById(fieldId);
    field.addEventListener('input', () => {
      hasUnsavedChanges = true;
    });
  });
}

/**
 * Closes the edit modal with unsaved changes check
 */
function closeModal() {
  if (hasUnsavedChanges) {
    const confirmClose = confirm("You have unsaved changes. Are you sure you want to close?");
    if (!confirmClose) return;
  }
  
  document.getElementById("manage-modal").style.display = "none";
  
  // Reset form and flags
  resetModal();
}

/**
 * Resets the modal to its initial state
 */
function resetModal() {
  // Clear form fields
  document.getElementById("edit-title").value = "";
  document.getElementById("edit-author").value = "";
  document.getElementById("edit-genre").value = "";
  document.getElementById("edit-published-year").value = "";
  document.getElementById("edit-availability").value = "1";
  document.getElementById("cover-input").value = "";
  
  // Reset cover preview
  updateCoverPreview(null);
  
  // Reset flags
  hasUnsavedChanges = false;
  selectedBookId = null;
  originalBookData = null;
}

/**
 * Shows a toast notification
 * @param {string} message - Message to display
 * @param {string} type - Type of toast (info, success, warning, error)
 */
function showToast(message, type = "info") {
  const toast = document.createElement('div');
  toast.className = `toast toast-${type}`;
  toast.innerHTML = `
    <div style="display: flex; align-items: center; gap: 8px;">
      ${type === 'success' ? '<i class="fas fa-check-circle"></i>' : 
        type === 'error' ? '<i class="fas fa-exclamation-circle"></i>' :
        type === 'warning' ? '<i class="fas fa-exclamation-triangle"></i>' : 
        '<i class="fas fa-info-circle"></i>'}
      <span>${message}</span>
    </div>
  `;
  
  const container = document.getElementById('toast-container');
  if (container) {
    container.appendChild(toast);
    
    // Auto-remove after delay
    setTimeout(() => {
      toast.classList.add('toast-hide');
      setTimeout(() => {
        if (container.contains(toast)) {
          container.removeChild(toast);
        }
      }, 500);
    }, 3000);
  }
}

/**
 * Saves edited book information with loading state
 */
function saveChanges() {
  if (!selectedBookId) {
    showToast("No book selected for editing.", "error");
    return;
  }

  const token = document.querySelector('meta[name="csrf-token"]').content;
  const formData = new FormData();
  
  // Get form values
  formData.append("title", document.getElementById("edit-title").value.trim());
  formData.append("author", document.getElementById("edit-author").value.trim());
  formData.append("genre", document.getElementById("edit-genre").value.trim());
  formData.append("published_year", document.getElementById("edit-published-year").value);
  formData.append("availability", document.getElementById("edit-availability").value);
  formData.append("_method", "PUT"); // Laravel method spoofing
  
  // Handle cover image if uploaded
  const coverInput = document.getElementById("cover-input");
  if (coverInput.files.length > 0) {
    formData.append("cover", coverInput.files[0]);
  }

  // Show loading state
  const saveButton = document.getElementById("save-button");
  const originalText = saveButton.innerHTML;
  saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
  saveButton.disabled = true;

  fetch(`/books/${selectedBookId}`, {
    method: "POST",
    headers: {
      "X-CSRF-TOKEN": token
    },
    body: formData
  })
  .then(response => {
    if (!response.ok) {
      return response.json().then(err => { 
        throw new Error(err.message || "Failed to save changes.");
      });
    }
    return response.json();
  })
  .then(data => {
    showToast("✅ Book updated successfully!", "success");
    hasUnsavedChanges = false;
    setTimeout(() => {
      location.reload();
    }, 1000);
  })
  .catch(err => {
    console.error("Save error:", err);
    showToast(`❌ Error: ${err.message}`, "error");
    
    // Restore button state
    setTimeout(() => {
      saveButton.innerHTML = originalText;
      saveButton.disabled = false;
    }, 300);
  });
}

/**
 * Deletes the selected book with confirmation
 */
function deleteBook() {
  console.log("✅ deleteBook() called");

  if (!selectedBookId) {
    console.error("❌ selectedBookId is missing:", selectedBookId);
    showToast("No book selected.", "error");
    return;
  }
  console.log("🟢 selectedBookId =", selectedBookId);

  const tokenMeta = document.querySelector('meta[name="csrf-token"]');
  console.log("🔍 Found meta tag:", tokenMeta);
  
  if (!tokenMeta) {
    console.error("❌ CSRF meta tag not found! Add: <meta name='csrf-token' content='{{ csrf_token() }}'>");
    showToast("Security error: token missing.", "error");
    return;
  }

  const token = tokenMeta.content;
  console.log("🔐 CSRF Token =", token);
  if (!token) {
    console.error("❌ CSRF token is empty!");
    showToast("CSRF token is empty.", "error");
    return;
  }

  const deleteButton = document.getElementById("delete-button");
  console.log("🖱️ Delete button:", deleteButton);
  if (deleteButton) {
    const original = deleteButton.innerHTML;
    deleteButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
    deleteButton.disabled = true;
  }

  // ✅ If you see all logs above → we should see fetch
  console.log("🚀 About to fetch DELETE request...");

  fetch(`/books/${selectedBookId}`, {
    method: "DELETE",
    headers: {
      "X-CSRF-TOKEN": token,
      "Accept": "application/json"
    }
  })
  .then(response => {
    console.log("📬 Response received:", response);
    if (!response.ok) throw new Error("Delete failed");
    return response.json();
  })
  .then(data => {
    console.log("✅ Success:", data);
    showToast("Deleted!", "success");
    closeModal();
    setTimeout(() => location.reload(), 800);
  })
  .catch(err => {
    console.error("🔥 Final error:", err);
    showToast(`Error: ${err.message}`, "error");
    if (deleteButton) {
      deleteButton.innerHTML = '<i class="fas fa-trash"></i> Delete';
      deleteButton.disabled = false;
    }
  });
}
// === Initialize when DOM is ready ===
document.addEventListener('DOMContentLoaded', () => {
  // Attach edit button click
  const editButton = document.getElementById('editButton');
  if (editButton) {
    editButton.addEventListener('click', manageBooks);
  }

  // Close modal on backdrop click
  const modal = document.getElementById('manage-modal');
  if (modal) {
    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        closeModal();
      }
    });
  }
  
  // Keyboard shortcuts
  document.addEventListener('keydown', (e) => {
    // ESC to close
    if (e.key === 'Escape' && modal && window.getComputedStyle(modal).display === 'flex') {
      closeModal();
    }
    
    // CTRL + S to save
    if (e.ctrlKey && e.key === 's' && modal && window.getComputedStyle(modal).display === 'flex') {
      e.preventDefault();
      saveChanges();
    }
  });
});