/**
 * Member Photo Upload Modal
 * Handles drag-drop, camera capture, and photo preview
 */

let photoUploadData = {
    selectedFile: null,
    croppedBlob: null,
    currentMemberId: null,
    stream: null,
    facingMode: 'user'
};

// ============================================================================
// MODAL MANAGEMENT
// ============================================================================

function openPhotoUploadModal(memberId) {
    const modal = document.getElementById('photoUploadModal');
    if (!modal) return;

    photoUploadData.currentMemberId = memberId;
    photoUploadData.selectedFile = null;
    photoUploadData.croppedBlob = null;

    // Reset to upload tab
    switchPhotoTab('upload');
    
    // Hide preview section initially
    document.getElementById('photoPreviewSection').style.display = 'none';

    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closePhotoUploadModal() {
    const modal = document.getElementById('photoUploadModal');
    if (!modal) return;

    stopPhotoCameraStream();
    
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
    
    photoUploadData.selectedFile = null;
    photoUploadData.croppedBlob = null;
}

// ============================================================================
// TAB SWITCHING
// ============================================================================

function switchPhotoTab(tabName) {
    // Update button states
    document.querySelectorAll('.photo-tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');

    // Update content visibility
    document.querySelectorAll('.photo-tab-content').forEach(content => {
        content.classList.remove('active');
    });
    document.getElementById(`photo-${tabName}-tab`).classList.add('active');

    // Initialize camera when switching to camera tab
    if (tabName === 'camera') {
        setTimeout(initializePhotoCamera, 300);
    }
}

// ============================================================================
// DRAG AND DROP
// ============================================================================

function handlePhotoDragOver(e) {
    e.preventDefault();
    e.stopPropagation();
    
    const dropZone = document.getElementById('photoDropZone');
    if (dropZone) {
        dropZone.classList.add('dragover');
    }
}

function handlePhotoDragLeave(e) {
    e.preventDefault();
    e.stopPropagation();
    
    const dropZone = document.getElementById('photoDropZone');
    if (dropZone) {
        dropZone.classList.remove('dragover');
    }
}

function handlePhotoDrop(e) {
    e.preventDefault();
    e.stopPropagation();

    const dropZone = document.getElementById('photoDropZone');
    if (dropZone) {
        dropZone.classList.remove('dragover');
    }

    const files = e.dataTransfer.files;
    if (files.length > 0) {
        const file = files[0];
        if (file.type.startsWith('image/')) {
            handlePhotoFileSelection(file);
        } else {
            showPhotoError('Please select an image file');
        }
    }
}

function handlePhotoFileSelect(e) {
    const files = e.target.files;
    if (files.length > 0) {
        handlePhotoFileSelection(files[0]);
    }
}

function handlePhotoFileSelection(file) {
    // Validate file size (5MB)
    if (file.size > 5 * 1024 * 1024) {
        showPhotoError('File size must be less than 5MB');
        return;
    }

    const reader = new FileReader();
    reader.onload = (e) => {
        photoUploadData.selectedFile = {
            file: file,
            data: e.target.result
        };
        showPhotoPreview(e.target.result);
    };
    reader.readAsDataURL(file);
}

function openPhotoFilePicker() {
    const input = document.getElementById('photoFileInput');
    if (input) input.click();
}

// ============================================================================
// CAMERA CAPTURE
// ============================================================================

async function initializePhotoCamera() {
    if (photoUploadData.stream) return; // Already initialized

    try {
        const constraints = {
            video: {
                facingMode: photoUploadData.facingMode,
                width: { ideal: 1280 },
                height: { ideal: 720 }
            }
        };

        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        photoUploadData.stream = stream;

        const video = document.getElementById('photoCameraVideo');
        if (video) {
            video.srcObject = stream;
            video.play().catch(err => {
                console.error('Error playing video:', err);
                showPhotoError('Failed to start camera. Please check permissions.');
            });
        }
    } catch (error) {
        console.error('Camera error:', error);
        let errorMsg = 'Failed to access camera. ';
        
        if (error.name === 'NotAllowedError') {
            errorMsg += 'Please allow camera access in your browser settings.';
        } else if (error.name === 'NotFoundError') {
            errorMsg += 'No camera found on this device.';
        } else if (error.name === 'NotReadableError') {
            errorMsg += 'Camera is being used by another application.';
        }
        
        showPhotoError(errorMsg);
    }
}

function stopPhotoCameraStream() {
    if (photoUploadData.stream) {
        photoUploadData.stream.getTracks().forEach(track => track.stop());
        photoUploadData.stream = null;
    }
}

async function switchPhotoCamera() {
    stopPhotoCameraStream();
    photoUploadData.facingMode = photoUploadData.facingMode === 'user' ? 'environment' : 'user';
    await initializePhotoCamera();
}

function capturePhoto() {
    const video = document.getElementById('photoCameraVideo');
    const canvas = document.getElementById('photoCanvasCapture');

    if (!video || !canvas) return;

    const context = canvas.getContext('2d');
    
    // Set canvas size to match video
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    // Draw video frame to canvas
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    // Convert canvas to blob
    canvas.toBlob((blob) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            photoUploadData.selectedFile = {
                file: new File([blob], `photo-${Date.now()}.png`, { type: 'image/png' }),
                data: e.target.result
            };
            showPhotoPreview(e.target.result);
        };
        reader.readAsDataURL(blob);
    }, 'image/png', 0.95);
}

