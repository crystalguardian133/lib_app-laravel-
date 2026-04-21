// ======================
// BORROW.JS - CLEAN & SIMPLE VERSION
// ======================

// Global variables
let selectedBooks = [];
let selectionMode = false;

// Enhanced book data structure for better readability
let borrowerBooksData = [];

function normalizeIdentifier(value) {
    return String(value ?? '').trim();
}

function findBookRow(identifier) {
    const normalized = normalizeIdentifier(identifier);
    if (!normalized) return null;
    return document.querySelector(`tr[data-id="${normalized}"]`) ||
        document.querySelector(`tr[data-legacy-id="${normalized}"]`);
}

// DEBUG: Log when borrow.js is loaded
console.log('🚀 BORROW.JS LOADED - Enhanced Multiple Books Version');

// Enhanced book data management functions
function addBookToBorrowerData(bookData) {
    // bookData should be an object with id, title, author, etc.
    if (!bookData || !bookData.id) {
        console.error('Invalid book data provided to addBookToBorrowerData');
        return false;
    }

    // Check if book already exists
    const existingIndex = borrowerBooksData.findIndex(book => String(book.id) === String(bookData.id));
    if (existingIndex >= 0) {
        console.log('Book already in borrower data:', bookData.title);
        return false;
    }

    // Add book with readable information
    const enhancedBookData = {
        id: bookData.id,
        book_id: bookData.id, // Keep original book_id for backend compatibility
        title: bookData.title || 'Unknown Title',
        author: bookData.author || 'Unknown Author',
        genre: bookData.genre || null,
        published_year: bookData.published_year || null,
        availability: bookData.availability || 0,
        added_at: new Date().toISOString()
    };

    borrowerBooksData.push(enhancedBookData);
    console.log('Added book to borrower data:', enhancedBookData);
    return true;
}

function removeBookFromBorrowerData(bookId) {
    const normalizedBookId = normalizeIdentifier(bookId);
    const index = borrowerBooksData.findIndex(book => String(book.id) === normalizedBookId);
    if (index >= 0) {
        const removedBook = borrowerBooksData.splice(index, 1)[0];
        console.log('Removed book from borrower data:', removedBook);
        return removedBook;
    }
    return null;
}

function getBorrowerBooksData() {
    return [...borrowerBooksData]; // Return a copy to prevent external modification
}

function clearBorrowerBooksData() {
    console.log('Cleared borrower books data. Previous count:', borrowerBooksData.length);
    borrowerBooksData = [];
}

function getBookIdsArray() {
    return borrowerBooksData.map(book => book.id);
}

function getReadableBooksList() {
    return borrowerBooksData.map(book => ({
        book_id: book.book_id,
        title: book.title,
        author: book.author,
        details: `${book.title} by ${book.author}${book.published_year ? ` (${book.published_year})` : ''}`
    }));
}

// ======================
// TOAST NOTIFICATIONS
// ======================

