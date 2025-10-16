// Enhanced Photo Preview with Drag & Drop functionality

// Handle file input changes for both modals
document.addEventListener('change', function(e) {
    if (e.target && e.target.type === 'file' && e.target.accept === 'image/*') {
        const file = e.target.files[0];
        if (file) {
            handleFileSelect(file, e.target);
        }
    }
});

// Handle drag and drop for photo upload areas
document.addEventListener('DOMContentLoaded', function() {
    const photoUploads = document.querySelectorAll('.photo-upload');

    photoUploads.forEach(uploadArea => {
        const input = uploadArea.querySelector('input[type="file"]');
        if (!input) return;

        // Click handler
        uploadArea.addEventListener('click', function(e) {
            if (e.target === input) return; // Don't trigger if clicking the input itself
            input.click();
        });

        // Drag and drop handlers
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            uploadArea.classList.remove('dragover');

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                input.files = files;
                handleFileSelect(files[0], input);
            }
        });
    });
});

function handleFileSelect(file, input) {
    if (!file) return;

    // Validate file type
    if (!file.type.match('image.*')) {
        alert('Please select an image file.');
        return;
    }

    // Validate file size (5MB max)
    if (file.size > 5 * 1024 * 1024) {
        alert('File size must be less than 5MB.');
        return;
    }

    // Find the preview image for this input
    const modal = input.closest('.modal');
    let preview;

    if (input.id === 'photo') {
        preview = document.getElementById('photoPreview');
    } else if (input.id === 'julitaPhoto') {
        preview = document.getElementById('julitaPhotoPreview');
    }

    if (!preview) {
        console.error('Preview element not found for input:', input.id);
        return;
    }

    const reader = new FileReader();

    reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = 'block';

        // Hide the upload area when image is selected
        const uploadArea = preview.previousElementSibling;
        if (uploadArea && uploadArea.classList.contains('photo-upload')) {
            uploadArea.classList.add('hidden');
        }

        // Add remove button and drag & drop to preview
        addRemoveButton(preview, input);
        addDragDropToPreview(preview, input);
    };

    reader.onerror = function() {
        alert('Error reading file. Please try again.');
    };

    reader.readAsDataURL(file);
}

function addRemoveButton(preview, input) {
    // Remove existing remove button
    const existingBtn = preview.parentNode.querySelector('.remove-photo');
    if (existingBtn) {
        existingBtn.remove();
    }

    // Create remove button
    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'remove-photo';
    removeBtn.innerHTML = '×';
    removeBtn.title = 'Remove photo';

    // Style the remove button
    removeBtn.style.cssText = `
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(239, 68, 68, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        transition: background 0.2s;
    `;

    removeBtn.addEventListener('mouseover', function() {
        this.style.background = 'rgba(220, 38, 38, 1)';
    });

    removeBtn.addEventListener('mouseout', function() {
        this.style.background = 'rgba(239, 68, 68, 0.9)';
    });

    removeBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        preview.src = '';
        preview.style.display = 'none';
        this.remove();

        // Clear the file input
        input.value = '';

        // Show the upload area again
        const uploadArea = preview.previousElementSibling;
        if (uploadArea && uploadArea.classList.contains('photo-upload')) {
            uploadArea.classList.remove('hidden');
        }

        // Remove drag & drop from preview since it's no longer visible
        preview.style.cursor = '';
        preview.title = '';
        preview.replaceWith(preview.cloneNode(true)); // Remove all event listeners
    });

    preview.parentNode.appendChild(removeBtn);
    preview.parentNode.style.position = 'relative';
}

function addDragDropToPreview(preview, input) {
    // Add drag and drop functionality to the preview image
    preview.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        preview.style.borderColor = '#ef4444'; // Red border to indicate replacement
        preview.style.filter = 'brightness(0.9)';
    });

    preview.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        preview.style.borderColor = '';
        preview.style.filter = '';
    });

    preview.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        preview.style.borderColor = '';
        preview.style.filter = '';

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];

            // Validate file type
            if (!file.type.match('image.*')) {
                alert('Please select an image file.');
                return;
            }

            // Validate file size (5MB max)
            if (file.size > 5 * 1024 * 1024) {
                alert('File size must be less than 5MB.');
                return;
            }

            // Update the file input
            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;

            // Update preview
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;

                // Update remove button reference to new file
                const removeBtn = preview.parentNode.querySelector('.remove-photo');
                if (removeBtn) {
                    removeBtn.fileReference = file;
                }
            };
            reader.readAsDataURL(file);
        }
    });

    // Make sure preview is focusable for better interaction
    preview.style.cursor = 'pointer';
    preview.title = 'Drag a new image here to replace, or click the × to remove';
}