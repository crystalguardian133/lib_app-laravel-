// Helper: Calculate Easter Sunday (Meeus algorithm)
function calculateEasterDate(year) {
  const a = year % 19;
  const b = Math.floor(year / 100);
  const c = year % 100;
  const d = Math.floor(b / 4);
  const e = b % 4;
  const f = Math.floor((b + 8) / 25);
  const g = Math.floor((b - f + 1) / 3);
  const h = (19 * a + b - d - g + 15) % 30;
  const i = Math.floor(c / 4);
  const k = c % 4;
  const l = (32 + 2 * e + 2 * i - h - k) % 7;
  const m = Math.floor((a + 11 * h + 22 * l) / 451);
  const month = Math.floor((h + l - 7 * m + 114) / 31) - 1;
  const day = ((h + l - 7 * m + 114) % 31) + 1;
  return new Date(year, month, day);
}

// Get Philippine holidays as YYYY-MM-DD strings
function getPhilippineHolidays(year) {
  const fixedHolidays = [
    { month: 0,   day: 1 },   // Jan 1 – New Year
    { month: 3,   day: 9 },   // Apr 9 – Araw ng Kagitingan
    { month: 4,   day: 1 },   // May 1 – Labor Day
    { month: 5,   day: 12 },  // Jun 12 – Independence Day
    { month: 8,   day: 30 },  // Aug 30 – Ninoy Aquino Day
    { month: 10,  day: 30 },  // Nov 30 – Bonifacio Day
    { month: 11,  day: 25 },  // Dec 25 – Christmas
    { month: 11,  day: 26 },  // Dec 26 – Special Non-Working
    { month: 11,  day: 30 },  // Dec 30 – Rizal Day
  ];

  const easter = calculateEasterDate(year);
  const goodFriday = new Date(easter);
  goodFriday.setDate(goodFriday.getDate() - 2);

  const holidayStrings = fixedHolidays.map(h =>
    `${year}-${String(h.month + 1).padStart(2, '0')}-${String(h.day).padStart(2, '0')}`
  );
  holidayStrings.push(goodFriday.toISOString().split('T')[0]);

  return holidayStrings;
}

// Add n business days (skip weekends & PH holidays)
function addBusinessDays(date, days) {
  const result = new Date(date);
  let added = 0;
  const currentYear = result.getFullYear();
  const nextYear = currentYear + 1;

  const holidaySet = new Set([
    ...getPhilippineHolidays(currentYear),
    ...getPhilippineHolidays(nextYear)
  ]);

  while (added < days) {
    result.setDate(result.getDate() + 1);
    const dayOfWeek = result.getDay(); // 0=Sun, 6=Sat
    const dateString = result.toISOString().split('T')[0];

    if (dayOfWeek !== 0 && dayOfWeek !== 6 && !holidaySet.has(dateString)) {
      added++;
    }
  }
  return result;
}

// Format date for input[type="date"] (YYYY-MM-DD)
function formatDateForInput(date) {
  const y = date.getFullYear();
  const m = String(date.getMonth() + 1).padStart(2, '0');
  const d = String(date.getDate()).padStart(2, '0');
  return `${y}-${m}-${d}`;
}

// Escape HTML to prevent XSS
function escapeHtml(text) {
  const div = document.createElement('div');
  div.textContent = text;
  return div.innerHTML;
}

// Format time to 12-hour with AM/PM
function formatTimeWithAMPM(date) {
  let h = date.getHours();
  const m = date.getMinutes();
  const ampm = h >= 12 ? 'PM' : 'AM';
  h = h % 12 || 12;
  const timeStr = `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`;
  return { time: timeStr, ampm };
}

// Corner popup (auto-dismiss)
function showCornerPopup(message) {
  let popup = document.getElementById('corner-popup');
  if (!popup) {
    popup = document.createElement('div');
    popup.id = 'corner-popup';
    popup.style.position = 'fixed';
    popup.style.bottom = '20px';
    popup.style.right = '20px';
    popup.style.background = '#222';
    popup.style.color = '#fff';
    popup.style.padding = '12px 20px';
    popup.style.borderRadius = '6px';
    popup.style.zIndex = '9999';
    popup.style.boxShadow = '0 4px 12px rgba(0,0,0,0.2)';
    popup.style.fontSize = '0.95rem';
    popup.style.maxWidth = '300px';
    popup.style.textAlign = 'center';
    document.body.appendChild(popup);
  }
  popup.innerText = message;
  popup.style.display = 'block';
  setTimeout(() => popup.style.display = 'none', 3000);
}

