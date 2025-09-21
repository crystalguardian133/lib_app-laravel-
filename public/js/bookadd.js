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
    
    // Specifically handle the cover file input
    const coverInput = document.getElementById('cover-input');
    if (coverInput && coverInput.files && coverInput.files[0]) {
      console.log('Adding cover file to FormData:', coverInput.files[0].name, 'Size:', coverInput.files[0].size);
      formData.append('cover', coverInput.files[0]);
    } else {
      console.log('No cover file selected');
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
  modal.style.display = 'flex';

  qrScanner = new Html5Qrcode("qr-reader");

  qrScanner.start(
    { facingMode: "environment" },
    { fps: 10, qrbox: 250 },
    async (decodedText) => {
      stopQRScan();

      if (type === 'member') {
        try {
          const res = await fetch(`/api/lookup-member?qr=${encodeURIComponent(decodedText)}`);
          const data = await res.json();
          if (data && data.name) {
            document.getElementById('memberName').value = data.name;
            document.getElementById('memberId').value = data.id;
            showCornerPopup(`Member: ${data.name}`);
          } else {
            showCornerPopup("Member not found");
          }
        } catch (err) {
          showCornerPopup("Error fetching member");
        }
      } else if (type === 'book') {
        const bookCard = document.querySelector(`.book-card[data-qr="${decodedText}"]`);
        if (bookCard) {
          toggleSelection(bookCard);
          showCornerPopup("Book selected via QR");
        } else {
          showCornerPopup("Book not found");
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
  if (qrScanner) {
    qrScanner.stop().then(() => {
      document.getElementById('qrScannerModal').style.display = 'none';
      qrScanner = null;
    }).catch(console.error);
  }
}