function showToast(message, type = 'info') {
    const existingToasts = document.querySelectorAll('.toast-notification');
    existingToasts.forEach(toast => toast.remove());

    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 100000000000;
        max-width: 400px;
        word-wrap: break-word;
    `;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// ======================
// CORE BORROW FUNCTIONS
// ======================

function openBorrowModal(initialBooks = []) {
    if (typeof window.setAutomaticDueDate === 'function') {
        window.setAutomaticDueDate();
    }
    
    const selectedRows = document.querySelectorAll('#booksTableBody tr.selected');
    const scannedBooks = Array.isArray(initialBooks) ? initialBooks : [];
    if (selectedRows.length === 0 && scannedBooks.length === 0) {
        showToast("No books selected for borrowing", 'warning');
        return;
    }

    // Clear previous borrower data
    clearBorrowerBooksData();

    const list = document.getElementById('selectedBooksList');
    if (list) {
        list.innerHTML = '';

        const appendBookToList = (bookData) => {
            const added = addBookToBorrowerData(bookData);
            if (!added) {
                return;
            }

            const li = document.createElement('li');
            li.textContent = `${bookData.title} by ${bookData.author}`;
            li.setAttribute('data-id', bookData.id);
            li.setAttribute('title', `Book ID: ${bookData.id} | Genre: ${bookData.genre || 'N/A'} | Year: ${bookData.published_year || 'N/A'}`);
            li.style.padding = '8px 0';
            li.style.borderBottom = '1px solid var(--border-light)';
            li.style.position = 'relative';

            const removeBtn = document.createElement('button');
            removeBtn.innerHTML = '×';
            removeBtn.className = 'btn btn-sm';
            removeBtn.style.cssText = `
                position: absolute;
                right: 0;
                top: 50%;
                transform: translateY(-50%);
                background: var(--danger);
                color: white;
                border: none;
                border-radius: 50%;
                width: 20px;
                height: 20px;
                font-size: 12px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
            `;
            removeBtn.onclick = function(e) {
                e.stopPropagation();
                removeBookFromSelection(bookData.id);
            };

            li.appendChild(removeBtn);
            list.appendChild(li);
        };

        selectedRows.forEach(row => {
            const bookData = {
                id: row.dataset.id,
                title: row.dataset.title || 'Unknown Title',
                author: row.dataset.author || 'Unknown Author',
                genre: row.dataset.genre || null,
                published_year: row.dataset.published_year || null,
                availability: row.dataset.availability || 0
            };
            appendBookToList(bookData);
        });

        scannedBooks.forEach(bookData => {
            appendBookToList(bookData);
        });
    }

    // Set automatic due date when modal opens
    if (typeof window.setAutomaticDueDate === 'function') {
        window.setAutomaticDueDate();
    }

    initializeCustomTimePicker();

    const memberNameInput = document.getElementById('memberName');
    const memberIdInput = document.getElementById('memberId');
    if (memberNameInput) memberNameInput.value = '';
    if (memberIdInput) memberIdInput.value = '';

    const modal = document.getElementById('borrowModal');
    if (modal) {
        modal.classList.add('active');
        modal.style.display = 'flex';
    }

    initializeMemberNameSearch();
    clearMemberSuggestions();

    updateConfirmButtonState();
}

function closeBorrowModal() {
    const modal = document.getElementById('borrowModal');
    if (modal) {
        modal.classList.remove('active');
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

    clearMemberSuggestions();

    // Clear enhanced data structures
    selectedBooks = [];
    clearBorrowerBooksData();
    updateConfirmButtonState();
}

function confirmBorrow() {
    const memberName = document.getElementById('memberName').value.trim();
    const memberId = document.getElementById('memberId').value.trim();
    const dueDate = document.getElementById('dueDate').value;
    const dueTimeHidden = document.getElementById('dueTime');
    const dueTime = dueTimeHidden ? dueTimeHidden.value : '';

    if (!memberName) {
        showToast('Please enter or scan a member name first', 'warning');
        return;
    }

    if (!dueTime) {
        showToast('Please set due time', 'warning');
        return;
    }

    // Check if due time is within allowed borrowing hours (7:30 AM - 4:30 PM)
    const minTime = '07:30';
    const maxTime = '16:30';
    if (dueTime < minTime || dueTime > maxTime) {
        showToast('Borrowing is only allowed between 7:30 AM and 4:30 PM', 'warning');
        return;
    }

    // Use enhanced borrower data structure
    const booksData = getBorrowerBooksData();
    const bookIds = getBookIdsArray();

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

    // Enhanced borrow data with readable book information
    const borrowData = {
        member_name: memberName,
        member_id: memberId || null,
        due_date: dueDate,
        due_time: dueTime,
        book_ids: bookIds,
        books_data: booksData, // Full book information for better tracking
        books_count: booksData.length,
        transaction_summary: {
            member: `${memberName} (ID: ${memberId})`,
            books: getReadableBooksList(),
            due_datetime: `${dueDate} ${dueTime}`,
            total_books: booksData.length
        }
    };

    console.log('📨 Enhanced borrow data being sent:');
    console.log('Member:', borrowData.transaction_summary.member);
    console.log('Books:', borrowData.transaction_summary.books);
    console.log('Due Date:', borrowData.transaction_summary.due_datetime);
    console.log('Book IDs Array:', bookIds);
    console.log('Full books data:', booksData);

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
    const row = findBookRow(bookId);
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
    
    // Open borrow modal - this will now automatically set due date
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
    const row = findBookRow(bookId);
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
    const dueTimeHidden = document.getElementById('dueTime');
    const dueTimeText = document.getElementById('dueTimeText');

    if (!dueTimeHidden) {
        console.error('Due time hidden input not found');
        return;
    }

    // Set to maximum allowed time (4:30 PM / 16:30) - fixed value
    const maxHour24 = 16; // 4 PM in 24-hour format
    const maxMinute = 30; // 30 minutes

    // Set hidden time input to maximum allowed time
    dueTimeHidden.value = `${maxHour24.toString().padStart(2, '0')}:${maxMinute.toString().padStart(2, '0')}`;
    
    // Update display text if element exists
    if (dueTimeText) {
        dueTimeText.textContent = '4:30 PM';
    }
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

    clearMemberSuggestions();

    updateConfirmButtonState();
    showToast('Member information cleared', 'info');
}

let memberSearchTimeout = null;
let memberSuggestionMap = new Map();

function setMemberFromSuggestion(member) {
    const memberName = document.getElementById('memberName');
    const memberId = document.getElementById('memberId');
    const fullName = getMemberFullName(member);

    if (!memberName || !fullName) return;

    memberName.value = fullName;
    memberName.style.cursor = 'text';
    memberName.readOnly = false;

    if (memberId) {
        memberId.value = member.uuid || member.id || '';
    }

    clearMemberSuggestions();
    updateConfirmButtonState();
}

function getMemberFullName(member) {
    if (!member) return '';

    const clean = (value) => {
        const str = String(value || '').trim();
        if (str === 'null' || str === '' || /^[-_\.\s]+$/.test(str)) return '';
        return str;
    };

    // Try single 'name' or 'full_name' field first
    if (member.name) {
        const nameValue = clean(member.name);
        if (nameValue) return nameValue;
    }
    if (member.full_name) {
        const fullNameValue = clean(member.full_name);
        if (fullNameValue) return fullNameValue;
    }

    // Combine first/middle/last name parts
    const parts = [
        clean(member.first_name),
        clean(member.middle_name),
        clean(member.last_name)
    ].filter(Boolean);

    if (parts.length > 0) {
        return parts.join(' ');
    }

    // Final fallback with ID
    return `Member #${member.id || member.uuid || 'Unknown'}`;
}

