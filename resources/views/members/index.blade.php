<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>👥 Members | Julita Public Library</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
      --success: #059669;
      --danger: #dc2626;
      --warning: #d97706;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: var(--light);
      color: var(--dark);
      transition: background-color 0.3s, color 0.3s;
    }

    body.dark-mode {
      background-color: var(--bg-dark);
      color: var(--text-dark);
    }

    /* Sidebar Styles */
    .sidebar {
      width: 260px;
      background: linear-gradient(135deg, var(--primary) 0%, #1e40af 100%);
      color: white;
      height: 100vh;
      padding: 1.5rem 1rem;
      position: fixed;
      left: 0;
      top: 0;
      display: flex;
      flex-direction: column;
      box-shadow: 2px 0 10px rgba(0,0,0,0.1);
      transition: width 0.3s ease;
    }

    .sidebar.collapsed {
      width: 70px;
    }

    .sidebar-header {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 2rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .sidebar-header img {
      width: 40px;
      height: 40px;
      border-radius: 8px;
      background: var(--accent);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
    }

    .sidebar-header h3 {
      font-size: 1.1rem;
      font-weight: 600;
      opacity: 1;
      transition: opacity 0.3s;
    }

    .sidebar.collapsed .sidebar-header h3,
    .sidebar.collapsed .label {
      opacity: 0;
      pointer-events: none;
    }

    .toggle-btn {
      background: rgba(255,255,255,0.1);
      color: white;
      border: none;
      padding: 10px;
      font-size: 1.1rem;
      border-radius: 8px;
      cursor: pointer;
      margin-bottom: 1.5rem;
      transition: background 0.2s;
      width: 100%;
      display: flex;
      justify-content: center;
    }

    .toggle-btn:hover {
      background: rgba(255,255,255,0.2);
    }

    .sidebar nav {
      flex: 1;
    }

    .sidebar nav a {
      display: flex;
      align-items: center;
      gap: 12px;
      color: rgba(255,255,255,0.9);
      text-decoration: none;
      padding: 12px 16px;
      border-radius: 8px;
      margin-bottom: 8px;
      transition: all 0.2s;
      position: relative;
    }

    .sidebar nav a:hover {
      background: rgba(255,255,255,0.1);
      color: white;
      transform: translateX(4px);
    }

    .sidebar nav a.active {
      background: var(--accent);
      color: white;
    }

    .sidebar nav a .icon {
      font-size: 1.2rem;
      width: 20px;
      text-align: center;
    }

    .dark-toggle {
      margin-top: auto;
      padding-top: 1rem;
      border-top: 1px solid rgba(255,255,255,0.1);
    }

    .switch {
      position: relative;
      display: inline-block;
      width: 52px;
      height: 28px;
      margin-bottom: 1rem;
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
      background-color: rgba(255,255,255,0.2);
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
      text-align: center;
      line-height: 24px;
      font-size: 12px;
      transition: 0.4s;
    }

    input:checked + .slider {
      background-color: var(--accent);
    }

    input:checked + .slider:before {
      transform: translateX(24px);
      content: "🌙";
    }

    .logout-link {
      display: flex;
      align-items: center;
      gap: 8px;
      color: rgba(255,255,255,0.8);
      text-decoration: none;
      font-size: 0.9rem;
      transition: color 0.2s;
    }

    .logout-link:hover {
      color: white;
    }

    /* Main Content */
    .main {
      margin-left: 260px;
      padding: 2rem;
      min-height: 100vh;
      transition: margin-left 0.3s ease;
    }

    .main.collapsed {
      margin-left: 70px;
    }

    .page-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 2rem;
      padding-bottom: 1rem;
      border-bottom: 2px solid var(--light);
    }

    body.dark-mode .page-header {
      border-bottom-color: var(--hover-dark);
    }

    .page-title {
      font-size: 2rem;
      font-weight: 700;
      color: var(--primary);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    body.dark-mode .page-title {
      color: var(--accent);
    }

    .top-controls {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      margin-bottom: 2rem;
      align-items: center;
    }

    .search-box {
      position: relative;
      flex: 1;
      min-width: 300px;
    }

    .search-box input {
      width: 100%;
      padding: 12px 16px 12px 45px;
      font-size: 1rem;
      border: 2px solid #e5e7eb;
      border-radius: 12px;
      background: white;
      transition: all 0.2s;
    }

    .search-box input:focus {
      outline: none;
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .search-box .search-icon {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--gray);
      font-size: 1.1rem;
    }

    body.dark-mode .search-box input {
      background: var(--hover-dark);
      border-color: #475569;
      color: var(--text-dark);
    }

    .btn {
      padding: 12px 24px;
      font-size: 1rem;
      font-weight: 600;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: all 0.2s;
      text-decoration: none;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--accent) 0%, #2563eb 100%);
      color: white;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
    }

    .btn-secondary {
      background: var(--gray);
      color: white;
    }

    .btn-secondary:hover {
      background: #6b7280;
      transform: translateY(-1px);
    }

    .btn-success {
      background: var(--success);
      color: white;
    }

    .btn-danger {
      background: var(--danger);
      color: white;
    }

    /* Table Styles */
    .table-container {
      background: white;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      border: 1px solid #e5e7eb;
    }

    body.dark-mode .table-container {
      background: var(--hover-dark);
      border-color: #475569;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    thead {
      background: linear-gradient(135deg, var(--primary) 0%, #1e40af 100%);
      color: white;
    }

    th {
      padding: 1rem;
      text-align: left;
      font-weight: 600;
      font-size: 0.95rem;
      letter-spacing: 0.5px;
    }

    td {
      padding: 1rem;
      border-bottom: 1px solid #f3f4f6;
    }

    body.dark-mode td {
      border-bottom-color: #475569;
      color: var(--text-dark);
    }

    tbody tr {
      transition: background-color 0.2s;
    }

    tbody tr:hover {
      background-color: #f9fafb;
    }

    body.dark-mode tbody tr:hover {
      background-color: rgba(255, 255, 255, 0.05);
    }

    .member-checkbox {
      width: 18px;
      height: 18px;
      cursor: pointer;
    }

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(4px);
      z-index: 1000;
      justify-content: center;
      align-items: center;
      padding: 2rem;
      box-sizing: border-box;
    }

    .modal.show {
      display: flex;
      animation: fadeIn 0.3s ease-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .modal-content {
      background: white;
      border-radius: 20px;
      padding: 2rem;
      width: 100%;
      max-width: 800px;
      max-height: 90vh;
      overflow-y: auto;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      animation: slideUp 0.3s ease-out;
    }

    @keyframes slideUp {
      from { 
        opacity: 0;
        transform: translateY(30px);
      }
      to { 
        opacity: 1;
        transform: translateY(0);
      }
    }

    body.dark-mode .modal-content {
      background: #1e293b;
      color: var(--text-dark);
    }

    .modal-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 2rem;
      padding-bottom: 1rem;
      border-bottom: 2px solid #f3f4f6;
    }

    body.dark-mode .modal-header {
      border-bottom-color: #475569;
    }

    .modal-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    body.dark-mode .modal-title {
      color: var(--accent);
    }

    .close-modal {
      background: none;
      border: none;
      font-size: 1.5rem;
      color: var(--gray);
      cursor: pointer;
      padding: 5px;
      border-radius: 50%;
      width: 35px;
      height: 35px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s;
    }

    .close-modal:hover {
      background: #f3f4f6;
      color: var(--dark);
    }

    body.dark-mode .close-modal:hover {
      background: var(--hover-dark);
      color: white;
    }

    .form-section {
      margin-bottom: 2rem;
    }

    .section-title {
      font-size: 1.2rem;
      font-weight: 600;
      color: var(--primary);
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    body.dark-mode .section-title {
      color: var(--accent);
    }

    .form-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
    }

    .form-group {
      display: flex;
      flex-direction: column;
    }

    .form-group label {
      font-weight: 600;
      margin-bottom: 0.5rem;
      color: var(--dark);
      font-size: 0.95rem;
    }

    body.dark-mode .form-group label {
      color: var(--text-dark);
    }

    .form-group input {
      padding: 12px 16px;
      font-size: 1rem;
      border: 2px solid #e5e7eb;
      border-radius: 10px;
      background: white;
      transition: all 0.2s;
    }

    .form-group input:focus {
      outline: none;
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    body.dark-mode .form-group input {
      background: var(--bg-dark);
      border-color: #475569;
      color: var(--text-dark);
    }

    body.dark-mode .form-group input:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    .modal-actions {
      display: flex;
      justify-content: flex-end;
      gap: 1rem;
      margin-top: 2rem;
      padding-top: 2rem;
      border-top: 2px solid #f3f4f6;
    }

    body.dark-mode .modal-actions {
      border-top-color: #475569;
    }

    .modal-actions .btn {
      min-width: 120px;
      justify-content: center;
    }

    /* QR Modal Styles */
    .qr-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.8);
      backdrop-filter: blur(4px);
      z-index: 1500;
      justify-content: center;
      align-items: center;
    }

    .qr-modal.show {
      display: flex;
      animation: fadeIn 0.3s ease-out;
    }

    .qr-content {
      background: white;
      padding: 2rem;
      border-radius: 20px;
      text-align: center;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
      animation: slideUp 0.3s ease-out;
    }

    body.dark-mode .qr-content {
      background: #1e293b;
      color: var(--text-dark);
    }

    .qr-content h3 {
      margin-bottom: 1.5rem;
      color: var(--primary);
      font-size: 1.3rem;
    }

    body.dark-mode .qr-content h3 {
      color: var(--accent);
    }

    .qr-content img {
      max-width: 300px;
      margin-bottom: 1.5rem;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        transform: translateX(-100%);
      }

      .sidebar.show {
        transform: translateX(0);
      }

      .main {
        margin-left: 0;
      }

      .modal {
        padding: 1rem;
      }

      .modal-content {
        padding: 1.5rem;
      }

      .form-grid {
        grid-template-columns: 1fr;
      }

      .modal-actions {
        flex-direction: column;
      }

      .modal-actions .btn {
        width: 100%;
      }

      .top-controls {
        flex-direction: column;
        align-items: stretch;
      }

      .search-box {
        min-width: auto;
      }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <div style="width:40px;height:40px;background:var(--accent);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:20px;">📚</div>
      <h3 class="label">Julita Public Library</h3>
    </div>
    
    <button class="toggle-btn" id="toggleSidebar" disabled>
      <i class="fas fa-bars"></i>
    </button>
    
    <nav>
      <a href="/dashboard">
        <span class="icon">🏠</span>
        <span class="label">Dashboard</span>
      </a>
      <a href="/books">
        <span class="icon">📘</span>
        <span class="label">Manage Books</span>
      </a>
      <a href="/members" class="active">
        <span class="icon">👥</span>
        <span class="label">Manage Members</span>
      </a>
      <a href="/transactions">
        <span class="icon">📃</span>
        <span class="label">Transactions</span>
      </a>
    </nav>
    
    <div class="dark-toggle">
      <label class="switch">
        <input type="checkbox" id="darkModeToggle">
        <span class="slider"></span>
      </label>
      <a href="/logout" class="logout-link">
        <span>🚪</span>
        <span class="label">Logout</span>
      </a>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main" id="mainContent">
    <div class="page-header">
      <h1 class="page-title">
        <span>👥</span>
        Registered Members
      </h1>
    </div>

    <div class="top-controls">
      <div class="search-box">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="searchInput" placeholder="Search members by name, address, or contact...">
      </div>
      <button class="btn btn-primary" onclick="openRegisterModal()">
        <i class="fas fa-user-plus"></i>
        Register Member
      </button>
      <button class="btn btn-secondary" onclick="openEditModal()" id="editBtn">
        <i class="fas fa-edit"></i>
        Edit Selected
      </button>
    </div>

    <!-- Members Table -->
   <!-- Members Table -->
