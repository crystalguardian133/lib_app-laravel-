document.addEventListener("DOMContentLoaded", function () {
  const headerTable = document.querySelectorAll(".main-table")[0];
  const bodyTable = document.querySelectorAll(".main-table")[1];
  if (!headerTable || !bodyTable) return;

  const headers = headerTable.querySelectorAll("th");

  headers.forEach((header, index) => {
    header.style.cursor = "pointer";
    header.addEventListener("click", () => {
      sortTableByColumn(bodyTable, index);
    });
  });

  function sortTableByColumn(table, columnIndex) {
    const tbody = table.querySelector("tbody");
    const rows = Array.from(tbody.querySelectorAll("tr"));

    const currentOrder = headerTable.dataset.sortOrder === "asc" ? "desc" : "asc";
    headerTable.dataset.sortOrder = currentOrder;

    rows.sort((a, b) => {
      const aText = a.cells[columnIndex]?.textContent.trim() || "";
      const bText = b.cells[columnIndex]?.textContent.trim() || "";
      return currentOrder === "asc"
        ? aText.localeCompare(bText, undefined, { numeric: true, sensitivity: "base" })
        : bText.localeCompare(aText, undefined, { numeric: true, sensitivity: "base" });
    });

    rows.forEach((row) => tbody.appendChild(row));
  }
});