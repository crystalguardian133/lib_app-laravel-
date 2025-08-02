<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>📚 Library Admin Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
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

    body {
      margin: 0;
      display: flex;
      font-family: 'Inter', 'Segoe UI', sans-serif;
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
      font-weight: 600;
    }

    .stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 1.5rem;
    }

    .card {
      background: var(--white);
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      transition: background-color 0.3s ease;
    }

    .card h3 {
      font-size: 1rem;
      color: var(--gray);
      margin-bottom: 0.5rem;
    }

    .card .count {
      font-size: 2rem;
      font-weight: bold;
    }

    body.dark-mode .card {
      background-color: #1e293b;
      color: var(--text-dark);
    }

    footer {
      text-align: center;
      margin-top: 2rem;
      font-size: 0.9rem;
      color: var(--gray);
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

    .dark-toggle a {
      display: block;
      margin-top: 1rem;
      color: #e0e0e0;
      font-size: 0.85rem;
      text-decoration: underline;
    }

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
      background: white;
      border: 1px solid #ccc;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      display: none;
      flex-direction: column;
      z-index: 1000;
      overflow: hidden;
    }

    body.dark-mode #chatbot-window {
      background-color: #1e293b;
      color: var(--text-dark);
      border: 1px solid #475569;
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

    body.dark-mode #chatbot-messages {
      background-color: #0f172a;
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
<div class="sidebar" id="sidebar">
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
  <div class="heading">Dashboard Overview</div>
  <div class="stats">
    <div class="card"><h3>Total Books</h3><div class="count">{{ $booksCount }}</div></div>
    <div class="card"><h3>Total Members</h3><div class="count">{{ $membersCount }}</div></div>
    <div class="card"><h3>Total Transactions</h3><div class="count">{{ $transactionsCount }}</div></div>
  </div>
  <footer>&copy; {{ date('Y') }} Julita Public Library. All rights reserved.</footer>
</div>

<!-- Chatbot -->
<button id="chatbot-button">💬</button>
<div id="chatbot-window">
  <div id="chatbot-header"><span>Chatbot</span><button id="chatbot-close">×</button></div>
  <div id="chatbot-messages"></div>
  <div id="chatbot-input">
    <input type="text" id="chatbot-user-input" placeholder="Ask me anything..." />
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
<script src="js/chatbot.js"></script>
</body>
</html>