<div class="table-container">
  <table id="membersTable">
    <thead>
      <tr>
        <th></th>
        <th>Name</th>
        <th>Age</th>
        <th>Address</th>
        <th>Contact Number</th>
        <th>School</th>
        <th>Member Since</th>
        <th>Computer Time</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="membersTableBody">
      @if(isset($members) && $members->count())
        @foreach ($members as $member)
          <tr>
            {{-- Name with checkbox --}}
            <td>
              <input type="checkbox" name="memberCheckbox" value="{{ $member->id }}" class="member-checkbox">
            </td> 
            <td>
              {{ $member->first_name ?? '' }}
              @if (!empty($member->middle_name) && $member->middle_name !== 'null')
                {{ ' ' . $member->middle_name }}
              @endif
              {{ !empty($member->last_name) && $member->last_name !== 'null' ? ' ' . $member->last_name : '' }}
            </td>

            {{-- Age --}}
            <td>{{ $member->age ?? '' }}</td>

            {{-- Full Address --}}
            <td>
              {{ collect([
                (!empty($member->house_number) && $member->house_number !== 'null') ? $member->house_number : null,
                (!empty($member->street) && $member->street !== 'null') ? $member->street : null,
                (!empty($member->barangay) && $member->barangay !== 'null') ? $member->barangay : null,
                (!empty($member->municipality) && $member->municipality !== 'null') ? $member->municipality : null,
                (!empty($member->province) && $member->province !== 'null') ? $member->province : null
              ])->filter()->implode(', ') }}
            </td>

            {{-- Contact Number --}}
            <td>{{ (!empty($member->contactnumber) && $member->contactnumber !== 'null') ? $member->contactnumber : '' }}</td>

            {{-- School --}}
            <td>{{ (!empty($member->school) && $member->school !== 'null') ? $member->school : '' }}</td>

            {{-- Member Since --}}
            <td>
              @if (!empty($member->memberdate) && $member->memberdate !== 'null')
                {{ \Carbon\Carbon::parse($member->memberdate)->format('F j, Y') }}
              @endif
            </td>

            {{-- Computer Time --}}
            <td>{{ (!empty($member->member_time) && $member->member_time !== 'null') ? $member->member_time . ' min' : '' }}</td>

            {{-- Actions --}}
            <td>
              <a href="{{ asset('card/member_' . $member->id . '.pdf') }}" 
                class="btn btn-sm btn-success" 
                target="_blank" 
                title="Download ID Card">
                <i class="fas fa-id-card"></i>
              </a>
            </td>
          </tr>
        @endforeach
      @else
        <tr>
          <td colspan="9" style="text-align: center;">No members found.</td>
        </tr>
      @endif
    </tbody>
  </table>