function clearMemberSuggestions() {
    memberSuggestionMap.clear();

    const datalist = document.getElementById('memberNameList');
    if (datalist) {
        datalist.innerHTML = '';
    }

    const suggestions = document.getElementById('memberSuggestions');
    if (suggestions) {
        suggestions.innerHTML = '';
        suggestions.style.display = 'none';
    }
}

function renderMemberSuggestions(members) {
    const datalist = document.getElementById('memberNameList');
    const suggestions = document.getElementById('memberSuggestions');

    if (!datalist && !suggestions) return;

    if (datalist) {
        datalist.innerHTML = '';
    }

    if (suggestions) {
        suggestions.innerHTML = '';
        suggestions.style.display = 'none';
    }

    memberSuggestionMap.clear();

    if (!Array.isArray(members) || members.length === 0) {
        return;
    }

    members.forEach(member => {
        const fullName = getMemberFullName(member);
        if (!fullName) return;

        memberSuggestionMap.set(fullName.toLowerCase(), member.uuid || member.id);

        if (datalist) {
            const option = document.createElement('option');
            option.value = fullName;
            option.label = `ID: ${member.id}`;
            datalist.appendChild(option);
        }

        if (suggestions) {
            const item = document.createElement('button');
            item.type = 'button';
            item.className = 'member-suggestion-item';
            item.dataset.memberId = member.uuid || member.id;
            item.dataset.memberName = fullName;
            item.style.cssText = 'display:block; width:100%; text-align:left; border:none; background:transparent; padding:10px 12px; cursor:pointer; color: var(--text-primary);';
            item.innerHTML = `<strong>${escapeHtml(fullName)}</strong><br><small style="color: var(--text-secondary);">ID: ${escapeHtml(String(member.id ?? ''))}</small>`;
            item.addEventListener('click', () => setMemberFromSuggestion(member));
            suggestions.appendChild(item);
        }
    });

    if (suggestions && suggestions.children.length > 0) {
        suggestions.style.display = 'block';
    }
}

async function fetchMemberSuggestions(query) {
    const endpoints = [
        `/members/search?query=${encodeURIComponent(query)}`,
        `/suggest-members?query=${encodeURIComponent(query)}`
    ];

    for (const endpoint of endpoints) {
        try {
            const response = await fetch(endpoint, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                continue;
            }

            const data = await response.json();
            if (Array.isArray(data)) {
                return data;
            }
        } catch (e) {
            // try next endpoint
        }
    }

    return [];
}

