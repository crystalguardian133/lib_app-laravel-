// ============================================
// MEMBER REGISTRATION MODAL FUNCTIONS
// ============================================

function openJulitaRegisterModal() {
    console.log('openJulitaRegisterModal called');
    closeAllModals();
    const confirmJulita = confirm("Are you a Julita resident?\nClick OK for Yes, Cancel for No.");
    if (confirmJulita) {
        const modal = document.getElementById("julitaRegisterModal");
        if (modal) {
            modal.classList.add("active");
            modal.style.display = "flex";
            modal.style.opacity = "1";
            modal.style.visibility = "visible";
            document.body.classList.add("modal-open");
            console.log('Julita modal opened');
        } else {
            console.error('julitaRegisterModal element not found');
        }
    } else {
        const modal = document.getElementById("registerModal");
        if (modal) {
            modal.classList.add("active");
            modal.style.display = "flex";
            modal.style.opacity = "1";
            modal.style.visibility = "visible";
            document.body.classList.add("modal-open");
            console.log('Register modal opened');
        } else {
            console.error('registerModal element not found');
        }
    }
}

function closeAllModals() {
    const modals = document.querySelectorAll('.modal, .modal-overlay');
    modals.forEach(modal => {
        modal.classList.remove("show", "active");
        modal.style.display = "none";
        modal.style.opacity = "0";
        modal.style.visibility = "hidden";
    });
    document.body.classList.remove("modal-open");
}

function closeRegisterModal() {
    const registerModal = document.getElementById("registerModal");
    const julitaModal = document.getElementById("julitaRegisterModal");
    if (registerModal) {
        registerModal.classList.remove("show", "active");
        registerModal.style.display = "none";
        registerModal.style.opacity = "0";
        registerModal.style.visibility = "hidden";
    }
    if (julitaModal) {
        julitaModal.classList.remove("show", "active");
        julitaModal.style.display = "none";
        julitaModal.style.opacity = "0";
        julitaModal.style.visibility = "hidden";
    }
    document.body.classList.remove("modal-open");
}

function closeJulitaRegisterModal() {
    closeRegisterModal();
}

// Form submission handlers
function submitJulitaRegister() {
    const julitaModal = document.getElementById("julitaRegisterModal");

    // Validate required fields
    const requiredFields = [
        { selector: '#julitaFirstName', label: 'First Name' },
        { selector: '#julitaLastName', label: 'Last Name' },
        { selector: '#julitaAge', label: 'Age' },
        { selector: '#julitaBarangay', label: 'Barangay' },
        { selector: '#julitaMunicipality', label: 'Municipality' },
        { selector: '#julitaProvince', label: 'Province' },
        { selector: '#julitaContactNumber', label: 'Contact Number' }
    ];

    for (const field of requiredFields) {
        const element = julitaModal.querySelector(field.selector);
        if (!element || !element.value.trim()) {
            alert(`${field.label} is required.`);
            element?.focus();
            return;
        }
    }

    // Validate contact number format
    const contactNumber = julitaModal.querySelector('#julitaContactNumber').value.trim();
    if (!/^[0-9]{11}$/.test(contactNumber)) {
        alert('Contact number must be exactly 11 digits.');
        julitaModal.querySelector('#julitaContactNumber').focus();
        return;
    }

    // Validate age
    const age = parseInt(julitaModal.querySelector('#julitaAge').value);
    if (age < 1 || age > 150) {
        alert('Age must be between 1 and 150.');
        julitaModal.querySelector('#julitaAge').focus();
        return;
    }

    // Reset form before submission to prevent browser from retaining values on reload
    const form = julitaModal.querySelector('#julitaRegisterForm');
    if (form) {
        // Clear all form fields before submission
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (input.type === 'checkbox' || input.type === 'radio') {
                input.checked = false;
            } else {
                input.value = '';
            }
        });

        // Use setTimeout to ensure form clearing happens before submission
        setTimeout(() => {
            form.submit();
        }, 100);
    }
}

function submitRegister() {
    const julitaModal = document.getElementById("julitaRegisterModal");
    const registerModal = document.getElementById("registerModal");

    const isJulitaOpen = julitaModal.classList.contains("show") || julitaModal.classList.contains("active");
    const modal = isJulitaOpen ? julitaModal : registerModal;

    // Validate required fields based on which modal is open
    let requiredFields = [];
    if (isJulitaOpen) {
        requiredFields = [
            { selector: '#julitaFirstName', label: 'First Name' },
            { selector: '#julitaLastName', label: 'Last Name' },
            { selector: '#julitaAge', label: 'Age' },
            { selector: '#julitaBarangay', label: 'Barangay' },
            { selector: '#julitaMunicipality', label: 'Municipality' },
            { selector: '#julitaProvince', label: 'Province' },
            { selector: '#julitaContactNumber', label: 'Contact Number' }
        ];
    } else {
        requiredFields = [
            { selector: '#firstName', label: 'First Name' },
            { selector: '#lastName', label: 'Last Name' },
            { selector: '#age', label: 'Age' },
            { selector: '#barangay', label: 'Barangay' },
            { selector: '#municipality', label: 'Municipality' },
            { selector: '#province', label: 'Province' },
            { selector: '#contactNumber', label: 'Contact Number' }
        ];
    }

    for (const field of requiredFields) {
        const element = modal.querySelector(field.selector);
        if (!element || !element.value.trim()) {
            alert(`${field.label} is required.`);
            element?.focus();
            return;
        }
    }

    // Validate contact number format
    const contactSelector = isJulitaOpen ? '#julitaContactNumber' : '#contactNumber';
    const contactNumber = modal.querySelector(contactSelector).value.trim();
    if (!/^[0-9]{11}$/.test(contactNumber)) {
        alert('Contact number must be exactly 11 digits.');
        modal.querySelector(contactSelector).focus();
        return;
    }

    // Validate age
    const ageSelector = isJulitaOpen ? '#julitaAge' : '#age';
    const age = parseInt(modal.querySelector(ageSelector).value);
    if (age < 1 || age > 150) {
        alert('Age must be between 1 and 150.');
        modal.querySelector(ageSelector).focus();
        return;
    }

    // Reset form before submission to prevent browser from retaining values on reload
    const form = modal.querySelector('form');
    if (form) {
        // Clear all form fields before submission
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (input.type === 'checkbox' || input.type === 'radio') {
                input.checked = false;
            } else {
                input.value = '';
            }
        });

        // Use setTimeout to ensure form clearing happens before submission
        setTimeout(() => {
            form.submit();
        }, 100);
    }
}

// ============================================
// CHATBOT FUNCTIONS
// ============================================

const chatbotWindow = document.getElementById('chatbot-window');
const chatbotButton = document.getElementById('chatbot-button');
const chatbotClose = document.getElementById('chatbot-close');

if (chatbotButton && chatbotWindow) {
    chatbotButton.addEventListener('click', () => {
        chatbotWindow.style.display = chatbotWindow.style.display === 'flex' ? 'none' : 'flex';
    });
}
if (chatbotClose && chatbotWindow) {
    chatbotClose.addEventListener('click', () => {
        chatbotWindow.style.display = 'none';
    });
}

// ============================================
// BOOKS TABLE MODAL FUNCTIONS
// ============================================

function openBooksTable() {
    const modal = document.getElementById('booksTableModal');
    if (modal) {
        modal.classList.add("active");
        modal.style.display = 'flex';
        modal.style.opacity = '1';
        modal.style.visibility = 'visible';
        document.body.classList.add("modal-open");
        loadBooksData();
    }
}

function closeBooksTable() {
    const modal = document.getElementById('booksTableModal');
    if (modal) {
        modal.classList.remove("active");
        modal.style.display = 'none';
        modal.style.opacity = '0';
        modal.style.visibility = 'hidden';
        document.body.classList.remove("modal-open");
    }
}

