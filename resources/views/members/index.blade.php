<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>👥 Members | Julita Public Library</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

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
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      display: flex;
      font-family: 'Inter', sans-serif;
      background-color: var(--light);
      color: var(--dark);
      transition: background-color 0.3s, color 0.3s;
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
      position: fixed;
      left: 0;
      top: 0;
      padding: 1.5rem 1rem;
      display: flex;
      flex-direction: column;
      z-index: 999;
      transition: width 0.3s;
    }

    .sidebar-header {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 2rem;
    }

    .sidebar-header img {
      width: 36px;
      height: 36px;
      border-radius: 6px;
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
      padding: 10px 12px;
      border-radius: 6px;
      margin-bottom: 8px;
      transition: background 0.2s;
    }

    .sidebar nav a:hover {
      background-color: var(--accent);
    }

    .sidebar.collapsed nav a {
      justify-content: center;
    }

    .toggle-btn {
      background: var(--accent);
      color: white;
      border: none;
      padding: 8px 12px;
      font-size: 1rem;
      border-radius: 6px;
      cursor: pointer;
      margin-bottom: 1.5rem;
    }

    .dark-toggle {
      margin-top: auto;
      text-align: center;
    }

    .switch {
      position: relative;
      display: inline-block;
      width: 50px;
      height: 26px;
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
      background-color: #ccc;
      transition: 0.4s;
      border-radius: 34px;
    }

    .slider:before {
      position: absolute;
      content: "🌞";
      height: 22px;
      width: 22px;
      left: 2px;
      bottom: 2px;
      background-color: white;
      border-radius: 50%;
      text-align: center;
      line-height: 22px;
      font-size: 13px;
      transition: 0.4s;
    }

    input:checked + .slider {
      background-color: var(--dark);
    }

    input:checked + .slider:before {
      transform: translateX(24px);
      content: "🌙";
    }

    .main {
      margin-left: 260px;
      padding: 2rem;
      flex: 1;
      transition: margin-left 0.3s ease;
    }

    .main.full {
      margin-left: 80px;
    }

    .top-controls {
      margin: 1rem 0;
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .top-controls input {
      padding: 8px 12px;
      font-size: 1rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      width: 300px;
    }

    .top-controls button {
      background: var(--accent);
      color: var(--white);
      padding: 8px 16px;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      font-size: 1rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      cursor: pointer;
    }

    .top-controls button:hover {
      background: #0056b3;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }

    th {
      background: var(--primary);
      color: white;
      position: sticky;
      top: 0;
    }

    .modal {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    .modal-content {
      background: var(--white);
      padding: 2rem;
      border-radius: 12px;
      width: 90%;
      max-width: 600px;
    }

    .modal-content label {
      display: block;
      margin-top: 1rem;
      font-weight: 600;
    }

    .modal-content input {
      width: 100%;
      padding: 0.5rem;
      margin-top: 0.3rem;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .actions {
      margin-top: 2rem;
      display: flex;
      justify-content: flex-end;
      gap: 1rem;
    }

      body.dark-mode .modal-content {
  background-color: #1e293b;
  color: var(--text-dark);
}

body.dark-mode .modal-content input {
  background-color: #0f172a;
  color: var(--text-dark);
  border: 1px solid #475569;
}

body.dark-mode .modal-content input::placeholder {
  color: #9ca3af;
}

body.dark-mode .actions .cancel {
  background: #475569;
  color: #e2e8f0;
}

body.dark-mode .actions .submit {
  background: var(--accent);
  color: white;
}

body.dark-mode .actions .delete {
  background: #ef4444;
  color: white;
}

    .actions .cancel, .actions .submit, .actions .delete {
      padding: 0.5rem 1rem;
      border-radius: 6px;
      border: none;
      cursor: pointer;
    }

    .actions .cancel {
      background: #ccc;
      color: #333;
    }

    .actions .submit {
      background: var(--accent);
      color: white;
    }

    .actions .delete {
      background: crimson;
      color: white;
    }
  </style>
</head>
<body>
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <img src="/images/logo.png" alt="Logo">
      <span class="label">Julita Public Library</span>
    </div>
    <button class="toggle-btn" id="toggleSidebar">☰</button>
    <nav>
    <a href="{{ route('dashboard') }}">
      <span class="icon">🏠</span>
      <span class="label">Dashboard</span>
    </a>
    <a href="{{ route('books.index') }}">
      <span class="icon">📘</span>
      <span class="label">Manage Books</span>
    </a>
    <a href="{{ route('members.index') }}">
      <span class="icon">👥</span>
      <span class="label">Manage Members</span>
    </a>
    <a href="{{ route('transactions.index') }}">
      <span class="icon">📃</span>
      <span class="label">Transactions</span>
    </a>
  </nav>
    <div class="dark-toggle">
      <label class="switch">
        <input type="checkbox" id="darkModeToggle">
        <span class="slider"></span>
      </label>
      <a href="/logout" style="display:block;margin-top:1rem;color:#e0e0e0;text-decoration:underline;">🚪 Logout</a>
    </div>
  </div>

  <div class="main" id="mainContent">
    <h2>👥 Registered Members</h2>
    <div class="top-controls">
      <input type="text" id="search-input" placeholder="Search by name...">
      <button id="registerBtn" onclick="openRegisterModal()"><i class="fas fa-user-plus"></i> Register User</button>
      <button id="editBtn" onclick="openMemberEditModal()"><i class="fas fa-cog"></i> Manage User</button>
    </div>
    <div class="table-container">
      <table id="member-table">
        <thead>
          <tr>
            <th>Select</th>
            <th>Name</th>
            <th>Age</th>
            <th>Address</th>
            <th>Contact Number</th>
            <th>Member Since</th>
            <th>Computer Time</th>
          </tr>
        </thead>
        <tbody>
          @foreach($members as $index => $member)
          <tr data-index="{{ $index }}" 
              data-id="{{ $member->id }}" 
              data-name="{{ $member->name }}" 
              data-age="{{ $member->age }}" 
              data-address="{{ $member->address }}" 
              data-contact="{{ $member->contactnumber }}" 
              data-school="{{ $member->school }}" 
              data-member-time="{{ $member->member_time }}">
            <td>
              <input type="checkbox" class="member-checkbox" data-id="{{ $member->id }}" 
                {{ $member->member_time > 0 ? '' : 'disabled' }}>
            </td>
            <td>{{ $member->name }}</td>
            <td>{{ $member->age }}</td>
            <td>{{ $member->address }}</td>
            <td>{{ $member->contactnumber }}</td>
            <td>{{ $member->memberdate }}</td>
            <td>{{ $member->member_time }}</td>
            <td>
  @if(!empty($member->qr_url))
    <button onclick="showMemberQRModal('{{ $member->name }}', '{{ $member->qr_url }}')" class="btn btn-secondary">
      📷 Show QR
    </button>
  @else
    <button onclick="generateQr({{ $member->id }})" class="btn btn-outline btn-sm">
      📷 Generate QR
    </button>
  @endif
</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Modals -->
    <div class="modal" id="registerModal"><div class="modal-content">
      <h3>Register New Member</h3>
      <label for="name">Full Name</label><input type="text" id="name">
      <label for="age">Age</label><input type="number" id="age">
      <label for="address">Address</label><input type="text" id="address">
      <label for="contactnumber">Contact Number</label><input type="text" id="contactnumber" maxlength="11" pattern="\d{11}" oninput="this.value = this.value.replace(/\D/g, '')">
      <label for="school">School</label><input type="text" id="school">
      <div class="actions">
        <button class="cancel" onclick="closeRegisterModal()">Cancel</button>
        <button class="submit" onclick="submitRegister()">Submit</button>
      </div>
    </div></div>

    <div class="modal" id="editModal"><div class="modal-content">
      <h3>Edit Member Info</h3>
      <input type="hidden" id="edit-id">
      <label for="edit-name">Full Name</label><input type="text" id="edit-name">
      <label for="edit-age">Age</label><input type="number" id="edit-age">
      <label for="edit-address">Address</label><input type="text" id="edit-address">
      <label for="edit-contact">Contact Number</label><input type="text" id="edit-contact" maxlength="11" pattern="\d{11}" oninput="this.value = this.value.replace(/\D/g, '')">
      <label for="edit-school">School</label><input type="text" id="edit-school">
      <div class="actions">
        <button class="cancel" onclick="closeEditModal()">Cancel</button>
        <button class="delete" onclick="deleteMember()">Delete</button>
        <button class="submit" onclick="updateMember()">Save Changes</button>
      </div>
    </div></div>
  </div>

  <div id="memberQrModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
  background:rgba(0,0,0,0.7); justify-content:center; align-items:center; z-index:9999;">
  <div style="background:#fff; padding:20px; border-radius:8px; text-align:center; max-width:90vw; position:relative;">
    <h3 id="qrMemberTitle" style="margin-bottom:10px;">Member QR Code</h3>
    <img id="qrMemberImage" src="" alt="QR Code" style="max-width:300px; margin-bottom:15px;" />
    <div>
      <a id="memberDownloadLink" class="btn btn-success" style="margin-right:10px;">📥 Download</a>
      <button onclick="closeMemberQRModal()" class="btn btn-danger">❌ Close</button>
    </div>
  </div>
</div>


  <script>
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleBtn = document.getElementById('toggleSidebar');
    const darkToggle = document.getElementById('darkModeToggle');

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

    document.getElementById('chatbot-button').onclick = () => {
      document.getElementById('chatbot-window').style.display = 'flex';
    };
    document.getElementById('chatbot-close').onclick = () => {
      document.getElementById('chatbot-window').style.display = 'none';
    };
  </script>
  <script src="js/membersearch.js"></script>
  <script src="js/memberscript.js"></script>
  <script src="js/memberedit.js"></script>
  <script src="{{ asset('js/sidebarcollapse.js')}}"></script>
  <script src="{{ asset('js/showqr.js') }}"></script>
</body>
</html>
