// ======================
// BORROW.JS - CLEAN & SIMPLE VERSION
// ======================

// Global variables
let selectedBooks = [];
let selectionMode = false;

// DEBUG: Log when borrow.js is loaded
console.log('🚀 BORROW.JS LOADED - Clean & Simple Version');

// ======================
// TOAST NOTIFICATIONS
// ======================

function showToast(message, type = 'info') {
    const existingToasts = document.querySelectorAll('.toast-notification');
    existingToasts.forEach(toast => toast.remove());

    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// ======================
// CORE BORROW FUNCTIONS
// ======================

function openBorrowModal() {
    const selectedRows = document.querySelectorAll('#booksTableBody tr.selected');
    if (selectedRows.length === 0) {
        showToast("No books selected for borrowing", 'warning');
        return;
    }

    const list = document.getElementById('selectedBooksList');
    if (list) {
        list.innerHTML = '';
        selectedRows.forEach(row => {
            const li = document.createElement('li');
            li.textContent = row.dataset.title || 'Unknown Title';
            li.setAttribute('data-id', row.dataset.id);
            li.style.padding = '8px 0';
            li.style.borderBottom = '1px solid var(--border-light)';
            list.appendChild(li);
        });
    }

    // Philippine holidays for 2025
    const philippineHolidays = [
        '2025-01-01', '2025-02-25', '2025-04-17', '2025-04-18', '2025-04-19',
        '2025-05-01', '2025-06-12', '2025-08-25', '2025-11-01', '2025-11-30',
        '2025-12-25', '2025-12-30', '2025-12-31'
    ];

    function isPhilippineHoliday(dateString) {
        return philippineHolidays.includes(dateString);
    }

    function calculatePhilippineBusinessDueDate() {
        const now = new Date();
        const philippineOffset = 8 * 60;
        const utcTime = now.getTime() + (now.getTimezoneOffset() * 60000);
        const philippineTime = new Date(utcTime + (philippineOffset * 60000));

        const startDate = new Date(philippineTime);
        startDate.setDate(startDate.getDate() + 1);

        let workingDaysCount = 0;
        let currentDate = new Date(startDate);
        const workingDates = [];

        while (workingDaysCount < 10) {
            currentDate.setDate(currentDate.getDate() + 1);
            const dayOfWeek = currentDate.getDay();
            const dateString = currentDate.toISOString().split('T')[0];

            if (dayOfWeek >= 1 && dayOfWeek <= 5 && !isPhilippineHoliday(dateString)) {
                workingDaysCount++;
                workingDates.push(new Date(currentDate));
            }
        }

        return { finalDate: currentDate, workingDates: workingDates };
    }

    const dueDateResult = calculatePhilippineBusinessDueDate();
    const dueDate = dueDateResult.finalDate;

    const dueDateInput = document.getElementById('dueDate');
    if (dueDateInput) {
        dueDateInput.value = dueDate.toISOString().split('T')[0];
    }

    initializeCustomTimePicker();

    const memberNameInput = document.getElementById('memberName');
    const memberIdInput = document.getElementById('memberId');
    if (memberNameInput) memberNameInput.value = '';
    if (memberIdInput) memberIdInput.value = '';

    const modal = document.getElementById('borrowModal');
    if (modal) {
        modal.classList.add('show');
        modal.style.display = 'flex';
    }

    updateConfirmButtonState();

    const memberNameInputModal = document.getElementById('memberName');
    if (memberNameInputModal) {
        memberNameInputModal.addEventListener('input', function() {
            setTimeout(() => updateConfirmButtonState(), 10);
        });
    }
}

function closeBorrowModal() {
    const modal = document.getElementById('borrowModal');
    if (modal) {
        modal.classList.remove('show');
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }

    document.querySelectorAll('#booksTableBody tr.selected').forEach(row => {
        row.classList.remove('selected');
    });

    const fieldsToReset = ['memberName', 'memberId', 'dueDate', 'dueTime'];
    fieldsToReset.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) field.value = '';
    });

    selectedBooks = [];
    updateConfirmButtonState();
}