async function loadBooksData() {
    try {
        const token = document.querySelector('meta[name="csrf-token"]');
        const response = await fetch('/dashboard/books-data', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': token ? token.getAttribute('content') : ''
            },
            credentials: 'same-origin'
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Server response:', errorText);
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }

        const text = await response.text();
        let books;
        try {
            books = JSON.parse(text);
        } catch (parseError) {
            if (text.includes('login') || text.includes('<html') || text.includes('<!DOCTYPE')) {
                window.location.href = '/login';
                return;
            }
            console.error('JSON parse error:', parseError);
            throw new Error('Invalid JSON response');
        }

        const tbody = document.getElementById('booksTableBody');
        if (!tbody) return;
        tbody.innerHTML = '';
        if (books.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="loading">No books found</td></tr>';
            return;
        }
        books.forEach((book, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td style="font-weight: 600; color: var(--primary);">${index + 1}</td>
                <td>${book.title}</td>
                <td>${book.author}</td>
                <td>${book.genre || '-'}</td>
                <td>${book.published_year}</td>
                <td>${book.availability}</td>
                <td>${new Date(book.created_at).toLocaleDateString()}</td>
            `;
            tbody.appendChild(row);
        });
    } catch (error) {
        console.error('Error loading books:', error);
        const tbody = document.getElementById('booksTableBody');
        if (tbody) {
            tbody.innerHTML = '<tr><td colspan="7" class="loading">Error loading books</td></tr>';
        }
    }
}

// ============================================
// MEMBERS TABLE MODAL FUNCTIONS
// ============================================

function openMembersTable() {
    console.log('openMembersTable called');
    const modal = document.getElementById('membersTableModal');
    if (modal) {
        modal.classList.add("active");
        modal.style.display = 'flex';
        modal.style.opacity = '1';
        modal.style.visibility = 'visible';
        document.body.classList.add("modal-open");
        loadMembersData();
        console.log('Members table modal opened');
    } else {
        console.error('membersTableModal element not found');
    }
}

function closeMembersTable() {
    const modal = document.getElementById('membersTableModal');
    if (modal) {
        modal.classList.remove("active");
        modal.style.display = 'none';
        modal.style.opacity = '0';
        modal.style.visibility = 'hidden';
        document.body.classList.remove("modal-open");
    }
}

async function loadMembersData() {
    try {
        const token = document.querySelector('meta[name="csrf-token"]');
        const response = await fetch('/dashboard/members-data', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': token ? token.getAttribute('content') : ''
            },
            credentials: 'same-origin'
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Server response:', errorText);
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }

        const text = await response.text();
        let members;
        try {
            members = JSON.parse(text);
        } catch (parseError) {
            if (text.includes('login') || text.includes('<html') || text.includes('<!DOCTYPE')) {
                window.location.href = '/login';
                return;
            }
            console.error('JSON parse error:', parseError);
            throw new Error('Invalid JSON response');
        }

        const tbody = document.getElementById('membersTableBody');
        if (!tbody) return;
        tbody.innerHTML = '';
        if (members.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="loading">No members found</td></tr>';
            return;
        }
        members.forEach((member, index) => {
            const fullName = [member.first_name, member.middle_name, member.last_name]
                .filter(name => name && name !== 'null')
                .join(' ');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td style="font-weight: 600; color: var(--primary);">${index + 1}</td>
                <td>${fullName}</td>
                <td>${member.age}</td>
                <td>${member.barangay}</td>
                <td>${member.contactnumber}</td>
                <td>${new Date(member.created_at).toLocaleDateString()}</td>
            `;
            tbody.appendChild(row);
        });
    } catch (error) {
        console.error('Error loading members:', error);
        const tbody = document.getElementById('membersTableBody');
        if (tbody) {
            tbody.innerHTML = '<tr><td colspan="6" class="loading">Error loading members</td></tr>';
        }
    }
}

// ============================================
// BORROWERS DATA FUNCTIONS
// ============================================

let originalBorrowersData = [];

async function loadBorrowersData() {
    const tbody = document.getElementById('borrowersTableBody');
    if (!tbody) {
        console.error('Borrowers table body not found');
        return;
    }
    tbody.innerHTML = '<tr><td colspan="9" class="loading">Loading borrowers...</td></tr>';
    try {
        const token = document.querySelector('meta[name="csrf-token"]');
        const response = await fetch('/dashboard/borrowers-data', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': token ? token.getAttribute('content') : ''
            },
            credentials: 'same-origin'
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Server response:', errorText);
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }

        const text = await response.text();
        let borrowers;
        try {
            borrowers = JSON.parse(text);
        } catch (parseError) {
            if (text.includes('login') || text.includes('<html') || text.includes('<!DOCTYPE')) {
                window.location.href = '/login';
                return;
            }
            console.error('JSON parse error:', parseError);
            throw new Error('Invalid JSON response');
        }

        if (borrowers.length === 0) {
            tbody.innerHTML = '<tr><td colspan="9" class="loading">No borrowers found</td></tr>';
            originalBorrowersData = [];
            return;
        }
        originalBorrowersData = [...borrowers];
        displayBorrowersData(borrowers);
    } catch (error) {
        console.error('Error loading borrowers:', error);
        tbody.innerHTML = '<tr><td colspan="9" class="loading">Error loading data</td></tr>';
    }
}

function displayBorrowersData(data) {
    const tbody = document.getElementById('borrowersTableBody');
    if (!tbody) return;
    tbody.innerHTML = '';
    if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9" class="loading">No borrowers found</td></tr>';
        return;
    }
    const groupedData = groupBooksByBorrowerAndDate(data);
    groupedData.forEach((group, groupIndex) => {
        if (!group || !group.member || !group.books) return;
        const fullName = [group.member.first_name, group.member.middle_name, group.member.last_name]
            .filter(name => name && name !== 'null')
            .join(' ');
        const borrowedDate = group.borrowed_at ? new Date(group.borrowed_at).toLocaleDateString() : 'Unknown';
        const dueDate = group.due_date ? new Date(group.due_date).toLocaleDateString() : 'Unknown';
        const currentDate = new Date();
        const allReturned = group.books.every(book => book && book.returned_at !== null);
        const anyOverdue = group.books.some(book => {
            if (!book || !book.due_date) return false;
            const bookDueDate = new Date(book.due_date);
            return book.returned_at === null && bookDueDate < currentDate;
        });
        let statusBadge = '';
        let rowClass = '';
        if (allReturned) {
            statusBadge = '<span style="color: #10b981; font-weight: 600;">✓ All Returned</span>';
            rowClass = 'returned-row';
        } else if (anyOverdue) {
            statusBadge = '<span style="color: #ef4444; font-weight: 600;">⚠ Some Overdue</span>';
            rowClass = 'overdue-row';
        } else {
            statusBadge = '<span style="color: #f59e0b; font-weight: 600;">⏳ Pending</span>';
            rowClass = 'pending-row';
        }
        const booksDisplay = createBooksDisplay(group.books);
        const booksSummary = group.books.map(book => (book && book.title) || 'Unknown Title').join(' | ');
        const actions = allReturned ?
            statusBadge :
            `<div style="display: flex; gap: 4px; flex-wrap: wrap;">
                <button class="btn btn-sm btn-primary btn-return-multiple"
                        onclick="returnMultipleBooks('${group.transaction_ids.join(',')}', '${booksSummary.replace(/'/g, "\\'")}')"
                        style="font-size: 0.75rem; padding: 3px 6px;"
                        data-original-text="Return All">
                    <i class="fas fa-undo"></i> Return All
                </button>
                <button class="btn btn-sm btn-outline"
                        onclick="showDetailedBookInfo('${groupIndex}')"
                        style="font-size: 0.75rem; padding: 3px 6px;">
                    <i class="fas fa-list"></i> Details
                </button>
            </div>`;
        const row = document.createElement('tr');
        row.className = rowClass;
        row.setAttribute('data-group-index', groupIndex);
        const allBooksReturned = group.books && group.books.every(book => book && book.returned_at !== null);
        const checkboxCellContent = allBooksReturned ?
            '<i class="fas fa-thumbs-up" style="color: var(--success); font-size: 1.2rem;" title="All books returned"></i>' :
            `<input type="checkbox" class="bookSelectCheckbox" data-group-index="${groupIndex}" onchange="updateSelection()" style="transform: scale(1.2);">`;
        row.innerHTML = `
            <td style="text-align: center;">${checkboxCellContent}</td>
            <td style="font-weight: 600; color: var(--primary);">${groupIndex + 1}</td>
            <td>${fullName}</td>
            <td>
                <div style="max-width: 200px;">
                    ${booksDisplay.short}
                    ${group.books.length > 2 ? `<div class="books-tooltip" style="display: none;" id="books-tooltip-${groupIndex}">${booksDisplay.full}</div>` : ''}
                </div>
            </td>
            <td>${borrowedDate}</td>
            <td>${dueDate}</td>
            <td>
                ${(() => {
                    if (!group.books) return '-';
                    const returnedDates = group.books
                        .filter(book => book && book.returned_at)
                        .map(book => new Date(book.returned_at).toLocaleDateString())
                        .filter((date, index, arr) => arr.indexOf(date) === index)
                        .join(', ');
                    return returnedDates || '-';
                })()}
            </td>
            <td>
                ${(() => {
                    if (!group.books) return '<span style="color: var(--danger); font-weight: 600;">No Books</span>';
                    const totalBooks = group.books.length;
                    const returnedBooks = group.books.filter(b => b && b.returned_at).length;
                    if (returnedBooks === 0) return '<span style="color: var(--danger); font-weight: 600;">Not Returned</span>';
                    if (returnedBooks === totalBooks) return '<span style="color: var(--success); font-weight: 600;">Fully Returned</span>';
                    return `<span style="color: var(--warning); font-weight: 600;">Partially Returned (${returnedBooks}/${totalBooks})</span>`;
                })()}
            </td>
            <td>${actions}</td>
        `;
        tbody.appendChild(row);
    });
}

