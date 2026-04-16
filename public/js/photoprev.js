const PHOTO_FIELD_CONFIG = {
    photo: { previewId: 'photoPreview' },
    julitaPhoto: { previewId: 'julitaPhotoPreview' },
    editPhoto: { previewId: 'editPhotoPreview' }
};

const cameraModalState = {
    stream: null,
    facingMode: 'user',
    targetInputId: null
};

document.addEventListener('change', function (e) {
    if (!e.target || e.target.type !== 'file' || e.target.accept !== 'image/*') {
        return;
    }

    const file = e.target.files && e.target.files[0];
    if (file) {
        handleFileSelect(file, e.target);
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const photoUploads = document.querySelectorAll('.photo-upload');

    photoUploads.forEach(uploadArea => {
        const input = uploadArea.querySelector('input[type="file"]');
        if (!input) return;

        uploadArea.addEventListener('click', function (e) {
            if (e.target === input) return;
            input.click();
        });

        uploadArea.addEventListener('dragover', function (e) {
            e.preventDefault();
            e.stopPropagation();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', function (e) {
            e.preventDefault();
            e.stopPropagation();
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', function (e) {
            e.preventDefault();
            e.stopPropagation();
            uploadArea.classList.remove('dragover');

            const files = e.dataTransfer.files;
            if (!files || !files.length) return;

            const dt = new DataTransfer();
            dt.items.add(files[0]);
            input.files = dt.files;
            handleFileSelect(files[0], input);
        });
    });

    const cameraModal = document.getElementById('cameraStreamModal');
    if (cameraModal) {
        cameraModal.addEventListener('click', function (e) {
            if (e.target === cameraModal) {
                closeCameraStreamModal();
            }
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeCameraStreamModal();
        }
    });

    ensureCameraStreamModal();
});

function getPreviewElementByInputId(inputId) {
    const config = PHOTO_FIELD_CONFIG[inputId];
    if (!config) return null;
    return document.getElementById(config.previewId);
}

function handleFileSelect(file, input) {
    if (!file || !input) return;

    if (!file.type.match('image.*')) {
        alert('Please select an image file.');
        return;
    }

    if (file.size > 5 * 1024 * 1024) {
        alert('File size must be less than 5MB.');
        return;
    }

    const preview = getPreviewElementByInputId(input.id);
    if (!preview) {
        console.error('Preview element not found for input:', input.id);
        return;
    }

    const reader = new FileReader();

    reader.onload = function (event) {
        preview.src = event.target.result;
        preview.style.display = 'block';

        const uploadArea = preview.previousElementSibling;
        if (uploadArea && uploadArea.classList.contains('photo-upload')) {
            uploadArea.classList.add('hidden');
        }

        addRemoveButton(preview, input);
        addDragDropToPreview(preview, input);
    };

    reader.onerror = function () {
        alert('Error reading file. Please try again.');
    };

    reader.readAsDataURL(file);
}

function addRemoveButton(preview, input) {
    const existingBtn = preview.parentNode.querySelector('.remove-photo');
    if (existingBtn) {
        existingBtn.remove();
    }

    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'remove-photo';
    removeBtn.innerHTML = 'x';
    removeBtn.title = 'Remove photo';
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
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        transition: background 0.2s;
    `;

    removeBtn.addEventListener('mouseover', function () {
        this.style.background = 'rgba(220, 38, 38, 1)';
    });

    removeBtn.addEventListener('mouseout', function () {
        this.style.background = 'rgba(239, 68, 68, 0.9)';
    });

    removeBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        clearPhotoSelection(input.id);
    });

    preview.parentNode.appendChild(removeBtn);
    preview.parentNode.style.position = 'relative';
}

function clearPhotoSelection(inputId) {
    const input = document.getElementById(inputId);
    const preview = getPreviewElementByInputId(inputId);
    if (!input || !preview) return;

    input.value = '';
    preview.src = '#';
    preview.style.display = 'none';

    const uploadArea = preview.previousElementSibling;
    if (uploadArea && uploadArea.classList.contains('photo-upload')) {
        uploadArea.classList.remove('hidden');
    }

    const removeBtn = preview.parentNode.querySelector('.remove-photo');
    if (removeBtn) {
        removeBtn.remove();
    }
}

function addDragDropToPreview(preview, input) {
    if (preview.dataset.dragBound === 'true') {
        return;
    }

    preview.dataset.dragBound = 'true';

    preview.addEventListener('dragover', function (e) {
        e.preventDefault();
        e.stopPropagation();
        preview.style.borderColor = '#ef4444';
        preview.style.filter = 'brightness(0.9)';
    });

    preview.addEventListener('dragleave', function (e) {
        e.preventDefault();
        e.stopPropagation();
        preview.style.borderColor = '';
        preview.style.filter = '';
    });

    preview.addEventListener('drop', function (e) {
        e.preventDefault();
        e.stopPropagation();
        preview.style.borderColor = '';
        preview.style.filter = '';

        const files = e.dataTransfer.files;
        if (!files || !files.length) return;

        const dt = new DataTransfer();
        dt.items.add(files[0]);
        input.files = dt.files;
        handleFileSelect(files[0], input);
    });

    preview.style.cursor = 'pointer';
    preview.title = 'Drag a new image here to replace, or click x to remove';
}

function ensureCameraStreamModal() {
    let modal = document.getElementById('cameraStreamModal');

    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'cameraStreamModal';
        modal.className = 'modal-overlay';
        modal.innerHTML = `
            <div class="modal-container" style="max-width: 720px;">
                <div class="modal-header">
                    <div class="modal-title">
                        <i class="fas fa-camera"></i>
                        Camera Capture
                    </div>
                    <button class="modal-close" type="button" onclick="closeCameraStreamModal()">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="camera-container">
                        <video id="cameraStreamVideo" playsinline autoplay></video>
                        <canvas id="cameraStreamCanvas" style="display: none;"></canvas>
                        <span class="capture-label">Capture Photo</span>
                        <div class="camera-stream-actions">
                            <button type="button" class="btn btn-primary" onclick="captureCameraStreamPhoto()">
                                <i class="fas fa-camera"></i> Capture
                            </button>
                            <button type="button" class="btn btn-outline" onclick="switchCameraStreamDevice()">
                                <i class="fas fa-sync"></i> Switch Camera
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="closeCameraStreamModal()">
                                <i class="fas fa-times"></i> Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    } else if (modal.parentNode !== document.body) {
        document.body.appendChild(modal);
    }

    if (!modal.dataset.bound) {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                closeCameraStreamModal();
            }
        });
        modal.dataset.bound = 'true';
    }

    modal.style.zIndex = '99999';
    return modal;
}

