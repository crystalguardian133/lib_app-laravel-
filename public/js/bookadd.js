document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('addBookForm');

  // === Form Submission: Add Book ===
  form.addEventListener('submit', async function (e) {
    e.preventDefault();

    // Client-side validation for required fields
    const requiredFields = ['title', 'author', 'published_year', 'availability'];
    let allFilled = true;

    for (const fieldName of requiredFields) {
      const field = form.querySelector(`[name="${fieldName}"]`);
      if (!field || !field.value.trim()) {
        allFilled = false;
        break;
      }
    }

    if (!allFilled) {
      showCornerPopup('Please fill in all required fields.');
      return;
    }

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

    // Debug: Check all possible sources
    console.log('=== COVER IMAGE DEBUG ===');
    console.log('window.selectedCoverImage:', window.selectedCoverImage);
    console.log('window.uploadedMediaFile:', window.uploadedMediaFile);
    console.log('window.selectedTempImage:', window.selectedTempImage);
    console.log('coverInput exists:', !!coverInput);
    console.log('coverInput.files:', coverInput?.files);
    if (coverInput?.files[0]) {
      console.log('coverInput file:', coverInput.files[0].name, 'Size:', coverInput.files[0].size);
    }

    // Priority order: 1. Temp image (from media picker), 2. File input (from media picker selection), 3. Uploaded file, 4. Selected URL, 5. Preview image
    if (window.selectedTempImage) {
        // Use temp uploaded image from media picker
        console.log('Using temp uploaded image from media picker:', window.selectedTempImage.name, 'Temp name:', window.selectedTempImage.temp_name);
        formData.append('temp_image', JSON.stringify(window.selectedTempImage));
        console.log('✅ Using temp uploaded image');
    } else if (coverInput && coverInput.files && coverInput.files[0]) {
        // Use file from input (set by media picker selection)
        console.log('Using file from input (media picker):', coverInput.files[0].name, 'Size:', coverInput.files[0].size);
        formData.append('cover', coverInput.files[0]);
        console.log('✅ Using file from input');
    } else if (window.uploadedMediaFile) {
        // Use uploaded file from media picker
        console.log('Using uploaded file from media picker:', window.uploadedMediaFile.name, 'Size:', window.uploadedMediaFile.size);
        formData.append('cover', window.uploadedMediaFile);
        console.log('✅ Using uploaded media file');
    } else if (window.selectedCoverImage) {
        // Fallback: convert selected URL to file (only if no file in input)
        console.log('Using selected cover image from media picker:', window.selectedCoverImage);

        try {
            // Fetch the image and convert to File object for proper upload
            const response = await fetch(window.selectedCoverImage);
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            const blob = await response.blob();
            const fileName = window.selectedCoverImage.split('/').pop() || 'cover-image.jpg';
            const file = new File([blob], fileName, { type: blob.type });
            formData.append('cover', file);
            console.log('✅ Successfully converted media picker URL to File object:', fileName, 'Size:', file.size, 'Type:', file.type);
        } catch (error) {
            console.error('❌ Error converting media picker URL to File:', error);
            showCornerPopup('Error processing selected cover image: ' + error.message);
            return;
        }
    } else {
        console.log('⚠️ No cover image selected or available');

        // Additional check: try to get file from preview area data attribute
        const previewImg = document.querySelector('#cover-preview-content img');
        if (previewImg && previewImg.src) {
            console.log('Found preview image, attempting to use it');
            try {
                // If preview exists, try to fetch it and create a file
                const response = await fetch(previewImg.src);
                const blob = await response.blob();
                const fileName = 'cover-image.jpg';
                const file = new File([blob], fileName, { type: blob.type });
                formData.append('cover', file);
                console.log('✅ Created file from preview image');
            } catch (error) {
                console.error('❌ Failed to create file from preview:', error);
            }
        }
    }

    // Debug: Log all FormData entries
    console.log('=== FORMDATA DEBUG ===');
    for (let [key, value] of formData.entries()) {
      if (value instanceof File) {
        console.log(`${key}: [File] ${value.name} (${value.size} bytes, ${value.type})`);
      } else {
        console.log(`${key}: ${value}`);
      }
    }

    // Additional validation for cover field
    const coverFiles = [];
    formData.forEach((value, key) => {
      if (key === 'cover' && value instanceof File) {
        coverFiles.push(value);
      }
    });

    if (coverFiles.length > 0) {
      console.log('✅ Cover file ready for upload:', coverFiles[0].name, 'Size:', coverFiles[0].size);
    } else {
      console.log('❌ No cover file in FormData');
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

      // Clear media picker selections if they exist
      if (typeof window.resetCoverPreview === 'function') {
          window.resetCoverPreview();
      } else {
          // Fallback: clear global variables
          window.selectedCoverImage = null;
          window.uploadedMediaFile = null;
          window.selectedTempImage = null;
      }

      // Close modal and refresh page immediately
      location.reload();
    } catch (error) {
      console.error('Error:', error);
      showCornerPopup('Error occurred while adding book.');
    }
  });

});