function groupBooksByBorrowerAndDate(data) {
    const groups = {};
    if (!Array.isArray(data)) {
        console.error('Invalid data format: expected array');
        return [];
    }
    data.forEach(borrower => {
        if (!borrower || !borrower.member) return;
        const borrowedDate = borrower.borrowed_at ? new Date(borrower.borrowed_at).toDateString() : 'unknown';
        const dueDate = borrower.due_date ? new Date(borrower.due_date).toDateString() : 'unknown';
        const key = `${borrower.member.id}_${borrowedDate}_${dueDate}`;
        if (!groups[key]) {
            groups[key] = {
                member: borrower.member,
                borrowed_at: borrower.borrowed_at,
                due_date: borrower.due_date,
                books: [],
                transaction_ids: []
            };
        }
        const bookData = {
            id: borrower.id,
            title: (borrower.book && borrower.book.title) || 'Unknown Title',
            author: (borrower.book && borrower.book.author) || 'Unknown Author',
            returned_at: borrower.returned_at,
            due_date: borrower.due_date,
            borrowed_at: borrower.borrowed_at
        };
        groups[key].books.push(bookData);
        groups[key].transaction_ids.push(borrower.id);
    });
    return Object.values(groups);
}

function createBooksDisplay(books) {
    if (!books || books.length === 0) return { short: 'No books', full: 'No books' };
    if (books.length === 1) {
        const book = books[0];
        return {
            short: (book && book.title) || 'Unknown Title',
            full: `${(book && book.title) || 'Unknown Title'}${book && book.returned_at ? ' (Returned)' : ''}`
        };
    }
    const bookTitles = books.map(b => (b && b.title) || 'Unknown Title');
    const short = books.length <= 2 ?
        bookTitles.join(', ') :
        `${bookTitles[0]}, ${bookTitles[1]} +${books.length - 2} more`;
    const full = books.map((book, index) =>
        `${index + 1}. ${(book && book.title) || 'Unknown Title'}${book && book.returned_at ? ' (Returned)' : ''}`
    ).join('<br>');
    return { short, full };
}

// ============================================
// RETURN BOOKS FUNCTIONS
// ============================================

function returnMultipleBooks(transactionIds, booksSummary) {
    const ids = transactionIds.split(',');
    if (ids.length === 1) {
        const groupData = getGroupedData();
        const allBooks = groupData.flatMap(group => group.books);
        const book = allBooks.find(b => b.id == ids[0]);
        const bookTitle = book ? book.title : 'Unknown Book';
        returnBookDirect(ids[0], bookTitle, '');
    } else {
        const groupData = getGroupedData();
        const allBooks = groupData.flatMap(group => group.books);
        const booksList = ids.map(id => {
            const book = allBooks.find(b => b.id == id);
            return book ? book.title : 'Unknown Book';
        }).filter(title => title !== 'Unknown Book');
        const summary = booksList.join(', ');
        const shortSummary = summary.length > 100 ? summary.substring(0, 100) + '...' : summary;
        if (confirm(`Are you sure you want to return ${ids.length} books: ${shortSummary}?`)) {
            returnMultipleBooksProcess(ids);
        }
    }
}

function returnMultipleBooksProcess(transactionIds) {
    const token = document.querySelector('meta[name="csrf-token"]');
    if (!token) {
        showToast('CSRF token not found', 'error');
        return;
    }
    const returnButtons = document.querySelectorAll('.btn-return-multiple, .btn-primary[onclick*="returnMultipleBooks"], .btn-primary[onclick*="returnBookDirect"], #bulkReturnBtn');
    returnButtons.forEach(button => {
        button.disabled = true;
        const originalText = button.textContent || 'Return';
        button.setAttribute('data-original-text', originalText);
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    });

    let completed = 0;
    let failed = 0;
    const totalBooks = transactionIds.length;
    transactionIds.forEach((id, index) => {
        fetch(`/transactions/${id}/return`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token.getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (response.ok) {
                completed++;
            } else {
                failed++;
            }
            if (index === totalBooks - 1) {
                setTimeout(() => {
                    if (completed > 0) {
                        showToast(`Successfully returned ${completed} book(s)`, 'success');
                    }
                    if (failed > 0) {
                        showToast(`Failed to return ${failed} book(s)`, 'error');
                    }
                    if (completed > 0) {
                        setTimeout(() => {
                            loadBorrowersData();
                            exitBulkReturnMode();
                        }, 1500);
                    } else {
                        returnButtons.forEach(button => {
                            button.disabled = false;
                            const originalText = button.getAttribute('data-original-text') || 'Return';
                            button.innerHTML = originalText;
                        });
                    }
                }, 500);
            }
        })
        .catch(error => {
            console.error('Return error:', error);
            failed++;
            if (index === totalBooks - 1) {
                setTimeout(() => {
                    if (completed > 0) {
                        showToast(`Successfully returned ${completed} book(s)`, 'success');
                        setTimeout(() => {
                            loadBorrowersData();
                            exitBulkReturnMode();
                        }, 1500);
                    } else {
                        showToast(`Failed to return ${failed} book(s)`, 'error');
                        returnButtons.forEach(button => {
                            button.disabled = false;
                            const originalText = button.getAttribute('data-original-text') || 'Return';
                            button.innerHTML = originalText;
                        });
                    }
                }, 500);
            }
        });
    });
}

