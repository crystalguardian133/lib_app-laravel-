document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('addBookForm');

  // === Form Submission: Add Book ===
  form.addEventListener('submit', async function (e) {
    e.preventDefault();

    // Create FormData and manually append all fields including file
    const formData = new FormData();
    
    // Add all regular form fields
    const formElements = form.elements;
    for (let i = 0; i < formElements.length; i++) {
      const element = formElements[i];
      
      if (element.name && element.type !== 'file') {
        formData.append(element.name, element.value);
      }
    }
    
    // Handle cover image - check for media picker selection or file input
    const coverInput = document.getElementById('cover-input');

    if (window.selectedCoverImage) {
      // Use selected image from media picker
      console.log('Using selected cover image from media picker:', window.selectedCoverImage);
      formData.append('cover_image_url', window.selectedCoverImage);
    } else if (window.uploadedMediaFile) {
      // Use uploaded file from media picker
      console.log('Using uploaded file from media picker:', window.uploadedMediaFile.name);
      formData.append('cover', window.uploadedMediaFile);
    } else if (coverInput && coverInput.files && coverInput.files[0]) {
      // Fallback to direct file input
      console.log('Using direct file input:', coverInput.files[0].name, 'Size:', coverInput.files[0].size);
      formData.append('cover', coverInput.files[0]);
    } else {
      console.log('No cover image selected');
    }

    // Debug: Log all FormData entries
    console.log('FormData contents:');
    for (let [key, value] of formData.entries()) {
      if (value instanceof File) {
        console.log(`${key}: [File] ${value.name} (${value.size} bytes)`);
      } else {
        console.log(`${key}: ${value}`);
      }
    }

    try {
      const response = await fetch('/books', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json',
          // Note: Don't set Content-Type header when sending FormData with files
        },
        body: formData,
      });

      if (!response.ok) {
        const errorText = await response.text();
        console.error('Error Response:', errorText);
        showCornerPopup('Failed to add book. Check the console for details.');
        return;
      }

      const result = await response.json();
      showCornerPopup(result.message || 'Book added successfully!');
      closeAddBookModal();
      form.reset();
      resetCoverPreview(); // Clear preview after submit

      setTimeout(() => location.reload(), 1000);
    } catch (error) {
      console.error('Error:', error);
      showCornerPopup('Error occurred while adding book.');
    }
  });

  // === Cover Preview: Giant Drag & Drop Rectangle ===
  const coverPreviewArea = document.getElementById('cover-preview-area');
  const coverInput = document.getElementById('cover-input');
  const coverPreviewContent = document.getElementById('cover-preview-content');

  // Make it a giant rectangle
  Object.assign(coverPreviewArea.style, {
    height: '250px',
    border: '3px dashed var(--gray-light, #d1d5db)',
    borderRadius: '16px',
    overflow: 'hidden',
    cursor: 'pointer',
    transition: 'all 0.3s ease',
    marginTop: '1rem',
    marginBottom: '1.5rem',
  });

  Object.assign(coverPreviewContent.style, {
    display: 'flex',
    flexDirection: 'column',
    alignItems: 'center',
    justifyContent: 'center',
    height: '100%',
    color: 'var(--gray, #6b7280)',
    fontSize: '1rem',
    textAlign: 'center',
    backgroundColor: '#f9fafb',
    transition: 'background-color 0.3s ease',
  });

  // FIXED: Complete content replacement instead of background image overlay
  function updateCoverPreview(file) {
    if (!file) return;

    if (!file.type.match('image/jpeg') && !file.type.match('image/png') && !file.type.match('image/gif')) {
      showCornerPopup('Only JPG, PNG, and GIF images are allowed.');
      return;
    }

    if (file.size > 5 * 1024 * 1024) {
      showCornerPopup('Image too large! Maximum size is 5MB.');
      return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
      // FIXED: Completely replace the content instead of using background image
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
      
      // Update the container styles
      coverPreviewContent.style.position = 'relative';
      coverPreviewContent.style.backgroundColor = '#f1f5f9';
      coverPreviewArea.style.borderColor = 'var(--primary, #2fb9eb)';
      coverPreviewArea.style.borderStyle = 'solid';
    };
    reader.readAsDataURL(file);
  }

  // Click to open file picker
  coverPreviewContent.addEventListener('click', () => {
    coverInput.click();
  });

  // Handle file selection - FIXED VERSION
  coverInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
      console.log('File selected:', file.name, 'Size:', file.size, 'Type:', file.type);
      updateCoverPreview(file);
      
      // Verify the file is still in the input after preview update
      setTimeout(() => {
        if (coverInput.files && coverInput.files[0]) {
          console.log('File confirmed in input:', coverInput.files[0].name);
        } else {
          console.log('WARNING: File not found in input after preview update');
        }
      }, 100);
    }
  });

  // Prevent default drag behaviors
  function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
  }

  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    coverPreviewArea.addEventListener(eventName, preventDefaults, false);
    document.body.addEventListener(eventName, preventDefaults, false);
  });

  // Visual feedback on drag over
  coverPreviewArea.addEventListener('dragenter', () => {
    coverPreviewArea.style.transform = 'scale(1.02)';
    coverPreviewArea.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
  });

  coverPreviewArea.addEventListener('dragover', () => {
    coverPreviewContent.style.backgroundColor = 'rgba(8, 145, 178, 0.1)';
    coverPreviewArea.style.borderColor = 'var(--accent, #0891b2)';
  });

  coverPreviewArea.addEventListener('dragleave', () => {
    coverPreviewArea.style.transform = '';
    coverPreviewArea.style.boxShadow = '';
    coverPreviewContent.style.backgroundColor = '#f9fafb';
    coverPreviewArea.style.borderColor = 'var(--gray-light, #d1d5db)';
  });

  // Fixed drag and drop handler
  coverPreviewArea.addEventListener('drop', (e) => {
    coverPreviewArea.style.transform = '';
    coverPreviewArea.style.boxShadow = '';
    coverPreviewContent.style.backgroundColor = '#f9fafb';
    coverPreviewArea.style.borderColor = 'var(--gray-light, #d1d5db)';
    
    const files = e.dataTransfer.files;
    if (files.length) {
      // Manually set the file to the input element
      const dt = new DataTransfer();
      dt.items.add(files[0]);
      coverInput.files = dt.files;
      
      console.log('File dropped and set to input:', files[0].name);
      updateCoverPreview(files[0]);
    }
  });

  // FIXED: Reset cover preview with complete content replacement
  window.resetCoverPreview = function () {
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
    coverInput.value = '';

    // Clear media picker selections
    window.selectedCoverImage = null;
    window.uploadedMediaFile = null;

    coverPreviewArea.style.borderColor = 'var(--gray-light, #d1d5db)';
    coverPreviewArea.style.borderStyle = 'dashed';
    coverPreviewArea.style.transform = '';
    coverPreviewArea.style.boxShadow = '';
  };
});

