document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('addBookForm');

  form.addEventListener('submit', async function (e) {
    e.preventDefault();

    const formData = new FormData(form);

    try {
      const response = await fetch('/books', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json',
        },
        body: formData,
      });

      if (!response.ok) {
        const text = await response.text();
        console.error('Error Response:', text);
        throw new Error('Failed to add book');
      }

      const result = await response.json();
      showCornerPopup(result.message || 'Book added successfully!');
      closeAddBookModal();
      form.reset();
      setTimeout(() => location.reload(), 1000);
    } catch (error) {
      console.error('Error:', error);
      showCornerPopup('Failed to add book. Please check console.');
    }
  });
});

function closeAddBookModal() {
  document.getElementById('addBookModal').style.display = 'none';
}

function showCornerPopup(message) {
  const popup = document.getElementById('corner-popup') || createPopup();
  popup.innerText = message;
  popup.style.display = 'block';
  setTimeout(() => popup.style.display = 'none', 3000);
}

function createPopup() {
  const div = document.createElement('div');
  div.id = 'corner-popup';
  div.className = 'corner-popup';
  document.body.appendChild(div);
  return div;
}
function openAddBookModal() {
  document.getElementById('addBookModal').style.display = 'block';
}

function closeAddBookModal() {
  document.getElementById('addBookModal').style.display = 'none';
}