function returnBookDirect(transactionId, bookTitle, memberName) {
    const confirmMessage = memberName ?
        `return the book "${bookTitle}" borrowed by ${memberName}?` :
        `return the book "${bookTitle}"?`;
    if (confirm(`Are you sure you want to ${confirmMessage}`)) {
        if (typeof window.returnId !== 'undefined') {
            window.returnId = transactionId;
        } else {
            window.returnId = transactionId;
        }
        if (typeof confirmReturn === 'function') {
            confirmReturn();
        } else {
            submitReturnForm(transactionId);
        }
    }
}

function submitReturnForm(transactionId) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/transactions/${transactionId}/return`;
    const token = document.querySelector('meta[name="csrf-token"]');
    if (token) {
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = token.getAttribute('content');
        form.appendChild(csrf);
    }
    document.body.appendChild(form);
    form.submit();
}

// ============================================
// SEARCH AND FILTER FUNCTIONS
// ============================================

function searchBorrowers(searchTerm) {
    if (!originalBorrowersData || originalBorrowersData.length === 0) return;
    const returnStatusFilter = document.getElementById('returnStatusFilter').value;
    const statusFilteredData = returnStatusFilter !== 'all' ? filterByReturnStatusClient(originalBorrowersData, returnStatusFilter) : originalBorrowersData;
    const searchFilteredData = searchTerm.trim() ? searchBorrowersClient(statusFilteredData, searchTerm) : statusFilteredData;
    const sortedData = currentSortColumn >= 0 ? sortDataByColumn(searchFilteredData, currentSortColumn, sortDirection) : searchFilteredData;
    displayBorrowersData(sortedData);
}

async function filterBorrowers(filter) {
    try {
        const token = document.querySelector('meta[name="csrf-token"]');
        const response = await fetch(`/dashboard/borrowers-data?filter=${filter}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': token ? token.getAttribute('content') : ''
            },
            credentials: 'same-origin'
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Server response:', errorText);
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }

        const text = await response.text();
        let borrowers;
        try {
            borrowers = JSON.parse(text);
        } catch (parseError) {
            if (text.includes('login') || text.includes('<html') || text.includes('<!DOCTYPE')) {
                window.location.href = '/login';
                return;
            }
            console.error('JSON parse error:', parseError);
            throw new Error('Invalid JSON response');
        }

        originalBorrowersData = [...borrowers];
        document.getElementById('borrowerSearch').value = '';
        const returnStatusFilter = document.getElementById('returnStatusFilter').value;
        const searchTerm = document.getElementById('borrowerSearch').value;
        let data = borrowers;
        if (returnStatusFilter !== 'all') {
            data = filterByReturnStatusClient(data, returnStatusFilter);
        }
        if (searchTerm.trim()) {
            data = searchBorrowersClient(data, searchTerm);
        }
        const finalData = currentSortColumn >= 0 ? sortDataByColumn(data, currentSortColumn, sortDirection) : data;
        displayBorrowersData(finalData);
    } catch (error) {
        console.error('Error loading borrowers:', error);
        const tbody = document.getElementById('borrowersTableBody');
        if (tbody) {
            tbody.innerHTML = '<tr><td colspan="9" class="loading">Error loading borrowers</td></tr>';
        }
    }
}

function filterByReturnStatusClient(data, status) {
    const currentDate = new Date();
    return data.filter(group => {
        const allReturned = group.books.every(book => book.returned_at !== null);
        const anyOverdue = group.books.some(book => {
            if (!book.due_date) return false;
            const dueDate = new Date(book.due_date);
            return book.returned_at === null && dueDate < currentDate;
        });
        const allPending = group.books.every(book => book.returned_at === null);
        switch(status) {
            case 'returned': return allReturned;
            case 'pending': return allPending && !anyOverdue;
            case 'overdue': return anyOverdue;
            default: return true;
        }
    });
}

function filterByReturnStatus(status) {
    if (!originalBorrowersData || originalBorrowersData.length === 0) return;
    const filteredData = status !== 'all' ? filterByReturnStatusClient(originalBorrowersData, status) : originalBorrowersData;
    const searchTerm = document.getElementById('borrowerSearch').value;
    const searchFilteredData = searchTerm.trim() ? searchBorrowersClient(filteredData, searchTerm) : filteredData;
    const finalData = currentSortColumn >= 0 ? sortDataByColumn(searchFilteredData, currentSortColumn, sortDirection) : searchFilteredData;
    displayBorrowersData(finalData);
}

function searchBorrowersClient(data, searchTerm) {
    if (!searchTerm.trim()) return data;
    const searchLower = searchTerm.toLowerCase();
    return data.filter(group => {
        if (!group || !group.member) return false;
        const fullName = [group.member.first_name, group.member.middle_name, group.member.last_name]
            .filter(name => name && name !== 'null')
            .join(' ')
            .toLowerCase();
        const bookTitles = (group.books || []).map(book => (book.title || 'Unknown Title').toLowerCase()).join(' ');
        const bookIds = (group.transaction_ids || []).join(' ');
        return fullName.includes(searchLower) ||
               bookTitles.includes(searchLower) ||
               bookIds.includes(searchLower) ||
               (data.indexOf(group) + 1).toString().includes(searchLower);
    });
}

// ============================================
// SORTING FUNCTIONS
// ============================================

let currentSortColumn = -1;
let sortDirection = 'asc';

function sortTable(columnIndex) {
    const headers = document.querySelectorAll('.sortable-header');
    const indicator = headers[columnIndex].querySelector('.sort-indicator');
    headers.forEach((header, index) => {
        const ind = header.querySelector('.sort-indicator');
        if (index !== columnIndex) {
            ind.innerHTML = '↕';
            ind.style.opacity = '0.3';
            ind.style.color = 'inherit';
        }
    });
    if (currentSortColumn === columnIndex) {
        sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
    } else {
        currentSortColumn = columnIndex;
        sortDirection = 'asc';
    }
    indicator.innerHTML = sortDirection === 'asc' ? '↑' : '↓';
    indicator.style.opacity = '0.7';
    indicator.style.color = 'var(--primary)';
    let data = originalBorrowersData || [];
    const returnStatusFilter = document.getElementById('returnStatusFilter').value;
    if (returnStatusFilter !== 'all') {
        data = filterByReturnStatusClient(data, returnStatusFilter);
    }
    const searchTerm = document.getElementById('borrowerSearch').value;
    if (searchTerm.trim()) {
        data = searchBorrowersClient(data, searchTerm);
    }
    const sortedData = sortDataByColumn(data, columnIndex, sortDirection);
    displayBorrowersData(sortedData);
}

function sortDataByColumn(data, columnIndex, direction) {
    return data.sort((a, b) => {
        if (!a || !b) return 0;
        let valueA, valueB;
        switch(columnIndex) {
            case 0: return 0;
            case 1:
                if (!a.member || !b.member) return 0;
                const nameA = [a.member.first_name, a.member.middle_name, a.member.last_name]
                    .filter(name => name && name !== 'null').join(' ').toLowerCase();
                const nameB = [b.member.first_name, b.member.middle_name, b.member.last_name]
                    .filter(name => name && name !== 'null').join(' ').toLowerCase();
                valueA = nameA;
                valueB = nameB;
                break;
            case 2:
                if (!a.books || !b.books || a.books.length === 0 || b.books.length === 0) return 0;
                const firstBookA = (a.books[0].title || 'Unknown Title').toLowerCase();
                const firstBookB = (b.books[0].title || 'Unknown Title').toLowerCase();
                valueA = firstBookA;
                valueB = firstBookB;
                break;
            case 3:
                if (!a.borrowed_at || !b.borrowed_at) return 0;
                valueA = new Date(a.borrowed_at);
                valueB = new Date(b.borrowed_at);
                break;
            case 4:
                if (!a.due_date || !b.due_date) return 0;
                valueA = new Date(a.due_date);
                valueB = new Date(b.due_date);
                break;
            case 5:
                if (!a.books || !b.books) return 0;
                const returnedCountA = a.books.filter(book => book && book.returned_at !== null).length;
                const returnedCountB = b.books.filter(book => book && book.returned_at !== null).length;
                valueA = returnedCountA;
                valueB = returnedCountB;
                break;
            case 6:
                if (!a.books || !b.books) return 0;
                const totalA = a.books.length;
                const returnedA = a.books.filter(book => book && book.returned_at !== null).length;
                const totalB = b.books.length;
                const returnedB = b.books.filter(book => book && book.returned_at !== null).length;
                if (returnedA === 0) valueA = 0;
                else if (returnedA === totalA) valueA = 2;
                else valueA = 1;
                if (returnedB === 0) valueB = 0;
                else if (returnedB === totalB) valueB = 2;
                else valueB = 1;
                break;
            default: return 0;
        }
        if (valueA < valueB) return direction === 'asc' ? -1 : 1;
        if (valueA > valueB) return direction === 'asc' ? 1 : -1;
        return 0;
    });
}