// === Modal Controls ===
function openAddBookModal() {
  const modal = document.getElementById('addBookModal');
  if (modal) {
    modal.style.display = 'flex';
    modal.classList.add('show');
    // Optional: reset form and preview
    document.getElementById('addBookForm').reset();
    if (typeof resetCoverPreview === 'function') resetCoverPreview();
  }
}

function closeAddBookModal() {
  const modal = document.getElementById('addBookModal');
  if (modal) {
    modal.style.display = 'none';
    modal.classList.remove('show');
  }
}

// === Toast Notifications ===
function showCornerPopup(message) {
  let popup = document.getElementById('corner-popup');
  if (!popup) {
    popup = document.createElement('div');
    popup.id = 'corner-popup';
    popup.className = 'corner-popup';
    Object.assign(popup.style, {
      position: 'fixed',
      bottom: '20px',
      right: '20px',
      background: '#333',
      color: '#fff',
      padding: '10px 15px',
      borderRadius: '8px',
      zIndex: '9999',
      boxShadow: '0 4px 12px rgba(0,0,0,0.2)',
      fontSize: '0.9rem',
      maxWidth: '300px',
      textAlign: 'center',
    });
    document.body.appendChild(popup);
  }
  popup.innerText = message;
  popup.style.display = 'block';
  setTimeout(() => {
    popup.style.display = 'none';
  }, 3000);
}

