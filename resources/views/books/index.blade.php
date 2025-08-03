<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>📚 Book Records</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
:root {
  --primary: #1e3a8a;
  --accent: #3b82f6;
  --light: #f9fafb;
  --dark: #1f2937;
  --white: #ffffff;
  --gray: #9ca3af;
  --highlight: #d2e4ff;
  --bg-dark: #0f172a;
  --text-dark: #e5e7eb;
  --hover-dark: #334155;
}

body {
  margin: 0;
  font-family: 'Inter', 'Segoe UI', sans-serif;
  background-color: var(--light);
  color: var(--dark);
  display: flex;
  transition: background-color 0.3s ease, color 0.3s ease;
}

body.dark-mode {
  background-color: var(--bg-dark);
  color: var(--text-dark);
}

header {
  background-color: var(--primary);
  color: var(--white);
  padding: 1rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

header h1 {
  font-size: 1.5rem;
}

nav a {
  color: var(--white);
  text-decoration: none;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 12px;
  border-radius: 6px;
  margin-bottom: 6px;
  transition: background-color 0.2s ease;
  justify-content: flex-start;
}

nav a:hover {
  background-color: var(--accent);
}

.sidebar {
  width: 240px;
  background-color: var(--primary);
  color: var(--white);
  height: 100vh;
  padding: 1.5rem 1rem;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1000;
  transition: width 0.3s ease;
  overflow-x: hidden;
  display: flex;
  flex-direction: column;
  box-shadow: 2px 0 8px rgba(0, 0, 0, 0.2);
}

.sidebar-header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 2rem;
}

.sidebar-header .logo {
  width: 36px;
  height: 36px;
  object-fit: contain;
  border-radius: 4px;
}

.sidebar.collapsed {
  width: 60px;
}

.sidebar.collapsed .label {
  display: none;
}

.sidebar.collapsed .sidebar-header {
  justify-content: center;
}

.sidebar nav a {
  display: flex;
  align-items: center;
  gap: 10px;
  color: var(--white);
  text-decoration: none;
  padding: 10px 12px;
  border-radius: 6px;
  margin-bottom: 6px;
  transition: background-color 0.2s ease;
}

.sidebar nav a:hover {
  background-color: var(--accent);
}

.sidebar.collapsed nav a {
  justify-content: center;
}
.container {
  width: 100%;
  margin: 0 auto;
  padding: 2rem;
  background-color: rgba(255, 255, 255, 0.9);
  box-sizing: border-box;
}

h2 {
  text-align: center;
  color: var(--primary);
}

.top-controls {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
  gap: 1rem;
  margin: 1rem 0;
}

.top-controls input {
  padding: 8px 12px;
  width: 80%;
  max-width: 400px;
  font-size: 1rem;
  border-radius: 6px;
  border: 1px solid #ccc;
}

.top-controls button {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 8px 16px;
  background-color: var(--accent);
  color: white;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  font-size: 1rem;
  transition: background-color 0.2s ease-in-out, transform 0.1s ease;
}

.top-controls button:hover {
  background-color: #1e40af;
  transform: scale(1.03);
}

.table-container {
  overflow-x: auto;
  overflow-y: auto;
  max-height: 500px;
  background: transparent;
  width: 100%;
}

table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  min-width: 600px;
}

.table-wrapper {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 6px;
  overflow: hidden;
}

.scrollable-body {
  max-height: 400px; /* Adjust height if needed */
  overflow-y: auto;
  display: block;
}

.scrollable-body table {
  width: 100%;
  border-collapse: collapse;
}

.scrollable-body td {
  padding: 12px;
  border-bottom: 1px solid #ddd;
}

th, td {
  padding: 12px 16px;
  border-bottom: 1px solid #ddd;
  text-align: left;
}

th {
  background-color: var(--primary);
  color: white;
  position: sticky;
  top: 0;
  z-index: 2;
  cursor: pointer;
}

th.sort-asc::after {
  content: " \25B2";
}

th.sort-desc::after {
  content: " \25BC";
}

tr.selected {
  background-color: var(--highlight);
}

.corner-popup {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background: #e53935;
  color: white;
  padding: 10px 16px;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.2);
  z-index: 1000;
}