// ============================================
// DETAILED BOOK INFO MODAL
// ============================================

function showDetailedBookInfo(groupIndex) {
    const details = getGroupBookDetails(groupIndex);
    if (!details) {
        showToast('Group details not found', 'error');
        return;
    }
    const returnedCount = details.books.filter(book => book.returned).length;
    const pendingCount = details.books.length - returnedCount;
    const currentDate = new Date();
    const dueDate = new Date(details.due_date);
    const isOverdue = !details.books.every(book => book.returned) && dueDate < currentDate;
    const overdueDays = isOverdue ? Math.ceil((currentDate - dueDate) / (1000 * 60 * 60 * 24)) : 0;
    let detailsHTML = `
        <div style="padding: 0;">
            <div style="background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; padding: 1.5rem; margin: -1.5rem -1.5rem 1.5rem -1.5rem; border-radius: 0;">
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 1rem;">
                    <div style="background: rgba(255, 255, 255, 0.2); padding: 10px; border-radius: 50%; font-size: 1.5rem;">
                        <i class="fas fa-book"></i>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 1.3rem; font-weight: 700;">📚 Borrowed Books Details</h3>
                        <p style="margin: 0.25rem 0 0 0; opacity: 0.9; font-size: 0.95rem;">
                            ${details.member} • ${details.books.length} book(s) total
                        </p>
                    </div>
                </div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <span style="background: rgba(255, 255, 255, 0.2); padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                        ${returnedCount}/${details.books.length} Returned
                    </span>
                    ${pendingCount > 0 ? `<span style="background: rgba(245, 158, 11, 0.2); color: var(--warning); padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                        ${pendingCount} Pending
                    </span>` : ''}
                    ${isOverdue ? `<span style="background: rgba(239, 68, 68, 0.2); color: var(--danger); padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                        ${overdueDays} day(s) overdue
                    </span>` : ''}
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div style="background: var(--glass-bg); padding: 1rem; border-radius: var(--radius); border: 1px solid var(--border);">
                    <h5 style="margin: 0 0 0.75rem 0; color: var(--primary); font-size: 0.9rem; font-weight: 600;">
                        <i class="fas fa-calendar-plus"></i> Borrowed Date
                    </h5>
                    <p style="margin: 0; font-size: 0.95rem; color: var(--text-primary);">
                        ${new Date(details.borrowed_at).toLocaleDateString('en-US', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        })}
                    </p>
                </div>
                <div style="background: var(--glass-bg); padding: 1rem; border-radius: var(--radius); border: 1px solid var(--border);">
                    <h5 style="margin: 0 0 0.75rem 0; color: var(--primary); font-size: 0.9rem; font-weight: 600;">
                        <i class="fas fa-calendar-times"></i> Due Date
                    </h5>
                    <p style="margin: 0; font-size: 0.95rem; color: var(--text-primary);">
                        ${new Date(details.due_date).toLocaleDateString('en-US', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        })}
                    </p>
                </div>
            </div>
            <div style="margin-top: 1rem;">
                <h4 style="margin: 0 0 1rem 0; color: var(--primary); font-size: 1.1rem; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-list"></i>
                    Books in this Transaction
                </h4>
                <div style="max-height: 250px; overflow-y: auto; border: 1px solid var(--border); border-radius: var(--radius);">
    `;
    details.books.forEach((book, index) => {
        const bookTitle = book.title || 'Unknown Title';
        const isOverdueBook = isOverdue && !book.returned;
        detailsHTML += `
            <div style="
                padding: 1rem;
                margin: 0;
                border-bottom: 1px solid var(--border-light);
                background: ${book.returned ? 'rgba(16, 185, 129, 0.08)' : isOverdueBook ? 'rgba(239, 68, 68, 0.08)' : 'var(--surface)'};
                border-left: 4px solid ${book.returned ? 'var(--success)' : isOverdueBook ? 'var(--danger)' : 'var(--warning)'};
                transition: all 0.2s ease;
            ">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 0.5rem;">
                    <div style="
                        background: ${book.returned ? 'var(--success)' : isOverdueBook ? 'var(--danger)' : 'var(--warning)'};
                        color: white;
                        width: 24px;
                        height: 24px;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 0.8rem;
                        font-weight: bold;
                    ">
                        ${index + 1}
                    </div>
                    <div style="flex: 1;">
                        <h6 style="margin: 0; font-size: 1rem; font-weight: 600; color: var(--text-primary);">
                            ${bookTitle}
                        </h6>
                    </div>
                    <div style="
                        padding: 4px 8px;
                        border-radius: 12px;
                        font-size: 0.75rem;
                        font-weight: 600;
                        background: ${book.returned ? 'rgba(16, 185, 129, 0.2)' : isOverdueBook ? 'rgba(239, 68, 68, 0.2)' : 'rgba(245, 158, 11, 0.2)'};
                        color: ${book.returned ? 'var(--success)' : isOverdueBook ? 'var(--danger)' : 'var(--warning)'};
                    ">
                        ${book.returned ? '✓ Returned' : isOverdueBook ? '⚠ Overdue' : '⏳ Pending'}
                    </div>
                </div>
                ${book.returned ? `
                    <div style="margin-left: 34px; font-size: 0.85rem; color: var(--success);">
                        <i class="fas fa-check-circle"></i>
                        Returned on ${new Date(book.returned_at).toLocaleDateString('en-US', {
                            month: 'short',
                            day: 'numeric',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        })}
                    </div>
                ` : isOverdueBook ? `
                    <div style="margin-left: 34px; font-size: 0.85rem; color: var(--danger);">
                        <i class="fas fa-exclamation-triangle"></i>
                        Was due ${overdueDays} day(s) ago
                    </div>
                ` : `
                    <div style="margin-left: 34px; font-size: 0.85rem; color: var(--warning);">
                        <i class="fas fa-clock"></i>
                        Due in ${Math.ceil((dueDate - currentDate) / (1000 * 60 * 60 * 24))} day(s)
                    </div>
                `}
            </div>
        `;
    });
    detailsHTML += `
                </div>
            </div>
            ${pendingCount > 0 ? `
            <div style="margin-top: 1.5rem; padding: 1rem; background: linear-gradient(135deg, var(--primary), var(--accent)); border-radius: var(--radius); border: 2px solid rgba(255, 255, 255, 0.2);">
                <div style="text-align: center; margin-bottom: 1rem;">
                    <h5 style="margin: 0 0 0.5rem 0; color: white; font-size: 1rem; font-weight: 600;">
                        <i class="fas fa-undo"></i>
                        Return Remaining Books
                    </h5>
                    <p style="margin: 0; color: rgba(255, 255, 255, 0.9); font-size: 0.9rem;">
                        ${pendingCount} book(s) still need to be returned
                    </p>
                </div>
                <button class="btn btn-primary btn-return-multiple" onclick="returnMultipleBooks('${details.transaction_ids.filter((_, idx) => !details.books[idx].returned).join(',')}', '${details.books.filter((_, idx) => !details.books[idx].returned).map(b => b.title || 'Unknown Title').join(', ')}')" style="width: 100%; background: white; color: var(--primary); border: none; font-weight: 700; padding: 12px;">
                    <i class="fas fa-undo"></i> Return ${pendingCount} Book(s)
                </button>
            </div>
            ` : `
            <div style="margin-top: 1.5rem; padding: 1rem; background: linear-gradient(135deg, var(--success), #059669); border-radius: var(--radius); text-align: center; color: white;">
                <h5 style="margin: 0 0 0.5rem 0; font-size: 1rem; font-weight: 600;">
                    <i class="fas fa-check-circle"></i>
                    All Books Returned
                </h5>
                <p style="margin: 0; opacity: 0.9; font-size: 0.9rem;">
                    This transaction is complete
                </p>
            </div>
            `}
        </div>
    `;
    showCustomModal('Detailed Book Information', detailsHTML);
}

