document.addEventListener('DOMContentLoaded', async () => {
    const toast = document.getElementById('overdueToast');
    const toastMessage = document.getElementById('toastMessage');
    const closeBtn = document.getElementById('closeToast');

    if (!toast || !toastMessage || !closeBtn) {
        console.error("Toast elements missing");
        return;
    }

    closeBtn.addEventListener('click', () => {
        toast.classList.remove('show');
    });

    try {
        const response = await fetch('/transactions/overdue', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        if (!response.ok) throw new Error('Failed to load data');

        const data = await response.json();
        const count = data.books.length;

        if (count === 0) return; // No toast if nothing overdue

        // Group books by member
        const memberBooks = {};
        data.books.forEach(book => {
            if (!memberBooks[book.member]) {
                memberBooks[book.member] = [];
            }
            memberBooks[book.member].push(book.title);
        });

        const memberNames = Object.keys(memberBooks);
        const memberCount = memberNames.length;

        let message = '';

        if (memberCount === 1) {
            const member = memberNames[0];
            const books = memberBooks[member];
            const bookCount = books.length;

            if (bookCount === 1) {
                // "John Doe had borrowed The Great Gatsby, and is overdue."
                message = `<strong>${member}</strong> had borrowed <strong>${books[0]}</strong>, and is overdue.`;
            } else {
                // "John Doe had borrowed 2 books, and are overdue."
                message = `<strong>${member}</strong> had borrowed <strong>${bookCount} book${bookCount > 1 ? 's' : ''}</strong>, and is overdue.`;
            }
        } else {
            // "2 member(s) had overdue book(s)."
            message = `<strong>${memberCount} member${memberCount > 1 ? 's' : ''}</strong> had overdue book${count > 1 ? 's' : ''}.`;
        }

        // Update and show toast
        toastMessage.innerHTML = message;
        toast.classList.add('show');

        // Auto-dismiss after 10 seconds
        setTimeout(() => {
            toast.classList.remove('show');
        }, 10000);
    } catch (err) {
        console.error('Overdue notification error:', err);
        // Optional fallback
        // toastMessage.innerHTML = "⚠️ Could not load overdue books.";
        // toast.style.background = 'var(--warning)';
        // toast.classList.add('show');
    }
});