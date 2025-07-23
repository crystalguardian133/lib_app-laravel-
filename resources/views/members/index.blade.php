<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>👥 Members | Julita Public Library </title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    :root {
      --primary: #004080;
      --accent: #007bff;
      --light: #f4f7fa;
      --dark: #1f2937;
      --white: #ffffff;
      --gray: #6b7280;
    }
    * { box-sizing: border-box; }
    body { font-family: 'Segoe UI', sans-serif; margin:0; background:var(--light); color:var(--dark); }
    header { background:var(--primary); color:var(--white); padding:1rem 2rem; display:flex; justify-content:space-between; align-items:center; }
    header h1 { font-size:1.5rem; }
    nav a { color:var(--white); margin-left:1rem; text-decoration:none; font-weight:500; }
    nav a:hover { text-decoration:underline; }
    .container { max-width:1200px; margin:2rem auto; padding:0 2rem; }
    h2 { color:var(--primary); text-align:center; }
    .top-controls { display:flex; flex-wrap:wrap; justify-content:center; gap:1rem; margin:1rem 0; }
    .top-controls input { padding:8px 12px; font-size:1rem; border:1px solid #ccc; border-radius:6px; width:300px; }
    .top-controls button { background:var(--accent); color:var(--white); padding:8px 16px; border:none; border-radius:8px; font-weight:600; font-size:1rem; display:flex; align-items:center; gap:0.5rem; cursor:pointer; }
    .top-controls button:hover { background:#0056b3; }
    .table-container { overflow-x:auto; margin-top:1rem; }
    table { width:100%; border-collapse:collapse; }
    th, td { padding:12px; border-bottom:1px solid #ddd; text-align:left; }
    th { background:var(--primary); color:white; position:sticky; top:0; z-index:2; }
    td img { width:50px; height:50px; border-radius:50%; object-fit:cover; }
    .modal { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:999; }
    .modal-content { background:var(--white); padding:2rem; border-radius:12px; width:90%; max-width:800px; }
    .modal-content h3 { margin-top:0; color:var(--primary); }
    .modal-content label { display:block; margin-top:1rem; font-weight:bold; }
    .modal-content input { width:100%; padding:0.5rem; margin-top:0.5rem; border:1px solid #ccc; border-radius:6px; }
    .actions { margin-top:2rem; display:flex; justify-content:flex-end; gap:1rem; }
    .actions .cancel { background:#ccc; color:#333; border:none; padding:0.5rem 1rem; border-radius:6px; cursor:pointer; }
    .actions .submit { background:var(--accent); color:white; border:none; padding:0.5rem 1rem; border-radius:6px; cursor:pointer; }
  </style>
</head>
<body>
<header>
  <h1><a href="{{route('dashboard') }}"👥 Library Members</h1></a>
  <nav>
    <a href="/dashboard">🏠 Dashboard</a>
    <a href="/books">📚 Books</a>
  </nav>
</header>
<div class="container">
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
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
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

<div class="modal" id="editModal">
  <div class="modal-content">
    <h3>Edit Member Info</h3>
    <input type="hidden" id="edit-id">

    <label for="edit-name">Full Name</label>
    <input type="text" id="edit-name">

    <label for="edit-age">Age</label>
    <input type="number" id="edit-age">

    <label for="edit-address">Address</label>
    <input type="text" id="edit-address">

    <label for="edit-contact">Contact Number</label>
    <input type="text" id="edit-contact" maxlength="11" pattern="\d{11}" oninput="this.value = this.value.replace(/\D/g, '')">

    <label for="edit-school">School</label>
    <input type="text" id="edit-school">

    <div class="actions">
      <button class="cancel" onclick="closeEditModal()">Cancel</button>
      <button class="delete" onclick="deleteMember()">Deletes</button>
      <button class="submit" onclick="updateMember()">Save Changes</button>
    </div>
  </div>
</div>
<script src="js/membersearch.js"></script>
<script src="js/memberscript.js"></script>
<script src="js/memberedit.js"></script>
</body>
</html>
