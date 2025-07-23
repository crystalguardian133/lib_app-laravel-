let selectedRowId = null;

function manageBooks() {
  const checkedBoxes = document.querySelectorAll(".book-checkbox:checked");

  if (checkedBoxes.length === 0) {
    alert("❗ Please select a book first.");
    return;
  }

  if (checkedBoxes.length > 1) {
    alert("⚠️ Please select only one book at a time.");
    return;
  }

  const selectedRow = checkedBoxes[0].closest("tr");
  const cells = selectedRow.children;

  // Set selected book data
  selectedRowId = checkedBoxes[0].value;
  document.getElementById("edit-title").value = cells[1].textContent.trim();         // Title
  document.getElementById("edit-author").value = cells[2].textContent.trim();        // Author
  document.getElementById("edit-genre").value = cells[3].textContent.trim();         // Genre
  document.getElementById("edit-published-year").value = cells[4].textContent.trim(); // Year
  document.getElementById("edit-availability").value = cells[5].textContent.trim();   // Availability

  document.getElementById("manage-modal").style.display = "block";
}

function closeModal() {
  document.getElementById("manage-modal").style.display = "none";
}

function saveChanges() {
  if (!selectedRowId) {
    alert("❗ No book selected.");
    return;
  }

  const token = document.querySelector('meta[name="csrf-token"]').content;
  const data = {
    title: document.getElementById("edit-title").value,
    genre: document.getElementById("edit-genre").value,
    author: document.getElementById("edit-author").value,
    published_year: document.getElementById("edit-published-year").value,
    availability: document.getElementById("edit-availability").value,
  };

  fetch(`/books/${selectedRowId}`, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": token
    },
    body: JSON.stringify(data)
  })
  .then(response => {
    if (!response.ok) throw new Error("Failed to save changes.");
    return response.json();
  })
  .then(() => {
    alert("✅ Changes saved successfully!");
    location.reload();
  })
  .catch(err => {
    console.error(err);
    alert("🚫 Error saving changes.");
  });
}

function deleteBook() {
  if (!selectedRowId) {
    alert("❗ No book selected.");
    return;
  }

  const confirmDelete = confirm("🗑️ Are you sure you want to delete this book?");
  if (!confirmDelete) return;

  const token = document.querySelector('meta[name="csrf-token"]').content;

  fetch(`/books/${selectedRowId}`, {
    method: "DELETE",
    headers: {
      "X-CSRF-TOKEN": token
    }
  })
  .then(response => {
    if (!response.ok) throw new Error("Failed to delete book.");
    return response.json();
  })
  .then(() => {
    alert("🗑️ Book deleted successfully!");
    location.reload();
  })
  .catch(err => {
    console.error(err);
    alert("🚫 Error deleting book.");
  });
}

