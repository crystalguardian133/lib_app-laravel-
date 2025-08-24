document.addEventListener('DOMContentLoaded', () => {
  checkOverdueBooks();
});

// Function to fetch overdue books for the current member
function checkOverdueBooks() {
  fetch('/members/overdue') // Endpoint should return JSON: { books: [ { title, due_date } ] }
    .then(res => res.json())
    .then(data => {
      if (!data.books || data.books.length === 0) return;

      data.books.forEach(book => {
        const message = `📚 "${book.title}" is overdue! Due: ${book.due_date}`;
        showOverduePopup(message);
      });
    })
    .catch(err => console.error('Error fetching overdue books:', err));
}

// Show overdue corner popup (disappears after 5s or on click)
function showOverduePopup(message) {
  const popup = document.createElement('div');
  popup.className = 'corner-popup overdue-popup';
  popup.innerText = message;

  Object.assign(popup.style, {
    position: 'fixed',
    bottom: '20px',
    right: '20px',
    background: '#ff4d4d',
    color: '#fff',
    padding: '12px 20px',
    borderRadius: '6px',
    zIndex: '9999',
    boxShadow: '0 2px 10px rgba(0,0,0,0.3)',
    cursor: 'pointer',
    opacity: '0',
    transition: 'opacity 0.3s'
  });

  document.body.appendChild(popup);

  // Fade in
  setTimeout(() => popup.style.opacity = '1', 50);

  // Remove on click
  popup.addEventListener('click', () => popup.remove());

  // Auto-remove after 5 seconds
  setTimeout(() => {
    popup.style.opacity = '0';
    setTimeout(() => popup.remove(), 300);
  }, 5000);
}