function initializeMemberNameSearch() {
    const memberName = document.getElementById('memberName');
    const memberId = document.getElementById('memberId');

    if (!memberName || memberName.dataset.memberSearchInitialized === '1') {
        return;
    }

    memberName.dataset.memberSearchInitialized = '1';
    memberName.readOnly = false;
    memberName.autocomplete = 'off';
    memberName.style.cursor = 'text';

    const normalize = (value) => String(value || '').trim().toLowerCase();

    const runSearch = async () => {
        const query = memberName.value.trim();

        if (memberId && query === '') {
            memberId.value = '';
        }

        if (query.length < 2) {
            clearMemberSuggestions();
            updateConfirmButtonState();
            return;
        }

        try {
            const members = await fetchMemberSuggestions(query);

            if (Array.isArray(members) && members.length === 1) {
                const exactName = normalize(getMemberFullName(members[0]));
                if (exactName === normalize(query)) {
                    if (memberId) memberId.value = members[0].uuid || members[0].id;
                    memberName.value = getMemberFullName(members[0]);
                    clearMemberSuggestions();
                    updateConfirmButtonState();
                    return;
                }
            }

            renderMemberSuggestions(members);
        } catch (error) {
            console.error('Member search failed:', error);
            clearMemberSuggestions();
        }

        updateConfirmButtonState();
    };

    memberName.addEventListener('input', function() {
        if (memberId) {
            const matchedId = memberSuggestionMap.get(memberName.value.trim().toLowerCase());
            memberId.value = matchedId ? matchedId : '';
        }
        clearTimeout(memberSearchTimeout);
        memberSearchTimeout = setTimeout(runSearch, 250);
        updateConfirmButtonState();
    });

    memberName.addEventListener('focus', function() {
        if (memberName.value.trim().length >= 2) {
            clearTimeout(memberSearchTimeout);
            memberSearchTimeout = setTimeout(runSearch, 100);
        }
    });

    memberName.addEventListener('blur', function() {
        setTimeout(() => {
            const suggestions = document.getElementById('memberSuggestions');
            if (suggestions) {
                suggestions.style.display = 'none';
            }
        }, 150);
    });

    memberName.addEventListener('click', function() {
        if (memberName.value.trim().length >= 2) {
            clearTimeout(memberSearchTimeout);
            memberSearchTimeout = setTimeout(runSearch, 100);
        }
    });

    memberName.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            clearMemberSuggestions();
        }
    });
}

