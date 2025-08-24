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

  // Grid card click selection for multi-borrow
  document.querySelectorAll('.book-card').forEach(card => {
    card.addEventListener('click', (e) => {
      // Avoid triggering when clicking buttons inside the card
      if (e.target.tagName === 'BUTTON' || e.target.tagName === 'IMG') return;

      // Toggle selection
      card.classList.toggle('selected');
    });
  });
});

// Select member from autocomplete
function selectMember(name) {
  document.getElementById('memberName').value = name;
  document.getElementById('suggestionBox').innerHTML = '';
  document.getElementById('dueDate').focus();
}

// Open borrow modal (for multi or single selection)
function openBorrowModal() {
  const selectedCards = document.querySelectorAll('.book-card.selected');
  if (selectedCards.length === 0) {
    showCornerPopup("❗ No books selected.");
    return;
  }

  const list = document.getElementById('selectedBooksList');
  list.innerHTML = '';

  selectedCards.forEach(card => {
    const li = document.createElement('li');
    li.textContent = card.getAttribute('data-title');
    li.setAttribute('data-id', card.getAttribute('data-id'));
    list.appendChild(li);
  });

  const now = new Date();
  const { time, ampm } = formatTimeWithAMPM(now);
  const timeInput = document.getElementById('dueTime');
  timeInput.value = time;

  let ampmIndicator = document.getElementById('ampmIndicator');
  if (!ampmIndicator) {
    ampmIndicator = document.createElement('span');
    ampmIndicator.id = 'ampmIndicator';
    ampmIndicator.style.marginLeft = '5px';
    timeInput.parentNode.insertBefore(ampmIndicator, timeInput.nextSibling);
  }
  ampmIndicator.textContent = ampm;

  document.getElementById('borrowModal').style.display = 'flex';
}

// Close borrow modal
function closeBorrowModal() {
  document.getElementById('borrowModal').style.display = 'none';
  document.getElementById('selectedBooksList').innerHTML = '';
  document.getElementById('memberName').value = '';
  document.getElementById('memberId').value = '';
  document.getElementById('dueDate').value = '';
  const ampmIndicator = document.getElementById('ampmIndicator');
  if (ampmIndicator) ampmIndicator.remove();

  // Remove all selections
  document.querySelectorAll('.book-card.selected').forEach(c => c.classList.remove('selected'));
}

// Confirm borrow (send to backend)
function confirmBorrow() {
  const memberId = document.getElementById('memberId').value;
  const dueDate = document.getElementById('dueDate').value;
  const dueTime = document.getElementById('dueTime').value;

  const selectedCards = document.querySelectorAll('.book-card.selected');
  if (!memberId || !dueDate || !dueTime) {
    alert("⚠️ Please fill in member name, due date, and due time.");
    return;
  }
  if (selectedCards.length === 0) {
    alert("❗ No books selected.");
    return;
  }

  const bookIds = Array.from(selectedCards).map(c => c.getAttribute('data-id'));
  const dueDateTime = `${dueDate}T${dueTime}:00`;

  fetch("/borrow", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json",
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
      member_id: memberId,
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

// Borrow a single book via button
function borrowOne(bookId) {
  const card = document.querySelector(`.book-card[data-id="${bookId}"]`);
  if (!card) return showCornerPopup("❌ Book not found.");

  const availableText = card.querySelector('.book-meta div:nth-child(3)').innerText;
  if (!availableText.includes('Yes')) return showCornerPopup("⚠️ No copies available.");

  // Single selection: clear previous
  document.querySelectorAll('.book-card.selected').forEach(c => c.classList.remove('selected'));
  card.classList.add('selected');

  // Populate modal immediately
  const list = document.getElementById('selectedBooksList');
  list.innerHTML = '';
  const li = document.createElement('li');
  li.textContent = card.getAttribute('data-title');
  li.setAttribute('data-id', bookId);
  list.appendChild(li);

  const now = new Date();
  const { time, ampm } = formatTimeWithAMPM(now);
  const timeInput = document.getElementById('dueTime');
  timeInput.value = time;

  let ampmIndicator = document.getElementById('ampmIndicator');
  if (!ampmIndicator) {
    ampmIndicator = document.createElement('span');
    ampmIndicator.id = 'ampmIndicator';
    ampmIndicator.style.marginLeft = '5px';
    timeInput.parentNode.insertBefore(ampmIndicator, timeInput.nextSibling);
  }
  ampmIndicator.textContent = ampm;

  document.getElementById('borrowModal').style.display = 'flex';
}

// Format time to 12-hour + AM/PM
function formatTimeWithAMPM(date) {
  let hours = date.getHours();
  const minutes = date.getMinutes();
  const ampm = hours >= 12 ? 'PM' : 'AM';
  hours = hours % 12 || 12;
  const timeStr = `${hours.toString().padStart(2,'0')}:${minutes.toString().padStart(2,'0')}`;
  return { time: timeStr, ampm };
}

// Corner popup
function showCornerPopup(message) {
  let popup = document.getElementById('corner-popup');
  if (!popup) {
    popup = document.createElement('div');
    popup.id = 'corner-popup';
    popup.className = 'corner-popup';
    Object.assign(popup.style, {
      position: 'fixed',
      bottom: '20px',
      right: '20px',
      background: '#222',
      color: '#fff',
      padding: '10px 20px',
      borderRadius: '5px',
      zIndex: '9999'
    });
    document.body.appendChild(popup);
  }
  popup.innerText = message;
  popup.style.display = 'block';
  setTimeout(() => popup.style.display = 'none', 3000);
}