function confirmBorrow() {
    const memberName = document.getElementById('memberName').value.trim();
    const memberId = document.getElementById('memberId').value.trim();
    const dueDate = document.getElementById('dueDate').value;
    const dueTimeHidden = document.getElementById('dueTime');
    const dueTime = dueTimeHidden ? dueTimeHidden.value : '';

    if (!memberName || !memberId) {
        showToast('Please scan member QR code first', 'warning');
        return;
    }

    if (!dueDate || !dueTime) {
        showToast('Please set due date and time', 'warning');
        return;
    }

    const selectedBooksList = document.getElementById('selectedBooksList');
    let bookIds = [];
    
    if (selectedBooksList && selectedBooksList.children.length > 0) {
        bookIds = Array.from(selectedBooksList.children).map(li => parseInt(li.dataset.id));
    } else {
        const selectedRows = document.querySelectorAll('#booksTableBody tr.selected');
        if (selectedRows.length === 0) {
            showToast('Please select books to borrow first', 'warning');
            return;
        }
        bookIds = Array.from(selectedRows).map(row => parseInt(row.dataset.id));
    }

    if (bookIds.length === 0) {
        showToast('Please select books to borrow first', 'warning');
        return;
    }

    const tokenElement = document.querySelector('meta[name="csrf-token"]');
    if (!tokenElement) {
        showToast('CSRF token not found', 'error');
        return;
    }

    const token = tokenElement.content;
    const confirmButton = document.getElementById('confirmBorrowBtn');
    
    if (confirmButton) {
        confirmButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        confirmButton.disabled = true;
    }

    const borrowData = {
        member_name: memberName,
        member_id: memberId,
        due_date: dueDate,
        due_time: dueTime,
        book_ids: bookIds
    };

    console.log('📨 Sending borrow data:', borrowData);

    fetch('/borrow/process', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(borrowData)
    })
    .then(response => {
        console.log('📡 Response status:', response.status);
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        return response.json();
    })
    .then(data => {
        console.log('✅ Success:', data);
        showToast(data.message || 'Books borrowed successfully!', 'success');
        closeBorrowModal();
        setTimeout(() => location.reload(), 1500);
    })
    .catch(error => {
        console.error('❌ Error:', error);
        showToast('Failed to borrow books: ' + error.message, 'error');
        if (confirmButton) {
            confirmButton.innerHTML = '<i class="fas fa-check"></i> Confirm Borrow';
            confirmButton.disabled = false;
        }
    });
}

function borrowOne(bookId) {
    const row = document.querySelector(`tr[data-id="${bookId}"]`);
    if (!row) {
        showToast("Book not found", 'error');
        return;
    }

    const availability = parseInt(row.dataset.availability);
    if (availability <= 0) {
        showToast("This book is currently not available", 'warning');
        return;
    }

    document.querySelectorAll('#booksTableBody tr.selected').forEach(r => {
        r.classList.remove('selected');
    });

    row.classList.add('selected');
    openBorrowModal();
}

function updateConfirmButtonState() {
    const memberName = document.getElementById('memberName');
    const confirmBtn = document.getElementById('confirmBorrowBtn');
    const selectedBooksList = document.getElementById('selectedBooksList');

    if (!memberName || !confirmBtn) return;

    const hasMember = memberName.value.trim() !== '';
    const booksCount = selectedBooksList ? selectedBooksList.children.length : 0;

    confirmBtn.disabled = !hasMember;
    confirmBtn.style.pointerEvents = hasMember ? 'auto' : 'none';
    confirmBtn.style.opacity = hasMember ? '1' : '0.5';

    if (hasMember && booksCount > 0) {
        confirmBtn.innerHTML = '<i class="fas fa-check"></i> Confirm Borrow';
        confirmBtn.style.backgroundColor = '#10b981';
        confirmBtn.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            confirmBorrow();
        };
    } else if (hasMember) {
        confirmBtn.innerHTML = '<i class="fas fa-book"></i> Select Books';
        confirmBtn.style.backgroundColor = '#f59e0b';
    } else {
        confirmBtn.innerHTML = '<i class="fas fa-qrcode"></i> Scan Member';
        confirmBtn.style.backgroundColor = '#6b7280';
    }
}

