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
    --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 
              0 10px 10px -5px rgba(0, 0, 0, 0.04);
    --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    --border-radius: 18px;
    --border-radius-sm: 10px;
    --transition: all 0.3s ease-in-out;
}

/* Global Reset */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

/* Body */
body {
    margin: 0;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: linear-gradient(135deg, var(--light) 0%, #f0f9ff 100%);
    color: var(--dark);
    transition: var(--transition);
    min-height: 100vh;
    overflow-x: hidden;
}

body.dark-mode {
    background: linear-gradient(135deg, var(--bg-dark) 0%, #0c1426 100%);
    color: var(--text-dark);
}

/* Sidebar */
.sidebar {
    width: 260px;
    background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: var(--white);
    height: 100vh;
    padding: 1.5rem 1rem;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    transition: var(--transition);
    display: flex;
    flex-direction: column;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.25);
    backdrop-filter: blur(12px);
}

.sidebar-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 2rem;
}

.sidebar-header .logo {
    width: 38px;
    height: 38px;
    object-fit: contain;
    border-radius: 6px;
}

.sidebar.collapsed {
    width: 80px;
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
    gap: 12px;
    color: var(--white);
    text-decoration: none;
    padding: 12px 14px;
    border-radius: var(--border-radius-sm);
    margin-bottom: 8px;
    transition: var(--transition);
    font-weight: 500;
}

.sidebar nav a:hover {
    background: var(--accent);
    transform: translateX(5px);
}

.sidebar nav a.active {
    background: var(--accent-light);
    color: var(--dark);
    font-weight: 600;

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
  background-color: rgba(255, 255, 255, 0.2);
  transition: 0.4s;
  border-radius: 34px;
  box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Circle knob */
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
  font-size: 14px;
  transition: 0.4s;
  box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

/* When checked */
input:checked + .slider {
  background-color: var(--accent);
}

input:checked + .slider:before {
  transform: translateX(24px);
  content: "🌙";
}

/* Toggle Button */
.toggle-btn {
    margin: 0 auto 1.5rem auto;
    background: var(--accent);
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
    background: var(--accent-light);
    color: var(--dark);
    transform: scale(1.05);
}

/* Main */
.main {
    margin-left: 260px;
    padding: 2rem;
    flex-grow: 1;
    transition: var(--transition);
    min-width: calc(100% - 260px);
    animation: fadeInUp 0.6s ease-out;
}

.main.full {
    margin-left: 80px;
    min-width: calc(100% - 80px);
}

.heading {
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: 700;
    font-size: 2.2rem;
    margin-bottom: 2rem;
    animation: fadeInDown 0.6s ease-out;
}

/* Cards */
.stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.card {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(18px);
    padding: 1.5rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

body.dark-mode .card {
    background: rgba(30, 41, 59, 0.75);
    border: 1px solid rgba(51, 65, 85, 0.4);
}

.card::before {
    content: "";
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle at center, rgba(255,255,255,0.15) 0%, transparent 60%);
    transform: rotate(25deg);
    opacity: 0;
    transition: opacity 0.4s;
}

.card:hover::before {
    opacity: 1;
}

.card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: var(--shadow-lg);
}

.card h3 {
    font-size: 1rem;
    color: var(--gray);
    margin-bottom: 0.6rem;
}

.card .count {
    font-size: 2rem;
    font-weight: bold;
    color: var(--primary-dark);
}

body.dark-mode .count {
    color: var(--accent-light);
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
    box-shadow: var(--shadow);
}

body.dark-mode canvas {
    background: rgba(30, 41, 59, 0.85);
    border: 1px solid rgba(51, 65, 85, 0.4);
}

#chatbot-button {
  position: fixed;
  bottom: 24px;
  right: 24px;
  width: 56px;
  height: 56px;
  display: grid;
  place-items: center;
  background: linear-gradient(135deg, var(--accent) 0%, var(--primary) 100%);
  color: #fff;
  border: none;
  border-radius: 50%;
  box-shadow: 0 12px 30px rgba(0,0,0,0.25);
  cursor: pointer;
  z-index: 2200; /* above sidebar/cards */
  transition: transform .2s ease, box-shadow .2s ease, opacity .2s ease;
}
#chatbot-button:hover { transform: scale(1.06); box-shadow: 0 16px 36px rgba(0,0,0,0.28); }
#chatbot-button:active { transform: scale(0.98); }