async function startCameraStream() {
    const video = document.getElementById('cameraStreamVideo');
    if (!video || cameraModalState.stream) {
        return;
    }

    try {
        const stream = await navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: cameraModalState.facingMode,
                width: { ideal: 1280 },
                height: { ideal: 720 }
            },
            audio: false
        });

        cameraModalState.stream = stream;
        video.srcObject = stream;
        await video.play();
    } catch (error) {
        console.error('Unable to access camera:', error);
        let message = 'Unable to access camera.';

        if (error.name === 'NotAllowedError') {
            message = 'Unable to access camera. Please allow camera permission and try again.';
        } else if (error.name === 'NotFoundError') {
            message = 'No camera device was found.';
        } else if (error.name === 'NotReadableError') {
            message = 'Camera is currently being used by another app.';
        }

        alert(message);
        closeCameraStreamModal();
    }
}

function stopCameraStream() {
    if (cameraModalState.stream) {
        cameraModalState.stream.getTracks().forEach(track => track.stop());
        cameraModalState.stream = null;
    }

    const video = document.getElementById('cameraStreamVideo');
    if (video) {
        video.srcObject = null;
    }
}

function openCameraStreamModal(inputId) {
    if (!PHOTO_FIELD_CONFIG[inputId]) {
        console.warn('Unsupported camera target input:', inputId);
        return;
    }

    const modal = ensureCameraStreamModal();
    if (!modal) return;

    cameraModalState.targetInputId = inputId;
    modal.style.display = 'flex';
    modal.style.opacity = '1';
    modal.style.visibility = 'visible';
    modal.classList.add('active');
    startCameraStream();
}

function closeCameraStreamModal() {
    const modal = document.getElementById('cameraStreamModal');
    if (modal) {
        modal.classList.remove('active');
        modal.style.display = 'none';
    }
    stopCameraStream();
}

async function switchCameraStreamDevice() {
    cameraModalState.facingMode = cameraModalState.facingMode === 'user' ? 'environment' : 'user';
    stopCameraStream();
    await startCameraStream();
}

function captureCameraStreamPhoto() {
    const targetInputId = cameraModalState.targetInputId;
    const input = document.getElementById(targetInputId);
    const video = document.getElementById('cameraStreamVideo');
    const canvas = document.getElementById('cameraStreamCanvas');

    if (!targetInputId || !input || !video || !canvas || !video.videoWidth || !video.videoHeight) {
        alert('Camera is not ready yet.');
        return;
    }

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    canvas.toBlob(function (blob) {
        if (!blob) {
            alert('Failed to capture photo. Please try again.');
            return;
        }

        const file = new File([blob], `capture-${Date.now()}.jpg`, { type: 'image/jpeg' });
        const dt = new DataTransfer();
        dt.items.add(file);
        input.files = dt.files;
        handleFileSelect(file, input);
        closeCameraStreamModal();
    }, 'image/jpeg', 0.92);
}

function toggleInlineCamera(inputId, shouldOpen) {
    if (shouldOpen === false) {
        closeCameraStreamModal();
        return;
    }
    openCameraStreamModal(inputId);
}

function switchInlineCamera() {
    switchCameraStreamDevice();
}

function captureInlinePhoto(inputId) {
    if (inputId) {
        cameraModalState.targetInputId = inputId;
    }
    captureCameraStreamPhoto();
}

function stopAllInlineCameras() {
    closeCameraStreamModal();
}

function setPhotoPreviewFromUrl(inputId, imageUrl) {
    if (!imageUrl) {
        clearPhotoSelection(inputId);
        return;
    }

    const preview = getPreviewElementByInputId(inputId);
    if (!preview) return;

    preview.src = imageUrl;
    preview.style.display = 'block';

    const input = document.getElementById(inputId);
    const uploadArea = preview.previousElementSibling;
    if (uploadArea && uploadArea.classList.contains('photo-upload')) {
        uploadArea.classList.add('hidden');
    }

    if (input) {
        addRemoveButton(preview, input);
        addDragDropToPreview(preview, input);
    }
}

window.toggleInlineCamera = toggleInlineCamera;
window.switchInlineCamera = switchInlineCamera;
window.captureInlinePhoto = captureInlinePhoto;
window.stopAllInlineCameras = stopAllInlineCameras;
window.openCameraStreamModal = openCameraStreamModal;
window.closeCameraStreamModal = closeCameraStreamModal;
window.switchCameraStreamDevice = switchCameraStreamDevice;
window.captureCameraStreamPhoto = captureCameraStreamPhoto;
window.setPhotoPreviewFromUrl = setPhotoPreviewFromUrl;