function getGroupBookDetails(groupIndex) {
    const groups = getGroupedData();
    const group = groups[groupIndex];
    if (!group) return null;
    return {
        member: `${group.member.first_name || ''} ${group.member.last_name || ''}`.trim(),
        books: group.books.map(book => ({
            id: book.id,
            title: book.title || 'Unknown Title',
            returned: book.returned_at !== null,
            returned_at: book.returned_at
        })),
        transaction_ids: group.transaction_ids,
        borrowed_at: group.borrowed_at,
        due_date: group.due_date
    };
}

function getGroupedData() {
    if (!originalBorrowersData || !Array.isArray(originalBorrowersData)) {
        console.warn('Invalid or missing borrowers data');
        return [];
    }
    return groupBooksByBorrowerAndDate(originalBorrowersData);
}

// ============================================
// CUSTOM MODAL FUNCTIONS
// ============================================

function showCustomModal(title, content) {
    const existingModal = document.getElementById('customModal');
    if (existingModal) existingModal.remove();
    const modal = document.createElement('div');
    modal.id = 'customModal';
    modal.className = 'modal';
    modal.style.display = 'flex';
    modal.style.zIndex = '9999';
    modal.innerHTML = `
        <div class="modal-content" style="
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
            z-index: 9999;
            margin: auto;
            animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 3px solid var(--primary);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25), 0 0 40px rgba(99, 102, 241, 0.3);
        ">
            <div class="modal-header" style="
                background: linear-gradient(135deg, var(--primary), var(--accent));
                color: white;
                padding: 1.5rem;
                margin: 0;
                border-radius: 0;
            ">
                <h2 class="modal-title" style="
                    margin: 0;
                    font-size: 1.5rem;
                    font-weight: 700;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                ">
                    <i class="fas fa-info-circle"></i>
                    ${title}
                </h2>
                <button class="close-modal" onclick="closeCustomModal()" style="
                    background: rgba(255, 255, 255, 0.2);
                    border: 2px solid rgba(255, 255, 255, 0.3);
                    color: white;
                    font-size: 1.5rem;
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    font-weight: bold;
                ">×</button>
            </div>
            <div class="modal-body" style="
                padding: 1.5rem;
                background: var(--surface-elevated);
                max-height: 60vh;
                overflow-y: auto;
            ">
                ${content}
            </div>
            <div class="modal-actions" style="
                padding: 1rem 1.5rem;
                background: var(--surface);
                border-top: 1px solid var(--border);
                display: flex;
                justify-content: flex-end;
                gap: 10px;
            ">
                <button class="btn btn-secondary" onclick="closeCustomModal()" style="
                    padding: 10px 20px;
                    font-weight: 600;
                ">
                    <i class="fas fa-times"></i>
                    Close
                </button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    document.body.classList.add('modal-open');
    const style = document.createElement('style');
    style.textContent = `
        .modal-content { transform-origin: center; }
        .close-modal:hover {
            background: rgba(255, 255, 255, 0.3) !important;
            transform: scale(1.1) rotate(90deg);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
        }
        body.dark-mode .modal-content {
            background: rgba(15, 23, 42, 0.98);
            border-color: var(--accent);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4), 0 0 50px rgba(6, 182, 212, 0.3);
        }
        body.dark-mode .modal-header {
            background: linear-gradient(135deg, var(--accent), var(--primary));
        }
    `;
    document.head.appendChild(style);
}

function closeCustomModal() {
    const modal = document.getElementById('customModal');
    if (modal) {
        modal.classList.remove('show');
        setTimeout(() => modal.remove(), 300);
        document.body.classList.remove('modal-open');
    }
}

// ============================================
// BULK RETURN FUNCTIONS
// ============================================

let selectedGroups = new Set();

function toggleSelectAll() {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    if (!selectAllCheckbox) return;
    const checkboxes = document.querySelectorAll('.bookSelectCheckbox:not(:disabled)');
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    updateSelection();
}

function updateSelection() {
    selectedGroups.clear();
    const checkboxes = document.querySelectorAll('.bookSelectCheckbox:checked');
    checkboxes.forEach(checkbox => {
        const groupIndex = parseInt(checkbox.dataset.groupIndex);
        if (!isNaN(groupIndex)) {
            selectedGroups.add(groupIndex);
        }
    });
    const enabledCheckboxes = document.querySelectorAll('.bookSelectCheckbox:not(:disabled)');
    const checkedEnabledCheckboxes = document.querySelectorAll('.bookSelectCheckbox:not(:disabled):checked');
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    if (selectAllCheckbox) {
        selectAllCheckbox.checked = enabledCheckboxes.length > 0 && enabledCheckboxes.length === checkedEnabledCheckboxes.length;
        selectAllCheckbox.indeterminate = checkedEnabledCheckboxes.length > 0 && checkedEnabledCheckboxes.length < enabledCheckboxes.length;
    }
    updateSelectedBooksSummary();
}

function clearSelection() {
    selectedGroups.clear();
    const checkboxes = document.querySelectorAll('.bookSelectCheckbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    if (selectAllCheckbox) {
        selectAllCheckbox.checked = false;
        selectAllCheckbox.indeterminate = false;
    }
    updateSelectedBooksSummary();
}

function updateSelectedBooksSummary() {
    const summaryDiv = document.getElementById('selectedBooksSummary');
    if (!summaryDiv || selectedGroups.size === 0) return;
    const groups = getGroupedData();
    let totalBooks = 0;
    let totalTransactions = 0;
    const memberNames = [];
    selectedGroups.forEach(groupIndex => {
        const group = groups[groupIndex];
        if (group && group.books && group.transaction_ids) {
            const pendingBooks = group.books.filter(book => book && !book.returned_at);
            totalBooks += pendingBooks.length;
            totalTransactions += group.transaction_ids.length;
            if (group.member) {
                memberNames.push(`${group.member.first_name || ''} ${group.member.last_name || ''}`.trim());
            }
        }
    });
    const uniqueMembers = [...new Set(memberNames.filter(name => name))];
    const membersText = uniqueMembers.length === 1 ?
        uniqueMembers[0] :
        `${uniqueMembers.length} members`;
    summaryDiv.innerHTML = `
        <p style="margin: 0; font-size: 0.9rem;">
            <strong>Selected:</strong> ${totalBooks} book(s) from ${membersText}<br>
            <small style="color: var(--text-muted);">${totalTransactions} transaction(s) total</small>
        </p>
    `;
}

function toggleBulkReturnMode() {
    const bulkSection = document.getElementById('bulkReturnSection');
    const toggleText = document.getElementById('bulkReturnToggleText');
    if (!bulkSection || !toggleText) return;
    if (bulkSection.style.display === 'none' || bulkSection.style.opacity === '0') {
        bulkSection.style.display = 'block';
        toggleText.textContent = 'Exit Bulk Return';
        bulkSection.style.opacity = '0';
        bulkSection.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            bulkSection.style.transition = 'all 0.3s ease';
            bulkSection.style.opacity = '1';
            bulkSection.style.transform = 'translateY(0)';
        }, 10);
    } else {
        bulkSection.style.transition = 'all 0.3s ease';
        bulkSection.style.opacity = '0';
        bulkSection.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            bulkSection.style.display = 'none';
            toggleText.textContent = 'Enable Bulk Return';
            clearSelection();
        }, 300);
    }
}

function selectAllPending() {
    const checkboxes = document.querySelectorAll('.bookSelectCheckbox:not(:disabled)');
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
    updateSelection();
}

function exitBulkReturnMode() {
    clearSelection();
    const bulkSection = document.getElementById('bulkReturnSection');
    const toggleText = document.getElementById('bulkReturnToggleText');
    if (bulkSection) {
        bulkSection.style.transition = 'all 0.3s ease';
        bulkSection.style.opacity = '0';
        bulkSection.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            bulkSection.style.display = 'none';
            if (toggleText) {
                toggleText.textContent = 'Enable Bulk Return';
            }
        }, 300);
    }
}

function processBulkReturn() {
    if (selectedGroups.size === 0) {
        showToast('No books selected for return', 'warning');
        return;
    }
    const groups = getGroupedData();
    const allTransactionIds = [];
    const booksSummary = [];
    const memberNames = [];
    selectedGroups.forEach(groupIndex => {
        const group = groups[groupIndex];
        if (group) {
            const pendingBooks = group.books.filter(book => !book.returned_at);
            pendingBooks.forEach(book => {
                allTransactionIds.push(book.id);
                booksSummary.push(book.title || 'Unknown Title');
            });
            const memberName = `${group.member.first_name || ''} ${group.member.last_name || ''}`.trim();
            if (memberName && !memberNames.includes(memberName)) {
                memberNames.push(memberName);
            }
        }
    });
    if (allTransactionIds.length === 0) {
        showToast('No pending books to return', 'warning');
        return;
    }
    const membersText = memberNames.length === 1 ? memberNames[0] : `${memberNames.length} members`;
    const summary = booksSummary.join(', ');
    const shortSummary = summary.length > 100 ? summary.substring(0, 100) + '...' : summary;
    const confirmMessage = `Are you sure you want to return ${allTransactionIds.length} book(s) from ${membersText}?`;
    if (confirm(`${confirmMessage}\nBooks: ${shortSummary}`)) {
        returnMultipleBooksProcess(allTransactionIds);
    }
}

// ============================================
// TOAST NOTIFICATION FUNCTIONS
// ============================================

function showToast(message, type) {
    let toast = document.querySelector('.toast-notification.toast-' + type);
    if (!toast) {
        toast = document.createElement('div');
        toast.className = 'toast-notification toast-' + type;
        toast.innerHTML = `
            <div class="toast-content">
                <div class="toast-icon">${type === 'success' ? '✅' : type === 'error' ? '❌' : type === 'warning' ? '⚠️' : 'ℹ️'}</div>
                <div class="toast-text">${message}</div>
                <button class="toast-close" onclick="this.parentElement.parentElement.remove()">×</button>
            </div>
        `;
        const stack = document.getElementById('toast-stack');
        if (stack) stack.appendChild(toast);
    } else {
        toast.querySelector('.toast-text').textContent = message;
    }
    setTimeout(() => toast.classList.add('show'), 100);
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            if (toast.parentNode) toast.remove();
        }, 300);
    }, 5000);
}

// ============================================
// CHART FUNCTIONS
// ============================================

async function updateWeeklyChart() {
    const month = document.getElementById('monthFilter').value;
    const year = document.getElementById('yearFilter').value;
    try {
        const token = document.querySelector('meta[name="csrf-token"]');
        const response = await fetch(`/dashboard/weekly-data?month=${month}&year=${year}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': token ? token.getAttribute('content') : ''
            },
            credentials: 'same-origin'
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Server response:', errorText);
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }

        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const errorText = await response.text();
            console.error('Expected JSON but got:', errorText);
            throw new Error('Server returned non-JSON response');
        }

        const data = await response.json();
        if (window.weeklyChart) {
            window.weeklyChart.data.labels = data.map(item => item.week);
            window.weeklyChart.data.datasets[0].data = data.map(item => item.count);
            window.weeklyChart.update();
        }
    } catch (error) {
        console.error('Error updating weekly chart:', error);
    }
}