/* Window */
#chatbot-window {
  position: fixed;
  bottom: 96px;
  right: 24px;
  width: 360px;
  max-width: calc(100vw - 48px);
  background: rgba(255,255,255,0.92);
  backdrop-filter: blur(14px);
  -webkit-backdrop-filter: blur(14px);
  border: 1px solid rgba(0,0,0,0.08);
  border-radius: 16px;
  box-shadow: var(--shadow-lg);
  display: none;         /* your JS toggles this */
  flex-direction: column;
  overflow: hidden;
  z-index: 2300;         /* above button */
  animation: chatSlideUp .25s ease;
}
#chatbot-window.show { display: flex; } /* optional: if your JS uses a 'show' class */

/* Header */
#chatbot-header {
  background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
  color: #fff;
  padding: 12px 14px;
  font-weight: 600;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
#chatbot-close {
  background: rgba(255,255,255,0.18);
  border: none;
  color: #fff;
  font-size: 18px;
  width: 32px;
  height: 32px;
  border-radius: 8px;
  cursor: pointer;
  transition: background .2s ease, transform .2s ease;
}
#chatbot-close:hover { background: rgba(255,255,255,0.28); transform: rotate(90deg); }

/* Messages */
#chatbot-messages {
  height: 300px;
  overflow-y: auto;
  padding: 12px;
  background: #f8fafc;
  scrollbar-width: thin;
}
#chatbot-messages::-webkit-scrollbar { width: 8px; }
#chatbot-messages::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.15); border-radius: 8px; }

/* Input Row */
#chatbot-input {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 12px;
  background: rgba(255,255,255,0.8);
  border-top: 1px solid rgba(0,0,0,0.06);
}
#chatbot-user-input {
  flex: 1;
  padding: 10px 12px;
  font-size: .95rem;
  border: 2px solid #e5e7eb;
  border-radius: 12px;
  background: #fff;
  transition: border-color .2s ease, box-shadow .2s ease;
}
#chatbot-user-input:focus {
  outline: none;
  border-color: var(--accent);
  box-shadow: 0 0 0 4px rgba(6,182,212,0.12);
}
#chatbot-send {
  padding: 10px 14px;
  font-weight: 600;
  border: none;
  border-radius: 12px;
  background: linear-gradient(135deg, var(--accent) 0%, #2563eb 100%);
  color: #fff;
  cursor: pointer;
  transition: transform .15s ease, box-shadow .15s ease, opacity .15s ease;
}
#chatbot-send:hover { transform: translateY(-1px); box-shadow: 0 8px 18px rgba(0,0,0,0.18); }
#chatbot-send:active { transform: translateY(0); }

.dark-mode-toggle {
  position: relative;
  width: 50px;
  height: 26px;
  -webkit-appearance: none;
  appearance: none;
  background: var(--secondary);
  border-radius: 50px;
  cursor: pointer;
  outline: none;
  transition: background 0.3s ease-in-out;
}

.dark-mode-toggle:checked {
  background: var(--accent);
}

.dark-mode-toggle::before {
  content: "";
  position: absolute;
  top: 3px;
  left: 3px;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background: var(--light);
  transition: transform 0.3s ease-in-out;
}

.dark-mode-toggle:checked::before {
  transform: translateX(24px);
}
/* Dark Mode */
body.dark-mode #chatbot-window {
  background: rgba(15,23,42,0.92);
  border-color: rgba(51,65,85,0.45);
}
body.dark-mode #chatbot-messages { background: var(--hover-dark); color: var(--text-dark); }
body.dark-mode #chatbot-input { background: rgba(15,23,42,0.8); border-top-color: rgba(51,65,85,0.45); }
body.dark-mode #chatbot-user-input {
  background: var(--bg-dark);
  border-color: #475569;
  color: var(--text-dark);
}
body.dark-mode #chatbot-user-input:focus {
  border-color: var(--accent);
  box-shadow: 0 0 0 4px rgba(6,182,212,0.16);
}
body.dark-mode #chatbot-send { background: linear-gradient(135deg, var(--accent) 0%, var(--primary) 100%); }

/* Mobile tweaks */
@media (max-width: 520px) {
  #chatbot-window {
    right: 12px;
    left: 12px;
    width: auto;
    bottom: 84px;
    border-radius: 14px;
  }
  #chatbot-button { bottom: 16px; right: 16px; width: 54px; height: 54px; }
}

/* Animation */
@keyframes chatSlideUp {
  from { transform: translateY(10px); opacity: 0; }
  to   { transform: translateY(0); opacity: 1; }
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
    <script src="{{ asset('js/overdue.js') }}"></script>
</body>
</html>