#suggestionBox {
  position: relative;
  max-height: 150px;
  overflow-y: auto;
  background-color: #fff;
  border: 1px solid #ccc;
  border-radius: 6px;
  margin-top: 4px;
  font-size: 0.95rem;
  z-index: 10;
}

body.dark-mode #suggestionBox {
  background-color: #1e293b;
  color: var(--text-dark);
  border-color: #334155;
}

#suggestionBox .suggestion {
  padding: 8px 12px;
  cursor: pointer;
}

#suggestionBox .suggestion:hover {
  background-color: var(--highlight);
  color: black;
}

body.dark-mode #suggestionBox .suggestion:hover {
  background-color: var(--hover-dark);
  color: white;
}

.modal, #borrowModal, #manage-modal {
  display: none;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: rgba(255, 255, 255, 0.95);
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 0 20px rgba(0,0,0,0.3);
  z-index: 9999;
  width: 90%;
  max-width: 500px;
  box-sizing: border-box;
}

.modal h3, #borrowModal h3, #manage-modal h3 {
  margin-top: 0;
  color: var(--primary);
  text-align: center;
  font-size: 1.25rem;
}

.modal label,
#borrowModal label,
#manage-modal label {
  display: block;
  margin-top: 10px;
  font-weight: 600;
  color: var(--dark);
}

.modal input,
#borrowModal input,
#manage-modal input {
  width: 100%;
  padding: 8px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 1rem;
  background-color: #f9f9f9;
}

.modal-buttons,
.modal-btn,
#manage-modal .actions {
  display: flex;
  justify-content: space-between;
  margin-top: 1.5rem;
  gap: 0.5rem;
}

.modal-btn,
#manage-modal .actions button {
  flex: 1;
  padding: 10px 16px;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.modal-btn.cancel {
  background-color: #e5e7eb;
  color: #374151;
}

.modal-btn.confirm,
#manage-modal .actions .submit {
  background-color: var(--accent);
  color: white;
}

.modal-btn.confirm:hover,
#manage-modal .actions .submit:hover {
  background-color: #2563eb;
}

.modal-btn.cancel:hover,
#manage-modal .actions .cancel:hover {
  background-color: #d1d5db;
}

#manage-modal .actions .cancel {
  background-color: #6b7280;
  color: white;
}

#manage-modal .actions .submit.delete {
  background-color: #dc2626;
}

    .sidebar {
      width: 240px;
      background-color: var(--primary);
      color: var(--white);
      height: 100vh;
      padding: 1.5rem 1rem;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1000;
      transition: width 0.3s ease;
      overflow-x: hidden;
      display: flex;
      flex-direction: column;
      box-shadow: 2px 0 8px rgba(0, 0, 0, 0.2);
    }

    .sidebar-header {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 2rem;
    }

    .sidebar-header .logo {
      width: 36px;
      height: 36px;
      object-fit: contain;
      border-radius: 4px;
    }

    .sidebar.collapsed {
      width: 60px;
    }

    .sidebar.collapsed .label {
      display: none;
    }

    .sidebar.collapsed .sidebar-header {
      justify-content: center;
    }

    .sidebar nav a {
      display: flex;
      align-items: center;
      gap: 10px;
      color: var(--white);
      text-decoration: none;
      padding: 10px 12px;
      border-radius: 6px;
      margin-bottom: 6px;
      transition: background-color 0.2s ease;
    }

    .sidebar nav a:hover {
      background-color: var(--accent);
    }

    .sidebar.collapsed nav a {
      justify-content: center;
    }

    .sidebar .toggle-btn {
      margin: 0 auto 1.5rem auto;
      background: var(--accent);
      color: white;
      border: none;
      padding: 8px 12px;
      font-size: 1rem;
      border-radius: 6px;
      cursor: pointer;
      width: 100%;
    }

.sidebar .toggle-btn:hover {
  background-color: #2563eb;
}

.main {
  margin-left: 260px;
  padding: 2rem;
  flex-grow: 1;
  transition: margin-left 0.3s ease;
  width: 100%;
  box-sizing: border-box;
}

.main.full {
  margin-left: 80px;
}

.dark-toggle {
  margin-top: 2rem;
  text-align: center;
}

.switch {
  position: relative;
  display: inline-block;
  width: 52px;
  height: 28px;
  margin-top: 1rem;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #888;
  transition: 0.4s;
  border-radius: 34px;
}