</div>

  </div>

  <!-- Register Member Modal -->
  <div class="modal" id="registerModal">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">
          <i class="fas fa-user-plus"></i>
          Register New Member
        </h2>
        <button class="close-modal" onclick="closeRegisterModal()">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <form id="registerForm">
        <!-- Personal Information Section -->
        <div class="form-section">
          <h3 class="section-title">
            <i class="fas fa-user"></i>
            Personal Information
          </h3>
          <div class="form-grid">
            <div class="form-group">
              <label for="firstName">First Name *</label>
              <input type="text" id="firstName" name="firstName" required>
            </div>
            <div class="form-group">
              <label for="middleName">Middle Name</label>
              <input type="text" id="middleName" name="middleName">
            </div>
            <div class="form-group">
              <label for="lastName">Last Name *</label>
              <input type="text" id="lastName" name="lastName" required>
            </div>
            <div class="form-group">
              <label for="age">Age *</label>
              <input type="number" id="age" name="age" min="1" max="150" required>
            </div>
          </div>
        </div>

        <!-- Address Information Section -->
        <div class="form-section">
          <h3 class="section-title">
            <i class="fas fa-map-marker-alt"></i>
            Address Information
          </h3>
          <div class="form-grid">
            <div class="form-group">
              <label for="houseNumber">House Number</label>
              <input type="text" id="houseNumber" name="houseNumber">
            </div>
            <div class="form-group">
              <label for="street">Street</label>
              <input type="text" id="street" name="street">
            </div>
            <div class="form-group">
              <label for="barangay">Barangay *</label>
              <input type="text" id="barangay" name="barangay" required>
            </div>
            <div class="form-group">
              <label for="municipality">Municipality/City *</label>
              <input type="text" id="municipality" name="municipality" required>
            </div>
            <div class="form-group">
              <label for="province">Province *</label>
              <input type="text" id="province" name="province" required>
            </div>
          </div>
        </div>

        <!-- Contact Information Section -->
        <div class="form-section">
          <h3 class="section-title">
            <i class="fas fa-phone"></i>
            Contact Information
          </h3>
          <div class="form-grid">
            <div class="form-group">
              <label for="contactNumber">Contact Number *</label>
              <input type="tel" id="contactNumber" name="contactNumber" pattern="[0-9]{11}" maxlength="11" required>
            </div>
            <div class="form-group">
              <label for="school">School/Institution</label>
              <input type="text" id="school" name="school">
            </div>
          </div>
        </div>

        <div class="modal-actions">
          <button type="button" class="btn btn-secondary" onclick="closeRegisterModal()">
            <i class="fas fa-times"></i>
            Cancel
          </button>
            <button type="button" class="btn btn-primary" onclick="submitRegister()">
            <i class="fas fa-save"></i>
            Register Member
            </button>
        </div>
      </form>
    </div>
  </div>

  <div class="modal" id="julitaRegisterModal">
  <div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title">
        <i class="fas fa-user-plus"></i>
        Register Julita Resident
      </h2>
      <button class="close-modal" onclick="closeJulitaRegisterModal()">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <form id="julitaRegisterForm">
      <!-- Personal Information Section -->
      <div class="form-section">
        <h3 class="section-title">
          <i class="fas fa-user"></i>
          Personal Information
        </h3>
        <div class="form-grid">
          <div class="form-group">
            <label for="firstName">First Name *</label>
            <input type="text" id="firstName" name="firstName" required>
          </div>
          <div class="form-group">
            <label for="middleName">Middle Name</label>
            <input type="text" id="middleName" name="middleName">
          </div>
          <div class="form-group">
            <label for="lastName">Last Name *</label>
            <input type="text" id="lastName" name="lastName" required>
          </div>
          <div class="form-group">
            <label for="age">Age *</label>
            <input type="number" id="age" name="age" min="1" max="150" required>
          </div>
        </div>
      </div>

      <!-- Address Information Section -->
      <div class="form-section">
        <h3 class="section-title">
          <i class="fas fa-map-marker-alt"></i>
          Address Information
        </h3>
        <div class="form-grid">
          <div class="form-group">
            <label for="houseNumber">House Number</label>
            <input type="text" id="houseNumber" name="houseNumber">
          </div>
          <div class="form-group">
            <label for="street">Street</label>
            <input type="text" id="street" name="street">
          </div>
          <div class="form-group">
            <label for="barangay">Barangay *</label>
            <select id="barangay" name="barangay" required>
              <option value="" disabled selected>Select Barangay</option>
              <option>Alegria</option>
              <option>Balante</option>
              <option>Bugho</option>
              <option>Campina</option>
              <option>Canwhaton</option>
              <option>Caridad Norte</option>
              <option>Caridad Sur</option>
              <option>Cuatro de Agosto</option>
              <option>Dita</option>
              <option>Hinalaan</option>
              <option>Hindang</option>
              <option>Iniguihan</option>
              <option>Macopa</option>
              <option>San Andres</option>
              <option>San Pablo</option>
              <option>San Roque</option>
              <option>Santo Niño</option>
              <option>Sta. Cruz</option>
              <option>Taglibas</option>
              <option>Veloso</option>
            </select>
          </div>
          <div class="form-group">
            <label for="municipality">Municipality *</label>
            <input type="text" id="municipality" name="municipality" value="Julita" readonly>
          </div>
          <div class="form-group">
            <label for="province">Province *</label>
            <input type="text" id="province" name="province" value="Leyte" readonly>
          </div>
        </div>
      </div>

      <!-- Contact Information Section -->
      <div class="form-section">
        <h3 class="section-title">
          <i class="fas fa-phone"></i>
          Contact Information
        </h3>
        <div class="form-grid">
          <div class="form-group">
            <label for="contactNumber">Contact Number *</label>
            <input type="tel" id="contactNumber" name="contactNumber" pattern="[0-9]{11}" maxlength="11" required>
          </div>
          <div class="form-group">
            <label for="school">School/Institution</label>
            <input type="text" id="school" name="school">
          </div>
        </div>
      </div>

      <div class="modal-actions">
        <button type="button" class="btn btn-secondary" onclick="closeJulitaRegisterModal()">
          <i class="fas fa-times"></i>
          Cancel
        </button>
        <button type="button" class="btn btn-primary" onclick="submitRegister()">
          <i class="fas fa-save"></i>
          Register Member
        </button>
      </div>
    </form>
  </div>
