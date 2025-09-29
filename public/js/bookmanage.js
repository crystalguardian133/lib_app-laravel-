// === GLOBAL STATE ===
let selectedBookId = null;
let hasUnsavedChanges = false;
let originalBookData = null;

// === EXPOSE FUNCTIONS TO GLOBAL SCOPE (Critical for onclick="...") ===
window.manageBooks = manageBooks;
window.saveChanges = saveChanges;
window.deleteBook = deleteBook;
window.closeModal = closeModal;
window.showToast = showToast;
window.openAddBookModal = openAddBookModal;
window.closeAddBookModal = closeAddBookModal;

/**
 * Opens the edit modal with pre-filled book data
 * Only works when exactly one book is selected
 */
function manageBooks() {
  const selectedRows = document.querySelectorAll('tr.selected');

  // Validation
  if (selectedRows.length === 0) {
    showToast("Please select a book first to edit.", "error");
    return;
  }

  if (selectedRows.length > 1) {
    showToast("Please select only one book at a time for editing.", "warning");
    return;
  }

  const row = selectedRows[0];
  selectedBookId = row.dataset.id;

  // Extract data from the table row
  const bookData = extractBookDataFromRow(row);

  // Store original data for unsaved changes check
  originalBookData = { ...bookData };
  hasUnsavedChanges = false;

  // Fill modal with book data
  fillEditModal(bookData);

  // Show the modal
  const modal = document.getElementById("manage-modal");
  if (modal) {
    modal.classList.add('show');
    modal.style.display = 'flex';
  }

  // Auto-focus title field
  setTimeout(() => {
    const titleField = document.getElementById("edit-title");
    if (titleField) titleField.focus();
  }, 300);

  // Setup drag & drop with a small delay to ensure modal is fully rendered
  setTimeout(() => {
    setupCoverDragDrop();
  }, 100);

  // Setup modal event listeners
  setupModalEventListeners();

  // Ensure modal doesn't interfere with drag and drop
  const editModal = document.getElementById('manage-modal');
  if (editModal) {
    editModal.style.pointerEvents = 'auto';
    editModal.style.userSelect = 'text';

    // Make sure the modal backdrop doesn't block events
    const modalBackdrop = editModal.querySelector('.modal');
    if (modalBackdrop) {
      modalBackdrop.style.pointerEvents = 'none';
    }
  }
}

/**
 * Sets up modal event listeners for proper functionality
 */
function setupModalEventListeners() {
  const modal = document.getElementById('manage-modal');
  if (!modal) return;

  // Close modal on backdrop click
  modal.addEventListener('click', (e) => {
    if (e.target === modal) {
      closeModal();
    }
  });

  // Close modal on escape key
  const escapeHandler = (e) => {
    if (e.key === 'Escape' && window.getComputedStyle(modal).display === 'flex') {
      closeModal();
    }
  };

  // Remove any existing listeners to avoid duplicates
  document.removeEventListener('keydown', escapeHandler);
  document.addEventListener('keydown', escapeHandler);

  // Save on Ctrl+S
  const saveHandler = (e) => {
    if (e.ctrlKey && e.key === 's' && window.getComputedStyle(modal).display === 'flex') {
      e.preventDefault();
      saveChanges();
    }
  };

  document.removeEventListener('keydown', saveHandler);
  document.addEventListener('keydown', saveHandler);
}

/**
 * Extracts book data from the card element
 * @param {HTMLElement} card - The selected book card
 * @returns {Object} Book data object
 */
