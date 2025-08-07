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
  #memberName.readonly {
  background-color: #eee;
  cursor: not-allowed;
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

  /* FIXED TABLE ALIGNMENT */
.table-container {
  max-height: 500px;
  overflow-y: auto;
  border: 1px solid var(--primary);
}

.table-container table {
  width: 100%;
  border-collapse: collapse;
}

.table-container thead th {
  position: sticky;
  top: 0;
  background-color: var(--light); /* Or dark background if in dark mode */
  z-index: 1;
  text-align: left;
  padding: 0.5rem;
  border-bottom: 1px solid #ccc;
}

.table-container tbody td {
  padding: 0.5rem;
  border-bottom: 1px solid #ddd;
}

  /* Single unified table with proper alignment */
  table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    table-layout: fixed; /* Force consistent column widths */
  }

  /* Define specific column widths for alignment */
  table th:nth-child(1), table td:nth-child(1) { width: 60px; }   /* Select */
  table th:nth-child(2), table td:nth-child(2) { width: 80px; }   /* Cover */
  table th:nth-child(3), table td:nth-child(3) { width: 200px; }  /* Title */
  table th:nth-child(4), table td:nth-child(4) { width: 150px; }  /* Author */
  table th:nth-child(5), table td:nth-child(5) { width: 120px; }  /* Genre */
  table th:nth-child(6), table td:nth-child(6) { width: 120px; }  /* Published Year */
  table th:nth-child(7), table td:nth-child(7) { width: 100px; }  /* Available */
  table th:nth-child(8), table td:nth-child(8) { width: 140px; }  /* QR Code */

  .table-wrapper {
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 6px;
    overflow: hidden;
  }

  .scrollable-body {
    max-height: 400px;
    overflow-y: auto;
    overflow-x: auto; /* Allow horizontal scroll if needed */
    display: block;
  }

  /* For the two-table structure (current) */
  .scrollable-body table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed; /* Match header table layout */
    margin-top: 0; /* Remove any margin */
  }

  /* Ensure both header and body tables have same column widths */
  .table-container > table th:nth-child(1),
  .scrollable-body table td:nth-child(1) { width: 60px; }
  
  .table-container > table th:nth-child(2),
  .scrollable-body table td:nth-child(2) { width: 80px; }
  
  .table-container > table th:nth-child(3),
  .scrollable-body table td:nth-child(3) { width: 200px; }
  
  .table-container > table th:nth-child(4),
  .scrollable-body table td:nth-child(4) { width: 150px; }
  
  .table-container > table th:nth-child(5),
  .scrollable-body table td:nth-child(5) { width: 120px; }
  
  .table-container > table th:nth-child(6),
  .scrollable-body table td:nth-child(6) { width: 120px; }
  
  .table-container > table th:nth-child(7),
  .scrollable-body table td:nth-child(7) { width: 100px; }
  
  .table-container > table th:nth-child(8),
  .scrollable-body table td:nth-child(8) { width: 140px; }

  .scrollable-body td {
    padding: 12px 16px; /* Match header padding */
    border-bottom: 1px solid #ddd;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  th, td {
    padding: 12px 16px;
    border-bottom: 1px solid #ddd;
    text-align: left;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
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

  /* Cover image styling */
  table img.cover {
    width: 60px;
    height: 80px;
    object-fit: cover;
    border-radius: 4px;
  }

  /* Make sure images in table don't break layout */
  .scrollable-body table td img {
    max-width: 60px;
    height: auto;
    border-radius: 4px;
  }

  @media (max-width: 768px) {
    .container {
      padding: 1rem;
    }

    .table-container {
      overflow-x: auto; /* Allow horizontal scroll on mobile */
    }

    table {
      min-width: 800px; /* Prevent table from getting too compressed */
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
  .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.75);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 9999;
  }
  .modal-content {
      background: var(--card-bg, #fff);
      padding: 20px;
      border-radius: 1rem;
      text-align: center;
      max-width: 90%;
  }
  .modal-wrapper {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 9999;
  height: 100vh;
  width: 100vw;
  background: rgba(0, 0, 0, 0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  backdrop-filter: blur(3px);
}

.modal-box {
  background-color: var(--light);
  color: var(--dark);
  border-radius: 12px;
  padding: 1.5rem;
  width: 90%;
  max-width: 400px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
  position: relative;
  transition: all 0.3s ease;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.modal-title {
  font-size: 1.25rem;
  font-weight: 600;
}

.modal-close {
  background: transparent;
  border: none;
  font-size: 1.5rem;
  color: inherit;
  cursor: pointer;
}

.modal-body.center {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
}

.qr-image {
  width: 200px;
  height: 200px;
  object-fit: contain;
  border: 2px solid var(--accent);
  border-radius: 8px;
  background-color: var(--light);
}

.btn-download {
  padding: 0.5rem 1rem;
  background-color: var(--accent);
  color: white;
  text-decoration: none;
  border-radius: 6px;
  transition: background-color 0.2s ease;
}
.btn-download:hover {
  background-color: var(--accent-light);
}

/* Dark mode support */
body.dark-mode .modal-box {
  background-color: var(--dark);
  color: var(--light);
}

body.dark-mode .qr-image {
  background-color: var(--dark);
  border-color: var(--accent-light);
}
    </style>
  </head>
  <body>
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

    <div class="main" id="mainContent">
      <div class="container">
        <h2>📚 Book Records</h2>
        <div class="top-controls">
          <input type="text" id="search-input" placeholder="Search by title..." />
          <button onclick="manageBooks()">⚙️ Edit</button>
          <button onclick="openAddBookModal()">➕ Add Book</button>
          <button onclick="openBorrowModal()">📖 Borrow</button>
        </div>

<div class="table-wrapper">
  <table class="main-table">
    <thead>
      <tr>
        <th>Select</th>
        <th>Cover</th>
        <th>Title</th>
        <th>Author</th>
        <th>Genre</th>
        <th>Published Year</th>
        <th>Available</th>
        <th>QR Code</th>
      </tr>
    </thead>
  </table>
  <div class="scrollable-body">
    <table class="main-table">
      <tbody>
        @foreach($books as $book)
        <tr data-id="{{ $book->id }}">
          <td><input type="checkbox" class="book-checkbox" value="{{ $book->id }}"></td>
          <td>
            @if($book->cover_image)
              <img src="{{ $book->cover_image }}" width="60" />
            @else
              No Cover
            @endif
          </td>
          <td>{{ $book->title }}</td>
          <td>{{ $book->author }}</td>
          <td>{{ $book->genre }}</td>
          <td>{{ $book->published_year }}</td>
          <td>{{ $book->availability }}</td>
          <td id="qrCell-{{ $book->id }}">
            @if(!empty($book->qr_url))
              <button onclick="showQRModal('{{ $book->title }}', '{{ $book->qr_url }}')" class="btn btn-secondary">
                📷 Show QR
              </button>
            @else
              <button onclick="generateQr({{ $book->id }})" class="btn btn-outline btn-sm">
                📷 Generate QR
              </button>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
        </div>
      </div>
    </div>

    <!-- Borrow Modal (same as your existing) -->
  <!-- BORROW MODAL -->
  <div class="modal" id="borrowModal">
  <div class="modal-content borrow-modal-content">
    <h3>📘 Borrow Selected Books</h3>

    <!-- MEMBER -->
    <label for="memberName">👤 Member Name</label>
    <input type="text" id="memberName" placeholder="Scan QR code to fill" readonly>

    <!-- DUE DATE & TIME -->
    <div class="date-time-group">
      <label for="dueDate">📅 Due Date</label>
      <input type="date" id="dueDate" />
      <label for="dueTime">⏰ Due Time</label>
      <input type="time" id="dueTime" class="time-input" />
      <small class="time-hint">Use a 12-hour format (AM/PM visible in browser input)</small>
    </div>

    <!-- SELECTED BOOKS -->
    <label>📚 Selected Books</label>
    <ul id="selectedBooksList"></ul>

    <!-- QR BUTTONS -->
    <div style="display: flex; gap: 10px; margin-bottom: 10px;">
      <button type="button" onclick="startQRScan('member')" class="btn btn-outline-secondary">📷 Scan Member QR</button>
      <button type="button" onclick="startQRScan('book')" class="btn btn-outline-secondary">📷 Scan Book QR</button>
    </div>

    <!-- QR SCANNER MODAL -->
    <div id="qrScannerModal" style="display:none; position:fixed; top:10%; left:50%; transform:translateX(-50%); background:white; padding:20px; z-index:9999; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.2);">
      <h5>Scan QR Code</h5>
      <div id="qr-reader" style="width:300px;"></div>
      <button type="button" onclick="stopQRScan()" class="btn btn-danger mt-2">Cancel</button>
    </div>

    <!-- MODAL BUTTONS -->
    <div class="modal-buttons">
      <button class="modal-btn cancel" onclick="closeBorrowModal()">Cancel</button>
      <button class="modal-btn confirm" onclick="confirmBorrow()">Confirm</button>
    </div>
  </div>
</div>


    <!-- ADD MODAL -->
      <div class="modal" id="addBookModal">
      <div class="modal-content borrow-modal-content">
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

    <!-- 📷 Cover Upload -->
    <label for="cover_image">🖼️ Upload Cover Image</label>
    <div style="display:flex; align-items:center; gap:1rem;">
  <input type="file" name="cover" id="cover" accept="image/*" onchange="previewCover(event)">
    </div>

    <div id="coverPreview" style="margin-top:10px;"></div>

    <div class="modal-buttons">
      <button type="button" class="modal-btn cancel" onclick="closeAddBookModal()">Cancel</button>
      <button type="submit" class="modal-btn confirm">Add Book</button>
    </div>
  </form>
  </div>
      </div>
  >

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
      <input type="hidden" id="memberId" />


      <div class="date-time-group">
        <label for="dueDate">📅 Due Date</label>
        <input type="date" id="dueDate" />
        <label for="dueTime">⏰ Due Time</label>
        <input type="time" id="dueTime" class="time-input" />
        <small class="time-hint">Use a 12-hour format (AM/PM visible in browser input)</small>
      </div>

      <label>📚 Selected Books</label>
      <ul id="selectedBooksList"></ul>

      <!-- QR Buttons -->
      <div style="display: flex; gap: 10px; margin-bottom: 10px;">
        <button type="button" onclick="startQRScan('member')" class="btn btn-outline-secondary">📷 Scan Member QR</button>
        <button type="button" onclick="startQRScan('book')" class="btn btn-outline-secondary">📷 Scan Book QR</button>
      </div>

      <!-- QR Scanner Modal -->
      <div id="qrScannerModal" style="display:none; position:fixed; top:10%; left:50%; transform:translateX(-50%); background:white; padding:20px; z-index:9999; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.2);">
        <h5>Scan QR Code</h5>
        <div id="qr-reader" style="width:300px;"></div>
        <button type="button" onclick="stopQRScan()" class="btn btn-danger mt-2">Cancel</button>
      </div>

      <div class="modal-buttons">
        <button class="modal-btn cancel" onclick="closeBorrowModal()">Cancel</button>
        <button class="modal-btn confirm" onclick="confirmBorrow()">Confirm</button>
      </div>
    </div>
  </div>

  <!-- Book QR Modal -->
<div id="qrModal" class="modal-wrapper" style="display: none;">
  <div class="modal-box">
    <div class="modal-header">
      <h2 id="qrBookTitle" class="modal-title">QR Code</h2>
      <button class="modal-close" onclick="closeQRModal()">&times;</button>
    </div>
    <div class="modal-body center">
      <img id="qrImage" src="" alt="QR Code" class="qr-image" />
      <a id="downloadLink" href="#" download class="btn-download" target="_blank">
        Download QR Code
      </a>
    </div>
  </div>
</div>

    <script src="{{ asset('js/borrow.js') }}"></script>
    <script src="{{ asset('js/qrgen.js') }}"></script>
    <script src="{{ asset('js/showqr.js') }}"></script>
    <script>
      function openBorrowModal(){
        let list = document.getElementById('selectedBooksList');
        list.innerHTML = '';
        document.querySelectorAll('.book-checkbox:checked').forEach(cb => {
          const tr = cb.closest('tr');
          const id = tr.getAttribute('data-id');
          const title = tr.children[2].innerText;
          const li = document.createElement('li');
          li.textContent = title;
          li.setAttribute('data-id', id);
          list.appendChild(li);
        });
        document.getElementById('borrowModal').style.display='flex';
      }
    </script>
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
  <script src="{{ asset('js/qrgen.js') }}"></script>
  <script src="{{ asset('js/showqr.js') }}"></script>
  <script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
  <script src="{{ asset('js/qrscanner-borrow.js') }}"></script>
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