</div>

  <!-- Edit Member Modal -->
  <div class="modal" id="editModal">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">
          <i class="fas fa-edit"></i>
          Edit Member Information
        </h2>
        <button class="close-modal" onclick="closeEditModal()">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <form id="editForm">
        <input type="hidden" id="editMemberId" name="memberId">
        
        <!-- Personal Information Section -->
        <div class="form-section">
          <h3 class="section-title">
            <i class="fas fa-user"></i>
            Personal Information
          </h3>
          <div class="form-grid">
            <div class="form-group">
              <label for="editFirstName">First Name *</label>
              <input type="text" id="editFirstName" name="firstName" required>
            </div>
            <div class="form-group">
              <label for="editMiddleName">Middle Name</label>
              <input type="text" id="editMiddleName" name="middleName">
            </div>
            <div class="form-group">
              <label for="editLastName">Last Name *</label>
              <input type="text" id="editLastName" name="lastName" required>
            </div>
            <div class="form-group">
              <label for="editAge">Age *</label>
              <input type="number" id="editAge" name="age" min="1" max="150" required>
            </div>
          </div>
        </div>

        <!-- Address Information Section -->
        <div class="form-section">
          <h3 class="section-title">
            <i class="fas fa-map-marker-alt"></i>
            Address Information
          </h3>
          <div class="form-grid">
            <div class="form-group">
              <label for="editHouseNumber">House Number</label>
              <input type="text" id="editHouseNumber" name="houseNumber">
            </div>
            <div class="form-group">
              <label for="editStreet">Street</label>
              <input type="text" id="editStreet" name="street">
            </div>
            <div class="form-group">
              <label for="editBarangay">Barangay *</label>
              <input type="text" id="editBarangay" name="barangay" required>
            </div>
            <div class="form-group">
              <label for="editMunicipality">Municipality/City *</label>
              <input type="text" id="editMunicipality" name="municipality" required>
            </div>
            <div class="form-group">
              <label for="editProvince">Province *</label>
              <input type="text" id="editProvince" name="province" required>
            </div>
          </div>
        </div>

        <!-- Contact Information Section -->
        <div class="form-section">
          <h3 class="section-title">
            <i class="fas fa-phone"></i>
            Contact Information
          </h3>
          <div class="form-grid">
            <div class="form-group">
              <label for="editContactNumber">Contact Number *</label>
              <input type="tel" id="editContactNumber" name="contactNumber" pattern="[0-9]{11}" maxlength="11" required>
            </div>
            <div class="form-group">
              <label for="editSchool">School/Institution</label>
              <input type="text" id="editSchool" name="school">
            </div>
          </div>
        </div>
          
        <div class="modal-actions">
          <button type="button" class="btn btn-danger" 
    @if(!isset($member)) disabled @endif 
    onclick="deleteMember({{ $member->id ?? 0 }})">
    Delete
