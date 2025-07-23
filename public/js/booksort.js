const table = document.getElementById('book-table');
const headers = table.querySelectorAll('th');
const tbody = table.querySelector('tbody');
let sortStates = {};

headers.forEach(th => {
  const col = th.getAttribute('data-column');
  sortStates[col] = 0; // 0: unsorted, 1: asc, 2: desc

  th.addEventListener('click', () => {
    // Reset all other headers
    headers.forEach(h => {
      if (h !== th) h.classList.remove('sort-asc', 'sort-desc');
    });

    // Update state
    sortStates[col] = (sortStates[col] + 1) % 3;
    const state = sortStates[col];

    th.classList.remove('sort-asc', 'sort-desc');
    if (state === 1) th.classList.add('sort-asc');
    else if (state === 2) th.classList.add('sort-desc');

    // Sort rows
    const rows = Array.from(tbody.querySelectorAll('tr'));
    if (state === 0) {
      rows.sort((a, b) => a.rowIndex - b.rowIndex); // default
    } else {
      rows.sort((a, b) => {
        const A = a.children[col].textContent.trim().toLowerCase();
        const B = b.children[col].textContent.trim().toLowerCase();
        if (A < B) return state === 1 ? -1 : 1;
        if (A > B) return state === 1 ? 1 : -1;
        return 0;
      });
    }

    // Re-append rows
    rows.forEach(row => tbody.appendChild(row));
  });
});

document.getElementById('search-input').addEventListener('input', function () {
  const searchValue = this.value.toLowerCase();
  const rows = document.querySelectorAll('table tbody tr');

  rows.forEach(row => {
    const title = row.cells[1].textContent.toLowerCase(); // 1 = title column
    const author = row.cells[2].textContent.toLowerCase(); // optional: include more columns
    if (title.includes(searchValue) || author.includes(searchValue)) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
});
