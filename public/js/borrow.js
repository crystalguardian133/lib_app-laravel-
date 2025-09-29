// ======================
// BORROW.JS - COMPLETE IMPLEMENTATION
// ======================

// Global variables
let selectedBooks = [];
let selectionMode = false;

// DEBUG: Log when borrow.js is loaded
console.log('🚀 BORROW.JS LOADED - Version with Philippine business days and z-index fixes');
console.log('📅 Current time in Philippine timezone:', new Date().toLocaleString('en-US', {timeZone: 'Asia/Manila'}));

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
// UTILITY FUNCTIONS
// ======================

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Initialize custom precise time picker
function initializeCustomTimePicker() {
    const dueHour = document.getElementById('dueHour');
    const dueMinute = document.getElementById('dueMinute');
    const dueAmPm = document.getElementById('dueAmPm');
    const dueTimeHidden = document.getElementById('dueTime');

    if (!dueHour || !dueMinute || !dueAmPm || !dueTimeHidden) {
        console.error('❌ Custom time picker elements not found');
        return;
    }

    // Set default time to current Philippine time
    const now = new Date();
    const philippineOffset = 8 * 60; // 8 hours in minutes
    const utcTime = now.getTime() + (now.getTimezoneOffset() * 60000);
    const philippineTime = new Date(utcTime + (philippineOffset * 60000));

    let currentHour = philippineTime.getHours();
    const currentMinute = philippineTime.getMinutes();

    // Convert to 12-hour format
    let ampm = 'AM';
    if (currentHour >= 12) {
        ampm = 'PM';
        if (currentHour > 12) {
            currentHour -= 12;
        }
    } else if (currentHour === 0) {
        currentHour = 12;
    }

    // Round minutes to nearest 15-minute interval for better UX
    const minuteOptions = [0, 15, 30, 45];
    const roundedMinute = minuteOptions.reduce((prev, curr) =>
        Math.abs(curr - currentMinute) < Math.abs(prev - currentMinute) ? curr : prev
    );

    dueHour.value = currentHour.toString();
    dueMinute.value = roundedMinute.toString().padStart(2, '0');
    dueAmPm.value = ampm;

    console.log('⏰ Current Philippine time set:', `${currentHour}:${roundedMinute.toString().padStart(2, '0')} ${ampm}`);

    // Update hidden input whenever any selector changes
    function updateHiddenTimeInput() {
        const hour = parseInt(dueHour.value);
        const minute = dueMinute.value;
        const ampm = dueAmPm.value;

        // Convert to 24-hour format for the hidden input
        let hour24 = hour;
        if (ampm === 'PM' && hour !== 12) {
            hour24 = hour + 12;
        } else if (ampm === 'AM' && hour === 12) {
            hour24 = 0;
        }

        const timeString = `${hour24.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
        dueTimeHidden.value = timeString;

        console.log('⏰ Time updated:', `${hour}:${minute} ${ampm}`, '→', timeString);
    }

    // Add event listeners
    dueHour.addEventListener('change', updateHiddenTimeInput);
    dueMinute.addEventListener('change', updateHiddenTimeInput);
    dueAmPm.addEventListener('change', updateHiddenTimeInput);

    // Initial update
    updateHiddenTimeInput();

    console.log('⏰ Custom time picker initialized successfully');
}


// ======================
// BORROW MODAL FUNCTIONS
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

    // Philippine holidays for 2025 (you can expand this for other years)
    const philippineHolidays = [
        '2025-01-01', // New Year
        '2025-02-25', // EDSA Revolution
        '2025-04-17', // Maundy Thursday
        '2025-04-18', // Good Friday
        '2025-04-19', // Black Saturday
        '2025-05-01', // Labor Day
        '2025-06-12', // Independence Day
        '2025-08-25', // National Heroes Day
        '2025-11-01', // All Saints Day
        '2025-11-30', // Bonifacio Day
        '2025-12-25', // Christmas
        '2025-12-30', // Rizal Day
        '2025-12-31'  // New Year's Eve
    ];

    // Check if a date is a Philippine holiday
    function isPhilippineHoliday(dateString) {
        return philippineHolidays.includes(dateString);
    }

    // Calculate Philippine business days (10 working days) excluding holidays
    function calculatePhilippineBusinessDueDate() {
        console.log('🔄 Calculating Philippine business due date (excluding holidays)...');

        // Get current date in Philippine timezone (Asia/Manila, UTC+8)
        const now = new Date();
        const philippineOffset = 8 * 60; // 8 hours in minutes
        const utcTime = now.getTime() + (now.getTimezoneOffset() * 60000);
        const philippineTime = new Date(utcTime + (philippineOffset * 60000));

        console.log('📅 Current Philippine time:', philippineTime.toLocaleString('en-US', {timeZone: 'Asia/Manila'}));

        // Start from tomorrow for due date calculation
        const startDate = new Date(philippineTime);
        startDate.setDate(startDate.getDate() + 1);

        console.log('📅 Starting calculation from:', startDate.toLocaleDateString());

        // Calculate 10 working days (Monday to Friday, excluding weekends and holidays)
        let workingDaysCount = 0;
        let currentDate = new Date(startDate);
        const workingDates = [];

        while (workingDaysCount < 10) {
            // Move to next day
            currentDate.setDate(currentDate.getDate() + 1);

            // Check if it's a weekday (Monday = 1, Friday = 5)
            const dayOfWeek = currentDate.getDay();
            const dateString = currentDate.toISOString().split('T')[0];

            if (dayOfWeek >= 1 && dayOfWeek <= 5 && !isPhilippineHoliday(dateString)) {
                workingDaysCount++;
                workingDates.push(new Date(currentDate));
                console.log(`✅ Working day ${workingDaysCount}:`, currentDate.toLocaleDateString(), `(not a holiday)`);
            } else {
                if (dayOfWeek < 1 || dayOfWeek > 5) {
                    console.log(`❌ Weekend skipped:`, currentDate.toLocaleDateString(), `(Day ${dayOfWeek})`);
                } else if (isPhilippineHoliday(dateString)) {
                    console.log(`❌ Holiday skipped:`, currentDate.toLocaleDateString(), `(${dateString})`);
                }
            }
        }

        console.log('🎯 Final due date calculated:', currentDate.toLocaleDateString());
        console.log('📅 All working dates:', workingDates.map(d => d.toLocaleDateString()));

        return {
            finalDate: currentDate,
            workingDates: workingDates
        };
    }

    const dueDateResult = calculatePhilippineBusinessDueDate();
    const dueDate = dueDateResult.finalDate;
    const workingDates = dueDateResult.workingDates;

    console.log('📋 Due date set to:', dueDate.toISOString().split('T')[0]);

    const dueDateInput = document.getElementById('dueDate');
    if (dueDateInput) {
        dueDateInput.value = dueDate.toISOString().split('T')[0];

        // Restrict date picker to only allow the calculated working days
        dueDateInput.setAttribute('min', workingDates[0].toISOString().split('T')[0]);
        dueDateInput.setAttribute('max', dueDate.toISOString().split('T')[0]);

        // Set up validation for working days only
        dueDateInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const dayOfWeek = selectedDate.getDay();
            const dateString = this.value;

            if (dayOfWeek === 0 || dayOfWeek === 6) {
                showToast('Please select a weekday (Monday to Friday)', 'warning');
                this.value = dueDate.toISOString().split('T')[0];
                return;
            }

            if (isPhilippineHoliday(dateString)) {
                showToast('Selected date is a Philippine holiday. Please choose another date.', 'warning');
                this.value = dueDate.toISOString().split('T')[0];
                return;
            }

            // Check if selected date is one of the calculated working days
            const isValidWorkingDay = workingDates.some(wd =>
                wd.toISOString().split('T')[0] === dateString
            );

            if (!isValidWorkingDay) {
                showToast('Please select one of the available working days', 'warning');
                this.value = dueDate.toISOString().split('T')[0];
            }
        });

        // Create a custom date picker experience by showing available dates
        console.log('📅 Available working dates for selection:');
        workingDates.forEach((date, index) => {
            console.log(`${index + 1}. ${date.toLocaleDateString()} (${date.toLocaleDateString('en-US', {weekday: 'long'})})`);
        });

    }

    // Initialize custom time picker
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

    // Reset custom time picker
    const dueHour = document.getElementById('dueHour');
    const dueMinute = document.getElementById('dueMinute');
    const dueAmPm = document.getElementById('dueAmPm');

    if (dueHour) dueHour.value = '5'; // 5 PM
    if (dueMinute) dueMinute.value = '59';
    if (dueAmPm) dueAmPm.value = 'PM';

    const list = document.getElementById('selectedBooksList');
    if (list) list.innerHTML = '';

    selectedBooks = [];

    const memberNameField = document.getElementById('memberName');
    if (memberNameField) {
        memberNameField.style.backgroundColor = 'var(--surface-elevated)';
        memberNameField.style.cursor = 'not-allowed';
    }

    updateConfirmButtonState();
}

function confirmBorrow() {
    const memberName = document.getElementById('memberName').value.trim();
    const memberId = document.getElementById('memberId').value.trim();
    const dueDate = document.getElementById('dueDate').value;
    const dueTimeHidden = document.getElementById('dueTime');
    const dueTime = dueTimeHidden ? dueTimeHidden.value : '';

    if (!memberName || !memberId) {
        showToast('Please scan member QR code', 'warning');
        return;
    }

    if (!dueDate || !dueTime) {
        showToast('Please set due date and time', 'warning');
        return;
    }

    const selectedRows = document.querySelectorAll('#booksTableBody tr.selected');
    if (selectedRows.length === 0) {
        showToast('No books selected', 'warning');
        return;
    }

    const token = document.querySelector('meta[name="csrf-token"]').content;
    if (!token) {
        showToast('Security token missing. Please refresh the page.', 'error');
        return;
    }

    const bookIds = Array.from(selectedRows).map(row => parseInt(row.dataset.id));
    const borrowData = {
        member_name: memberName,
        due_date: dueDate,
        due_time: dueTime,
        book_ids: bookIds
    };

    const confirmButton = document.querySelector('#borrowModal .btn-primary');
    if (confirmButton) {
        const originalText = confirmButton.innerHTML;
        confirmButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        confirmButton.disabled = true;

        fetch('/borrow/process', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(borrowData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            showToast('Books borrowed successfully!', 'success');
            closeBorrowModal();
            setTimeout(() => {
                location.reload();
            }, 1500);
        })
        .catch(error => {
            console.error('Borrow error:', error);
            showToast('Failed to process borrowing', 'error');
        })
        .finally(() => {
            confirmButton.innerHTML = originalText;
            confirmButton.disabled = false;
        });
    }
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

    if (memberName && confirmBtn) {
        const hasMember = memberName.value.trim() !== '';
        const hasBooks = selectedBooksList && selectedBooksList.children.length > 0;

        confirmBtn.disabled = !hasMember || !hasBooks;

        if (!hasMember) {
            confirmBtn.innerHTML = '<i class="fas fa-qrcode"></i> Confirm';
            confirmBtn.style.backgroundColor = '#9ca3af'; // Gray color
            confirmBtn.style.cursor = 'pointer';
            confirmBtn.style.opacity = '1';
            confirmBtn.onclick = function() {
                showQRScannerModal('member');
            };
        } else if (!hasBooks) {
            confirmBtn.innerHTML = '<i class="fas fa-qrcode"></i> Confirm';
            confirmBtn.style.backgroundColor = '#9ca3af'; // Gray color
            confirmBtn.style.cursor = 'pointer';
            confirmBtn.style.opacity = '1';
            confirmBtn.onclick = function() {
                showToast('Please add books to borrow first', 'warning');
            };
        } else {
            confirmBtn.innerHTML = '<i class="fas fa-check"></i> Confirm';
            confirmBtn.style.backgroundColor = '#10b981'; // Green color for success
            confirmBtn.style.cursor = 'pointer';
            confirmBtn.style.opacity = '1';
            confirmBtn.onclick = function() {
                confirmBorrow();
            };
        }
    }
}

function clearMemberInfo() {
    const memberNameField = document.getElementById('memberName');
    const memberIdField = document.getElementById('memberId');

    if (memberNameField) {
        memberNameField.value = '';
        memberNameField.style.backgroundColor = 'var(--surface-elevated)';
        memberNameField.style.cursor = 'not-allowed';
    }

    if (memberIdField) {
        memberIdField.value = '';
    }

    updateConfirmButtonState();
    showToast('Member information cleared', 'info');
}

function removeBookFromSelection(bookId) {
    selectedBooks = selectedBooks.filter(book => book.id != bookId);

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

// Global variables for QR scanner
let currentBorrowScanType = null;
let qrScannerInstance = null;
let isQRScanning = false;

// ======================
// QR SCANNER FUNCTIONS - INTEGRATED
// ======================

function initializeQRModalElements() {
    console.log('Initializing QR modal elements...');

    const modal = document.getElementById('qrScannerModal');
    const qrReader = document.getElementById('qr-reader');
    const qrInstruction = document.getElementById('qr-instruction');
    const qrButtons = document.getElementById('qr-buttons');

    if (!modal) {
        console.error('QR Scanner modal not found');
        return false;
    }

    if (!qrReader) {
        console.error('QR reader element not found');
        return false;
    }

    // Initialize modal content if elements are missing
    if (!qrInstruction) {
        const instruction = document.createElement('p');
        instruction.id = 'qr-instruction';
        instruction.style.cssText = 'margin-top: 15px; color: var(--text-secondary); font-size: 0.9rem; text-align: center;';
        instruction.textContent = 'Point your camera at a QR code to scan';
        qrReader.parentNode.appendChild(instruction);
    }

    if (!qrButtons) {
        const buttonsDiv = document.createElement('div');
        buttonsDiv.id = 'qr-buttons';
        buttonsDiv.style.cssText = 'display: flex; gap: 10px; margin-top: 20px; justify-content: center;';

        const cancelBtn = document.createElement('button');
        cancelBtn.type = 'button';
        cancelBtn.className = 'btn btn-outline';
        cancelBtn.style.minWidth = '120px';
        cancelBtn.innerHTML = '<i class="fas fa-times"></i> Cancel';
        cancelBtn.onclick = () => closeQRScanner();

        buttonsDiv.appendChild(cancelBtn);
        qrReader.parentNode.appendChild(buttonsDiv);
    }

    console.log('QR modal elements initialized successfully');
    return true;
}

function startQRScan(type) {
    console.log(`startQRScan called with type: ${type}`);

    if (typeof Html5Qrcode === 'undefined') {
        showToast('QR Scanner library not loaded. Please refresh the page.', 'error');
        return false;
    }

    if (isQRScanning) {
        console.log('QR Scanner already active');
        return false;
    }

    currentBorrowScanType = type;

    try {
        // Initialize modal elements first
        if (!initializeQRModalElements()) {
            showToast('QR Scanner modal not properly initialized', 'error');
            return false;
        }

        const modal = document.getElementById('qrScannerModal');
        const qrReader = document.getElementById('qr-reader');

        if (!modal || !qrReader) {
            showToast('QR Scanner elements not found', 'error');
            return false;
        }

        // Clear previous content
        qrReader.innerHTML = '';

        // Show modal
        modal.classList.add('show');
        modal.style.display = 'flex';
        modal.style.zIndex = '999999';

        // Initialize scanner
        qrScannerInstance = new Html5Qrcode("qr-reader");
        isQRScanning = true;

        updateQRStatus(`Scanning for ${type === 'member' ? 'member' : 'book'}...`);

        qrScannerInstance.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: { width: 250, height: 250 }
            },
            (decodedText) => onScanSuccess(decodedText),
            (error) => onScanError(error)
        ).catch(handleCameraError);

        console.log('QR Scanner started successfully');
        return true;

    } catch (error) {
        console.error('Error starting QR scanner:', error);
        showToast('Failed to start QR scanner: ' + error.message, 'error');
        return false;
    }
}

function onScanSuccess(decodedText) {
    console.log('QR Code detected:', decodedText);

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

    showQRError(errorMessage);
}

function stopQRScan() {
    console.log('Stopping QR scanner...');

    if (qrScannerInstance && isQRScanning) {
        qrScannerInstance.stop()
            .then(() => {
                console.log('QR Scanner stopped successfully');
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
    console.log('Cleaning up scanner instance...');

    if (qrScannerInstance) {
        try {
            qrScannerInstance.clear();
            console.log('Scanner instance cleared');
        } catch (e) {
            console.error('Error clearing scanner:', e);
        }

        qrScannerInstance = null;
        console.log('Scanner instance set to null');
    }

    isQRScanning = false;
    currentBorrowScanType = null;
    console.log('Scanner cleanup completed');
}

function stopAllMediaTracks() {
    console.log('Stopping all media tracks...');

    // Get all video elements and stop their tracks
    const videos = document.querySelectorAll('video');
    videos.forEach(video => {
        if (video.srcObject) {
            const stream = video.srcObject;
            const tracks = stream.getTracks();
            tracks.forEach(track => {
                console.log('Stopping track:', track.kind, track.label);
                track.stop();
            });
            video.srcObject = null;
        }
    });

    // Also check for any active getUserMedia streams
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        try {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    stream.getTracks().forEach(track => track.stop());
                    console.log('Dummy stream stopped');
                })
                .catch(err => {
                    console.log('Dummy stream approach not needed or failed:', err.message);
                });
        } catch (e) {
            console.error('Error with dummy stream approach:', e);
        }
    }

    console.log('Media tracks cleanup completed');
}

function showQRScannerModal(type) {
    console.log('🔍 Opening QR scanner modal for:', type);
    console.log('🎯 Current z-index values check...');

    const modal = document.getElementById('qrScannerModal');
    if (!modal) {
        console.error('❌ QR Scanner modal not found');
        showToast('QR Scanner modal not found', 'error');
        return;
    }

    // Check current z-index values
    const computedStyle = window.getComputedStyle(modal);
    console.log('📊 Current modal z-index:', computedStyle.zIndex);
    console.log('📊 Current modal display:', computedStyle.display);

    // Store reference to current modal (borrow modal)
    window.previousModal = document.getElementById('borrowModal');

    // Initialize modal elements
    initializeQRModalElements();

    // Clear previous content
    const qrReader = document.getElementById('qr-reader');
    if (qrReader) {
        qrReader.innerHTML = '';
    }

    updateQRStatus('Initializing camera...');

    // Show modal with extreme z-index and proper positioning (ABOVE borrow modal)
    modal.classList.add('show');
    modal.style.display = 'flex';
    modal.style.zIndex = '999999999'; // HIGHEST z-index for QR scanner
    modal.style.position = 'fixed';
    modal.style.top = '0';
    modal.style.left = '0';
    modal.style.width = '100%';
    modal.style.height = '100%';
    modal.style.justifyContent = 'center';
    modal.style.alignItems = 'center';

    // Ensure modal content is also properly positioned
    const modalContent = modal.querySelector('.modal-content');
    if (modalContent) {
        modalContent.style.position = 'relative';
        modalContent.style.zIndex = '999999998';
        modalContent.style.margin = 'auto';
    }

    // Ensure borrow modal has lower z-index
    const borrowModal = document.getElementById('borrowModal');
    if (borrowModal) {
        borrowModal.style.zIndex = '999999900'; // Lower than QR scanner
        console.log('📉 Borrow modal z-index set to:', borrowModal.style.zIndex);
    }

    console.log('✅ QR Scanner modal opened with z-index:', modal.style.zIndex);
    console.log('📍 Modal position:', modal.style.position, modal.style.top, modal.style.left);

    // Start scanning after a short delay
    setTimeout(() => {
        startQRScan(type);
    }, 300);
}

function closeQRScannerModal() {
    console.log('Closing QR scanner modal');

    const modal = document.getElementById('qrScannerModal');
    if (!modal) return;

    // 1. First, ensure scanner is properly stopped (aggressive cleanup)
    if (qrScannerInstance) {
        console.log('Force stopping scanner instance...');
        qrScannerInstance.stop()
            .then(() => {
                console.log('Scanner stopped successfully');
            })
            .catch(err => {
                console.error('Error stopping scanner:', err);
            })
            .finally(() => {
                cleanupScannerInstance();
            });
    } else {
        cleanupScannerInstance();
    }

    // 2. Stop all media tracks
    stopAllMediaTracks();

    // 3. Hide modal immediately
    modal.classList.remove('show');
    modal.style.display = 'none';

    // 4. Clear modal content immediately
    const qrReader = document.getElementById('qr-reader');
    if (qrReader) {
        qrReader.innerHTML = '';
    }

    // 5. Restore previous modal if it was open
    if (window.previousModal && window.previousModal.classList.contains('show')) {
        window.previousModal.style.display = 'flex';
    }

    currentBorrowScanType = null;
    window.previousModal = null;
}

function closeQRScanner() {
    console.log('closeQRScanner called - ensuring proper cleanup');

    // 1. Stop the scanner instance
    if (qrScannerInstance) {
        console.log('Force stopping scanner instance...');
        qrScannerInstance.stop()
            .then(() => {
                console.log('Scanner stopped successfully');
            })
            .catch(err => {
                console.error('Error stopping scanner:', err);
            })
            .finally(() => {
                cleanupScannerInstance();
            });
    } else {
        cleanupScannerInstance();
    }

    // 2. Also aggressively cleanup any running media tracks
    stopAllMediaTracks();

    // 3. Close modal
    closeQRScannerModal();
}

// ======================
// QR SCANNER UTILITY FUNCTIONS
// ======================

function updateQRStatus(message) {
    let status = document.getElementById('qr-status');
    if (!status) {
        // Create status element if it doesn't exist
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
        status.style.color = 'var(--text-secondary)';
    }
}

function showQRError(message) {
    const qrReader = document.getElementById('qr-reader');
    const status = document.getElementById('qr-status');

    if (qrReader) {
        qrReader.innerHTML = `
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 300px; padding: 40px;">
                <i class="fas fa-exclamation-triangle" style="font-size: 48px; color: var(--danger); margin-bottom: 20px;"></i>
                <h4 style="color: var(--text-primary); margin-bottom: 10px;">Camera Error</h4>
                <p style="color: var(--text-secondary); text-align: center; max-width: 300px;">${message}</p>
            </div>
        `;
    }

    if (status) {
        status.textContent = 'Camera access failed';
        status.style.color = 'var(--danger)';
    }

    showToast(message, 'error');
    isQRScanning = false;
}

// Force cleanup function for emergency situations
function forceCleanupScanners() {
    console.log('Force cleanup of all scanners...');

    // Reset all global variables
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

    // Close any open QR scanner modals
    const modal = document.getElementById('qrScannerModal');
    if (modal) {
        modal.classList.remove('show');
        modal.style.display = 'none';

        const qrReader = document.getElementById('qr-reader');
        if (qrReader) {
            qrReader.innerHTML = '';
        }
    }

    // Stop all media tracks
    stopAllMediaTracks();

    console.log('Force cleanup completed');
}

// Test function for debugging
function testQRScanner() {
    console.log('Testing QR Scanner...');

    if (typeof Html5Qrcode === 'undefined') {
        showToast('Html5Qrcode library not loaded', 'error');
        return;
    }

    showToast('QR Scanner library is loaded', 'success');

    // Test modal elements
    if (initializeQRModalElements()) {
        showToast('QR Modal elements initialized successfully', 'success');
    } else {
        showToast('Failed to initialize QR modal elements', 'error');
    }
}

function processMemberQR(qrData) {
    console.log('🔍 Processing member QR:', qrData);

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

    console.log('📋 Extracted member ID:', memberId);

    if (!memberId || isNaN(memberId)) {
        showToast('Invalid member QR code format', 'error');
        closeQRScannerModal();
        return;
    }

    fetch(`/api/members/${memberId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Member not found');
            }
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
                memberNameInput.style.backgroundColor = 'rgba(16, 185, 129, 0.1)';
                memberNameInput.style.cursor = 'default';
                // Trigger change event to update button state
                memberNameInput.dispatchEvent(new Event('change'));
            }

            if (memberIdInput) {
                memberIdInput.value = member.id;
            }

            // Update button state after member is processed
            updateConfirmButtonState();

            showToast(`Member: ${fullName}`, 'success');
            closeQRScannerModal();
        })
        .catch(error => {
            console.error('Member fetch error:', error);
            showToast('Failed to load member information', 'error');
            closeQRScannerModal();
        });
}