function toggleBookSelection(bookId) {
    const row = document.querySelector(`tr[data-id="${bookId}"]`);
    if (!row) return;

    if (row.classList.contains('selected')) {
        row.classList.remove('selected');
    } else {
        row.classList.add('selected');
    }

    updateConfirmButtonState();
}

// ======================
// UTILITY FUNCTIONS
// ======================

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function initializeCustomTimePicker() {
    const dueHour = document.getElementById('dueHour');
    const dueMinute = document.getElementById('dueMinute');
    const dueAmPm = document.getElementById('dueAmPm');
    const dueTimeHidden = document.getElementById('dueTime');

    if (!dueHour || !dueMinute || !dueAmPm || !dueTimeHidden) {
        console.error('Custom time picker elements not found');
        return;
    }

    const now = new Date();
    const philippineOffset = 8 * 60;
    const utcTime = now.getTime() + (now.getTimezoneOffset() * 60000);
    const philippineTime = new Date(utcTime + (philippineOffset * 60000));

    let currentHour = philippineTime.getHours();
    const currentMinute = philippineTime.getMinutes();

    let ampm = 'AM';
    if (currentHour >= 12) {
        ampm = 'PM';
        if (currentHour > 12) {
            currentHour -= 12;
        }
    } else if (currentHour === 0) {
        currentHour = 12;
    }

    const minuteOptions = [0, 15, 30, 45];
    const roundedMinute = minuteOptions.reduce((prev, curr) =>
        Math.abs(curr - currentMinute) < Math.abs(prev - currentMinute) ? curr : prev
    );

    dueHour.value = currentHour.toString();
    dueMinute.value = roundedMinute.toString().padStart(2, '0');
    dueAmPm.value = ampm;

    function updateHiddenTimeInput() {
        const hour = parseInt(dueHour.value);
        const minute = dueMinute.value;
        const ampm = dueAmPm.value;

        let hour24 = hour;
        if (ampm === 'PM' && hour !== 12) {
            hour24 = hour + 12;
        } else if (ampm === 'AM' && hour === 12) {
            hour24 = 0;
        }

        const timeString = `${hour24.toString().padStart(2, '0')}:${minute}`;
        dueTimeHidden.value = timeString;
    }

    dueHour.addEventListener('change', updateHiddenTimeInput);
    dueMinute.addEventListener('change', updateHiddenTimeInput);
    dueAmPm.addEventListener('change', updateHiddenTimeInput);

    updateHiddenTimeInput();
}

function clearMemberInfo() {
    const memberName = document.getElementById('memberName');
    const memberId = document.getElementById('memberId');

    if (memberName) {
        memberName.value = '';
    }

    if (memberId) {
        memberId.value = '';
    }

    updateConfirmButtonState();
    showToast('Member information cleared', 'info');
}

function removeBookFromSelection(bookId) {
    const row = document.querySelector(`tr[data-id="${bookId}"]`);
    if (row) {
        row.classList.remove('selected');
    }

    const listItem = document.querySelector(`#selectedBooksList li[data-id="${bookId}"]`);
    if (listItem) {
        listItem.remove();
    }

    updateConfirmButtonState();
    showToast('Book removed from selection', 'info');
}

// ======================
// SELECTION MODE FUNCTIONS
// ======================

function enterSelectionMode() {
    selectionMode = true;
    document.getElementById('selectionBar')?.style.setProperty('display', 'flex');
    document.body.style.paddingTop = '80px';

    document.querySelectorAll('#booksTableBody tr[data-id]').forEach(row => {
        row.onclick = (e) => {
            if (e.target.closest('.action-buttons') || e.target.closest('.btn')) {
                return;
            }
            toggleRowSelection(row);
        };
        row.style.cursor = 'pointer';
    });
}

function exitSelectionMode() {
    selectionMode = false;
    const bar = document.getElementById('selectionBar');
    if (bar) bar.style.display = 'none';
    document.body.style.paddingTop = '0';

    document.querySelectorAll('#booksTableBody tr[data-id]').forEach(row => {
        row.onclick = null;
        row.style.cursor = '';
    });

    document.querySelectorAll('tr.selected').forEach(row => {
        row.classList.remove('selected');
    });
    selectedBooks = [];
}

