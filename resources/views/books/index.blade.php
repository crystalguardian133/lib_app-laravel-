<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>📘 Julita Library | Bookshelf</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    :root {
      --primary: #5b21b6;
      --accent: #0891b2;
      --light: #f9fafb;
      --dark: #0f172a;
      --gray: #6b7280;
      --card-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
      --modal-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
      --radius: 16px;
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      --gap: 1.5rem;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Outfit', sans-serif;
      background: #f3f4f6;
      color: var(--dark);
      line-height: 1.6;
    }

    body.dark-mode {
      background: #0f172a;
      color: #e2e8f0;
    }

    /* Layout */
    .app-container {
      display: grid;
      grid-template-columns: 280px 1fr;
      min-height: 100vh;
    }

    @media (max-width: 768px) {
      .app-container {
        grid-template-columns: 1fr;
      }
    }

    /* Sidebar */
    .sidebar {
      background: white;
      border-right: 1px solid #e5e7eb;
      padding: 1.5rem;
      position: sticky;
      top: 0;
      height: 100vh;
      overflow-y: auto;
    }

    body.dark-mode .sidebar {
      background: #1e293b;
      border-color: #334155;
    }

    .logo {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--primary);
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 2rem;
    }

    .nav-menu {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 16px;
      border-radius: var(--radius);
      color: var(--gray);
      text-decoration: none;
      font-weight: 500;
      transition: var(--transition);
    }

    .nav-item.active {
      background: rgba(126, 34, 206, 0.1);
      color: var(--primary);
      font-weight: 600;
    }

    .nav-item:hover {
      background: #f1f5f9;
      color: var(--primary);
    }

    body.dark-mode .nav-item:hover {
      background: #334155;
    }

    /* Dark Mode Toggle */
    .dark-mode-toggle {
      margin-top: 2rem;
      padding: 1rem 0;
      display: flex;
      align-items: center;
      gap: 12px;
      font-weight: 500;
    }

    .switch {
      position: relative;
      width: 58px;
      height: 32px;
    }

    .switch input {
      opacity: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0; left: 0; right: 0; bottom: 0;
      background: linear-gradient(90deg, #d1d5db, #9ca3af);
      border-radius: 32px;
      transition: 0.3s;
    }

    .slider:before {
      content: "";
      position: absolute;
      height: 26px;
      width: 26px;
      left: 3px;
      bottom: 3px;
      background: white;
      border-radius: 50%;
      transition: 0.3s;
    }

    input:checked + .slider {
      background: linear-gradient(90deg, #7e22ce, #5b21b6);
    }

    input:checked + .slider:before {
      transform: translateX(26px);
    }

    /* Main */
    main {
      padding: 2rem;
      max-width: 1400px;
      margin: 0 auto;
      width: 100%;
    }

    /* Sticky Header Controls */
    .page-controls {
      position: sticky;
      top: 0;
      background: rgba(243, 244, 246, 0.95);
      backdrop-filter: blur(10px);
      z-index: 100;
      padding: 1rem 0;
      margin-bottom: var(--gap);
      border-radius: var(--radius);
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    body.dark-mode .page-controls {
      background: rgba(15, 23, 42, 0.95);
    }

    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 1rem;
      padding: 0 1rem;
    }

    .page-title {
      font-size: 1.8rem;
      font-weight: 600;
      color: var(--primary);
    }

    .actions {
      display: flex;
      gap: 0.75rem;
    }

    .btn {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 10px 16px;
      border-radius: 12px;
      font-weight: 500;
      cursor: pointer;
      border: none;
    }

    .btn-primary {
      background: var(--primary);
      color: white;
    }

    .btn-outline {
      background: transparent;
      color: var(--primary);
      border: 1px solid var(--primary);
    }

    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    /* Search */
    .search-bar {
      width: 100%;
      padding: 14px 18px;
      border: 1px solid #d1d5db;
      border-radius: 14px;
      font-size: 1rem;
      background: white;
      margin: 1rem 0 0;
    }

    body.dark-mode .search-bar {
      background: #1e293b;
      border-color: #475569;
      color: #e2e8f0;
    }

    /* Book Grid */
    .book-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: var(--gap);
      margin-bottom: 2rem;
    }

    .book-card {
      background: white;
      border-radius: var(--radius);
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      transition: var(--transition);
    }

    body.dark-mode .book-card {
      background: #1e293b;
    }

    .book-card:hover {
      transform: translateY(-6px);
    }

    .book-cover {
      width: 100%;
      height: 300px;
      object-fit: cover;
    }

    .book-info {
      padding: 1.2rem;
    }

    .book-title {
      font-weight: 600;
      font-size: 1.1rem;
      margin: 0 0 0.5rem 0;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .book-meta {
      font-size: 0.85rem;
      color: var(--gray);
      margin-bottom: 0.75rem;
    }

    .book-actions {
      display: flex;
      gap: 0.5rem;
    }

    .btn-qr, .btn-borrow {
      flex: 1;
      padding: 8px 0;
      border: none;
      border-radius: 8px;
      font-size: 0.85rem;
      cursor: pointer;
    }

    .btn-qr {
      background: #f3e8ff;
      color: var(--primary);
    }

    .btn-borrow {
      background: #dcfce7;
      color: #15803d;
    }

    /* MODALS - Styled Like Book Cards */
    .modal {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(10px);
      align-items: center;
      justify-content: center;
      z-index: 2000;
    }

    .modal-card {
      background: white;
      border-radius: var(--radius);
      overflow: hidden;
      box-shadow: var(--modal-shadow);
      width: 90%;
      max-width: 500px;
      max-height: 90vh;
      display: flex;
      flex-direction: column;
    }

    body.dark-mode .modal-card {
      background: #1e293b;
    }

    .modal-header {
      padding: 1.2rem 1.2rem 0.8rem;
      background: var(--primary);
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .modal-title {
      font-size: 1.2rem;
      font-weight: 600;
    }

    .modal-close {
      background: none;
      border: none;
      font-size: 1.5rem;
      color: white;
      cursor: pointer;
      width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
    }

    .modal-close:hover {
      background: rgba(255,255,255,0.2);
    }

    .modal-body {
      padding: 1.5rem;
      overflow-y: auto;
    }

    .form-group {
      margin-bottom: 1rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 6px;
      font-weight: 500;
      color: var(--dark);
    }

    body.dark-mode .form-group label {
      color: #e2e8f0;
    }

    .form-control {
      width: 100%;
      padding: 10px;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      font-size: 1rem;
    }

    .form-control:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(126, 34, 206, 0.2);
    }

    body.dark-mode .form-control {
      background: #0f172a;
      border-color: #475569;
      color: #e2e8f0;
    }

    .modal-footer {
      padding: 1rem 1.5rem;
      display: flex;
      gap: 1rem;
      border-top: 1px solid #e5e7eb;
    }

    body.dark-mode .modal-footer {
      border-top-color: #334155;
    }

    /* Add/Edit Modal - Book-Style Layout */
    .edit-modal-cover {
      width: 100%;
      height: 200px;
      background: #f1f5f9;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--gray);
      font-size: 1.2rem;
      margin-bottom: 1rem;
    }

    /* QR Modal */
    .qr-image {
      width: 200px;
      height: 200px;
      border: 2px solid var(--accent);
      border-radius: 16px;
      margin: 1rem auto;
      display: block;
      background: white;
    }

    body.dark-mode .qr-image {
      background: #0f172a;
    }

    .btn-download {
      display: inline-block;
      padding: 10px 20px;
      background: var(--accent);
      color: white;
      text-decoration: none;
      border-radius: 8px;
      margin-top: 1rem;
    }

    /* Selection Mode Bar */
    .selection-mode {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background: var(--accent);
      color: white;
      padding: 1rem 2rem;
      z-index: 1000;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: 500;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .book-card.selected {
      outline: 4px solid var(--accent);
    }
    /* Cover Preview Area - Large, drag & drop, clickable */
.cover-preview-area {
  width: 100%;
  height: 400px;
  border-radius: 12px;
  overflow: hidden;
  margin-bottom: 1.5rem;
  position: relative;
  cursor: pointer;
  transition: all 0.3s ease;
  border: 2px dashed var(--gray-light);
}

.cover-preview-area.drag-over {
  border-color: var(--accent);
  background-color: rgba(8, 145, 178, 0.1);
  transform: scale(1.02);
}

.cover-preview-content {
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  color: var(--gray);
  transition: all 0.3s ease;
  background-size: cover;
  background-position: center;
  text-align: center;
  padding: 1rem;
}

.cover-input {
  position: absolute;
  width: 100%;
  height: 100%;
  opacity: 0;
  cursor: pointer;
  z-index: 2;
}

#cover-upload-icon {
  font-size: 3.5rem;
  margin-bottom: 10px;
  transition: all 0.3s ease;
  color: var(--accent);
}

#cover-preview-text {
  font-size: 1.1rem;
  font-weight: 500;
  transition: all 0.3s ease;
  color: var(--gray);
}

#cover-preview-text small {
  display: block;
  font-size: 0.85rem;
  opacity: 0.7;
  margin-top: 8px;
}