</button>
          <button type="button" class="btn btn-secondary" onclick="closeEditModal()">
            <i class="fas fa-times"></i>
            Cancel
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- QR Code Modal -->
  <div class="qr-modal" id="qrModal">
    <div class="qr-content">
      <h3 id="qrTitle">Member QR Code</h3>
      <img id="qrImage" src="" alt="QR Code" style="display: none;">
      <div style="margin-top: 1.5rem;">
        <button class="btn btn-success" id="downloadQR" style="margin-right: 10px;">
          <i class="fas fa-download"></i>
          Download
        </button>
        <button class="btn btn-secondary" onclick="closeQRModal()">
          <i class="fas fa-times"></i>
          Close
        </button>
      </div>
    </div>
  </div>
<div id="cardPreviewModal" class="modal" style="display: none;">
  <div class="modal-content" style="width: 90%; max-width: 800px;">
    <div class="modal-header">
      <h2 class="modal-title">
        <i class="fas fa-id-card"></i> Membership ID Card
      </h2>
      <button class="close-modal" onclick="closeCardPreviewModal()">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <div class="modal-body" style="text-align: center;">
      <iframe id="cardPreviewFrame" src="" width="100%" height="500px" frameborder="0"></iframe>
    </div>

    <div class="modal-actions" style="text-align: right; margin-top: 10px;">
      <a id="downloadCardBtn" href="#" download target="_blank" class="btn btn-success">
        <i class="fas fa-download"></i> Download Card
      </a>
      <button onclick="closeCardPreviewModal()" class="btn btn-secondary">
        <i class="fas fa-times"></i> Close
      </button>
    </div>
  </div>