// Get stats data from data attributes or global variables
const statsData = {
    lifetime: {
        mainCount: window.dashboardStats?.lifetimeCount || 0,
        mainLabel: 'Total Transactions',
        booksCount: window.dashboardStats?.booksCount || 0,
        membersCount: window.dashboardStats?.membersCount || 0,
        chartData: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            books: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, window.dashboardStats?.booksCount || 0],
            members: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, window.dashboardStats?.membersCount || 0]
        }
    },
    today: {
        mainCount: window.dashboardStats?.dailyCount || 0,
        mainLabel: "Today's Transactions",
        booksCount: window.dashboardStats?.booksToday || 0,
        membersCount: window.dashboardStats?.membersToday || 0,
        chartData: {
            labels: ['6AM', '9AM', '12PM', '3PM', '6PM', '9PM'],
            books: [0, window.dashboardStats?.booksToday || 0, 0, 0, 0, 0],
            members: [0, window.dashboardStats?.membersToday || 0, 0, 0, 0, 0]
        }
    },
    weekly: {
        mainCount: window.dashboardStats?.weeklyCount || 0,
        mainLabel: "This Week's Transactions",
        booksCount: window.dashboardStats?.booksThisWeek || 0,
        membersCount: window.dashboardStats?.membersThisWeek || 0,
        chartData: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            books: [0, 0, 0, 0, 0, 0, window.dashboardStats?.booksThisWeek || 0],
            members: [0, 0, 0, 0, 0, 0, window.dashboardStats?.membersThisWeek || 0]
        }
    }
};

function filterStats(period) {
    const data = statsData[period];
    document.getElementById('mainCount').textContent = data.mainCount;
    document.getElementById('mainLabel').textContent = data.mainLabel;
    document.getElementById('booksCount').textContent = data.booksCount;
    document.getElementById('membersCount').textContent = data.membersCount;
    if (window.statsChart) {
        window.statsChart.data.labels = data.chartData.labels;
        window.statsChart.data.datasets[0].data = data.chartData.books;
        window.statsChart.data.datasets[1].data = data.chartData.members;
        window.statsChart.update();
    }
}

// ============================================
// HELPER FUNCTIONS
// ============================================

function handleBookReturnSuccess() {
    showToast('Book returned successfully!', 'success');
    if (typeof closeReturnModal === 'function') {
        closeReturnModal();
    }
    loadBorrowersData();
    if (typeof loadOverdueData === 'function') {
        loadOverdueData();
    }
}

function showBookDetails(groupIndex) {
    const tooltip = document.getElementById(`books-tooltip-${groupIndex}`);
    if (tooltip) {
        tooltip.style.display = tooltip.style.display === 'block' ? 'none' : 'block';
    }
}

// ============================================
// CHRISTMAS EFFECTS INITIALIZATION
// ============================================

