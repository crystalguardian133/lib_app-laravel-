document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('memberSearchInput') || document.getElementById('search-input');
  const rows = document.querySelectorAll('#membersTable tbody tr, #member-table tbody tr');

  if (!searchInput || rows.length === 0) {
    return;
  }

  searchInput.addEventListener('input', function () {
    const keyword = this.value.trim().toLowerCase();

    rows.forEach((row) => {
      const cells = row.querySelectorAll('td');
      if (cells.length === 0) {
        return;
      }

      const name = (cells[0]?.textContent || '').toLowerCase();
      const address = (cells[2]?.textContent || '').toLowerCase();
      const contact = (cells[3]?.textContent || '').toLowerCase();
      const school = (cells[4]?.textContent || '').toLowerCase();

      const visible =
        keyword === '' ||
        name.includes(keyword) ||
        address.includes(keyword) ||
        contact.includes(keyword) ||
        school.includes(keyword);

      row.style.display = visible ? '' : 'none';
    });
  });
});
