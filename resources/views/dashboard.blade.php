<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>📚 Library Admin Dashboard</title>
  <style>
    :root {
      --primary: #004080;
      --accent: #007bff;
      --light: #f4f7fa;
      --dark: #1f2937;
      --white: #ffffff;
      --gray: #6b7280;
      --bg-dark: #121212;
      --text-dark: #e5e5e5;
    }

    body {
      margin: 0;
      display: flex;
      font-family: 'Segoe UI', sans-serif;
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
    }

    .sidebar.collapsed {
      width: 60px;
    }

    .sidebar h2,
    .sidebar .label {
      transition: opacity 0.3s, transform 0.3s;
    }

    .sidebar.collapsed h2 {
  opacity: 0;
  transform: translateX(-100%);
  pointer-events: none;
  text-align: center;
}

.sidebar.collapsed .label {
  display: none;
}

.sidebar nav a {
  display: flex;
  align-items: center;
  color: var(--white);
  text-decoration: none;
  padding: 12px;
  margin: 6px 0;
  border-radius: 6px;
  transition: background 0.2s, justify-content 0.3s;
}

.sidebar.collapsed nav a {
  justify-content: center;
}

    .sidebar nav a:hover {
      background-color: var(--accent);
    }

    .sidebar nav a .icon {
      margin-right: 10px;
      font-size: 1.2rem;
      min-width: 24px;
      text-align: center;
    }

    .sidebar .toggle-btn {
      display: block;
      margin: 0 auto 1.5rem auto;
      background: #003366;
      color: white;
      border: none;
      padding: 8px 14px;
      font-size: 1.2rem;
      border-radius: 4px;
      cursor: pointer;
      width: 70%;
      transition: background 0.3s ease;
      text-align: center;
    }

    .sidebar .toggle-btn:hover {
      background-color: #0056b3;
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
      font-size: 2rem;
      margin-bottom: 1.5rem;
    }

    .stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
    }

    .card {
      background: var(--white);
      padding: 1.5rem;
      border-radius: 10px;
      border-left: 5px solid var(--accent);
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    body.dark-mode .card {
      background-color: #1e1e1e;
      color: var(--text-dark);
    }

    .card h3 {
      font-size: 1rem;
      color: var(--gray);
    }

    .card .count {
      font-size: 2rem;
      font-weight: bold;
    }

    footer {
      text-align: center;
      margin-top: 2rem;
      font-size: 0.9rem;
      color: var(--gray);
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
      background-color: #333;
    }

    input:checked + .slider:before {
      transform: translateX(24px);
      content: "🌙";
    }

    /* Chatbot Button */
    #chatbot-button {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: var(--accent);
      color: white;
      border: none;
      border-radius: 50%;
      padding: 0.9rem 1rem;
      font-size: 1.5rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
      cursor: pointer;
      z-index: 999;
    }

    #chatbot-window {
      position: fixed;
      bottom: 90px;
      right: 20px;
      width: 320px;
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      display: none;
      flex-direction: column;
      z-index: 1000;
      overflow: hidden;
    }

    #chatbot-header {
      background-color: var(--primary);
      color: white;
      padding: 10px;
      font-weight: bold;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    #chatbot-messages {
      height: 250px;
      overflow-y: auto;
      padding: 10px;
      background-color: #f9f9f9;
    }

    #chatbot-input {
      display: flex;
      padding: 10px;
      border-top: 1px solid #ddd;
    }

    #chatbot-user-input {
      flex-grow: 1;
      padding: 6px;
      font-size: 0.9rem;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    #chatbot-send {
      margin-left: 5px;
      padding: 6px 12px;
      background-color: var(--accent);
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    @media (max-width: 768px) {
      .main {
        margin-left: 60px;
      }
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
  <h2>📚 <span class="label">Julita Public Library</span></h2>
  <button class="toggle-btn" id="toggleSidebar">☰</button>
  <nav>
    <a href="{{ route('dashboard') }}"><span class="icon">🏠</span><span class="label">Dashboard</span></a>
    <a href="{{ route('books.index') }}"><span class="icon">📘</span><span class="label">Manage Books</span></a>
    <a href="{{ route('members.index') }}"><span class="icon">👥</span><span class="label">Manage Members</span></a>
    <a href="{{ route('transactions.index') }}"><span class="icon">📃</span><span class="label">Manage Transactions</span></a>
    <a href="{{ route('computers.index') }}"><span class="icon">🖥️</span><span class="label">Manage Computers</span></a>
  </nav>
  <div class="dark-toggle">
    <label class="switch">
      <input type="checkbox" id="darkModeToggle">
      <span class="slider"></span>
    </label>
    <div style="margin-top: 1rem;">
      <a href="/logout" style="color: #fff; text-decoration: underline;">🚪 Logout</a>
    </div>
  </div>
</div>

<!-- Main -->
<div class="main" id="mainContent">
  <div class="heading">Dashboard Overview</div>
  <div class="stats">
    <div class="card"><h3>Total Books</h3><div class="count">{{ $booksCount }}</div></div>
    <div class="card"><h3>Total Members</h3><div class="count">{{ $membersCount }}</div></div>
    <div class="card"><h3>Total Transactions</h3><div class="count">{{ $transactionsCount }}</div></div>
  </div>
  <footer>&copy; {{ date('Y') }} Julita Public Library. All rights reserved.</footer>
</div>

<!-- Chatbot -->
<div id="chatbot-button">💬</div>
<div id="chatbot-window">
  <div id="chatbot-header"><span>Library Assistant</span><button id="chatbot-close">×</button></div>
  <div id="chatbot-messages"></div>
  <div id="chatbot-input">
    <input type="text" id="chatbot-user-input" placeholder="Ask a question..." />
    <button id="chatbot-send">Send</button>
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
</script>
<script src="{{ asset('js/chatbot.js') }}"></script>
</body>
</html>