function extractBookDataFromRow(row) {
  // Get availability from the table cell
  const availability = row.dataset.availability || '1';

  // Get cover path from dataset
  const coverPath = row.dataset.coverImage;

  let coverUrl = null;
  if (coverPath && coverPath.trim() !== '') {
    // Ensure it starts with / and is valid
    coverUrl = coverPath.startsWith('/') ? coverPath : '/' + coverPath;
  }

  return {
    id: row.dataset.id,
    title: row.dataset.title,
    author: row.dataset.author,
    genre: row.dataset.genre,
    published_year: row.dataset.publishedYear,
    availability: availability,
    cover_image: coverUrl
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
 * Updates the cover preview in the edit modal - WORKING VERSION from bookadd.js
 * @param {File|string|null} fileOrUrl - File object from input/drag or URL string for existing covers
 */
function updateCoverPreview(fileOrUrl) {
  const coverPreviewContent = document.getElementById("cover-preview-content");
  if (!coverPreviewContent) return;

  // Handle existing cover URL (string)
  if (typeof fileOrUrl === 'string' && fileOrUrl) {
    if (fileOrUrl.includes('no-cover') || fileOrUrl.endsWith('/cover/null')) {
      resetCoverPreview();
      return;
    }

    // Load existing cover image
    const img = new Image();
    img.onload = function() {
      coverPreviewContent.innerHTML = `
        <img src="${fileOrUrl}?t=${Date.now()}" alt="Current Book Cover" style="
          max-width: 100%;
          max-height: 100%;
          width: auto;
          height: auto;
          border-radius: 12px;
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
          object-fit: contain;
        ">
        <p style="
          position: absolute;
          bottom: 10px;
          left: 50%;
          transform: translateX(-50%);
          background: rgba(0, 0, 0, 0.7);
          color: white;
          padding: 4px 8px;
          border-radius: 6px;
          font-size: 0.8rem;
          margin: 0;
          max-width: 90%;
          text-overflow: ellipsis;
          overflow: hidden;
          white-space: nowrap;
        ">Current Cover</p>
      `;

      coverPreviewContent.style.position = 'relative';
      coverPreviewContent.style.backgroundColor = '#f1f5f9';
    };

    img.onerror = function() {
      console.warn(`Failed to load existing cover: ${fileOrUrl}`);
      resetCoverPreview();
    };

    img.src = fileOrUrl;
    return;
  }

  // Handle new file upload (File object)
  const file = fileOrUrl;
  if (!file) {
    resetCoverPreview();
    return;
  }

  // Validate file type
  if (!file.type.match('image/jpeg') && !file.type.match('image/png') && !file.type.match('image/gif')) {
    showToast('Only JPG, PNG, and GIF images are allowed.', 'error');
    return;
  }

  // Validate file size (5MB)
  if (file.size > 5 * 1024 * 1024) {
    showToast('Image too large! Maximum size is 5MB.', 'error');
    return;
  }

  // Read and preview the file
  const reader = new FileReader();
  reader.onload = function (e) {
    coverPreviewContent.innerHTML = `
      <img src="${e.target.result}" alt="Book Cover Preview" style="
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        object-fit: contain;
      ">
      <p style="
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.8rem;
        margin: 0;
        max-width: 90%;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
      ">${file.name}</p>
    `;

    // Update container styles
    coverPreviewContent.style.position = 'relative';
    coverPreviewContent.style.backgroundColor = '#f1f5f9';
  };

  reader.onerror = function() {
    console.error('Error reading file:', file.name);
    showToast('Error reading file. Please try again.', 'error');
    resetCoverPreview();
  };

  reader.readAsDataURL(file);
}

/**
 * Sets up drag & drop functionality for cover image
 */
function setupCoverDragDrop() {
  const coverArea = document.getElementById("cover-preview-area");
  const coverPreview = document.getElementById("cover-preview-content");
  const coverInput = document.getElementById("cover-input");

  console.log('Setting up drag and drop:', { coverArea: !!coverArea, coverPreview: !!coverPreview, coverInput: !!coverInput });

  if (!coverArea || !coverInput) {
    console.warn('Drag and drop setup failed: missing required elements');
    return;
  }

  // Style the area consistently with Add Book modal
  Object.assign(coverArea.style, {
    height: '200px',
    border: '3px dashed var(--gray-light, #d1d5db) !important',
    borderRadius: '12px',
    overflow: 'hidden',
    cursor: 'pointer',
    transition: 'all 0.3s ease',
    marginBottom: '1.5rem',
    display: 'block !important',
    position: 'relative',
    zIndex: '1000',
    // Ensure drag events work properly
    pointerEvents: 'auto !important',
    userSelect: 'none'
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
    position: 'relative',
    cursor: 'pointer',
    userSelect: 'none'
  });

  Object.assign(coverInput.style, {
    position: 'absolute',
    opacity: '0',
    width: '100%',
    height: '100%',
    cursor: 'pointer',
    zIndex: '10'
  });

  // Ensure file input accepts only images
  coverInput.accept = 'image/jpeg,image/jpg,image/png,image/gif';

  // Click to open file picker
  coverPreview.addEventListener('click', (e) => {
    e.preventDefault();
    e.stopPropagation();
    console.log('Cover preview clicked, opening file picker');
    alert('Cover preview clicked! This should open file picker.');
    coverInput.click();
  });

  // Also add click to the cover area itself (fallback)
  coverArea.addEventListener('click', (e) => {
    // Only handle clicks directly on the cover area, not on child elements
    if (e.target === coverArea || e.target === coverPreview) {
      e.preventDefault();
      e.stopPropagation();
      console.log('Cover area clicked, opening file picker');
      alert('Cover area clicked! This should open file picker.');
      coverInput.click();
    }
  });

  // Add debugging for drag events
  coverArea.addEventListener('dragenter', (e) => {
    console.log('Drag entered cover area');
    alert('Drag entered cover area! Drag and drop should work.');
    coverArea.style.transform = 'scale(1.02)';
    coverArea.style.borderColor = 'var(--accent, #0891b2)';
    coverPreview.style.backgroundColor = 'rgba(8, 145, 178, 0.1)';
  });

  coverArea.addEventListener('dragover', (e) => {
    console.log('Dragging over cover area');
    coverArea.style.borderColor = 'var(--accent, #0891b2)';
    coverPreview.style.backgroundColor = 'rgba(8, 145, 178, 0.1)';
  });

  coverArea.addEventListener('dragleave', (e) => {
    console.log('Drag left cover area');
    coverArea.style.transform = '';
    coverArea.style.borderColor = 'var(--gray-light, #d1d5db)';
    coverPreview.style.backgroundColor = '#f9fafb';
  });

  // Prevent default drag behaviors on the modal only (but NOT drop)
  ['dragenter', 'dragover', 'dragleave'].forEach(eventName => {
    coverArea.addEventListener(eventName, preventDefaults, false);
    // Only prevent on modal backdrop, not entire document
    const modal = document.getElementById('manage-modal');
    if (modal) {
      modal.addEventListener(eventName, preventDefaults, false);
    }
  });

  // Add drag and drop event listeners to the document to catch all drag events
  document.addEventListener('dragenter', (e) => {
    if (e.target.closest('#manage-modal')) {
      console.log('Drag entered modal area');
    }
  });

  document.addEventListener('dragover', (e) => {
    if (e.target.closest('#manage-modal')) {
      e.preventDefault();
      console.log('Dragging over modal area');
    }
  });

  // Visual feedback for drag
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

  // Visual feedback for click/hover
  coverPreview.addEventListener('mouseenter', () => {
    if (!coverPreview.style.backgroundImage || coverPreview.style.backgroundImage === 'none') {
      coverPreview.style.backgroundColor = 'rgba(8, 145, 178, 0.05)';
      coverPreview.style.transform = 'scale(1.02)';
    }
  });

  coverPreview.addEventListener('mouseleave', () => {
    if (!coverPreview.style.backgroundImage || coverPreview.style.backgroundImage === 'none') {
      coverPreview.style.backgroundColor = '#f9fafb';
      coverPreview.style.transform = '';
    }
  });

  coverPreview.addEventListener('mousedown', () => {
    coverPreview.style.transform = 'scale(0.98)';
  });

  coverPreview.addEventListener('mouseup', () => {
    coverPreview.style.transform = 'scale(1.02)';
  });

  // Handle dropped files - WORKING VERSION
  coverArea.addEventListener('drop', (e) => {
    console.log('Drop event triggered on cover area');
    const files = e.dataTransfer.files;
    console.log('Dropped files:', files.length, files);

    // Reset visual feedback
    coverArea.style.transform = '';
    coverArea.style.boxShadow = '';
    coverPreview.style.backgroundColor = '#f9fafb';
    coverArea.style.borderColor = 'var(--gray-light, #d1d5db)';

    if (files.length > 0) {
      // Manually set the file to the input element
      const dt = new DataTransfer();
      dt.items.add(files[0]);
      coverInput.files = dt.files;

      console.log('File dropped and set to input:', files[0].name);
      updateCoverPreview(files[0]);

      // Mark as having unsaved changes
      hasUnsavedChanges = true;
    } else {
      console.warn('No files in drop event');
    }
  });

  // Also add drop listener to the document as fallback
  document.addEventListener('drop', (e) => {
    if (e.target.closest('#manage-modal #cover-preview-area')) {
      console.log('Drop event caught by document listener');
      e.preventDefault();
      const files = e.dataTransfer.files;
      console.log('Document drop files:', files.length, files);

      if (files.length > 0) {
        // Manually set the file to the input element
        const dt = new DataTransfer();
        dt.items.add(files[0]);
        coverInput.files = dt.files;

        console.log('File dropped and set to input via document:', files[0].name);
        updateCoverPreview(files[0]);

        // Mark as having unsaved changes
        hasUnsavedChanges = true;
      }
    }
  });

  // Handle file input change
  coverInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
      console.log('File selected:', file.name, 'Size:', file.size, 'Type:', file.type);
      updateCoverPreview(file);

      // Mark as having unsaved changes
      hasUnsavedChanges = true;
    }
  });
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

  const modal = document.getElementById("manage-modal");
  if (modal) {
    modal.classList.remove('show');
    setTimeout(() => {
      modal.style.display = 'none';
    }, 300);
  }
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
function deleteBook(bookId = null) {
  // If no bookId provided, try to get it from selectedBookId or selected rows
  if (!bookId) {
    if (selectedBookId) {
      bookId = selectedBookId;
    } else {
      // Check if there's a selected row
      const selectedRows = document.querySelectorAll('tr.selected');
      if (selectedRows.length === 1) {
        bookId = selectedRows[0].dataset.id;
      } else {
        showToast("No book selected.", "error");
        return;
      }
    }
  }

  const row = document.querySelector(`tr[data-id="${bookId}"]`);
  if (!row) {
    showToast("Book not found.", "error");
    return;
  }

  const bookTitle = row.dataset.title || 'Unknown Book';

  if (!confirm(`Are you sure you want to delete "${bookTitle}"? This action cannot be undone.`)) {
    return;
  }

  const tokenElement = document.querySelector('meta[name="csrf-token"]');
  const token = tokenElement ? tokenElement.content : null;
  const deleteButton = document.getElementById("delete-button");

  console.log('CSRF token element:', tokenElement);
  console.log('CSRF token value:', token);

  if (!token) {
    showToast("CSRF token missing.", "error");
    return;
  }

  // Loading state
  if (deleteButton) {
    deleteButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
    deleteButton.disabled = true;
  }

  console.log(`Attempting to delete book ${bookId} with title "${bookTitle}"`);
  console.log('CSRF token being sent:', token);

  // Test if we can make a basic request first
  fetch('/dashboard', {
    method: 'GET',
    headers: {
      'Accept': 'text/html'
    }
  })
  .then(testResponse => {
    console.log('Basic request test:', testResponse.status, testResponse.ok);
  })
  .catch(testErr => {
    console.error('Basic request failed:', testErr);
  });

  fetch(`/books/${bookId}`, {
    method: "DELETE",
    headers: {
      "X-CSRF-TOKEN": token,
      "Accept": "application/json",
      "Content-Type": "application/json"
    }
  })
  .then(response => {
    console.log('Delete response status:', response.status);
    console.log('Delete response headers:', response.headers);

    if (!response.ok) {
      return response.text().then(text => {
        console.error('Delete failed with response:', text);
        throw new Error(`Delete failed with status ${response.status}: ${text}`);
      });
    }
    return response.json();
  })
  .then(data => {
    console.log('Delete successful:', data);
    showToast(`🗑️ "${bookTitle}" deleted successfully!`, "success");

    // Remove the row from the table
    if (row) {
      row.remove();
    }

    // Clear selection
    selectedBookId = null;
    document.querySelectorAll('tr.selected').forEach(r => r.classList.remove('selected'));

    // Close any open modals
    closeModal();

    // Check if table is empty
    const tbody = document.getElementById('booksTableBody');
    if (tbody && tbody.children.length === 0) {
      tbody.innerHTML = `
        <tr>
          <td colspan="8" class="loading" style="text-align: center; padding: 40px; color: var(--text-muted);">
            <i class="fas fa-book" style="font-size: 3rem; margin-bottom: 15px; display: block;"></i>
            <p>No books found. Add your first book to get started!</p>
            <button class="btn btn-primary" onclick="openAddBookModal()" style="margin-top: 15px;">
              <i class="fas fa-plus"></i> Add Book
            </button>
          </td>
        </tr>
      `;
    }

    setTimeout(() => location.reload(), 800);
  })
  .catch(err => {
    console.error("Delete error:", err);
    showToast(`❌ Error: ${err.message}`, "error");
    if (deleteButton) {
      deleteButton.innerHTML = '<i class="fas fa-trash"></i> Delete';
      deleteButton.disabled = false;
    }
  });
}