.slider:before {
  position: absolute;
  content: "🌞";
  height: 24px;
  width: 24px;
  left: 2px;
  bottom: 2px;
  background-color: white;
  border-radius: 50%;
  transition: 0.4s;
  text-align: center;
  line-height: 24px;
  font-size: 14px;
}

input:checked + .slider {
  background-color: var(--dark);
}

input:checked + .slider:before {
  transform: translateX(24px);
  content: "🌙";
}

@media (max-width: 768px) {
  .container {
    padding: 1rem;
  }

  table {
    min-width: 100%;
  }
}

@media (max-width: 600px) {
  table, thead, tbody, th, td, tr {
    display: block;
  }

  th {
    display: none;
  }

  td {
    position: relative;
    padding-left: 50%;
  }

  td::before {
    content: attr(data-label);
    position: absolute;
    left: 15px;
    font-weight: bold;
  }
}

body.dark-mode .container {
  background-color: var(--bg-dark);
  color: var(--text-dark);
}

body.dark-mode tr.selected {
  background-color: var(--hover-dark);
  color: var(--text-dark);
}

body.dark-mode .modal,
body.dark-mode #borrowModal,
body.dark-mode #manage-modal {
  background-color: #1e1e1e;
  color: var(--text-dark);
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
}

body.dark-mode .modal h3,
body.dark-mode #borrowModal h3,
body.dark-mode #manage-modal h3 {
  color: var(--accent);
}

body.dark-mode .modal label,
body.dark-mode #borrowModal label,
body.dark-mode #manage-modal label {
  color: var(--text-dark);
}

body.dark-mode .modal input,
body.dark-mode #borrowModal input,
body.dark-mode #manage-modal input {
  background-color: #2b2b2b;
  color: var(--text-dark);
  border: 1px solid #444;
}
.time-input {
  width: 100%;
  padding: 0.5rem;
  margin-top: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 1rem;
}

body.dark-mode .time-input {
  background-color: #1e293b;
  color: var(--text-dark);
  border-color: #475569;
}

.time-hint {
  font-size: 0.85rem;
  color: var(--gray);
  display: block;
  margin-top: 0.25rem;
}

  </style>
</head>
<body>

<!-- SIDEBAR -->
<<div class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <img src="/images/logo.png" alt="Library Logo" class="logo">
    <span class="label">Julita Public Library</span>
  </div>
  <button class="toggle-btn" id="toggleSidebar">☰</button>
  <nav>
    <a href="{{ route('dashboard') }}"><span class="icon">🏠</span><span class="label">Dashboard</span></a>
    <a href="{{ route('books.index') }}"><span class="icon">📘</span><span class="label">Manage Books</span></a>
    <a href="{{ route('members.index') }}"><span class="icon">👥</span><span class="label">Manage Members</span></a>
    <a href="{{ route('transactions.index') }}"><span class="icon">📃</span><span class="label">Transactions</span></a>
  </nav>
  <div class="dark-toggle">
    <label class="switch">
      <input type="checkbox" id="darkModeToggle">
      <span class="slider"></span>
    </label>
    <a href="/logout">🚪 Logout</a>
  </div>
</div>

