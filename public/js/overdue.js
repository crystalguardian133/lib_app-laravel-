document.addEventListener('DOMContentLoaded', () => {
  checkOverdueBooks();
  setInterval(checkOverdueBooks, 60000); // recheck every 60s
});

async function checkOverdueBooks() {
  try {
    const res = await fetch('/transactions/overdue');
    const data = await res.json();

    if (!data.books || data.books.length === 0) return;

    data.books.forEach(book => {
      const msg = `📚 ${book.member} has not returned "${book.title}" (Due: ${book.due_date})`;
      showOverduePopup(msg);
    });
  } catch (err) {
    console.error('Error fetching overdue books:', err);
  }
}

function showOverduePopup(message) {
  const container = document.getElementById("overdueContainer") || createOverdueContainer();

  const popup = document.createElement("div");
  popup.className = "overdue-popup";
  popup.innerHTML = `<span class="popup-icon">⚠️</span><span class="popup-msg">${message}</span>`;

  popup.addEventListener("click", () => popup.remove());
  container.appendChild(popup);

  requestAnimationFrame(() => popup.classList.add("show"));

  setTimeout(() => {
    popup.classList.remove("show");
    setTimeout(() => popup.remove(), 400);
  }, 7000);
}

function createOverdueContainer() {
  const container = document.createElement("div");
  container.id = "overdueContainer";
  document.body.appendChild(container);
  return container;
}
