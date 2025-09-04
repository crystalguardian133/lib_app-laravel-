document.getElementById("search-input").addEventListener("input", function () {
  const search = this.value.toLowerCase();
  const rows = document.querySelectorAll("#member-table tbody tr");
  rows.forEach(row => {
    const name = row.querySelector("td[data-label='Name']").textContent.toLowerCase();
    row.style.display = name.includes(search) ? "" : "none";
  });
});
