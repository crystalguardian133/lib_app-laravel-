<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>📚 Library Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    :root {
        --primary: #5b21b6;
        --accent: #0891b2;
        --light: #f9fafb;
        --dark: #0f172a;
        --gray: #6b7280;
        --bg-dark: #0f172a;
        --text-dark: #e2e8f0;
        --white: #ffffff;
        --danger: #ef4444;
        --success: #10b981;
        --warning: #f59e0b;
        --card-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
        --modal-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        --border-radius: 16px;
        --border-radius-sm: 12px;
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
        transition: var(--transition);
        min-height: 100vh;
        overflow-x: hidden;
    }

    body.dark-mode {
        background: var(--bg-dark);
        color: var(--text-dark);
    }

    /* Sidebar */
    .sidebar {
        width: 280px;
        background: var(--white);
        border-right: 1px solid #e5e7eb;
        padding: 1.5rem;
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        transition: width 0.3s ease;
        color: var(--dark);
    }

    body.dark-mode .sidebar {
        background: #1e293b;
        border-color: #334155;
        color: var(--text-dark);
    }

    .sidebar.collapsed {
        width: 80px;
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 2rem;
        transition: var(--transition);
    }

    .sidebar.collapsed .sidebar-header {
        justify-content: center;
    }

    .sidebar-header .logo {
        width: 38px;
        height: 38px;
        object-fit: contain;
        border-radius: 8px;
    }

    .label {
        font-weight: 600;
        color: var(--primary);
    }

    .sidebar.collapsed .label {
        display: none;
    }

    /* Nav links */
    .sidebar nav a {
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--gray);
        text-decoration: none;
        padding: 12px 16px;
        border-radius: var(--border-radius);
        transition: var(--transition);
        font-weight: 500;
    }

    body.dark-mode .sidebar nav a {
        color: var(--text-dark);
    }

    .sidebar nav a:hover {
        background: #f1f5f9;
        color: var(--primary);
    }

    body.dark-mode .sidebar nav a:hover {
        background: #334155;
        color: var(--accent);
    }

    .sidebar nav a.active {
        background: rgba(126, 34, 206, 0.1);
        color: var(--primary);
        font-weight: 600;
    }

    body.dark-mode .sidebar nav a.active {
        background: rgba(126, 34, 206, 0.25);
        color: var(--accent);
    }

    /* Collapsed nav links */
    .sidebar.collapsed nav a {
        justify-content: center;
    }

    .sidebar.collapsed nav a .icon {
        font-size: 1.2rem;
        margin: 0;
    }

    .sidebar.collapsed nav a .label {
        display: none;
    }

    /* Toggle Button */
    .toggle-btn {
        margin: 0 auto 1.5rem auto;
        background: var(--primary);
        color: white;
        border: none;
        padding: 10px 14px;
        font-size: 1.1rem;
        border-radius: var(--border-radius-sm);
        cursor: pointer;
        width: 100%;
        transition: var(--transition);
    }

    .toggle-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    /* Dark Mode Toggle */
    .dark-toggle {
        margin-top: auto;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
    }

    body.dark-mode .dark-toggle {
        border-top-color: #334155;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 58px;
        height: 32px;
        margin-right: 10px;
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
        background: linear-gradient(90deg, #d1d5db, #9ca3af);
        border-radius: 32px;
        transition: 0.3s;
    }

    .slider:before {
        content: "🌞";
        position: absolute;
        height: 26px;
        width: 26px;
        left: 3px;
        bottom: 3px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        transition: 0.3s;
    }

    input:checked + .slider {
        background: linear-gradient(90deg, #7e22ce, #5b21b6);
    }

    input:checked + .slider:before {
        transform: translateX(26px);
        content: "🌙";
    }

    /* Main Content */
    .main {
        margin-left: 280px;
        padding: 2rem;
        flex-grow: 1;
        transition: margin-left 0.3s ease;
        min-width: calc(100% - 280px);
        animation: fadeInUp 0.6s ease-out;
    }

    .main.full {
        margin-left: 80px;
        min-width: calc(100% - 80px);
    }

    .heading {
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 2rem;
        animation: fadeInDown 0.6s ease-out;
    }

    /* Cards */
    .stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: var(--gap);
        margin-top: 2rem;
    }

    .card {
        background: var(--white);
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        padding: 1.5rem;
    }

    body.dark-mode .card {
        background: #1e293b;
    }

    .card:hover {
        transform: translateY(-6px);
        box-shadow: var(--modal-shadow);
    }

    .card h3 {
        font-size: 1rem;
        color: var(--gray);
        margin-bottom: 0.6rem;
    }

    .card .count {
        font-size: 2rem;
        font-weight: bold;
        color: var(--primary);
    }

    /* Charts */
    .chart-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-top: 2rem;
    }

    canvas {
        background: var(--white);
        border-radius: var(--border-radius-sm);
        padding: 1rem;
        margin-top: 1rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border: 1px solid #e5e7eb;
    }

    body.dark-mode canvas {
        background: #1e293b;
        border-color: #475569;
    }

    /* Chatbot */
    #chatbot-button {
        position: fixed;
        bottom: 24px;
        right: 24px;
        width: 56px;
        height: 56px;
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, var(--accent), var(--primary));
        color: #fff;
        border: none;
        border-radius: 50%;
        box-shadow: 0 12px 30px rgba(0,0,0,0.25);
        cursor: pointer;
        z-index: 2200;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    #chatbot-button:hover {
        transform: scale(1.06);
        box-shadow: 0 16px 36px rgba(0,0,0,0.28);
    }

    #chatbot-button:active {
        transform: scale(0.98);
    }

    #chatbot-window {
        position: fixed;
        bottom: 96px;
        right: 24px;
        width: 360px;
        max-width: calc(100vw - 48px);
        background: var(--white);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius);
        box-shadow: var(--modal-shadow);
        display: none;
        flex-direction: column;
        overflow: hidden;
        z-index: 2300;
        animation: chatSlideUp 0.25s ease;
    }

    body.dark-mode #chatbot-window {
        background: #1e293b;
        border-color: #475569;
    }

    #chatbot-header {
        padding: 12px 14px;
        background: var(--primary);
        color: white;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    #chatbot-close {
        background: none;
        border: none;
        color: white;
        font-size: 18px;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    #chatbot-close:hover {
        background: rgba(255,255,255,0.2);
    }

    #chatbot-messages {
        height: 300px;
        overflow-y: auto;
        padding: 12px;
        background: var(--light);
    }

    body.dark-mode #chatbot-messages {
        background: #1e293b;
        color: var(--text-dark);
    }

    #chatbot-messages::-webkit-scrollbar {
        width: 6px;
    }

    #chatbot-messages::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 8px;
    }

    body.dark-mode #chatbot-messages::-webkit-scrollbar-thumb {
        background: #475569;
    }

    #chatbot-input {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px;
        background: var(--light);
        border-top: 1px solid #e5e7eb;
    }

    body.dark-mode #chatbot-input {
        background: #1e293b;
        border-top-color: #475569;
    }

    #chatbot-user-input {
        flex: 1;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.95rem;
        background: white;
        transition: border-color 0.2s ease;
        color: var(--dark);
    }

    body.dark-mode #chatbot-user-input {
        background: #0f172a;
        border-color: #475569;
        color: var(--text-dark);
    }

    #chatbot-user-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(126, 34, 206, 0.2);
    }

    #chatbot-send {
        padding: 10px 14px;
        border: none;
        border-radius: 8px;
        background: var(--accent);
        color: white;
        font-weight: 500;
        cursor: pointer;
        transition: transform 0.15s ease;
    }

    #chatbot-send:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(0,0,0,0.18);
    }

    #chatbot-send:active {
        transform: translateY(0);
    }

    /* Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes chatSlideUp {
        from { transform: translateY(10px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    /* Mobile */
    @media (max-width: 768px) {
        .sidebar {
            width: 80px;
            padding: 1rem;
        }
        .sidebar-header .label, .label {
            display: none;
        }
        .main, .main.full {
            margin-left: 80px;
            min-width: calc(100% - 80px);
            padding: 1.5rem;
        }
        #chatbot-window {
            width: calc(100vw - 32px);
            left: 16px;
            right: 16px;
            bottom: 84px;
            border-radius: 14px;
        }
        #chatbot-button {
            bottom: 16px;
            right: 16px;
            width: 54px;
            height: 54px;
        }
    }
