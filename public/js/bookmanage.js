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
    const titleField = document.getElementById("edit-title");
    if (titleField) titleField.focus();
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

  // Get cover path from dataset (e.g., "/cover/book-1.png")
  const coverPath = card.dataset.coverImage;

  let coverUrl = null;
  if (coverPath && coverPath.trim() !== '') {
    // Ensure it starts with / and is valid
    coverUrl = coverPath.startsWith('/') ? coverPath : '/' + coverPath;
  }

  return {
    id: card.dataset.id,
    title: card.dataset.title,
    author: card.dataset.author,
    genre: card.querySelector('.book-meta > div:nth-child(2)').textContent.split('•')[0].trim(),
    published_year: card.querySelector('.book-meta > div:nth-child(2)').textContent.split('•')[1].trim(),
    availability: availability,
    cover_image: coverUrl // e.g., "/cover/book-1.png"
  };
}

/**
 * Populates the edit modal with book data
 * @param {Object} bookData - Book information to fill
 */
function fillEditModal(bookData) {
  // Fill form fields
  const titleField = document.getElementById("edit-title");
  const authorField = document.getElementById("edit-author");
  const genreField = document.getElementById("edit-genre");
  const yearField = document.getElementById("edit-published-year");
  const availField = document.getElementById("edit-availability");

  if (titleField) titleField.value = bookData.title || "";
  if (authorField) authorField.value = bookData.author || "";
  if (genreField) genreField.value = bookData.genre || "";
  if (yearField) yearField.value = bookData.published_year || "";
  if (availField) availField.value = bookData.availability || "1";

  // Update cover preview using real URL
  updateCoverPreview(bookData.cover_image);

  // Reset flags
  hasUnsavedChanges = false;

  // Setup change detection
  setupChangeDetection();
}

/**
 * Updates the cover preview in the edit modal
 * @param {string|null} imageUrl - Full path like '/cover/cover-5-12345678.jpg'
 */
function updateCoverPreview(imageUrl) {
  const coverPreview = document.getElementById("cover-preview-content");
  const uploadIcon = document.getElementById("cover-upload-icon");
  const previewText = document.getElementById("cover-preview-text");

  if (!coverPreview) return;

  // Reset all styles
  coverPreview.style.backgroundImage = "";
  coverPreview.style.backgroundSize = "";
  coverPreview.style.backgroundPosition = "";
  coverPreview.style.backgroundRepeat = "";
  coverPreview.style.color = "";
  coverPreview.style.backgroundColor = "#f9fafb";

  if (uploadIcon) uploadIcon.style.opacity = "1";
  if (previewText) {
    previewText.style.opacity = "1";
    previewText.innerHTML = 'Click or drag image here<br><small>Supports JPG, PNG, GIF (max 5MB)</small>';
  }

  // If valid image URL, try to load it
  if (imageUrl && !imageUrl.includes('no-cover') && !imageUrl.endsWith('/cover/null')) {
    const img = new Image();
    img.onload = () => {
      coverPreview.style.backgroundImage = `url(${imageUrl})`;
      coverPreview.style.backgroundSize = "cover";
      coverPreview.style.backgroundPosition = "center";
      coverPreview.style.backgroundRepeat = "no-repeat";
      coverPreview.style.color = "transparent";
      if (uploadIcon) uploadIcon.style.opacity = "0";
      if (previewText) previewText.style.opacity = "0";
    };
    img.onerror = () => {
      console.warn(`Failed to load image: ${imageUrl}, showing placeholder`);
      showPlaceholder();
    };
    img.src = imageUrl + '?t=' + Date.now(); // Cache busting
  } else {
    showPlaceholder();
  }

  function showPlaceholder() {
    coverPreview.style.backgroundImage = `url(/images/no-cover.png)`;
    coverPreview.style.backgroundSize = "contain";
    coverPreview.style.backgroundPosition = "center";
    coverPreview.style.backgroundRepeat = "no-repeat";
    coverPreview.style.backgroundColor = "#f9fafb";
    if (uploadIcon) uploadIcon.style.opacity = "0.6";
    if (previewText) previewText.style.opacity = "0.7";
  }
}

/**
 * Sets up drag & drop functionality for cover image
 */
function setupCoverDragDrop() {
  const coverArea = document.getElementById("cover-preview-area");
  const coverPreview = document.getElementById("cover-preview-content");
  const coverInput = document.getElementById("cover-input");

  if (!coverArea || !coverInput) return;

  // Style the area consistently with Add Book modal
  Object.assign(coverArea.style, {
    height: '200px',
    border: '3px dashed var(--gray-light, #d1d5db)',
    borderRadius: '12px',
    overflow: 'hidden',
    cursor: 'pointer',
    transition: 'all 0.3s ease',
    marginBottom: '1.5rem',
    display: 'block'
  });

  Object.assign(coverPreview.style, {
    display: 'flex',
    flexDirection: 'column',
    alignItems: 'center',
    justifyContent: 'center',
    height: '100%',
    color: 'var(--gray, #6b7280)',
    fontSize: '1rem',
    textAlign: 'center',
    backgroundColor: '#f9fafb',
    transition: 'all 0.3s ease',
    position: 'relative'
  });

  Object.assign(coverInput.style, {
    position: 'absolute',
    opacity: '0',
    width: '100%',
    height: '100%',
    cursor: 'pointer',
    zIndex: '10'
  });

  // Click to open file picker
  coverPreview.addEventListener('click', (e) => {
    e.preventDefault();
    coverInput.click();
  });

  // Prevent default drag behaviors
  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    coverArea.addEventListener(eventName, preventDefaults, false);
    document.body.addEventListener(eventName, preventDefaults, false);
  });

  // Visual feedback
  coverArea.addEventListener('dragenter', () => {
    coverArea.style.transform = 'scale(1.02)';
    coverArea.style.borderColor = 'var(--accent, #0891b2)';
    coverPreview.style.backgroundColor = 'rgba(8, 145, 178, 0.1)';
  });

  coverArea.addEventListener('dragover', () => {
    coverArea.style.borderColor = 'var(--accent, #0891b2)';
    coverPreview.style.backgroundColor = 'rgba(8, 145, 178, 0.1)';
  });

  coverArea.addEventListener('dragleave', () => {
    coverArea.style.transform = '';
    coverArea.style.borderColor = 'var(--gray-light, #d1d5db)';
    coverPreview.style.backgroundColor = '#f9fafb';
  });

  // Handle dropped files
  coverArea.addEventListener('drop', (e) => {
    e.preventDefault();
    const files = e.dataTransfer.files;
    if (files.length > 0) {
      const dt = new DataTransfer();
      dt.items.add(files[0]);
      coverInput.files = dt.files;
      handleCoverSelection({ target: { files } });
    }
  });

  // Handle file input change
  coverInput.addEventListener('change', handleCoverSelection);
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
 * Handles cover image selection
 * @param {Event} event - File selection event
 */