// ============================================================================
// PREVIEW
// ============================================================================

function showPhotoPreview(imageData) {
    const previewImg = document.getElementById('photoPreviewImg');
    const previewSection = document.getElementById('photoPreviewSection');

    if (previewImg && previewSection) {
        previewImg.src = imageData;
        previewSection.style.display = 'block';
    }
}

function resetPhotoUpload() {
    photoUploadData.selectedFile = null;
    document.getElementById('photoFileInput').value = '';
    document.getElementById('photoPreviewSection').style.display = 'none';
}

// ============================================================================
// SAVE PHOTO
// ============================================================================

async function savePhotoUpload() {
    if (!photoUploadData.selectedFile || !photoUploadData.currentMemberId) {
        showPhotoError('No photo selected or member ID missing');
        return;
    }

    const btn = event.target;
    const originalHTML = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';

    try {
        const formData = new FormData();
        formData.append('photo', photoUploadData.selectedFile.file);

        const response = await fetch(`/members/${photoUploadData.currentMemberId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: formData
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Failed to upload photo');
        }

        showPhotoSuccess('Photo uploaded successfully!');
        setTimeout(() => {
            closePhotoUploadModal();
            // Refresh the member table or specific row if needed
            location.reload();
        }, 1500);

    } catch (error) {
        console.error('Upload error:', error);
        showPhotoError(error.message || 'Failed to upload photo. Please try again.');
    } finally {
        btn.disabled = false;
        btn.innerHTML = originalHTML;
    }
}

// ============================================================================
// NOTIFICATIONS
// ============================================================================

function showPhotoError(message) {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #ef4444;
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 10000;
        animation: slideInRight 0.3s ease-out;
    `;
    notification.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${message}`;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 4000);
}

function showPhotoSuccess(message) {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #10b981;
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 10000;
        animation: slideInRight 0.3s ease-out;
    `;
    notification.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// ============================================================================
// EXPOSE TO GLOBAL SCOPE
// ============================================================================

window.openPhotoUploadModal = openPhotoUploadModal;
window.closePhotoUploadModal = closePhotoUploadModal;
window.switchPhotoTab = switchPhotoTab;
window.handlePhotoDragOver = handlePhotoDragOver;
window.handlePhotoDragLeave = handlePhotoDragLeave;
window.handlePhotoDrop = handlePhotoDrop;
window.handlePhotoFileSelect = handlePhotoFileSelect;
window.openPhotoFilePicker = openPhotoFilePicker;
window.capturePhoto = capturePhoto;
window.switchPhotoCamera = switchPhotoCamera;
window.resetPhotoUpload = resetPhotoUpload;
window.savePhotoUpload = savePhotoUpload;