</style>

</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="/images/logo.png" alt="Library Logo" class="logo">
            <span class="label">Julita Public Library</span>
        </div>
        <button class="toggle-btn" id="toggleSidebar">☰</button>
        <nav>
            <a href="{{ route('dashboard') }}" class="active">
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
            <a href="/logout" style="color: var(--gray); text-decoration: none; margin-left: 6px;">🚪 Logout</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main" id="mainContent">
        <div class="heading">Dashboard Overview</div>

        <!-- Stats Cards -->
        <div class="stats">
            <div class="card">
                <h3>Total Books</h3>
                <div class="count">{{ $booksCount }}</div>
            </div>
            <div class="card">
                <h3>Total Members</h3>
                <div class="count">{{ $membersCount }}</div>
            </div>
            <div class="card">
                <h3>Total Transactions</h3>
                <div class="count">{{ $transactionsCount }}</div>
            </div>
        </div>

        <!-- Chart Grid -->
        <div class="chart-grid">
            <div class="card">
                <h3>📈 Transactions (Last 7 Days)</h3>
                <canvas id="transactionsChart" height="120"></canvas>
            </div>
            <div class="card">
                <h3>👣 Average Daily Visits (Past 7 Days)</h3>
                <canvas id="visitsChart" height="120"></canvas>
            </div>
        </div>

        <!-- Time-based Statistics -->
        <div class="stats" style="margin-top: 2rem;">
            <div class="card">
                <h3>📅 Today</h3>
                <div class="count">{{ $dailyCount }}</div>
                <p>📚 Books Added: {{ $booksToday }}</p>
                <p>👤 Members Registered: {{ $membersToday }}</p>
            </div>

            <div class="card">
                <h3>📆 This Week</h3>
                <div class="count">{{ $weeklyCount }}</div>
                <p>📚 Books Added: {{ $booksThisWeek }}</p>
                <p>👤 Members Registered: {{ $membersThisWeek }}</p>
            </div>

            <div class="card">
                <h3>📊 Lifetime</h3>
                <div class="count">{{ $lifetimeCount }}</div>
                <p>📚 Total Books: {{ $booksCount }}</p>
                <p>👤 Total Members: {{ $membersCount }}</p>
            </div>
        </div>

        <!-- Footer -->
        <footer style="margin-top: 3rem; text-align: center; color: var(--gray); font-size: 0.9rem;">
            &copy; {{ date('Y') }} Julita Public Library. All rights reserved.
        </footer>
    </div>

    <!-- Chatbot -->
    <button id="chatbot-button">💬</button>
    <div id="chatbot-window">
        <div id="chatbot-header">
            <span>Chatbot</span>
            <button id="chatbot-close">×</button>
        </div>
        <div id="chatbot-messages"></div>
        <div id="chatbot-input">
            <input type="text" id="chatbot-user-input" placeholder="Ask me anything..." />
            <button id="chatbot-send">Send</button>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        const chartData = @json($last7Days);
        const visitsData = @json($visitsData);
    </script>
    <script src="{{ asset('js/dashb.js') }}"></script>
    <script src="{{ asset('js/chatbot.js') }}"></script>
    <script src="{{ asset('js/overdue.js') }}"></script>