// === QR Scanner ===
let qrScanner;

function startQRScan(type) {
  const modal = document.getElementById('qrScannerModal');
  if (modal) {
    modal.classList.add('show');
    modal.style.display = 'flex';
  }

  qrScanner = new Html5Qrcode("qr-reader");

  qrScanner.start(
    { facingMode: "environment" },
    { fps: 10, qrbox: 250 },
    async (decodedText) => {
      console.log('🎯 QR Code detected:', decodedText);
      console.log('🔄 Stopping scanner and closing modal...');

      // Stop scanner first
      if (qrScanner) {
        try {
          await qrScanner.stop();
          console.log('✅ Scanner stopped');
        } catch (err) {
          console.error('❌ Error stopping scanner:', err);
        }
      }

      // Close modal immediately
      const modal = document.getElementById('qrScannerModal');
      if (modal) {
        modal.classList.remove('show');
        modal.style.display = 'none';
        console.log('✅ qrScannerModal closed');
      } else {
        console.error('❌ qrScannerModal element not found');
      }

      // Reset scanner instance
      qrScanner = null;

      if (type === 'member') {
        try {
          // Extract member ID from QR code URL (e.g., http://localhost:8000/members/1)
          let memberId = null;
          try {
            const url = new URL(decodedText);
            const parts = url.pathname.split('/');
            if (parts[1] === 'members' && parts[2]) {
              memberId = parts[2];
            }
          } catch {
            memberId = decodedText.split('/').pop();
          }

          if (!memberId || isNaN(memberId)) {
            showCornerPopup("Invalid member QR code format");
            return;
          }

          console.log('📋 Extracted member ID:', memberId);

          // Use the existing web route /members/{id}
          const res = await fetch(`/members/${memberId}`);
          const member = await res.json();

          if (member && member.id) {
            // Build full name from member data
            const nameParts = [
              member.first_name,
              (member.middle_name && member.middle_name !== 'null') ? member.middle_name : null,
              (member.last_name && member.last_name !== 'null') ? member.last_name : null
            ].filter(Boolean);

            const fullName = nameParts.join(' ');

            document.getElementById('memberName').value = fullName;
            document.getElementById('memberId').value = member.id;
            showCornerPopup(`✅ Member: ${fullName}`);

            // Close QR scanner modal immediately after successful scan
            stopQRScan();
          } else {
            showCornerPopup("❌ Member not found");
          }
        } catch (err) {
          console.error('Error fetching member:', err);
          showCornerPopup("❌ Error fetching member");
        }
      } else if (type === 'book') {
        try {
          // Extract book ID from QR code URL (e.g., http://localhost:8000/books/1)
          let bookId = null;
          try {
            const url = new URL(decodedText);
            const parts = url.pathname.split('/');
            if (parts[1] === 'books' && parts[2]) {
              bookId = parts[2];
            }
          } catch {
            // Handle different QR code formats
            const match = decodedText.match(/book-(\d+)/);
            if (match) {
              bookId = match[1];
            } else {
              bookId = decodedText.split('/').pop();
            }
          }

          if (!bookId || isNaN(bookId)) {
            showCornerPopup("❌ Invalid book QR code format");
            return;
          }

          console.log('📚 Extracted book ID:', bookId);

          // Find the book row in the table
          const bookRow = document.querySelector(`tr[data-id="${bookId}"]`);
          if (!bookRow) {
            showCornerPopup("❌ Book not found in library");
            return;
          }

          // Check if book is already selected (prevent duplication)
          const existingSelection = document.querySelector(`#selectedBooksList li[data-id="${bookId}"]`);
          if (existingSelection) {
            showCornerPopup("⚠️ Book already selected");
            stopQRScan();
            return;
          }

          // Check book availability
          const availability = parseInt(bookRow.dataset.availability);
          if (isNaN(availability) || availability <= 0) {
            showCornerPopup("❌ Book is not available");
            return;
          }

          // Get book title
          const bookTitle = bookRow.dataset.title || 'Unknown Title';

          // Add book to selection visually
          const selectedBooksList = document.getElementById('selectedBooksList');
          if (selectedBooksList) {
            const li = document.createElement('li');
            li.textContent = bookTitle;
            li.setAttribute('data-id', bookId);
            li.style.cssText = 'padding: 8px 0; border-bottom: 1px solid var(--border-light); display: flex; justify-content: space-between; align-items: center;';

            const removeBtn = document.createElement('button');
            removeBtn.innerHTML = '<i class="fas fa-times"></i>';
            removeBtn.className = 'btn btn-sm btn-danger';
            removeBtn.style.cssText = 'margin-left: 10px; padding: 4px 8px;';
            removeBtn.onclick = () => {
              li.remove();
              bookRow.classList.remove('selected');
              updateConfirmButtonState();
            };

            li.appendChild(removeBtn);
            selectedBooksList.appendChild(li);
          }

          // Mark book as selected in the table
          bookRow.classList.add('selected');

          showCornerPopup(`✅ Added: ${bookTitle}`);

          // Update confirm button state
          updateConfirmButtonState();

          // Close QR scanner modal immediately after successful scan
          stopQRScan();

        } catch (err) {
          console.error('Error processing book QR:', err);
          showCornerPopup("❌ Error processing book");
        }
      }
    },
    error => {
      // Ignore minor scan errors
    }
  ).catch(err => {
    console.error("QR Scanner failed:", err);
    showCornerPopup("Failed to start camera.");
    stopQRScan();
  });
}