function removeBookFromSelection(bookId) {
    const normalizedBookId = normalizeIdentifier(bookId);
    // Remove from enhanced data structure
    const removedBook = removeBookFromBorrowerData(normalizedBookId);

    // Remove visual selection
    const row = findBookRow(normalizedBookId);
    if (row) {
        row.classList.remove('selected');
    }

    // Remove from UI list
    const listItem = document.querySelector(`#selectedBooksList li[data-id="${normalizedBookId}"]`);
    if (listItem) {
        listItem.remove();
    }

    updateConfirmButtonState();

    if (removedBook) {
        showToast(`Removed: ${removedBook.title} (ID: ${normalizedBookId})`, 'info');
    } else {
        showToast('Book removed from selection', 'info');
    }
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
    const bookId = normalizeIdentifier(row.dataset.id);
    const bookTitle = row.dataset.title;

    if (!bookId) {
        showToast('Error: Invalid book data', 'error');
        return;
    }

    const index = selectedBooks.findIndex(b => String(b.id) === bookId);

    if (index === -1) {
        selectedBooks.push({ id: bookId, title: bookTitle || 'Unknown Title' });
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
        const bookId = normalizeIdentifier(row.dataset.id);
        const bookTitle = row.dataset.title;

        if (!bookId) {
            return;
        }

        if (!selectedBooks.find(b => String(b.id) === bookId)) {
            selectedBooks.push({ id: bookId, title: bookTitle || 'Unknown Title' });
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
            const row = findBookRow(id);
            const title = row ? row.dataset.title : 'Unknown Title';
            return { id: id, title: title };
        });
    }

    const validBooks = booksToProcess.filter(book => {
        return book.id && book.id !== 'undefined' && String(book.id).trim() !== '';
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
                const row = findBookRow(book.id);
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

        const row = findBookRow(bookId);
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
    modal.style.zIndex = '999999';
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
        modalContent.style.zIndex = '999998';
        modalContent.style.margin = 'auto';
    }

    const borrowModal = document.getElementById('borrowModal');
    if (borrowModal) {
        borrowModal.style.zIndex = '999900';
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
    initializeMemberNameSearch();

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

    if (!memberId || String(memberId).trim() === '') {
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
                memberIdInput.value = member.uuid || member.id;
            }

            clearMemberSuggestions();

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

    const normalizeBookId = (value) => {
        if (value === null || value === undefined) return null;
        const str = String(value).trim();
        if (!str) return null;

        const uuidMatch = str.match(/[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[1-5][0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}/);
        if (uuidMatch) return uuidMatch[0];

        const directNumeric = parseInt(str, 10);
        if (!isNaN(directNumeric)) return String(directNumeric);

        const bookPattern = str.match(/book\s*#?\s*(\d+)/i);
        if (bookPattern) return String(bookPattern[1]);

        return str;
    };

    const loadBookData = async (id) => {
        const tableRow = findBookRow(id);
        if (tableRow) {
            return {
                id: normalizeIdentifier(tableRow.dataset.id || id),
                title: tableRow.dataset.title || 'Unknown Title',
                author: tableRow.dataset.author || 'Unknown Author',
                genre: tableRow.dataset.genre || null,
                published_year: tableRow.dataset.published_year || null,
                availability: parseInt(tableRow.dataset.availability || '0', 10)
            };
        }

        const endpoints = [`/api/books/${id}`, `/books/${id}`];
        for (const endpoint of endpoints) {
            try {
                const response = await fetch(endpoint, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if (!response.ok) continue;
                const data = await response.json();
                return {
                    id: normalizeIdentifier(data.uuid || data.id || id),
                    title: data.title || 'Unknown Title',
                    author: data.author || 'Unknown Author',
                    genre: data.genre || null,
                    published_year: data.published_year || null,
                    availability: parseInt(data.availability ?? '0', 10)
                };
            } catch (e) {
                // Try next endpoint
            }
        }

        return null;
    };

    try {
        const url = new URL(qrData);
        const parts = url.pathname.split('/');
        if (parts[1] === 'books' && parts[2]) {
            bookId = normalizeBookId(parts[2]);
        }
    } catch {
        const match = qrData.match(/book-(\d+)/);
        if (match) {
            bookId = String(match[1]);
        } else {
            bookId = normalizeBookId(qrData.split('/').pop() || qrData);
        }
    }

    if (!bookId) {
        showToast('Invalid book QR code', 'error');
        return;
    }

    if (borrowerBooksData.find(book => String(book.id) === String(bookId))) {
        showToast('Book already selected', 'warning');
        return;
    }

    const borrowModal = document.getElementById('borrowModal');
    const isModalOpen = borrowModal && borrowModal.classList.contains('active');

    (async () => {
        const bookData = await loadBookData(bookId);

        if (!bookData) {
            showToast(`Book ${bookId} not found`, 'error');
            return;
        }

        if (!bookData.availability || bookData.availability <= 0) {
            showToast('Book not available', 'warning');
            return;
        }

        const row = findBookRow(bookData.id);
        if (row) {
            row.classList.add('selected');
        }

        if (!isModalOpen) {
            openBorrowModal([bookData]);
        } else {
            if (!addBookToBorrowerData(bookData)) {
                showToast('Book already selected', 'warning');
                return;
            }

            const list = document.getElementById('selectedBooksList');
            if (list) {
                const li = document.createElement('li');
                li.textContent = `${bookData.title} by ${bookData.author}`;
                li.setAttribute('data-id', String(bookData.id));
                li.setAttribute('title', `Book ID: ${bookData.id} | Genre: ${bookData.genre || 'N/A'} | Year: ${bookData.published_year || 'N/A'}`);
                li.style.padding = '8px 0';
                li.style.borderBottom = '1px solid var(--border-light)';
                li.style.position = 'relative';

                const removeBtn = document.createElement('button');
                removeBtn.innerHTML = '×';
                removeBtn.className = 'btn btn-sm';
                removeBtn.style.cssText = `
                    position: absolute;
                    right: 0;
                    top: 50%;
                    transform: translateY(-50%);
                    background: var(--danger);
                    color: white;
                    border: none;
                    border-radius: 50%;
                    width: 20px;
                    height: 20px;
                    font-size: 12px;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                `;
                removeBtn.onclick = function(e) {
                    e.stopPropagation();
                    removeBookFromSelection(bookData.id);
                };

                li.appendChild(removeBtn);
                list.appendChild(li);
            }

            updateConfirmButtonState();
        }

        showToast(`Added: ${bookData.title} (ID: ${bookData.id})`, 'success');
    })();
}

// Backward-compatible helper used by legacy inline handlers
function addBookToBorrow(bookId) {
    processBookQR(String(bookId));
}

// ======================
// EXPORT FUNCTIONS
// ======================

// Core borrow functions
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

// Enhanced book data management functions
window.addBookToBorrowerData = addBookToBorrowerData;
window.removeBookFromBorrowerData = removeBookFromBorrowerData;
window.getBorrowerBooksData = getBorrowerBooksData;
window.clearBorrowerBooksData = clearBorrowerBooksData;
window.getBookIdsArray = getBookIdsArray;
window.getReadableBooksList = getReadableBooksList;

// QR Scanner functions
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
window.addBookToBorrow = addBookToBorrow;
window.initializeQRModalElements = initializeQRModalElements;
window.initializeMemberNameSearch = initializeMemberNameSearch;
window.clearMemberSuggestions = clearMemberSuggestions;

window.openQRScanner = showQRScannerModal;
