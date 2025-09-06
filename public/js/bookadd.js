document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('addBookForm');

  // === Form Submission: Add Book ===
  form.addEventListener('submit', async function (e) {
    e.preventDefault();

    const formData = new FormData(form);

    try {
      const response = await fetch('/books', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json',
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
  const uploadIcon = document.getElementById('cover-upload-icon');
  const previewText = document.getElementById('cover-preview-text');

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

  function updateCoverPreview(file) {
    if (!file) return;

    if (!file.type.match('image/jpeg') && !file.type.match('image/png')) {
      showCornerPopup('Only JPG and PNG images are allowed.');
      return;
    }

    if (file.size > 5 * 1024 * 1024) {
      showCornerPopup('Image too large! Maximum size is 5MB.');
      return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
      coverPreviewContent.style.backgroundImage = `url(${e.target.result})`;
      coverPreviewContent.style.backgroundSize = 'cover';
      coverPreviewContent.style.backgroundPosition = 'center';
      coverPreviewContent.style.color = 'transparent';
      uploadIcon.style.opacity = '0';
      previewText.style.opacity = '0';
    };
    reader.readAsDataURL(file);
  }

  // Click to open file picker
  coverPreviewContent.addEventListener('click', () => {
    coverInput.click();
  });

  // Handle file selection
  coverInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) updateCoverPreview(file);
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

  coverPreviewArea.addEventListener('drop', (e) => {
    coverPreviewArea.style.transform = '';
    coverPreviewArea.style.boxShadow = '';
    const files = e.dataTransfer.files;
    if (files.length) {
      updateCoverPreview(files[0]);
    }
  });

  // Reset cover preview
  window.resetCoverPreview = function () {
    coverPreviewContent.style.backgroundImage = '';
    coverPreviewContent.style.backgroundColor = '#f9fafb';
    coverPreviewContent.style.color = '';
    uploadIcon.style.opacity = '1';
    previewText.style.opacity = '1';
    previewText.innerHTML = 'Click or drag image here<br><small>Supports JPG, PNG (max 5MB)</small>';
    coverInput.value = '';
    coverPreviewArea.style.borderColor = 'var(--gray-light, #d1d5db)';
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