function stopQRScan() {
  console.log('🛑 Stopping QR scanner...');

  // First, immediately close the modal
  const modal = document.getElementById('qrScannerModal');
  if (modal) {
    modal.classList.remove('show');
    modal.style.display = 'none';
    console.log('✅ qrScannerModal closed immediately');
  } else {
    console.error('❌ qrScannerModal element not found');
  }

  // Then try to stop the scanner instance if it exists
  if (qrScanner) {
    qrScanner.stop().then(() => {
      console.log('✅ QR Scanner stopped successfully');
      qrScanner = null;
    }).catch(err => {
      console.error('❌ Error stopping QR scanner:', err);
      qrScanner = null;
    });
  } else {
    console.log('ℹ️ No QR scanner instance to stop');
  }
}

// Update confirm button state for borrow modal
function updateConfirmButtonState() {
  const memberName = document.getElementById('memberName');
  const confirmBtn = document.getElementById('confirmBorrowBtn');
  const selectedBooksList = document.getElementById('selectedBooksList');

  if (memberName && confirmBtn && selectedBooksList) {
    const hasMember = memberName.value.trim() !== '';
    const hasBooks = selectedBooksList.children.length > 0;

    confirmBtn.disabled = !hasMember || !hasBooks;

    if (!hasMember) {
      confirmBtn.innerHTML = '<i class="fas fa-user"></i> Select Member First';
    } else if (!hasBooks) {
      confirmBtn.innerHTML = '<i class="fas fa-book"></i> Add Books to Borrow';
    } else {
      confirmBtn.innerHTML = '<i class="fas fa-check"></i> Confirm Borrow';
    }
  }
}