function toggleRowSelection(row) {
    const bookId = row.dataset.id;
    const bookTitle = row.dataset.title;

    let parsedBookId;
    try {
        parsedBookId = bookId ? parseInt(bookId, 10) : null;
    } catch (e) {
        console.error('Error parsing book ID:', bookId, e);
        return;
    }

    if (!parsedBookId || isNaN(parsedBookId)) {
        showToast('Error: Invalid book data', 'error');
        return;
    }

    const index = selectedBooks.findIndex(b => b.id === parsedBookId);

    if (index === -1) {
        selectedBooks.push({ id: parsedBookId, title: bookTitle || 'Unknown Title' });
        row.classList.add('selected');
    } else {
        selectedBooks.splice(index, 1);
        row.classList.remove('selected');
    }
}

function selectAllBooks() {
    const visibleRows = document.querySelectorAll('#booksTableBody tr[data-id]:not([style*="display: none"])');
    let newSelections = 0;

    visibleRows.forEach(row => {
        const bookId = row.dataset.id;
        const bookTitle = row.dataset.title;

        let parsedBookId;
        try {
            parsedBookId = bookId ? parseInt(bookId, 10) : null;
        } catch (e) {
            return;
        }

        if (!parsedBookId || isNaN(parsedBookId)) {
            return;
        }

        if (!selectedBooks.find(b => b.id === parsedBookId)) {
            selectedBooks.push({ id: parsedBookId, title: bookTitle || 'Unknown Title' });
            row.classList.add('selected');
            newSelections++;
        }
    });

    if (newSelections > 0) {
        showToast(`Selected ${newSelections} additional book(s)`, 'success');
    } else {
        showToast('All visible books are already selected', 'info');
    }
}

function unselectAllBooks() {
    if (selectedBooks.length === 0) {
        showToast('No books are currently selected', 'info');
        return;
    }

    const previousCount = selectedBooks.length;

    document.querySelectorAll('#booksTableBody tr.selected').forEach(row => {
        row.classList.remove('selected');
    });

    selectedBooks = [];
    showToast(`Unselected ${previousCount} book(s)`, 'info');
}

function deleteSelected() {
    if (selectedBooks.length === 0) {
        showToast('No books selected', 'warning');
        return;
    }

    let booksToProcess = selectedBooks;
    if (selectedBooks.length > 0 && (typeof selectedBooks[0] === 'number' || typeof selectedBooks[0] === 'string')) {
        booksToProcess = selectedBooks.map(id => {
            const row = document.querySelector(`tr[data-id="${id}"]`);
            const title = row ? row.dataset.title : 'Unknown Title';
            return { id: id, title: title };
        });
    }

    const validBooks = booksToProcess.filter(book => {
        return book.id && book.id !== 'undefined' && book.id !== '' && !isNaN(book.id);
    });

    if (validBooks.length === 0) {
        showToast('No valid books selected for deletion', 'error');
        return;
    }

    if (validBooks.length === 1) {
        if (typeof window.deleteBook === 'function') {
            window.deleteBook(validBooks[0].id);
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            showToast('Delete functionality not available', 'error');
        }
    } else {
        if (confirm(`Delete ${validBooks.length} selected book(s)?`)) {
            selectedBooks.length = 0;
            validBooks.forEach(book => selectedBooks.push(book));
            deleteMultipleBooks();
        }
    }
}