// === Helper Functions ===
function submitAddBook() {
    const form = document.getElementById('addBookForm');
    if (form) {
        form.dispatchEvent(new Event('submit'));
    }
}

// === Separate Submit Function from Books Index ===
async function submitAddBookFromBooksIndex() {
    const form = document.getElementById('addBookForm');
    if (!form) return;

    // Client-side validation for required fields
    const requiredFields = ['title', 'author', 'published_year', 'availability'];
    let allFilled = true;

    for (const fieldName of requiredFields) {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (!field || !field.value.trim()) {
            allFilled = false;
            break;
        }
    }

    if (!allFilled) {
        showCornerPopup('Please fill in all required fields.');
        return;
    }

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

    // Debug: Check all possible sources
    console.log('=== COVER IMAGE DEBUG ===');
    console.log('window.selectedCoverImage:', window.selectedCoverImage);
    console.log('window.uploadedMediaFile:', window.uploadedMediaFile);
    console.log('window.selectedTempImage:', window.selectedTempImage);
    console.log('coverInput exists:', !!coverInput);
    console.log('coverInput.files:', coverInput?.files);
    if (coverInput?.files[0]) {
      console.log('coverInput file:', coverInput.files[0].name, 'Size:', coverInput.files[0].size);
    }

    // Priority order: 1. Temp image (from media picker), 2. File input (from media picker selection), 3. Uploaded file, 4. Selected URL, 5. Preview image
    if (window.selectedTempImage) {
        // Use temp uploaded image from media picker
        console.log('Using temp uploaded image from media picker:', window.selectedTempImage.name, 'Temp name:', window.selectedTempImage.temp_name);
        formData.append('temp_image', JSON.stringify(window.selectedTempImage));
        console.log('✅ Using temp uploaded image');
    } else if (coverInput && coverInput.files && coverInput.files[0]) {
        // Use file from input (set by media picker selection)
        console.log('Using file from input (media picker):', coverInput.files[0].name, 'Size:', coverInput.files[0].size);
        formData.append('cover', coverInput.files[0]);
        console.log('✅ Using file from input');
    } else if (window.uploadedMediaFile) {
        // Use uploaded file from media picker
        console.log('Using uploaded file from media picker:', window.uploadedMediaFile.name, 'Size:', window.uploadedMediaFile.size);
        formData.append('cover', window.uploadedMediaFile);
        console.log('✅ Using uploaded media file');
    } else if (window.selectedCoverImage) {
        // Fallback: convert selected URL to file (only if no file in input)
        console.log('Using selected cover image from media picker:', window.selectedCoverImage);

        try {
            // Fetch the image and convert to File object for proper upload
            const response = await fetch(window.selectedCoverImage);
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            const blob = await response.blob();
            const fileName = window.selectedCoverImage.split('/').pop() || 'cover-image.jpg';
            const file = new File([blob], fileName, { type: blob.type });
            formData.append('cover', file);
            console.log('✅ Successfully converted media picker URL to File object:', fileName, 'Size:', file.size, 'Type:', file.type);
        } catch (error) {
            console.error('❌ Error converting media picker URL to File:', error);
            showCornerPopup('Error processing selected cover image: ' + error.message);
            return;
        }
    } else {
        console.log('⚠️ No cover image selected or available');

        // Additional check: try to get file from preview area data attribute
        const previewImg = document.querySelector('#cover-preview-content img');
        if (previewImg && previewImg.src) {
            console.log('Found preview image, attempting to use it');
            try {
                // If preview exists, try to fetch it and create a file
                const response = await fetch(previewImg.src);
                const blob = await response.blob();
                const fileName = 'cover-image.jpg';
                const file = new File([blob], fileName, { type: blob.type });
                formData.append('cover', file);
                console.log('✅ Created file from preview image');
            } catch (error) {
                console.error('❌ Failed to create file from preview:', error);
            }
        }
    }

    // Debug: Log all FormData entries
    console.log('=== FORMDATA DEBUG ===');
    for (let [key, value] of formData.entries()) {
        if (value instanceof File) {
            console.log(`${key}: [File] ${value.name} (${value.size} bytes, ${value.type})`);
        } else {
            console.log(`${key}: ${value}`);
        }
    }

    // Additional validation for cover field
    const coverFiles = [];
    formData.forEach((value, key) => {
        if (key === 'cover' && value instanceof File) {
            coverFiles.push(value);
        }
    });

    if (coverFiles.length > 0) {
        console.log('✅ Cover file ready for upload:', coverFiles[0].name, 'Size:', coverFiles[0].size);
    } else {
        console.log('❌ No cover file in FormData');
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

        // Clear media picker selections if they exist
        if (typeof window.resetCoverPreview === 'function') {
            window.resetCoverPreview();
        } else {
            // Fallback: clear global variables
            window.selectedCoverImage = null;
            window.uploadedMediaFile = null;
            window.selectedTempImage = null;
        }

        // Close modal and refresh page immediately
        location.reload();
    } catch (error) {
        console.error('Error:', error);
        showCornerPopup('Error occurred while adding book.');
    }
}