/* Toast Notifications */
.toast {
  padding: 12px 20px;
  margin-bottom: 10px;
  border-radius: 8px;
  color: white;
  font-weight: 500;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  animation: fadeIn 0.3s, fadeOut 0.3s 2.7s;
  max-width: 300px;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeOut {
  from { opacity: 1; }
  to { opacity: 0; }
}

.toast-info {
  background: var(--accent);
}

.toast-success {
  background: var(--success);
}

.toast-warning {
  background: var(--warning);
}

.toast-error {
  background: var(--danger);
}
  </style>
</head>
<body>

  <div class="app-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="logo">
        <i class="fas fa-book"></i> Julita Library
      </div>
      <nav class="nav-menu">
        <a href="{{ route('dashboard') }}" class="nav-item"><i class="fas fa-th"></i> Dashboard</a>
        <a href="{{ route('books.index') }}" class="nav-item active"><i class="fas fa-book"></i> Books</a>
        <a href="{{ route('members.index') }}" class="nav-item"><i class="fas fa-users"></i> Members</a>
        <a href="{{ route('transactions.index') }}" class="nav-item"><i class="fas fa-file-alt"></i> Transactions</a>
      </nav>
      <div class="dark-mode-toggle">
        <span>🌙 Dark Mode</span>
        <label class="switch">
          <input type="checkbox" id="darkModeToggle">
 
        </label>
      </div>
    </aside>

    <!-- Main -->
    <main>
      <div class="page-controls">
        <div class="page-header">
          <h1 class="page-title">📚 Your Collection</h1>
          <div class="actions">
            <button class="btn btn-outline" onclick="enterSelectionMode()">
              <i class="fas fa-check-square"></i> Select
            </button>
            <button class="btn btn-primary" onclick="openAddBookModal()">
              <i class="fas fa-plus"></i> Add
            </button>
          </div>
        </div>
        <input
          type="text"
          class="search-bar"
          placeholder="🔍 Search by title, author, or genre..."
          id="searchInput"
        />
      </div>

      <!-- Book Grid -->
      <div class="book-grid" id="bookGrid">
        @foreach($books as $book)
        <div class="book-card" data-id="{{ $book->id }}" data-title="{{ $book->title }}" data-author="{{ $book->author }}">
          <img src="{{ $book->cover_image ?? '/images/no-cover.png' }}" alt="Cover" class="book-cover">
          <div class="book-info">
            <h3 class="book-title">{{ $book->title }}</h3>
            <div class="book-meta">
              <div>by {{ $book->author }}</div>
              <div>{{ $book->genre }} • {{ $book->published_year }}</div>
              <div><strong>Available:</strong> {{ $book->availability > 0 ? 'Yes' : 'No' }}</div>
            </div>
            <div class="book-actions">
              @if(!empty($book->qr_url))
                <button class="btn-qr" onclick="showQRModal('{{ $book->title }}', '{{ $book->qr_url }}')">QR</button>
              @else
                <button class="btn-qr" onclick="generateQr({{ $book->id }})">Gen</button>
              @endif
              <button class="btn-borrow" onclick="borrowOne({{ $book->id }})">Borrow</button>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </main>
  </div>

  <!-- Selection Mode Bar -->
  <div class="selection-mode" id="selectionBar" style="display:none;">
    <span id="selectedCount">0 books selected</span>
    <div>
      <button class="btn btn-outline" style="color:white;" onclick="exitSelectionMode()">Cancel</button>
      <button class="btn btn-light" style="background:white; color:var(--accent);" onclick="openBorrowModal()">Borrow</button>
      <button class="btn btn-light" id="editButton" style="background:white; color:#7e22ce; display:none;" onclick="openEditModal()">
        <i class="fas fa-edit"></i> Edit
      </button>
    </div>
  </div>

  <!-- ADD BOOK MODAL (Styled Like Book Card) -->
  <div class="modal" id="addBookModal">
    <div class="modal-card">
      <div class="modal-header">
        <h3 class="modal-title">➕ Add New Book</h3>
        <button class="modal-close" onclick="closeAddBookModal()">&times;</button>
      </div>
      <div class="modal-body">
        <form id="addBookForm" enctype="multipart/form-data">
          @csrf
          <div class="edit-modal-cover">🖼️ Upload Cover</div>
          <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Author</label>
            <input type="text" name="author" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Genre</label>
            <input type="text" name="genre" class="form-control">
          </div>
          <div class="form-group">
            <label>Published Year</label>
            <input type="number" name="published_year" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Availability</label>
            <input type="number" name="availability" class="form-control" required min="0">
          </div>
          <div class="form-group">
            <label>Upload Cover</label>
            <input type="file" name="cover" accept="image/*" onchange="previewCover(event)" class="form-control">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline" onclick="closeAddBookModal()">Cancel</button>
        <button class="btn btn-primary" form="addBookForm" type="submit">Add Book</button>
      </div>
    </div>
  </div>

<!-- EDIT MODAL (Enhanced with Drag & Drop Cover) -->
<div class="modal" id="manage-modal">
  <div class="modal-card">
    <div class="modal-header">
      <h3 class="modal-title">✏️ Edit Book</h3>
      <button class="modal-close" onclick="closeModal()">&times;</button>
    </div>
    <div class="modal-body">
      <!-- Cover Preview - Large Drag & Drop Zone -->
      <div class="cover-preview-area" id="cover-preview-area">
        <div class="cover-preview-content" id="cover-preview-content">
          <i class="fas fa-cloud-upload-alt" id="cover-upload-icon"></i>
          <p id="cover-preview-text">Click or drag image here<br><small>Supports JPG, PNG (max 5MB)</small></p>
          <input type="file" id="cover-input" accept="image/*" class="cover-input">
        </div>
      </div>
      
      <!-- Form fields -->
      <div class="form-group">
        <label>Title</label>
        <input type="text" id="edit-title" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Author</label>
        <input type="text" id="edit-author" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Genre</label>
        <input type="text" id="edit-genre" class="form-control">
      </div>
      <div class="form-group">
        <label>Published Year</label>
        <input type="number" id="edit-published-year" class="form-control" min="1000" max="2099" required>
      </div>
      <div class="form-group">
        <label>Availability</label>
        <input type="number" id="edit-availability" class="form-control" required min="0">
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeModal()">Cancel</button>
      <button class="btn btn-danger" id="delete-button">Delete</button>
      <button class="btn btn-primary" onclick="saveChanges()" id="save-button">
        <i class="fas fa-save"></i> Save Changes
      </button>
    </div>
  </div>
</div>
=
<!-- BORROW MODAL -->
<div class="modal" id="borrowModal">
  <div class="modal-card">
    <div class="modal-header">
      <h3 class="modal-title">📦 Borrow Books</h3>
      <button class="modal-close" onclick="closeBorrowModal()">&times;</button>
    </div>
    <div class="modal-body">
      <div class="form-group">
        <label>👤 Member Name</label>
        <input type="text" id="memberName" class="form-control" placeholder="Scan QR code to fill" readonly>
        <input type="hidden" id="memberId">
      </div>
      <div class="form-group">
        <label>📅 Due Date</label>
        <input type="date" id="dueDate" class="form-control">
      </div>
      <div class="form-group">
        <label>⏰ Due Time</label>
        <input type="time" id="dueTime" class="form-control" value="<?= date('H:i') ?>">
        <small class="time-hint" style="display:block; margin-top:5px; color:var(--gray); font-size:0.85rem;">
          Default time set to end of day (11:59 PM)
        </small>
      </div>
      <div class="form-group">
        <label>📚 Selected Books</label>
        <ul id="selectedBooksList"></ul>
      </div>
      <div style="display: flex; gap: 10px; margin-top: 1rem;">
        <button type="button" class="btn btn-outline" onclick="startQRScan('member')">
          <i class="fas fa-person"></i> Scan Member
        </button>
      </div>
      <div style="display: flex; gap: 10px; margin-top: 1rem;">
        <button type="button" class="btn btn-outline" onclick="startQRScan('member')">
          <i class="fas fa-book"></i> Scan Books
        </button>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeBorrowModal()">Cancel</button>
      <button class="btn btn-primary" onclick="confirmBorrow()">Confirm</button>
    </div>
  </div>
</div>
<!-- QR SCANNER MODAL (Fixed) -->
<div class="modal" id="qrScannerModal">
  <div class="modal-card" style="max-width: 400px;">
    <div class="modal-header">
      <h3 class="modal-title">📷 Scan QR Code</h3>
      <button class="modal-close" onclick="stopQRScan()">&times;</button>
    </div>
    <div class="modal-body scanner-body">
      <div id="qr-reader" style="width: 100%; min-height: 250px;"></div>
      <div id="qr-scanner-error" class="error-message hidden"></div>
      <p class="scanner-instructions">
        Point your camera at the QR code
      </p>
    </div>
  </div>
</div>

<!-- Toast Notifications -->
<div id="toast-container" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;"></div>

  <!-- QR MODAL -->
  <div class="modal" id="qrModal">
    <div class="modal-card" style="max-width: 400px;">
      <div class="modal-header">
        <h3 id="qrModalTitle" class="modal-title">QR Code</h3>
        <button class="modal-close" onclick="closeQRModal()">&times;</button>
      </div>
      <div class="modal-body" style="text-align: center;">
        <img id="qrImage" class="qr-image" src="" alt="QR">
        <a id="downloadLink" class="btn-download" download>📥 Download QR</a>
      </div>
    </div>
  </div>

  <!-- SCRIPTS -->
  <script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
  <script src="{{ asset('js/bookadd.js') }}"></script>
  <script src="{{ asset('js/bookmanage.js') }}"></script>
  <script src="{{ asset('js/borrow.js') }}"></script>
  <script src="{{ asset('js/qrgen.js') }}"></script>
  <script src="{{ asset('js/showqr.js') }}"></script>
  <script src="{{ asset('js/overdue.js') }}"></script>
  <script src="{{ asset('js/qrscanner-borrow.js') }}"></script>

  <!-- Internal Modal Controls Only -->
  <script>
    let selectedBooks = [];

    // --- Selection Mode ---
    function enterSelectionMode() {
      document.getElementById('selectionBar').style.display = 'flex';
      document.querySelectorAll('.book-card').forEach(card => {
        card.onclick = () => toggleSelection(card);
      });
    }

    function exitSelectionMode() {
      document.getElementById('selectionBar').style.display = 'none';
      document.querySelectorAll('.book-card').forEach(card => {
        card.onclick = null;
      });
      document.querySelectorAll('.book-card.selected').forEach(c => c.classList.remove('selected'));
      selectedBooks = [];
      updateSelectionUI();
    }

    function toggleSelection(card) {
      const id = card.dataset.id;
      const title = card.dataset.title;
      const index = selectedBooks.findIndex(b => b.id == id);

      if (index === -1) {
        selectedBooks.push({ id, title });
        card.classList.add('selected');
      } else {
        selectedBooks.splice(index, 1);
        card.classList.remove('selected');
      }
      updateSelectionUI();
    }

    function updateSelectionUI() {
  const count = selectedBooks.length;
  document.getElementById('selectedCount').textContent = `${count} book(s) selected`;

  const editBtn = document.getElementById('editButton');
  editBtn.style.display = count === 1 ? 'inline-flex' : 'none';
}

    // --- Open Modals ---
    function openAddBookModal() {
      document.getElementById('addBookModal').style.display = 'flex';
    }

    function closeAddBookModal() {
      document.getElementById('addBookModal').style.display = 'none';
    }

    function openEditModal() {
      const book = selectedBooks[0];
      document.getElementById('edit-title').value = book.title;
      document.getElementById('edit-author').value = book.author;
      // You can set other fields too
      document.getElementById('editBookModal').style.display = 'flex';
    }

    function closeEditModal() {
      document.getElementById('editBookModal').style.display = 'none';
    }

    function openBorrowModal() {
      const list = document.getElementById('selectedBooksList');
      list.innerHTML = '';
      selectedBooks.forEach(book => {
        const li = document.createElement('li');
        li.textContent = book.title;
        list.appendChild(li);
      });
      document.getElementById('borrowModal').style.display = 'flex';
    }

    function closeBorrowModal() {
      document.getElementById('borrowModal').style.display = 'none';
    }

    function showQRModal(title, url) {
      document.getElementById('qrModalTitle').textContent = title;
      document.getElementById('qrImage').src = url;
      document.getElementById('downloadLink').href = url;
      document.getElementById('qrModal').style.display = 'flex';
    }

    function closeQRModal() {
      document.getElementById('qrModal').style.display = 'none';
    }

    // --- Cover Preview ---
    function previewCover(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = e => {
          document.querySelector('.edit-modal-cover').style.backgroundImage = `url(${e.target.result})`;
          document.querySelector('.edit-modal-cover').style.backgroundSize = 'cover';
          document.querySelector('.edit-modal-cover').style.backgroundPosition = 'center';
          document.querySelector('.edit-modal-cover').style.color = 'transparent';
        };
        reader.readAsDataURL(file);
      }
    }

    // --- Search ---
    document.getElementById('searchInput').addEventListener('input', (e) => {
      const term = e.target.value.toLowerCase();
      document.querySelectorAll('.book-card').forEach(card => {
        const title = card.dataset.title.toLowerCase();
        const author = card.dataset.author.toLowerCase();
        card.style.display = (title.includes(term) || author.includes(term)) ? 'block' : 'none';
      });
    });

    // --- Dark Mode ---
    document.getElementById('darkModeToggle').addEventListener('change', () => {
      document.body.classList.toggle('dark-mode', this.checked);
      localStorage.setItem('darkMode', this.checked);
    });

    window.addEventListener('DOMContentLoaded', () => {
      if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
        document.getElementById('darkModeToggle').checked = true;
      }
    });
  </script>
</body>
</html>