</div>
<script>function showCardPreviewModal(cardUrl) {
  document.getElementById("cardPreviewFrame").src = cardUrl;
  document.getElementById("downloadCardBtn").href = cardUrl;
  document.getElementById("cardPreviewModal").style.display = "block";
}

function closeCardPreviewModal() {
  document.getElementById("cardPreviewModal").style.display = "none";
  document.getElementById("cardPreviewFrame").src = "";
}
</script>
  <script>
    // Dark mode functionality
    const darkToggle = document.getElementById('darkModeToggle');
    
    // Initialize dark mode on page load
    document.addEventListener('DOMContentLoaded', function() {
      const darkMode = localStorage.getItem('darkMode') === 'true';
      if (darkMode) {
        document.body.classList.add('dark-mode');
        darkToggle.checked = true;
      }
    });

    // Dark mode toggle event listener
    darkToggle.addEventListener('change', function() {
      document.body.classList.toggle('dark-mode');
      localStorage.setItem('darkMode', this.checked);
    });

    // Sidebar toggle functionality
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleBtn = document.getElementById('toggleSidebar');

    toggleBtn.addEventListener('click', function() {
      sidebar.classList.toggle('collapsed');
      mainContent.classList.toggle('collapsed');
    });
  </script>
  
  <!-- External Scripts -->
  <script src="js/membersearch.js"></script>
  <script src="js/memberscript.js"></script>
  <script src="js/memberedit.js"></script>
  <script src="{{ asset('js/sidebarcollapse.js') }}"></script>
  <script src="{{ asset('js/showqr.js') }}"></script>
</body>
</html>