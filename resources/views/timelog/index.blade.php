<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>🕒 Member Time Logs | Julita Leyte</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
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
      --highlight: #dbeafe;
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
    /* Toast Notification */
.toast-notification {
    position: fixed;
    top: 24px;
    right: 24px;
    background: var(--danger);
    color: white;
    padding: 16px;
    border-radius: var(--border-radius-sm);
    box-shadow: var(--modal-shadow);
    z-index: 2000;
    max-width: 380px;
    opacity: 0;
    transform: translateY(-20px);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: flex-start;
    font-size: 0.95rem;
    line-height: 1.5;
}

.toast-notification.show {
    opacity: 1;
    transform: translateY(0);
}

.toast-content {
    display: flex;
    gap: 10px;
    width: 100%;
}

.toast-icon {
    font-size: 1.4rem;
    flex-shrink: 0;
}

.toast-text strong {
    display: block;
    margin-top: 4px;
}

.toast-close {
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    font-size: 1.2rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: -4px;
}

.toast-close:hover {
    background: rgba(255,255,255,0.3);
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
      top: 0; left: 0;
      right: 0; bottom: 0;
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
      flex-grow: 1;
      transition: margin-left 0.3s ease;
    }

    .main.full {
      margin-left: 80px;
    }

    .container {
      max-width: 960px;
      margin: auto;
      background: var(--white);
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    body.dark-mode .container {
      background-color: var(--hover-dark);
    }

    h2 {
      text-align: center;
      color: var(--primary);
    }
  

    .top-controls {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
      justify-content: center;
      margin-bottom: 1.5rem;
    }

    .top-controls input {
      width: 300px;
      padding: 0.75rem 1rem;
      font-size: 1rem;
      border-radius: 8px;
      border: 1px solid #ccc;
    }

    .top-controls button {
      background: var(--accent);
      color: white;
      padding: 0.75rem 1rem;
      border-radius: 8px;
      border: none;
      font-weight: 600;
      cursor: pointer;
    }

    #suggestionBox {
      position: absolute;
      width: 300px;
      max-height: 180px;
      overflow-y: auto;
      border: 1px solid #ccc;
      background: var(--white);
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      z-index: 999;
    }

    body.dark-mode #suggestionBox {
      background: var(--hover-dark);
      border-color: #475569;
      color: var(--text-dark);
    }

    #suggestionBox div {
      padding: 10px;
      cursor: pointer;
    }

    #suggestionBox div:hover {
      background-color: var(--highlight);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1.5rem;
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 14px;
      border-bottom: 1px solid #e5e7eb;
    }

    th {
      background: var(--primary);
      color: white;
      text-align: left;
    }

    .logout {
      background: var(--danger);
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 6px;
      cursor: pointer;
    }

    .corner-popup {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: var(--accent);
      color: white;
      padding: 12px 18px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
      font-size: 0.95rem;
      z-index: 1000;
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
      background: var(--white);
      padding: 1.5rem;
      border-radius: 12px;
      width: 90%;
      max-width: 500px;
      box-shadow: 0 20px 25px rgba(0, 0, 0, 0.1);
    }

    .modal-content label {
      display: block;
      margin-top: 1rem;
      font-weight: 600;
    }

    .modal-content input {
      width: 100%;
      padding: 0.6rem;
      margin-top: 0.4rem;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .actions {
      display: flex;
      justify-content: flex-end;
      gap: 1rem;
      margin-top: 1.5rem;
    }

    .cancel {
      background: #94a3b8;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      cursor: pointer;
      color: white;
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

    .submit {
      background: var(--accent);
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      cursor: pointer;
      color: white;
    }

    /* Custom Button Styles for Modals */
    .btn-cancel {
      background: linear-gradient(135deg, #9ca3af, #6b7280);
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-cancel:hover {
      transform: translateY(-2px) scale(1.05);
      box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
      background: linear-gradient(135deg, #6b7280, #4b5563);
    }

    .btn-confirm {
      background: linear-gradient(135deg, #10b981, #059669);
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-confirm:hover {
      transform: translateY(-2px) scale(1.05);
      box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
      background: linear-gradient(135deg, #059669, #047857);
    }
  </style>
</head>
<body>
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <img src="/images/logo.png" alt="Logo" class="logo">
      <span class="label">Julita Public Library</span>
    </div>
    <button class="toggle-btn" id="toggleSidebar">☰</button>

                <a href="{{ route('dashboard') }}" class="active">
                <span class="icon">🏠</span>
                <span class="label">Dashboard</span>
            </a>
    <div class="dark-toggle">
      <label class="switch">
        <input type="checkbox" id="darkModeToggle">
        <span class="slider"></span>
      </label>
      <a href="/logout" style="display:block; margin-top:1rem; color:white;">🚪 Logout</a>
    </div>
  </div>
  <!-- Overdue Toast Notification -->
<div id="overdueToast" class="toast-notification">
    <div class="toast-content">
        <div class="toast-icon">⚠️</div>
        <div class="toast-text">
            <strong>Overdue Alert!</strong><br>
            <span id="toastMessage">Loading...</span>
        </div>
        <button id="closeToast" class="toast-close">×</button>
    </div>
</div>

  <div class="main" id="mainContent">
    <div class="container">
      <h2>📅 Time In / Time Out</h2>
      <div class="top-controls">
        <div style="position: relative;">
          <input type="text" id="memberInput" placeholder="Search member..." autocomplete="off">
          <div id="suggestionBox"></div>
        </div>
        
      <button onclick="openScanQRModal()" id="scanQRBtn"><i class="fas fa-qrcode"></i> Scan QR</button>


      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>School</th>
            <th>Time In</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($logs as $log)
          <tr>
            <td>{{ $log->member->name }}</td>
            <td>{{ $log->member->school }}</td>
            <td>{{ \Carbon\Carbon::parse($log->time_in)->format('h:i A') }}</td>
            <td><button class="logout" onclick="timeOut({{ $log->id }}, this)">Time Out</button></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div class="modal" id="registerModal">
    <div class="modal-content">
      <h3>Register New Member</h3>
      <label>Full Name</label>
      <input type="text" id="name">

      <label>Age</label>
      <input type="number" id="age">

      <label>Address</label>
      <input type="text" id="address">

      <label>Contact Number</label>
      <input type="text" id="contactnumber" maxlength="11" pattern="\d{11}" oninput="this.value = this.value.replace(/\D/g, '')">

      <label>School</label>
      <input type="text" id="school">

      <div class="actions">
        <button class="btn-cancel" onclick="closeRegisterModal()">Cancel</button>
        <button class="btn-confirm" onclick="submitRegister()">Submit</button>
      </div>
    </div>
  </div>
  <div class="modal" id="scanQRModal">
  <div class="modal-content" style="max-width: 500px;">
    <h3>📷 Scan Member QR</h3>
    <div id="qr-reader" style="width: 100%; height: auto;"></div>
    <div class="actions">
      <button class="btn-cancel" onclick="closeScanQRModal()">Cancel</button>
    </div>
  </div>
</div>



  <div class="corner-popup" id="popup" style="display:none;"></div>

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
  </script>
  <script src="{{ asset('js/timelog.js') }}"></script>
  <script src="{{ asset('js/memberscript.js') }}"></script>
  <script src="{{ asset('js/sidebarcollapse.js')}}"></script>
  <script src="{{ asset('js/scanqr.js')}}"></script>
  <script src="{{ asset('js/overdue.js') }}"></script>
</body>
</html>
