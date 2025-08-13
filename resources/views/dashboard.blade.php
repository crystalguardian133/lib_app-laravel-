<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>📚 Library Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --accent: #06b6d4;
            --accent-light: #67e8f9;
            --light: #f8fafc;
            --dark: #1e293b;
            --white: #ffffff;
            --gray: #64748b;
            --gray-light: #f1f5f9;
            --bg-dark: #0f172a;
            --text-dark: #e2e8f0;
            --hover-dark: #1e293b;
            --danger: #ef4444;
            --success: #10b981;
            --warning: #f59e0b;
            --highlight: #e0e7ff;
            --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --border-radius: 16px;
            --border-radius-sm: 8px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            display: flex;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, var(--light) 0%, #f0f9ff 100%);
            color: var(--dark);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            overflow-x: hidden;
        }

        body.dark-mode {
            background: linear-gradient(135deg, var(--bg-dark) 0%, #0c1426 100%);
            color: var(--text-dark);
        }

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
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
            width: 70px;
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

        .toggle-btn {
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

        /* Main Content Styles */
        .main {
            margin-left: 260px;
            padding: 2rem;
            flex-grow: 1;
            transition: margin-left 0.3s ease;
            min-width: calc(100% - 260px);
        }

        body.dark-mode .main {
            margin-left: 260px;
            padding: 2rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            animation: fadeInUp 0.6s ease-out;
        }

        body.dark-mode .main.full {
            margin-left: 80px;
        }

        .main.full {
            margin-left: 80px;
            min-width: calc(100% - 80px);
        }

        .heading {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 2rem;
            animation: fadeInDown 0.6s ease-out;
        }

        body.dark-mode .heading {
            color: var(--accent-light);
        }

        /* Card and Stats Styles */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            padding: 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        body.dark-mode .card {
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(51, 65, 85, 0.3);
            color: var(--text-dark);
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .card h3 {
            font-size: 1rem;
            color: var(--gray);
            margin-bottom: 0.5rem;
        }

        body.dark-mode .card h3 {
            color: var(--gray-light);
        }

        .card .count {
            font-size: 2rem;
            font-weight: bold;
        }

        body.dark-mode .count {
            color: var(--accent-light);
        }

        .card.collapsible-card h3 {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .collapse-btn {
            background: none;
            border: none;
            color: inherit;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .card-content {
            margin-top: 0.5rem;
            display: block;
            transition: all 0.3s ease;
        }

        /* Chart Styles */
        .chart-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-top: 2rem;
        }

        canvas {
            background-color: var(--white);
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
        }

        body.dark-mode canvas {
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(51, 65, 85, 0.3);
        }

        /* Dark Mode Toggle */
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

        /* Chatbot Styles */
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
            background: var(--bg-dark);
            border-color: rgba(51, 65, 85, 0.6);
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
            background: var(--hover-dark);
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

        body.dark-mode #chatbot-user-input {
            background: var(--bg-dark);
            border-color: rgba(51, 65, 85, 0.6);
            color: var(--text-dark);
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

        /* Footer */
        footer {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.9rem;
            color: var(--gray);
        }

        body.dark-mode footer {
            color: var(--gray-light);
        }

        /* Media Queries */
        @media (max-width: 900px) {
            .chart-grid {
                grid-template-columns: 1fr;
            }
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
        <div class="sidebar-header">
            <img src="/images/logo.png" alt="Library Logo" class="logo">
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
            <a href="/logout">🚪 Logout</a>
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
            <div class="card collapsible-card">
                <h3>📅 Today</h3>
                <div class="card-content">
                    <div class="count">{{ $dailyCount }}</div>
                    <p>📚 Books Added: {{ $booksToday }}</p>
                    <p>👤 Members Registered: {{ $membersToday }}</p>
                </div>
            </div>

            <div class="card collapsible-card">
                <h3>📆 This Week</h3>
                <div class="card-content">
                    <div class="count">{{ $weeklyCount }}</div>
                    <p>📚 Books Added: {{ $booksThisWeek }}</p>
                    <p>👤 Members Registered: {{ $membersThisWeek }}</p>
                </div>
            </div>

            <div class="card collapsible-card">
                <h3>📊 Lifetime</h3>
                <div class="card-content">
                    <div class="count">{{ $lifetimeCount }}</div>
                    <p>📚 Total Books: {{ $booksCount }}</p>
                    <p>👤 Total Members: {{ $membersCount }}</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer>&copy; {{ date('Y') }} Julita Public Library. All rights reserved.</footer>
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
</body>
</html>