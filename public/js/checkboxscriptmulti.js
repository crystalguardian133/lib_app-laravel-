// This file handles borrowing logic only (multi-select allowed)
document.addEventListener("DOMContentLoaded", () => {
  const borrowCheckboxes = document.querySelectorAll('input.book-checkbox');

  borrowCheckboxes.forEach(checkbox => {
    checkbox.addEventListener("change", function () {
      const row = this.closest("tr");

      if (this.checked) {
        row.classList.add("selected");
      } else {
        row.classList.remove("selected");
      }

      // Availability check can be placed here if needed
    });
  });
});