function handleCoverSelection(event) {
  const file = event.target.files?.[0] || event.dataTransfer?.files?.[0];
  if (!file) return;

  console.log('Cover file selected:', file.name, 'Size:', file.size, 'Type:', file.type);

  // Validate type
  if (!['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
    showToast("Please select a valid image (JPG, PNG, or GIF)", "error");
    return;
  }

  // Validate size (max 5MB)
  if (file.size > 5 * 1024 * 1024) {
    showToast("Image must be less than 5MB", "error");
    return;
  }

  const reader = new FileReader();
  reader.onload = function(e) {
    updateCoverPreview(e.target.result); // Show local preview
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
    if (field) {
      field.addEventListener('input', () => {
        hasUnsavedChanges = true;
      });
    }
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
  resetModal();
}

/**
 * Resets the modal to its initial state
 */
function resetModal() {
  const fields = [
    'edit-title',
    'edit-author',
    'edit-genre',
    'edit-published-year',
    'edit-availability',
    'cover-input'
  ];

  fields.forEach(id => {
    const el = document.getElementById(id);
    if (el) el.value = "";
  });

  // Reset availability to default
  const avail = document.getElementById("edit-availability");
  if (avail) avail.value = "1";

  // Reset preview
  updateCoverPreview(null);

  // Reset state
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

  const container = document.getElementById('toast-container') || document.body;
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

  // Append form fields
  formData.append("title", document.getElementById("edit-title").value.trim());
  formData.append("author", document.getElementById("edit-author").value.trim());
  formData.append("genre", document.getElementById("edit-genre").value.trim());
  formData.append("published_year", document.getElementById("edit-published-year").value);
  formData.append("availability", document.getElementById("edit-availability").value);
  formData.append("_method", "PUT"); // Laravel method spoofing

  // Handle cover upload
  const coverInput = document.getElementById("cover-input");
  if (coverInput && coverInput.files && coverInput.files.length > 0) {
    console.log('Uploading new cover:', coverInput.files[0].name);
    formData.append("cover", coverInput.files[0]);
  }

  // Debug log
  console.log('Submitting edit formData:');
  for (let [key, value] of formData.entries()) {
    console.log(`${key}:`, value instanceof File ? `${value.name} (${value.size} bytes)` : value);
  }

  // Loading state
  const saveButton = document.getElementById("save-button");
  const originalText = saveButton.innerHTML;
  saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
  saveButton.disabled = true;

  fetch(`/books/${selectedBookId}`, {
    method: "POST",
    headers: {
      "X-CSRF-TOKEN": token,
      "Accept": "application/json"
      // Don't set Content-Type — let browser set boundary for multipart
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
    console.log('Update successful:', data);
    showToast("✅ Book updated successfully!", "success");
    hasUnsavedChanges = false;
    setTimeout(() => {
      location.reload();
    }, 1000);
  })
  .catch(err => {
    console.error("Save error:", err);
    showToast(`❌ Error: ${err.message}`, "error");
    setTimeout(() => {
      if (saveButton) {
        saveButton.innerHTML = originalText;
        saveButton.disabled = false;
      }
    }, 300);
  });
}

/**
 * Deletes the selected book with confirmation
 */
function deleteBook() {
  if (!selectedBookId) {
    showToast("No book selected.", "error");
    return;
  }

  if (!confirm("Are you sure you want to delete this book? This action cannot be undone.")) {
    return;
  }

  const token = document.querySelector('meta[name="csrf-token"]').content;
  const deleteButton = document.getElementById("delete-button");

  if (!token) {
    showToast("CSRF token missing.", "error");
    return;
  }

  // Loading state
  if (deleteButton) {
    deleteButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
    deleteButton.disabled = true;
  }

  fetch(`/books/${selectedBookId}`, {
    method: "DELETE",
    headers: {
      "X-CSRF-TOKEN": token,
      "Accept": "application/json"
    }
  })
  .then(response => {
    if (!response.ok) throw new Error("Delete failed");
    return response.json();
  })
  .then(data => {
    showToast("🗑️ Book deleted successfully!", "success");
    closeModal();
    setTimeout(() => location.reload(), 800);
  })
  .catch(err => {
    console.error("Delete error:", err);
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

  // Attach delete button click
  const deleteButton = document.getElementById('delete-button');
  if (deleteButton) {
    deleteButton.addEventListener('click', deleteBook);
  }
});