// Additional modal functions
function openAddBookModal() {
  const modal = document.getElementById('addBookModal');
  if (modal) {
    modal.style.display = 'flex';
  }
}

function closeAddBookModal() {
  const modal = document.getElementById('addBookModal');
  if (modal) {
    modal.style.display = 'none';
    document.getElementById('addBookForm').reset();
  }
}

function closeDeleteModal() {
  const modal = document.getElementById('deleteModal');
  if (modal) {
    modal.style.display = 'none';
  }
}

function confirmDelete() {
  const modal = document.getElementById('deleteModal');
  if (modal) {
    modal.style.display = 'none';
  }
  // The actual delete logic is handled by the deleteBook function
}

// === Initialize when DOM is ready ===
document.addEventListener('DOMContentLoaded', () => {
  // Attach edit button click
  const editButton = document.getElementById('editButton');
  if (editButton) {
    editButton.addEventListener('click', manageBooks);
  }

  // Attach delete button click
  const deleteButton = document.getElementById('delete-button');
  if (deleteButton) {
    deleteButton.addEventListener('click', deleteBook);
  }

  // Modal event listeners are now set up dynamically when the modal opens
});

/**
 * Resets the cover preview to initial state - WORKING VERSION from bookadd.js
 */
window.resetCoverPreview = function() {
  const coverPreviewContent = document.getElementById("cover-preview-content");
  const coverInput = document.getElementById("cover-input");
  const coverPreviewArea = document.getElementById("cover-preview-area");

  if (coverPreviewContent) {
    // Reset the innerHTML completely
    coverPreviewContent.innerHTML = `
      <i id="cover-upload-icon" class="fas fa-cloud-upload-alt" style="font-size: 2.5rem; color: var(--text-muted, #6b7280); margin-bottom: 12px;"></i>
      <p id="cover-preview-text" style="color: var(--text-muted, #6b7280); margin: 0; font-weight: 500; font-size: 1.1rem;">
        Click or drag image here...
      </p>
      <small style="color: var(--text-muted, #6b7280); margin-top: 8px; display: block;">
        Supports JPG, PNG, GIF (max 5MB)
      </small>
    `;

    // Reset styles
    coverPreviewContent.style.backgroundColor = '#f9fafb';
    coverPreviewContent.style.position = '';
  }

  if (coverInput) {
    coverInput.value = '';
  }

  if (coverPreviewArea) {
    coverPreviewArea.style.borderColor = 'var(--gray-light, #d1d5db)';
    coverPreviewArea.style.borderStyle = 'dashed';
    coverPreviewArea.style.transform = '';
    coverPreviewArea.style.boxShadow = '';
  }
};