<script>
    // Toggle Sidebar
    document.getElementById('toggleSidebar').addEventListener('click', () => {
        const sidebar = document.getElementById('sidebar');
        const main = document.getElementById('mainContent');
        sidebar.classList.toggle('collapsed');
        main.classList.toggle('full');
    });

    // Dark Mode Toggle
    const darkModeToggle = document.getElementById('darkModeToggle');

    // Apply saved dark mode preference on load
    if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
        darkModeToggle.checked = true;
    }

    // Toggle dark mode on switch
    darkModeToggle.addEventListener('change', () => {
        document.body.classList.toggle('dark-mode', darkModeToggle.checked);
        localStorage.setItem('darkMode', darkModeToggle.checked);
    });

    // Chatbot Toggle (fix: don't override "window")
    const chatbotWindow = document.getElementById('chatbot-window');
    document.getElementById('chatbot-button').addEventListener('click', () => {
        chatbotWindow.style.display = chatbotWindow.style.display === 'flex' ? 'none' : 'flex';
        if (chatbotWindow.style.display === 'flex') {
            chatbotWindow.style.display = 'flex';
            chatbotWindow.style.flexDirection = 'column';
        }
    });

    document.getElementById('chatbot-close').addEventListener('click', () => {
        chatbotWindow.style.display = 'none';
    });
</script>

</body>
</html>