<!-- MAIN -->
<div class="main" id="mainContent">
  <div class="container">
    <h2>📚 Book Records</h2>
    <div class="top-controls">
      <input type="text" id="search-input" placeholder="Search by title..." />
      <button onclick="manageBooks()">⚙️ Edit</button>
      <button onclick="openAddBookModal()">➕ Add Book</button>
      <button onclick="borrowBooks()">📖 Borrow</button>
    </div>

    <form method="POST" action="{{ route('borrow.book') }}">
      @csrf

      <div class="table-wrapper">
        <table>
          <thead>
            <tr>
              <th>Select</th>
              <th>Title</th>
              <th>Author</th>
              <th>Genre</th>
              <th>Published Year</th>
              <th>Available</th>
            </tr>
          </thead>
        </table>

        <div class="scrollable-body">
          <table>
            <tbody>
              @foreach($books as $book)
              <tr data-id="{{ $book->id }}">
                <td><input type="checkbox" class="book-checkbox" value="{{ $book->id }}"></td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->genre }}</td>
                <td>{{ $book->published_year }}</td>
                <td>{{ $book->availability }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </form>
  </div>
</div>
                        

  <!-- ADD MODAL -->
  <div class="modal" id="addBookModal">
    <div class="modal-content borrow-modal-content">
      <h3>📘 Add New Book</h3>
      <form id="addBookForm" enctype="multipart/form-data">
        @csrf
        <label for="title">📖 Title</label>
        <input type="text" id="title" name="title" required>
        <label for="author">✍️ Author</label>
        <input type="text" id="author" name="author" required>
        <label for="genre">📖 Genre</label>
        <input type="text" id="genre" name="genre">
        <label for="published_year">📅 Published Year</label>
        <input type="number" id="published_year" name="published_year" required>
        <label for="availability">📦 Availability</label>
        <input type="number" id="availability" name="availability" min="0" required>
        <div class="modal-buttons">
          <button type="button" class="modal-btn cancel" onclick="closeAddBookModal()">Cancel</button>
          <button type="submit" class="modal-btn confirm">Add Book</button>
        </div>
      </form>
    </div>
  </div>

  <!-- MANAGE MODAL -->
  <div class="modal" id="manage-modal">
    <div class="modal-content">
      <h3>Edit Book Information</h3>
      <label for="edit-title">Title</label>
      <input type="text" id="edit-title">
      <label for="edit-author">Author</label>
      <input type="text" id="edit-author">
      <label for="edit-genre">Genre</label>
      <input type="text" id="edit-genre">
      <label for="edit-published-year">Published Year</label>
      <input type="number" id="edit-published-year">
      <label for="edit-availability">Availability</label>
      <input type="number" id="edit-availability">
      <div class="actions">
        <button class="cancel" onclick="closeModal()">Cancel</button>
        <button class="submit" onclick="saveChanges()">Save Changes</button>
        <button class="submit" onclick="deleteBook()" style="background:#dc3545;">Delete</button>
      </div>
    </div>
  </div>

  <!-- BORROW MODAL -->
  <div class="modal" id="borrowModal">
  <div class="modal-content borrow-modal-content">
    <h3>📘 Borrow Selected Books</h3>

    <label for="memberName">👤 Member Name</label>
    <input type="text" id="memberName" autocomplete="off" placeholder="Start typing to search...">
    <div id="suggestionBox"></div>

    <div class="date-time-group">
      <label for="dueDate">📅 Due Date</label>
      <input type="date" id="dueDate" />

      <label for="dueTime">⏰ Due Time</label>
      <input type="time" id="dueTime" class="time-input" />
      <small class="time-hint">Use a 12-hour format (AM/PM visible in browser input)</small>
    </div>

    <label>📚 Selected Books</label>
    <ul id="selectedBooksList"></ul>

    <div class="modal-buttons">
      <button class="modal-btn cancel" onclick="closeBorrowModal()">Cancel</button>
      <button class="modal-btn confirm" onclick="confirmBorrow()">Confirm</button>
    </div>
  </div>
</div>

<script>
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.getElementById('mainContent');
  const toggleBtn = document.getElementById('toggleSidebar');
  const darkToggle = document.getElementById('darkModeToggle');
  const container = document.getElementById('container')

  toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
    mainContent.classList.toggle('full');
  });

  window.addEventListener('DOMContentLoaded', () => {
    const dark = localStorage.getItem('darkMode') === 'true';
    if (dark) {
      document.body.classList.add('dark-mode');
      darkToggle.checked = true;
    }
  });

  darkToggle.addEventListener('change', function () {
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('darkMode', this.checked);
  });
</script>

<script src="{{ asset('js/checkboxscriptmulti.js') }}"></script>
<script src="{{ asset('js/checkboxscriptsingle.js') }}"></script>
<script src="{{ asset('js/booksort.js') }}"></script>
<script src="{{ asset('js/bookmanage.js') }}"></script>
<script src="{{ asset('js/borrow.js') }}"></script>
<script src="{{ asset('js/bookadd.js') }}"></script>
<script src="{{ asset('js/sidebarcollapse.js')}}"></script>
<script src="{{ asset('js/dashb.js') }}"></script>

@if(session('duplicate'))
  <script>
    showCornerPopup("Book already exists");
    resetAddBookModal();
  </script>
@endif

@if(session('success'))
  <script>
    showCornerPopup("Book added successfully!");
    closeAddBookModal();
  </script>
@endif

</body>
</html>