function deleteMultipleBooks() {
    const token = document.querySelector('meta[name="csrf-token"]').content;
    if (!token) {
        showToast('CSRF token missing', 'error');
        return;
    }

    let completed = 0;
    let failed = 0;

    selectedBooks.forEach(book => {
        fetch(`/books/${book.id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                completed++;
                const row = document.querySelector(`tr[data-id="${book.id}"]`);
                if (row) row.remove();
            } else {
                failed++;
            }
        })
        .catch(error => {
            console.error(`Delete error for book ${book.id}:`, error);
            failed++;
        });
    });

    setTimeout(() => {
        let message = '';
        if (completed > 0) message += `${completed} book(s) deleted successfully`;
        if (failed > 0) message += `${failed} book(s) failed to delete`;

        showToast(message || 'No books were deleted', completed > 0 ? 'success' : 'error');

        selectedBooks = [];

        if (completed > 0) {
            setTimeout(() => {
                location.reload();
            }, 1500);
        }
    }, 1000);
}

function editBook(bookId) {
    if (typeof window.manageBooks === 'function') {
        document.querySelectorAll('tr.selected').forEach(r => r.classList.remove('selected'));
        selectedBooks = [];

        const row = document.querySelector(`tr[data-id="${bookId}"]`);
        if (row) {
            row.classList.add('selected');
            selectedBooks.push({ id: bookId, title: row.dataset.title });
            window.manageBooks();
        } else {
            showToast('Book not found', 'error');
        }
    } else {
        showToast('Edit functionality not available', 'error');
    }
}

// ======================
// QR SCANNER - INTEGRATED IMPLEMENTATION
// ======================

let currentBorrowScanType = null;
let qrScannerInstance = null;
let isQRScanning = false;

// ======================
// QR SCANNER FUNCTIONS
// ======================

function initializeQRModalElements() {
    const modal = document.getElementById('qrScannerModal');
    const qrReader = document.getElementById('qr-reader');

    if (!modal || !qrReader) {
        console.error('QR Scanner modal or reader not found');
        return false;
    }

    return true;
}

function startQRScan(type) {
    if (typeof Html5Qrcode === 'undefined') {
        showToast('QR Scanner library not loaded', 'error');
        return false;
    }

    if (isQRScanning) {
        return false;
    }

    currentBorrowScanType = type;

    try {
        if (!initializeQRModalElements()) {
            showToast('QR Scanner elements not found', 'error');
            return false;
        }

        const modal = document.getElementById('qrScannerModal');
        const qrReader = document.getElementById('qr-reader');

        qrReader.innerHTML = '';
        modal.classList.add('show');
        modal.style.display = 'flex';
        modal.style.zIndex = '999999';

        qrScannerInstance = new Html5Qrcode("qr-reader");
        isQRScanning = true;

        qrScannerInstance.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: { width: 250, height: 250 } },
            (decodedText) => onScanSuccess(decodedText),
            (error) => onScanError(error)
        ).catch(handleCameraError);

        return true;

    } catch (error) {
        console.error('Error starting QR scanner:', error);
        showToast('Failed to start QR scanner', 'error');
        return false;
    }
}

function onScanSuccess(decodedText) {
    if (qrScannerInstance) {
        qrScannerInstance.stop();
        qrScannerInstance.clear();
        qrScannerInstance = null;
    }
    isQRScanning = false;

    if (currentBorrowScanType === 'member') {
        processMemberQR(decodedText);
    } else if (currentBorrowScanType === 'book') {
        processBookQR(decodedText);
    }

    closeQRScannerModal();
}

function onScanError(error) {
    if (error && !error.includes('NotFoundException')) {
        console.debug('QR Scan error:', error);
    }
}

function handleCameraError(error) {
    console.error('Camera error:', error);
    let errorMessage = 'Unable to access camera. ';

    if (error.name === 'NotAllowedError' || error.name === 'PermissionDeniedError') {
        errorMessage += 'Please allow camera access in your browser settings.';
    } else if (error.name === 'NotFoundError') {
        errorMessage += 'No camera found on this device.';
    } else if (error.name === 'NotReadableError') {
        errorMessage += 'Camera is being used by another application.';
    } else {
        errorMessage += error.message || 'Unknown error occurred.';
    }

    showToast(errorMessage, 'error');
}

function stopQRScan() {
    if (qrScannerInstance && isQRScanning) {
        qrScannerInstance.stop()
            .then(() => {
                qrScannerInstance.clear();
                qrScannerInstance = null;
            })
            .catch(err => {
                console.error('Error stopping QR scanner:', err);
                qrScannerInstance = null;
            })
            .finally(() => {
                isQRScanning = false;
                closeQRScannerModal();
            });
    } else {
        isQRScanning = false;
        closeQRScannerModal();
    }
}

function cleanupScannerInstance() {
    if (qrScannerInstance) {
        try {
            qrScannerInstance.clear();
        } catch (e) {
            console.error('Error clearing scanner:', e);
        }
        qrScannerInstance = null;
    }

    isQRScanning = false;
    currentBorrowScanType = null;
}

function stopAllMediaTracks() {
    const videos = document.querySelectorAll('video');
    videos.forEach(video => {
        if (video.srcObject) {
            const stream = video.srcObject;
            const tracks = stream.getTracks();
            tracks.forEach(track => {
                track.stop();
            });
            video.srcObject = null;
        }
    });
}

function showQRScannerModal(type) {
    const modal = document.getElementById('qrScannerModal');
    if (!modal) {
        showToast('QR Scanner modal not found', 'error');
        return;
    }

    window.previousModal = document.getElementById('borrowModal');

    const qrReader = document.getElementById('qr-reader');
    if (qrReader) {
        qrReader.innerHTML = '';
    }

    modal.classList.add('show');
    modal.style.display = 'flex';
    modal.style.zIndex = '999999999';
    modal.style.position = 'fixed';
    modal.style.top = '0';
    modal.style.left = '0';
    modal.style.width = '100%';
    modal.style.height = '100%';
    modal.style.justifyContent = 'center';
    modal.style.alignItems = 'center';

    const modalContent = modal.querySelector('.modal-content');
    if (modalContent) {
        modalContent.style.position = 'relative';
        modalContent.style.zIndex = '999999998';
        modalContent.style.margin = 'auto';
    }

    const borrowModal = document.getElementById('borrowModal');
    if (borrowModal) {
        borrowModal.style.zIndex = '999999900';
    }

    setTimeout(() => {
        startQRScan(type);
    }, 300);
}

function closeQRScannerModal() {
    const modal = document.getElementById('qrScannerModal');
    if (!modal) return;

    if (qrScannerInstance) {
        qrScannerInstance.stop()
            .then(() => {
                cleanupScannerInstance();
            })
            .catch(err => {
                console.error('Error stopping scanner:', err);
                cleanupScannerInstance();
            });
    } else {
        cleanupScannerInstance();
    }

    stopAllMediaTracks();

    modal.classList.remove('show');
    modal.style.display = 'none';

    const qrReader = document.getElementById('qr-reader');
    if (qrReader) {
        qrReader.innerHTML = '';
    }

    if (window.previousModal && window.previousModal.classList.contains('show')) {
        window.previousModal.style.display = 'flex';
    }

    currentBorrowScanType = null;
    window.previousModal = null;
}

function closeQRScanner() {
    if (qrScannerInstance) {
        qrScannerInstance.stop()
            .then(() => {
                cleanupScannerInstance();
            })
            .catch(err => {
                console.error('Error stopping scanner:', err);
                cleanupScannerInstance();
            });
    } else {
        cleanupScannerInstance();
    }

    stopAllMediaTracks();
    closeQRScannerModal();
}

function updateQRStatus(message) {
    let status = document.getElementById('qr-status');
    if (!status) {
        const qrReader = document.getElementById('qr-reader');
        if (qrReader) {
            status = document.createElement('p');
            status.id = 'qr-status';
            status.style.cssText = 'text-align: center; color: var(--text-secondary); font-size: 0.9rem; margin-top: 10px;';
            qrReader.parentNode.appendChild(status);
        }
    }

    if (status) {
        status.textContent = message;
    }
}

function forceCleanupScanners() {
    if (qrScannerInstance) {
        try {
            qrScannerInstance.stop();
            qrScannerInstance.clear();
        } catch (e) {
            console.error('Error during force cleanup:', e);
        }
        qrScannerInstance = null;
    }

    isQRScanning = false;
    currentBorrowScanType = null;

    const modal = document.getElementById('qrScannerModal');
    if (modal) {
        modal.classList.remove('show');
        modal.style.display = 'none';

        const qrReader = document.getElementById('qr-reader');
        if (qrReader) {
            qrReader.innerHTML = '';
        }
    }

    stopAllMediaTracks();
}

function testQRScanner() {
    if (typeof Html5Qrcode === 'undefined') {
        showToast('Html5Qrcode library not loaded', 'error');
        return;
    }

    showToast('QR Scanner library is loaded', 'success');

    if (initializeQRModalElements()) {
        showToast('QR Modal elements initialized successfully', 'success');
    } else {
        showToast('Failed to initialize QR modal elements', 'error');
    }
}

function debugButtonState() {
    const memberName = document.getElementById('memberName');
    const confirmBtn = document.getElementById('confirmBorrowBtn');
    const selectedBooksList = document.getElementById('selectedBooksList');

    console.log('Manual debug - Element status:', {
        memberName: !!memberName,
        confirmBtn: !!confirmBtn,
        selectedBooksList: !!selectedBooksList
    });

    if (memberName) {
        console.log('Manual debug - Member name value:', `"${memberName.value}"`);
    }

    if (confirmBtn) {
        console.log('Manual debug - Button current state:', {
            innerHTML: confirmBtn.innerHTML,
            disabled: confirmBtn.disabled,
            style: confirmBtn.style.cssText
        });
    }

    if (selectedBooksList) {
        console.log('Manual debug - Books count:', selectedBooksList.children.length);
    }

    updateConfirmButtonState();

    showToast('Button state debug completed - check console', 'info');
}

document.addEventListener('DOMContentLoaded', function() {
    const forceEnableButtons = () => {
        const buttons = document.querySelectorAll('button');
        buttons.forEach(btn => {
            if (btn.id === 'confirmBorrowBtn' ||
                btn.textContent.toLowerCase().includes('confirm borrow') ||
                btn.textContent.toLowerCase().includes('borrow')) {

                btn.disabled = false;
                btn.removeAttribute('disabled');
                btn.style.pointerEvents = 'auto';
                btn.style.opacity = '1';
                btn.style.cursor = 'pointer';
                btn.classList.remove('disabled');
                btn.classList.remove('btn-disabled');

                if (btn.id === 'confirmBorrowBtn') {
                    btn.onclick = confirmBorrow;
                }
            }
        });
    };

    setTimeout(forceEnableButtons, 100);
    setTimeout(forceEnableButtons, 500);
    setTimeout(forceEnableButtons, 1000);

    const originalOpenBorrowModal = window.openBorrowModal;
    if (originalOpenBorrowModal) {
        window.openBorrowModal = function() {
            const result = originalOpenBorrowModal.apply(this, arguments);
            setTimeout(forceEnableButtons, 200);
            return result;
        };
    }
});

function forceEnableBorrowButton() {
    const buttons = document.querySelectorAll('button');
    let enabledCount = 0;

    buttons.forEach(btn => {
        if (btn.textContent.toLowerCase().includes('select books') ||
            btn.textContent.toLowerCase().includes('confirm') ||
            btn.textContent.toLowerCase().includes('borrow') ||
            btn.id === 'confirmBorrowBtn') {

            btn.disabled = false;
            btn.removeAttribute('disabled');
            btn.style.pointerEvents = 'auto';
            btn.style.opacity = '1';
            btn.style.cursor = 'pointer';
            btn.classList.remove('disabled');
            btn.classList.remove('btn-disabled');

            if (btn.id === 'confirmBorrowBtn') {
                btn.onclick = confirmBorrow;
            }

            enabledCount++;
        }
    });

    showToast(`Enabled ${enabledCount} button(s)`, 'success');
}

function enableBorrowButton() {
    const btn = document.getElementById('confirmBorrowBtn');
    if (btn) {
        btn.disabled = false;
        btn.removeAttribute('disabled');
        btn.style.cssText = 'pointer-events: auto !important; opacity: 1 !important; cursor: pointer !important;';
        btn.onclick = confirmBorrow;
        return true;
    }
    return false;
}

function processMemberQR(qrData) {
    let memberId = null;

    try {
        const url = new URL(qrData);
        const parts = url.pathname.split('/');
        if (parts[1] === 'members' && parts[2]) {
            memberId = parts[2];
        }
    } catch {
        memberId = qrData.split('/').pop();
    }

    if (!memberId || isNaN(memberId)) {
        showToast('Invalid member QR code', 'error');
        return;
    }

    fetch(`/members/${memberId}`)
        .then(response => {
            if (!response.ok) throw new Error('Member not found');
            return response.json();
        })
        .then(member => {
            const nameParts = [
                member.first_name,
                (member.middle_name && member.middle_name !== 'null') ? member.middle_name : null,
                (member.last_name && member.last_name !== 'null') ? member.last_name : null
            ].filter(Boolean);

            const fullName = nameParts.join(' ');

            const memberNameInput = document.getElementById('memberName');
            const memberIdInput = document.getElementById('memberId');

            if (memberNameInput) {
                memberNameInput.value = fullName;
                memberNameInput.dispatchEvent(new Event('input', { bubbles: true }));
            }

            if (memberIdInput) {
                memberIdInput.value = member.id;
            }

            updateConfirmButtonState();
            showToast(`Member: ${fullName}`, 'success');
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Failed to load member information', 'error');
        });
}

function processBookQR(qrData) {
    let bookId = null;

    try {
        const url = new URL(qrData);
        const parts = url.pathname.split('/');
        if (parts[1] === 'books' && parts[2]) {
            bookId = parts[2];
        }
    } catch {
        const match = qrData.match(/book-(\d+)/);
        if (match) {
            bookId = match[1];
        } else {
            bookId = qrData.split('/').pop();
        }
    }

    if (!bookId || isNaN(bookId)) {
        showToast('Invalid book QR code', 'error');
        return;
    }

    const row = document.querySelector(`tr[data-id="${bookId}"]`);
    if (!row) {
        showToast('Book not found', 'error');
        return;
    }

    const availability = parseInt(row.dataset.availability);
    if (availability <= 0) {
        showToast('Book not available', 'warning');
        return;
    }

    const title = row.dataset.title;
    const alreadySelected = document.querySelector(`#selectedBooksList li[data-id="${bookId}"]`);

    if (alreadySelected) {
        showToast('Book already selected', 'warning');
        return;
    }

    row.classList.add('selected');

    const list = document.getElementById('selectedBooksList');
    if (list) {
        const li = document.createElement('li');
        li.textContent = title;
        li.setAttribute('data-id', bookId);
        li.style.padding = '8px 0';
        li.style.borderBottom = '1px solid var(--border-light)';
        list.appendChild(li);
    }

    updateConfirmButtonState();
    showToast(`Added: ${title}`, 'success');
}

// ======================
// EXPORT FUNCTIONS
// ======================

window.borrowOne = borrowOne;
window.openBorrowModal = openBorrowModal;
window.closeBorrowModal = closeBorrowModal;
window.confirmBorrow = confirmBorrow;
window.clearMemberInfo = clearMemberInfo;
window.removeBookFromSelection = removeBookFromSelection;
window.enterSelectionMode = enterSelectionMode;
window.exitSelectionMode = exitSelectionMode;
window.selectAllBooks = selectAllBooks;
window.unselectAllBooks = unselectAllBooks;
window.deleteSelected = deleteSelected;
window.editBook = editBook;
window.showToast = showToast;
window.updateConfirmButtonState = updateConfirmButtonState;

window.startQRScan = startQRScan;
window.stopQRScan = stopQRScan;
window.showQRScannerModal = showQRScannerModal;
window.closeQRScannerModal = closeQRScannerModal;
window.closeQRScanner = closeQRScanner;
window.testQRScanner = testQRScanner;
window.debugButtonState = debugButtonState;
window.forceEnableBorrowButton = forceEnableBorrowButton;
window.enableBorrowButton = enableBorrowButton;
window.forceCleanupScanners = forceCleanupScanners;
window.stopAllMediaTracks = stopAllMediaTracks;
window.cleanupScannerInstance = cleanupScannerInstance;
window.processMemberQR = processMemberQR;
window.processBookQR = processBookQR;
window.initializeQRModalElements = initializeQRModalElements;

window.openQRScanner = showQRScannerModal;