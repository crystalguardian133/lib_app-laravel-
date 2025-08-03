document.addEventListener('DOMContentLoaded', () => {
  // Autocomplete member name
  const memberInput = document.getElementById('memberName');
  const suggestionBox = document.getElementById('suggestionBox');
  

  memberInput.addEventListener('input', () => {
    const query = memberInput.value.trim();
    if (query.length < 2) {
      suggestionBox.innerHTML = '';
      return;
    }

    fetch(`/members/search?query=${encodeURIComponent(query)}`)
      .then(res => res.json())
      .then(data => {
        if (!Array.isArray(data)) return;
        if (data.length === 0) {
          suggestionBox.innerHTML = `<div class="suggestion">No matches found.</div>`;
          return;
        }

        suggestionBox.innerHTML = data.map(name =>
          `<div class="suggestion" onclick="selectMember('${name}')">${name}</div>`
        ).join('');
      })
      .catch(() => {
        suggestionBox.innerHTML = `<div class="suggestion">Error fetching suggestions</div>`;
      });
  });
});

function selectMember(name) {
  document.getElementById('memberName').value = name;
  document.getElementById('suggestionBox').innerHTML = '';
  document.getElementById('dueDate').focus();
}

function borrowBooks() {
  const checkboxes = document.querySelectorAll('.book-checkbox:checked');
  const list = document.getElementById('selectedBooksList');
  list.innerHTML = '';

  if (checkboxes.length === 0) {
    alert("❗ Please select one or more books first.");
    return;
  }

  let hasUnavailable = false;

  checkboxes.forEach(cb => {
    const row = cb.closest('tr');
    const title = row.children[1].textContent.trim();
    const available = parseInt(row.children[5].textContent.trim());

    if (available === 0) {
      hasUnavailable = true;
    }

    const li = document.createElement('li');
    li.textContent = `${title} (${available} available)`;
    list.appendChild(li);
  });

  if (hasUnavailable) {
    alert("🚫 One or more selected books are unavailable (0 copies). Borrowing prohibited.");
    return;
  }

  document.getElementById('borrowModal').style.display = 'flex';
}

function closeBorrowModal() {
  document.getElementById('borrowModal').style.display = 'none';
  document.getElementById('selectedBooksList').innerHTML = '';
  document.getElementById('memberName').value = '';
  document.getElementById('dueDate').value = '';
}

function confirmBorrow() {
  const memberName = document.getElementById('memberName').value.trim();
  const dueDate = document.getElementById('dueDate').value;
  const dueTime = document.getElementById('dueTime').value;
  const checkboxes = document.querySelectorAll('.book-checkbox:checked');

  if (!memberName || !dueDate || !dueTime) {
    alert("⚠️ Please fill in member name, due date, and due time.");
    return;
  }

  if (checkboxes.length === 0) {
    alert("❗ No books selected.");
    return;
  }

  const bookIds = Array.from(checkboxes).map(cb => cb.closest('tr').getAttribute('data-id'));

  // Combine date + time into full ISO timestamp
  const dueDateTime = `${dueDate}T${dueTime}:00`;
  
fetch("/borrow", {
  method: "POST",
  headers: {
    "Content-Type": "application/json",
    "Accept": "application/json", // 👈 This tells Laravel to return JSON
    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
  },
  body: JSON.stringify({
    member_name: memberName,
    due_date: dueDateTime,
    book_ids: bookIds
  })
})
    .then(res => res.json())
    .then(data => {
      alert(data.message || "✅ Borrow successful!");
      location.reload();
    })
    .catch(err => {
      console.error(err);
      alert("🚫 Error borrowing books.");
    });
}