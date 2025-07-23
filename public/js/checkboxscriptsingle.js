document.addEventListener('DOMContentLoaded', () => {
  const rows = document.querySelectorAll("#book-table tbody tr");

  rows.forEach(row => {
    row.addEventListener('click', function (e) {
      // Ignore if the click is on a checkbox or button
      if (e.target.tagName === 'INPUT' || e.target.tagName === 'BUTTON') return;

      // Toggle .selected class
      this.classList.toggle("selected");
    });
  });
});