// DOM Ready
document.addEventListener('DOMContentLoaded', () => {
  const memberInput = document.getElementById('memberName');
  const suggestionBox = document.getElementById('suggestionBox');

  // Autocomplete member name
  if (memberInput && suggestionBox) {
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
            `<div class="suggestion" onclick="selectMember('${escapeHtml(name)}')">${escapeHtml(name)}</div>`
          ).join('');
        })
        .catch(() => {
          suggestionBox.innerHTML = `<div class="suggestion">Error fetching suggestions</div>`;
        });
    });
  }

  // Book card selection
  document.querySelectorAll('.book-card').forEach(card => {
    card.addEventListener('click', (e) => {
      if (['BUTTON', 'IMG'].includes(e.target.tagName)) return;
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

// Open borrow modal
function openBorrowModal() {
  const selectedCards = document.querySelectorAll('.book-card.selected');
  if (selectedCards.length === 0) {
    showCornerPopup("❗ No books selected.");
    return;
  }

  // Populate selected books
  const list = document.getElementById('selectedBooksList');
  list.innerHTML = '';
  selectedCards.forEach(card => {
    const li = document.createElement('li');
    li.textContent = card.getAttribute('data-title');
    li.setAttribute('data-id', card.getAttribute('data-id'));
    list.appendChild(li);
  });

  // Set current time
  const now = new Date();
  const { time, ampm } = formatTimeWithAMPM(now);
  const timeInput = document.getElementById('dueTime');
  timeInput.value = time;

  // Add AM/PM indicator
  let ampmIndicator = document.getElementById('ampmIndicator');
  if (!ampmIndicator) {
    ampmIndicator = document.createElement('span');
    ampmIndicator.id = 'ampmIndicator';
    ampmIndicator.style.marginLeft = '5px';
    ampmIndicator.style.color = 'var(--gray)';
    ampmIndicator.style.fontSize = '0.85rem';
    timeInput.parentNode.insertBefore(ampmIndicator, timeInput.nextSibling);
  }
  ampmIndicator.textContent = ampm;

  // 🔹 Calculate: min = today, max = 10 business days from today
  const today = new Date();
  const minDueDate = today;                    // ✅ Same-day allowed
  const maxDueDate = addBusinessDays(today, 10); // 10 business days ahead

  const dueDateInput = document.getElementById('dueDate');
  dueDateInput.min = formatDateForInput(minDueDate);
  dueDateInput.max = formatDateForInput(maxDueDate);
  dueDateInput.value = formatDateForInput(minDueDate); // ✅ Auto-fill with TODAY

  // Add hint
  let dueHint = document.getElementById('due-date-hint');
  if (!dueHint) {
    dueHint = document.createElement('small');
    dueHint.id = 'due-date-hint';
    dueHint.style.display = 'block';
    dueHint.style.color = 'var(--gray)';
    dueHint.style.fontSize = '0.85rem';
    dueHint.style.marginTop = '4px';
    dueDateInput.parentNode.appendChild(dueHint);
  }
  dueHint.textContent = `Auto-filled: Today. You can extend up to ${formatDateForInput(maxDueDate)}.`;

  // Validate on change
  dueDateInput.onchange = function () {
    const selected = new Date(this.value);
    const day = selected.getDay();
    const dateString = selected.toISOString().split('T')[0];
    const year = selected.getFullYear();
    const holidays = getPhilippineHolidays(year);

    if (day === 0 || day === 6) {
      showCornerPopup("📅 Please select a weekday (Mon–Fri).");
      this.value = formatDateForInput(minDueDate); // fallback to today
    } else if (holidays.includes(dateString)) {
      showCornerPopup("🚫 Selected date is a national holiday.");
      this.value = formatDateForInput(minDueDate);
    }
  };

  // Show modal
  document.getElementById('borrowModal').style.display = 'flex';
}

// Close borrow modal
function closeBorrowModal() {
  const modal = document.getElementById('borrowModal');
  if (modal) modal.style.display = 'none';

  const list = document.getElementById('selectedBooksList');
  if (list) list.innerHTML = '';

  ['memberName', 'memberId', 'dueDate', 'dueTime'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.value = '';
  });

  const ampmIndicator = document.getElementById('ampmIndicator');
  if (ampmIndicator) ampmIndicator.remove();

  const dueHint = document.getElementById('due-date-hint');
  if (dueHint) dueHint.remove();

  const dueDateInput = document.getElementById('dueDate');
  if (dueDateInput) dueDateInput.onchange = null;

  document.querySelectorAll('.book-card.selected').forEach(c => c.classList.remove('selected'));
}

// Confirm borrow
function confirmBorrow() {
  const memberId = document.getElementById('memberId').value;
  const dueDate = document.getElementById('dueDate').value;
  const dueTime = document.getElementById('dueTime').value;

  const selectedCards = document.querySelectorAll('.book-card.selected');
  if (!memberId || !dueDate || !dueTime) {
    alert("⚠️ Please fill in all fields.");
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
    setTimeout(() => location.reload(), 500);
  })
  .catch(err => {
    console.error("Error:", err);
    alert("🚫 Network error. Check console.");
  });
}

// Borrow single book
function borrowOne(bookId) {
  const card = document.querySelector(`.book-card[data-id="${bookId}"]`);
  if (!card) return showCornerPopup("❌ Book not found.");

  const availableText = card.querySelector('.book-meta div:nth-child(3)').innerText;
  if (!availableText.includes('Yes')) return showCornerPopup("⚠️ No copies available.");

  // Reset selection
  document.querySelectorAll('.book-card.selected').forEach(c => c.classList.remove('selected'));
  card.classList.add('selected');

  // Populate list
  const list = document.getElementById('selectedBooksList');
  list.innerHTML = '';
  const li = document.createElement('li');
  li.textContent = card.getAttribute('data-title');
  li.setAttribute('data-id', bookId);
  list.appendChild(li);

  // Time
  const now = new Date();
  const { time, ampm } = formatTimeWithAMPM(now);
  const timeInput = document.getElementById('dueTime');
  timeInput.value = time;

  let ampmIndicator = document.getElementById('ampmIndicator');
  if (!ampmIndicator) {
    ampmIndicator = document.createElement('span');
    ampmIndicator.id = 'ampmIndicator';
    ampmIndicator.style.marginLeft = '5px';
    ampmIndicator.style.color = 'var(--gray)';
    ampmIndicator.style.fontSize = '0.85rem';
    timeInput.parentNode.insertBefore(ampmIndicator, timeInput.nextSibling);
  }
  ampmIndicator.textContent = ampm;

  // Calculate range
  const today = new Date();
  const minDue = today;
  const maxDue = addBusinessDays(today, 10);

  const dueDateInput = document.getElementById('dueDate');
  dueDateInput.min = formatDateForInput(minDue);
  dueDateInput.max = formatDateForInput(maxDue);
  dueDateInput.value = formatDateForInput(minDue); // ✅ Auto-fill with today

  let dueHint = document.getElementById('due-date-hint');
  if (!dueHint) {
    dueHint = document.createElement('small');
    dueHint.id = 'due-date-hint';
    dueHint.style.display = 'block';
    dueHint.style.color = 'var(--gray)';
    dueHint.style.fontSize = '0.85rem';
    dueHint.style.marginTop = '4px';
    dueDateInput.parentNode.appendChild(dueHint);
  }
  dueHint.textContent = `Auto-filled: Today. Max: ${formatDateForInput(maxDue)}.`;

  // Validate
  dueDateInput.onchange = function () {
    const selected = new Date(this.value);
    const day = selected.getDay();
    const dateString = selected.toISOString().split('T')[0];
    const year = selected.getFullYear();
    const holidays = getPhilippineHolidays(year);

    if (day === 0 || day === 6) {
      showCornerPopup("📅 Weekends not allowed.");
      this.value = formatDateForInput(minDue);
    } else if (holidays.includes(dateString)) {
      showCornerPopup("🚫 Holiday. Pick another day.");
      this.value = formatDateForInput(minDue);
    }
  };

  document.getElementById('borrowModal').style.display = 'flex';
}