// === Modal Controls ===
function openAddBookModal() {
  const modal = document.getElementById('addBookModal');
  if (modal) {
    modal.classList.add('active');
    modal.style.display = 'flex';
    modal.style.opacity = '1';
    modal.style.visibility = 'visible';
    document.body.classList.add('modal-open');
    // Optional: reset form and preview
    document.getElementById('addBookForm').reset();
    if (typeof resetCoverPreview === 'function') resetCoverPreview();
  }
}

function closeAddBookModal() {
  const modal = document.getElementById('addBookModal');
  if (modal) {
    modal.classList.remove('active');
    modal.style.display = 'none';
    modal.style.opacity = '0';
    modal.style.visibility = 'hidden';
    document.body.classList.remove('modal-open');
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

// === Submit Function for Dashboard addBookModal ===
async function submitAddBookFromDashboard() {
    const form = document.getElementById('addBookForm');
    if (!form) return;

    // Client-side validation for required fields
    const requiredFields = ['title', 'author', 'published_year', 'availability'];
    let allFilled = true;

    for (const fieldName of requiredFields) {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (!field || !field.value.trim()) {
            allFilled = false;
            break;
        }
    }

    if (!allFilled) {
        showCornerPopup('Please fill in all required fields.');
        return;
    }

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

    // Debug: Check all possible sources
    console.log('=== COVER IMAGE DEBUG ===');
    console.log('window.selectedCoverImage:', window.selectedCoverImage);
    console.log('window.uploadedMediaFile:', window.uploadedMediaFile);
    console.log('window.selectedTempImage:', window.selectedTempImage);
    console.log('coverInput exists:', !!coverInput);
    console.log('coverInput.files:', coverInput?.files);
    if (coverInput?.files[0]) {
      console.log('coverInput file:', coverInput.files[0].name, 'Size:', coverInput.files[0].size);
    }

    // Priority order: 1. Temp image (from media picker), 2. File input (from media picker selection), 3. Uploaded file, 4. Selected URL, 5. Preview image
    if (window.selectedTempImage) {
        // Use temp uploaded image from media picker
        console.log('Using temp uploaded image from media picker:', window.selectedTempImage.name, 'Temp name:', window.selectedTempImage.temp_name);
        formData.append('temp_image', JSON.stringify(window.selectedTempImage));
        console.log('✅ Using temp uploaded image');
    } else if (coverInput && coverInput.files && coverInput.files[0]) {
        // Use file from input (set by media picker selection)
        console.log('Using file from input (media picker):', coverInput.files[0].name, 'Size:', coverInput.files[0].size);
        formData.append('cover', coverInput.files[0]);
        console.log('✅ Using file from input');
    } else if (window.uploadedMediaFile) {
        // Use uploaded file from media picker
        console.log('Using uploaded file from media picker:', window.uploadedMediaFile.name, 'Size:', window.uploadedMediaFile.size);
        formData.append('cover', window.uploadedMediaFile);
        console.log('✅ Using uploaded media file');
    } else if (window.selectedCoverImage) {
        // Fallback: convert selected URL to file (only if no file in input)
        console.log('Using selected cover image from media picker:', window.selectedCoverImage);

        try {
            // Fetch the image and convert to File object for proper upload
            const response = await fetch(window.selectedCoverImage);
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            const blob = await response.blob();
            const fileName = window.selectedCoverImage.split('/').pop() || 'cover-image.jpg';
            const file = new File([blob], fileName, { type: blob.type });
            formData.append('cover', file);
            console.log('✅ Successfully converted media picker URL to File object:', fileName, 'Size:', file.size, 'Type:', file.type);
        } catch (error) {
            console.error('❌ Error converting media picker URL to File:', error);
            showCornerPopup('Error processing selected cover image: ' + error.message);
            return;
        }
    } else {
        console.log('⚠️ No cover image selected or available');

        // Additional check: try to get file from preview area data attribute
        const previewImg = document.querySelector('#cover-preview-content img');
        if (previewImg && previewImg.src) {
            console.log('Found preview image, attempting to use it');
            try {
                // If preview exists, try to fetch it and create a file
                const response = await fetch(previewImg.src);
                const blob = await response.blob();
                const fileName = 'cover-image.jpg';
                const file = new File([blob], fileName, { type: blob.type });
                formData.append('cover', file);
                console.log('✅ Created file from preview image');
            } catch (error) {
                console.error('❌ Failed to create file from preview:', error);
            }
        }
    }

    // Debug: Log all FormData entries
    console.log('=== FORMDATA DEBUG ===');
    for (let [key, value] of formData.entries()) {
        if (value instanceof File) {
            console.log(`${key}: [File] ${value.name} (${value.size} bytes, ${value.type})`);
        } else {
            console.log(`${key}: ${value}`);
        }
    }

    // Additional validation for cover field
    const coverFiles = [];
    formData.forEach((value, key) => {
        if (key === 'cover' && value instanceof File) {
            coverFiles.push(value);
        }
    });

    if (coverFiles.length > 0) {
        console.log('✅ Cover file ready for upload:', coverFiles[0].name, 'Size:', coverFiles[0].size);
    } else {
        console.log('❌ No cover file in FormData');
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

        // Clear media picker selections if they exist
        if (typeof window.resetCoverPreview === 'function') {
            window.resetCoverPreview();
        } else {
            // Fallback: clear global variables
            window.selectedCoverImage = null;
            window.uploadedMediaFile = null;
            window.selectedTempImage = null;
        }

        // Close modal and refresh page immediately
        location.reload();
    } catch (error) {
        console.error('Error:', error);
        showCornerPopup('Error occurred while adding book.');
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