function initializeChristmasToggle() {
    let attempts = 0;
    const maxAttempts = 10;
    function tryInitialize() {
        attempts++;
        const christmasToggle = document.getElementById('christmasToggle');
        const christmasToggleText = document.querySelector('#christmasToggle #christmasToggleText');
        if (christmasToggle && christmasToggleText) {
            function updateToggleAppearance() {
                const isActive = window.christmasEffects && window.christmasEffects.getState ?
                    window.christmasEffects.getState().active : false;
                christmasToggle.classList.toggle('active', isActive);
                christmasToggleText.textContent = isActive ? 'Disable Christmas' : 'Enable Christmas';
            }
            updateToggleAppearance();
            christmasToggle.addEventListener('click', function() {
                if (window.christmasEffects && window.christmasEffects.toggle) {
                    window.christmasEffects.toggle();
                    updateToggleAppearance();
                } else {
                    console.error('Christmas effects not loaded');
                    document.dispatchEvent(new CustomEvent('christmas-toggle'));
                }
            });
            document.addEventListener('christmas-state-changed', function(e) {
                updateToggleAppearance();
            });
            return true;
        } else if (attempts < maxAttempts) {
            setTimeout(tryInitialize, 100);
            return false;
        } else {
            return false;
        }
    }
    return tryInitialize();
}

// ============================================
// KEYBOARD SHORTCUTS
// ============================================

document.addEventListener('keydown', function(e) {
    // Ctrl+A to select all in bulk return mode
    if (e.ctrlKey && e.key === 'a' && e.target.closest('.data-table')) {
        e.preventDefault();
        const bulkSection = document.getElementById('bulkReturnSection');
        if (bulkSection && bulkSection.style.display !== 'none') {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            if (selectAllCheckbox && !selectAllCheckbox.disabled) {
                selectAllCheckbox.checked = !selectAllCheckbox.checked;
                toggleSelectAll();
            }
        }
    }
    // Escape to clear selection
    if (e.key === 'Escape') {
        const bulkSection = document.getElementById('bulkReturnSection');
        if (bulkSection && bulkSection.style.display !== 'none') {
            clearSelection();
        }
    }
});

// ============================================
// DOCUMENT READY INITIALIZATION
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard page loaded');

    // Dark mode initialization
    const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const savedMode = localStorage.getItem('darkMode');
    const isDark = savedMode ? savedMode === 'true' : prefersDarkMode;
    document.body.classList.toggle('dark-mode', isDark);

    const darkModeToggle = document.getElementById('darkModeToggle');
    const darkModeLabel = document.getElementById('darkModeLabel');
    if (darkModeToggle && darkModeLabel) {
        darkModeToggle.checked = isDark;
        darkModeLabel.textContent = isDark ? 'Dark Mode' : 'Light Mode';
        darkModeToggle.addEventListener('change', () => {
            const isChecked = darkModeToggle.checked;
            document.body.classList.toggle('dark-mode', isChecked);
            localStorage.setItem('darkMode', isChecked);
            darkModeLabel.textContent = isChecked ? 'Dark Mode' : 'Light Mode';
        });
    }

    // Check for success message from URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('returned') === 'success') {
        showToast('Book returned successfully!', 'success');
        window.history.replaceState({}, document.title, window.location.pathname);
    }

    // Check for member registration success and reset modal
    if (urlParams.get('member_registered') === 'success') {
        // Reset member registration modals using the same logic as memberscript.js
        const registerForm = document.getElementById("registerForm");
        const julitaForm = document.getElementById("julitaRegisterForm");
        if (registerForm) registerForm.reset();
        if (julitaForm) julitaForm.reset();

        // Clear photo previews
        const previews = document.querySelectorAll("#photoPreview");
        previews.forEach(preview => {
            preview.src = "";
            preview.style.display = "none";
        });

        // Show success message
        showToast('Member registered successfully!', 'success');

        // Clean up URL
        window.history.replaceState({}, document.title, window.location.pathname);
    }

    // Load borrowers data
    loadBorrowersData();

    // Initialize bulk return section (hidden by default)
    const bulkSection = document.getElementById('bulkReturnSection');
    const toggleText = document.getElementById('bulkReturnToggleText');
    if (bulkSection) bulkSection.style.display = 'none';
    if (toggleText) toggleText.textContent = 'Enable Bulk Return';

    // Set current month and year for chart filters
    const currentMonth = new Date().getMonth() + 1;
    const monthFilter = document.getElementById('monthFilter');
    if (monthFilter) monthFilter.value = currentMonth;

    const currentYear = new Date().getFullYear();
    const yearFilter = document.getElementById('yearFilter');
    if (yearFilter) yearFilter.value = currentYear;

    // Initialize stats filter
    filterStats('lifetime');

    // Reset filter dropdowns to default
    const borrowersFilter = document.getElementById('borrowersFilter');
    const returnStatusFilter = document.getElementById('returnStatusFilter');
    if (borrowersFilter) borrowersFilter.value = 'all';
    if (returnStatusFilter) returnStatusFilter.value = 'all';

    // Initialize Christmas toggle
    setTimeout(() => {
        initializeChristmasToggle();
    }, 100);

    // Add click event listeners to member card buttons
    const memberCardButtons = document.querySelectorAll('.card .btn');
    memberCardButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            console.log('Button clicked:', this.onclick?.toString());
        });
    });

    console.log('✅ Dashboard initialization complete');
});

// ============================================
// BORROW FUNCTIONALITY INITIALIZATION
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    console.log('📚 Initializing borrow functionality...');
    
    // Member name input handler
    const memberNameInput = document.getElementById('memberName');
    if (memberNameInput) {
        memberNameInput.addEventListener('input', function() {
            console.log('🔄 Member name changed, updating button state');
            if (typeof updateConfirmButtonState === 'function') {
                updateConfirmButtonState();
            }
        });
    }
    
    // Book row click handlers
    const bookRows = document.querySelectorAll('#booksTableBody tr[data-id]');
    bookRows.forEach(row => {
        row.addEventListener('click', function(e) {
            if (!e.target.closest('.btn')) {
                const bookId = this.dataset.id;
                if (typeof toggleBookSelection === 'function') {
                    toggleBookSelection(bookId);
                }
            }
        });
    });
    
    console.log('✅ Borrow functionality initialized');
});

// ============================================
// EXPORT FUNCTIONS FOR GLOBAL ACCESS
// ============================================

// Make key functions available globally
window.openJulitaRegisterModal = openJulitaRegisterModal;
window.closeRegisterModal = closeRegisterModal;
window.closeJulitaRegisterModal = closeJulitaRegisterModal;
window.submitJulitaRegister = submitJulitaRegister;
window.submitRegister = submitRegister;
window.openBooksTable = openBooksTable;
window.closeBooksTable = closeBooksTable;
window.openMembersTable = openMembersTable;
window.closeMembersTable = closeMembersTable;
window.loadBorrowersData = loadBorrowersData;
window.returnMultipleBooks = returnMultipleBooks;
window.returnBookDirect = returnBookDirect;
window.searchBorrowers = searchBorrowers;
window.filterBorrowers = filterBorrowers;
window.filterByReturnStatus = filterByReturnStatus;
window.sortTable = sortTable;
window.showDetailedBookInfo = showDetailedBookInfo;
window.toggleSelectAll = toggleSelectAll;
window.updateSelection = updateSelection;
window.clearSelection = clearSelection;
window.toggleBulkReturnMode = toggleBulkReturnMode;
window.selectAllPending = selectAllPending;
window.exitBulkReturnMode = exitBulkReturnMode;
window.processBulkReturn = processBulkReturn;
window.showToast = showToast;
window.updateWeeklyChart = updateWeeklyChart;
window.filterStats = filterStats;
window.showBookDetails = showBookDetails;
window.closeCustomModal = closeCustomModal;

console.log('✅ dashb_iScripts.js loaded successfully');[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]