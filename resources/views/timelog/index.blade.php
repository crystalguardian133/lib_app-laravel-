<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>🕒 Member Time Logs | Ormoc City Library</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    :root {
      --primary: #004080;
      --accent: #007bff;
      --light: #f4f7fa;
      --white: #ffffff;
      --dark: #1f2937;
      --highlight: #d2e4ff;
      --danger: #dc3545;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      background: var(--light);
    }

    header {
      background-color: var(--primary);
      color: white;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    header h1 {
      font-size: 1.5rem;
    }

    nav a {
      color: white;
      margin-left: 1.5rem;
      text-decoration: none;
      font-weight: 500;
    }

    .container {
      padding: 2rem;
      background: white;
      margin: 2rem auto;
      max-width: 800px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: var(--primary);
    }

    #memberInput {
      width: 100%;
      padding: 10px;
      font-size: 1rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-bottom: 1rem;
    }

    #suggestionBox {
      position: relative;
      background: white;
      border: 1px solid #ccc;
      max-height: 150px;
      overflow-y: auto;
      border-radius: 6px;
      z-index: 1000;
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
      margin-top: 1rem;
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: var(--primary);
      color: white;
    }

    button.logout {
      background: var(--danger);
      border: none;
      color: white;
      padding: 6px 12px;
      border-radius: 6px;
      cursor: pointer;
    }

    .corner-popup {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: #007bff;
      color: white;
      padding: 10px 16px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
      z-index: 1000;
    }
    .modal { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:999; }
    .modal-content { background:var(--white); padding:2rem; border-radius:12px; width:90%; max-width:800px; }
    .modal-content h3 { margin-top:0; color:var(--primary); }
    .modal-content label { display:block; margin-top:1rem; font-weight:bold; }
    .modal-content input { width:100%; padding:0.5rem; margin-top:0.5rem; border:1px solid #ccc; border-radius:6px; }
    .actions { margin-top:2rem; display:flex; justify-content:flex-end; gap:1rem; }
    .actions .cancel { background:#ccc; color:#333; border:none; padding:0.5rem 1rem; border-radius:6px; cursor:pointer; }
    .actions .submit { background:var(--accent); color:white; border:none; padding:0.5rem 1rem; border-radius:6px; cursor:pointer; }

    .top-controls { display:flex; flex-wrap:wrap; justify-content:center; gap:1rem; margin:1rem 0; }
    .top-controls input { padding:8px 12px; font-size:1rem; border:1px solid #ccc; border-radius:6px; width:300px; }
    .top-controls button { background:var(--accent); color:var(--white); padding:8px 16px; border:none; border-radius:8px; font-weight:600; font-size:1rem; display:flex; align-items:center; gap:0.5rem; cursor:pointer; }
    .top-controls button:hover { background:#0056b3; }
    .table-container { overflow-x:auto; margin-top:1rem; }
  </style>
</head>
<body>

<header>
  <h1>🕒 Member Time Log</h1>
  <nav>
    <a href="/dashboard">🏠 Dashboard</a>
    <a href="/members">👥 Manage Members</a>
    <a href="/books">📘 Manage Books</a>
  </nav>
</header>

<div class="container">
  <h2>📅 Time In / Time Out</h2>
  <div class="top-controls">
  <input type="text" id="memberInput" placeholder="Start typing member name..." autocomplete="off">
  <div id="suggestionBox"></div>
    <button id="registerBtn" onclick="openRegisterModal()"><i class="fas fa-user-plus"></i> Register User</button>
  </div>
  <table id="logTable">
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
      <tr data-id="{{ $log->id }}">
        <td>{{ $log->member->name }}</td>
        <td>{{ $log->member->school }}</td>
        <td>{{ \Carbon\Carbon::parse($log->time_in)->format('h:i A') }}</td>
        <td><button class="logout" onclick="timeOut({{ $log->id }}, this)">Time Out</button></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="modal" id="registerModal">
  <div class="modal-content">
    <h3>Register New Member</h3>
    <label for="name">Full Name</label>
    <input type="text" id="name" name="name" placeholder="Enter full name">

    <label for="age">Age</label>
    <input type="number" id="age" name="age" placeholder="Enter age">

    <label for="address">Address</label>
    <input type="text" id="address" name="address" placeholder="Enter address">

    <label for="contactnumber">Contact Number</label>
    <input type="text" id="contactnumber" name="contactnumber" placeholder="09XXXXXXXXX" maxlength="11" pattern="\d{11}"oninput="this.value = this.value.replace(/\D/g, '')" required >


    <label for="school">School</label>
    <input type="text" id="school" name="school" placeholder="Enter school">

    <div class="actions">
      <button class="cancel" onclick="closeRegisterModal()">Cancel</button>
      <button class="submit" onclick="submitRegister()">Submit</button>
    </div>
  </div>
</div>

<div class="corner-popup" id="popup" style="display:none;"></div>

<script src="{{asset('js/timelog.js') }}"></script>
<script src="{{asset('js/memberscript.js')}}"></script>


</body>
</html>
