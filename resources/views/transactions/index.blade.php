@extends('layouts.app')
@section('title', '📃 Transactions | Julita Public Library')
@section('page_title', '📃 Borrowed Transactions')
@push('head')
  <style>
    :root {
      --primary: #1e3a8a;
      --accent: #3b82f6;
      --light: #f9fafb;
      --dark: #1f2937;
      --white: #ffffff;
      --gray: #9ca3af;
      --bg-dark: #0f172a;
      --text-dark: #e5e7eb;
      --hover-dark: #334155;
      --danger: #ef4444;
    }

    body {
      margin: 0;
      display: flex;
      font-family: 'Inter', sans-serif;
      background-color: var(--light);
      color: var(--dark);
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    body.dark-mode {
      background-color: var(--bg-dark);
      color: var(--text-dark);
    }

    .sidebar {
      width: 240px;
      background-color: var(--primary);
      color: white;
      height: 100vh;
      padding: 1.5rem 1rem;
      position: fixed;
      top: 0;
      left: 0;
      display: flex;
      flex-direction: column;
      transition: width 0.3s ease;
    }

    .sidebar-header {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 2rem;
    }

    .sidebar .logo {
      width: 36px;
      height: 36px;
      object-fit: contain;
    }

    .sidebar.collapsed {
      width: 60px;
    }

    .sidebar.collapsed .label {
      display: none;
    }

    .sidebar nav a {
      display: flex;
      align-items: center;
      gap: 10px;
      color: white;
      text-decoration: none;
      padding: 10px;
      border-radius: 6px;
      margin-bottom: 8px;
    }

    .sidebar nav a:hover {
      background-color: var(--accent);
    }

    .toggle-btn {
      background: var(--accent);
      border: none;
      color: white;
      padding: 8px;
      border-radius: 6px;
      cursor: pointer;
      margin-bottom: 1.5rem;
    }

    .main {
      margin-left: 260px;
      padding: 2rem;
      flex-grow: 1;
      transition: margin-left 0.3s ease;
    }

    .main.full {
      margin-left: 80px;
    }

    .heading {
      font-size: 1.8rem;
      font-weight: bold;
      margin-bottom: 1.5rem;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #ccc;
      text-align: left;
    }

    th {
      background-color: var(--primary);
      color: white;
    }

    tr.overdue {
      background-color: #fdecea;
    }

    body.dark-mode tr.overdue {
      background-color: #7f1d1d;
    }

    .submit {
      background: var(--accent);
      color: white;
      border: none;
      padding: 6px 12px;
      border-radius: 6px;
      cursor: pointer;
    }

    .submit:hover {
      background: #2563eb;
    }

    .modal {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
      z-index: 999;
    }

    .modal-content {
      background: white;
      padding: 2rem;
      border-radius: 10px;
      width: 90%;
      max-width: 500px;
    }

    body.dark-mode .modal-content {
      background: #1e293b;
      color: var(--text-dark);
    }

    .actions {
      margin-top: 1.5rem;
      display: flex;
      justify-content: flex-end;
      gap: 1rem;
    }

    .cancel {
      background: #9ca3af;
      color: white;
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    @media (max-width: 768px) {
      .main { margin-left: 60px; }
    }
    .popup {
  position: fixed;
  bottom: 20px;
  left: 20px;
  background-color: var(--danger);
  color: white;
  padding: 1rem 1.5rem;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.25);
  max-width: 280px;
  z-index: 1001;
  font-size: 0.9rem;
  transition: opacity 0.3s ease;
}

.popup ul {
  margin: 0;
  padding-left: 1.2rem;
}

.popup.hidden {
  display: none;
}

body.dark-mode .popup {
  background-color: #dc2626;
  color: var(--text-dark);
}
.styled-table-wrapper {
  border: 1px solid #ccc;
  border-radius: 8px;
  max-height: 400px;
  overflow-y: auto;
  margin-top: 1rem;
  box-shadow: 0 1px 4px rgba(0,0,0,0.1);
}

.styled-table {
  width: 100%;
  border-collapse: collapse;
}

.styled-table thead th {
  position: sticky;
  top: 0;
  background-color: var(--primary);
  color: white;
  z-index: 1;
}

.styled-table th, .styled-table td {
  padding: 12px;
  border-bottom: 1px solid #ddd;
  text-align: left;
}

.styled-table tbody tr.overdue {
  background-color: #fdecea;
}

body.dark-mode .styled-table tbody tr.overdue {
  background-color: #7f1d1d;
}

  </style>
@endpush

@section('content')
   <h2>📘 Borrowed Books</h2>
<div class="styled-table-wrapper">
  <table class="styled-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Member</th>
        <th>Book</th>
        <th>Borrowed At</th>
        <th>Due Date</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($borrowed as $transaction)
        <tr 
          data-id="{{ $transaction->id }}"
          data-member="{{ $transaction->member->name }}"
          data-book="{{ $transaction->book->title }}"
          class="{{ ($transaction->status === 'borrowed' && \Carbon\Carbon::parse($transaction->due_date)->isPast()) ? 'overdue' : '' }}"
        >
          <td>{{ $transaction->id }}</td>
          <td>{{ $transaction->member?->name ?? 'Unknown' }}</td>
          <td>{{ $transaction->book->title }}</td>
          <td>{{ \Carbon\Carbon::parse($transaction->borrowed_at)->format('M d, Y h:i A') }}</td>
          <td>{{ \Carbon\Carbon::parse($transaction->due_date)->format('M d, Y h:i A') }}</td>
          <td>{{ ucfirst($transaction->status) }}</td>
          <td>
            <form action="{{ route('transactions.return', $transaction->id) }}" method="POST" style="display:inline;">
  @csrf
  <button type="submit" class="submit">Return</button>
</form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<h2 style="margin-top: 3rem;">📦 Returned Books</h2>
<div class="styled-table-wrapper">
  <table class="styled-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Member</th>
        <th>Book</th>
        <th>Borrowed At</th>
        <th>Due Date</th>
        <th>Returned At</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($returned as $transaction)
        <tr>
          <td>{{ $transaction->id }}</td>
          <td>{{ $transaction->member->name }}</td>
          <td>{{ $transaction->book->title }}</td>
          <td>{{ \Carbon\Carbon::parse($transaction->borrowed_at)->format('M d, Y h:i A') }}</td>
          <td>{{ \Carbon\Carbon::parse($transaction->due_date)->format('M d, Y h:i A') }}</td>
          <td>{{ \Carbon\Carbon::parse($transaction->returned_at)->format('M d, Y h:i A') }}</td>
          <td>{{ ucfirst($transaction->status) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
  <!-- Return Modal -->
  <div class="modal" id="returnModal">
    <div class="modal-content">
      <h3>Confirm Return</h3>
      <p>Return <strong><span id="modalBook"></span></strong> borrowed by <strong><span id="modalMember"></span></strong>?</p>
      <div class="actions">
        <button class="cancel" onclick="closeReturnModal()">Cancel</button>
        <button class="submit" onclick="confirmReturn()">Confirm</button>
      </div>
    </div>
  </div>
    <div id="overduePopup" class="popup hidden">
  <p><strong>⏰ Overdue Alert:</strong></p>
  <ul id="overdueList"></ul>
</div>
@push('scripts')
  <script>
    // Sidebar + Dark Mode Logic
    document.addEventListener('DOMContentLoaded', () => {
      const sidebar = document.getElementById('sidebar');
      const main = document.getElementById('mainContent');
      const toggleBtn = document.getElementById('toggleSidebar');

      if (localStorage.getItem('sidebarCollapsed') === 'true') {
        sidebar.classList.add('collapsed');
        main.classList.add('full');
      }

      toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        main.classList.toggle('full');
        localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
      });

      if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
      }
    });
  </script>
  <script src="{{ asset('js/bookreturn.js') }}"></script>
@endpush
@endsection