function processBookQR(qrData) {
    console.log('Processing book QR:', qrData);

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
        closeQRScannerModal();
        return;
    }

    const row = document.querySelector(`tr[data-id="${bookId}"]`);

    if (!row) {
        showToast('Book not found in library', 'error');
        closeQRScannerModal();
        return;
    }

    const availability = parseInt(row.dataset.availability);
    if (isNaN(availability) || availability <= 0) {
        showToast('Book is not available', 'warning');
        closeQRScannerModal();
        return;
    }

    const title = row.dataset.title;
    const alreadySelected = selectedBooks.some(book => book.id == bookId);

    if (alreadySelected) {
        showToast('Book already selected', 'warning');
        closeQRScannerModal();
        return;
    }

    selectedBooks.push({ id: bookId, title: title });
    row.classList.add('selected');

    const list = document.getElementById('selectedBooksList');
    if (list) {
        const li = document.createElement('li');
        li.textContent = title;
        li.setAttribute('data-id', bookId);
        li.style.padding = '8px 0';
        li.style.borderBottom = '1px solid var(--border-light)';

        const removeBtn = document.createElement('button');
        removeBtn.innerHTML = '<i class="fas fa-times"></i>';
        removeBtn.className = 'btn btn-sm btn-danger';
        removeBtn.style.marginLeft = '10px';
        removeBtn.style.padding = '4px 8px';
        removeBtn.onclick = () => removeBookFromSelection(bookId);

        li.appendChild(removeBtn);
        list.appendChild(li);
    }

    updateConfirmButtonState();

    showToast(`Added: ${title}`, 'success');
    closeQRScannerModal();
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

// QR Scanner functions
window.startQRScan = startQRScan;
window.stopQRScan = stopQRScan;
window.showQRScannerModal = showQRScannerModal;
window.closeQRScannerModal = closeQRScannerModal;
window.closeQRScanner = closeQRScanner;
window.testQRScanner = testQRScanner;
window.forceCleanupScanners = forceCleanupScanners;
window.stopAllMediaTracks = stopAllMediaTracks;
window.cleanupScannerInstance = cleanupScannerInstance;
window.processMemberQR = processMemberQR;
window.processBookQR = processBookQR;
window.initializeQRModalElements = initializeQRModalElements;

// Legacy compatibility
window.openQRScanner = showQRScannerModal;
