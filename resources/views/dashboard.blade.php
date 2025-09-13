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
    /* Shared Color Palette */
    --primary: #2fb9eb;           /* Indigo */
    --primary-dark: #4f46e5;
    --secondary: #8b5cf6;         /* Purple */
    --accent: #06b6d4;            /* Cyan */
    --accent-dark: #0891b2;
    --success: #10b981;           /* Green */
    --warning: #f59e0b;           /* Amber */
    --danger: #ef4444;            /* Red */

    /* Neutral Scale */
    --white: #ffffff;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-300: #cbd5e1;
    --gray-400: #94a3b8;
    --gray-500: #64748b;
    --gray-600: #475569;
    --gray-700: #334155;
    --gray-800: #1e293b;
    --gray-900: #0f172a;

    /* 🌞 LIGHT MODE DEFAULT */
    --background: #f8fafc;
    --surface: rgba(255, 255, 255, 0.85);
    --surface-elevated: rgba(255, 255, 255, 0.95);
    --text-primary: var(--gray-900);
    --text-secondary: var(--gray-600);
    --text-muted: var(--gray-500);
    --border: rgba(226, 232, 240, 0.7);
    --border-light: rgba(241, 245, 249, 0.8);

    /* Glassmorphism (Light) */
    --glass-bg: rgba(255, 255, 255, 0.35);
    --glass-border: rgba(255, 255, 255, 0.25);
    --glass-shadow: 0 8px 32px rgba(31, 38, 135, 0.18);
    --glass-blur: blur(10px);

    /* Shadows & Effects */
    --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.04);
    --shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 10px 15px rgba(0, 0, 0, 0.08);
    --shadow-lg: 0 20px 25px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 25px 50px rgba(0, 0, 0, 0.15);
    --shadow-glow: 0 0 20px rgba(99, 102, 241, 0.12);

    /* Border Radius */
    --radius-sm: 8px;
    --radius: 12px;
    --radius-md: 16px;
    --radius-lg: 20px;
    --radius-xl: 24px;

    /* Transitions */
    --transition-fast: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
    --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    --transition-slow: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    --transition-spring: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);

    /* Spacing */
    --spacing-xs: 0.5rem;
    --spacing-sm: 0.75rem;
    --spacing: 1rem;
    --spacing-md: 1.25rem;
    --spacing-lg: 1.5rem;
    --spacing-xl: 2rem;
    --spacing-2xl: 2.5rem;
  }

  /* 🌙 DARK MODE - With Dark Gray Background */
  body.dark-mode {
    --background: #121212;          /* Sleek dark gray */
    --surface: rgba(30, 30, 30, 0.8);
    --surface-elevated: rgba(40, 40, 40, 0.85);
    --text-primary: var(--gray-100);
    --text-secondary: var(--gray-300);
    --text-muted: var(--gray-400);
    --border: rgba(255, 255, 255, 0.1);
    --border-light: rgba(255, 255, 255, 0.05);

    /* Glassmorphism for dark gray */
    --glass-bg: rgba(40, 40, 40, 0.4);
    --glass-border: rgba(255, 255, 255, 0.08);
    --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.6);
    --glass-blur: blur(10px);

    /* Stronger glow to pop on neutral dark */
    --shadow-glow: 0 0 25px rgba(99, 102, 241, 0.25);
  }

  /* Global Reset */
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  body {
    font-family: 'Outfit', 'Inter', sans-serif;
    background: linear-gradient(135deg, var(--background), #f1f5f9);
    color: var(--text-primary);
    line-height: 1.6;
    transition: all 0.3s ease-in-out;
    min-height: 100vh;
    overflow-x: hidden;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }

  body.dark-mode {
    background: linear-gradient(135deg, #121212, #1a1a1a);
  }

  /* Sidebar */
  .sidebar {
    width: 280px;
    background: var(--surface);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border-right: 1px solid var(--glass-border);
    padding: var(--spacing-lg);
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    box-shadow: var(--shadow-lg);
    transition: var(--transition);
    color: var(--text-primary);
  }

  .sidebar.collapsed {
    width: 80px;
    padding: var(--spacing);
  }

  .sidebar-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: var(--spacing-xl);
    transition: var(--transition);
  }

  .sidebar.collapsed .sidebar-header {
    justify-content: center;
    opacity: 0.8;
  }

  .sidebar-header .logo {
    width: 40px;
    height: 40px;
    object-fit: contain;
    border-radius: var(--radius);
    transition: var(--transition-spring);
    filter: drop-shadow(0 2px 4px rgba(99, 102, 241, 0.2));
  }

  .sidebar-header .logo:hover {
    transform: scale(1.05) rotate(2deg);
  }

  .label {
    font-weight: 700;
    font-size: 1.1rem;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    transition: var(--transition);
  }

  .sidebar.collapsed .label {
    display: none;
  }

  /* Nav Links */
  .sidebar nav a {
    display: flex;
    align-items: center;
    gap: 12px;
    color: var(--text-secondary);
    text-decoration: none;
    padding: 14px 16px;
    border-radius: var(--radius-md);
    transition: var(--transition-spring);
    font-weight: 500;
    position: relative;
    overflow: hidden;
  }

  .sidebar nav a::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.1), transparent);
    transition: var(--transition);
  }

  .sidebar nav a:hover::before {
    left: 100%;
  }

  .sidebar nav a:hover {
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    color: var(--primary);
    transform: translateX(6px) scale(1.02);
    box-shadow: var(--shadow-md);
  }

  .sidebar nav a.active {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(139, 92, 246, 0.1));
    color: var(--primary);
    font-weight: 600;
    border-left: 3px solid var(--primary);
    box-shadow: var(--shadow-glow);
  }

  .sidebar.collapsed nav a {
    justify-content: center;
    padding: 16px 0;
  }

  .sidebar.collapsed nav a .icon {
    font-size: 1.3rem;
    margin: 0;
  }

  .sidebar.collapsed nav a .label {
    display: none;
  }

  /* Toggle Button */
  .toggle-btn {
    margin: 0 auto var(--spacing-lg) auto;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    border: none;
    padding: 12px 16px;
    font-size: 1rem;
    border-radius: var(--radius-md);
    cursor: pointer;
    width: 100%;
    transition: var(--transition-spring);
    font-weight: 600;
    box-shadow: var(--shadow);
    position: relative;
    overflow: hidden;
  }

  .toggle-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: var(--transition);
  }

  .toggle-btn:hover::before {
    left: 100%;
  }

  .toggle-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
  }

  .toggle-btn:active {
    transform: translateY(-1px);
  }

  /* Dark Mode Toggle */
  .dark-toggle {
    margin-top: auto;
    padding-top: var(--spacing);
    border-top: 1px solid var(--border);
    display: flex;
    align-items: center;
    transition: var(--transition);
  }

  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
    margin-right: 12px;
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
    background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
    border-radius: 34px;
    transition: var(--transition);
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .slider:before {
    content: "☀️";
    position: absolute;
    height: 28px;
    width: 28px;
    left: 3px;
    bottom: 3px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    transition: var(--transition-spring);
    box-shadow: var(--shadow);
  }

  input:checked + .slider {
    background: linear-gradient(135deg, var(--accent), var(--accent-dark));
  }

  input:checked + .slider:before {
    transform: translateX(26px);
    content: "🌙";
  }

  /* Main Content */
  .main {
    margin-left: 280px;
    padding: var(--spacing-xl);
    flex-grow: 1;
    transition: var(--transition);
    min-width: calc(100% - 280px);
    animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .main.full {
    margin-left: 80px;
    min-width: calc(100% - 80px);
  }

  .heading {
    font-size: 2rem;
    font-weight: 800;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: var(--spacing-xl);
    animation: fadeInDown 0.8s cubic-bezier(0.4, 0, 0.2, 1);
  }

  /* Stats Cards */
  .stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: var(--spacing-lg);
    margin-top: var(--spacing);
  }

  .card {
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--glass-shadow);
    transition: var(--transition-spring);
    padding: var(--spacing-lg);
    position: relative;
  }

  .card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--primary), var(--accent));
    opacity: 0;
    transition: var(--transition);
  }

  .card:hover::before {
    opacity: 1;
  }

  .card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: var(--shadow-xl), var(--shadow-glow);
    border-color: rgba(99, 102, 241, 0.3);
  }

  .card h3 {
    font-size: 0.9rem;
    color: var(--text-muted);
    margin-bottom: var(--spacing-sm);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .card .count {
    font-size: 2.2rem;
    font-weight: 900;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    line-height: 1.2;
  }

  /* Charts */
  .chart-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--spacing-lg);
    margin-top: var(--spacing-xl);
  }

  canvas {
    background: var(--surface-elevated);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-md);
    padding: var(--spacing);
    margin-top: var(--spacing);
    box-shadow: var(--shadow-md);
    transition: var(--transition);
  }

  canvas:hover {
    box-shadow: var(--shadow-lg), var(--shadow-glow);
    transform: translateY(-2px);
  }

  /* Chatbot Button */
  #chatbot-button {
    position: fixed;
    bottom: 24px;
    right: 24px;
    width: 60px;
    height: 60px;
    display: grid;
    place-items: center;
    background: linear-gradient(135deg, var(--accent), var(--primary));
    color: #fff;
    border: none;
    border-radius: 50%;
    box-shadow: var(--shadow-lg), 0 0 30px rgba(99, 102, 241, 0.3);
    cursor: pointer;
    z-index: 2200;
    transition: var(--transition-spring);
    animation: pulse 3s infinite alternate;
  }

  @keyframes pulse {
    0% { 
      box-shadow: var(--shadow-lg), 0 0 20px rgba(99, 102, 241, 0.3); 
      transform: scale(1);
    }
    100% { 
      box-shadow: var(--shadow-xl), 0 0 40px rgba(99, 102, 241, 0.4); 
      transform: scale(1.02);
    }
  }

  #chatbot-button:hover {
    transform: scale(1.12) rotate(5deg);
    box-shadow: var(--shadow-xl), 0 0 50px rgba(99, 102, 241, 0.5);
  }

  #chatbot-button:active {
    transform: scale(1.05) rotate(5deg);
  }

  /* Chatbot Window */
  #chatbot-window {
    position: fixed;
    bottom: 100px;
    right: 24px;
    width: 380px;
    max-width: calc(100vw - 48px);
    background: var(--surface-elevated);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-xl);
    display: none;
    flex-direction: column;
    overflow: hidden;
    z-index: 2300;
    animation: chatSlideUp 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
  }

  #chatbot-header {
    padding: 16px 18px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: var(--shadow);
  }

  #chatbot-close {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    font-size: 18px;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  #chatbot-close:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: scale(1.1);
  }

  #chatbot-messages {
    height: 320px;
    overflow-y: auto;
    padding: 16px;
    background: var(--surface);
    color: var(--text-primary);
  }

  #chatbot-messages::-webkit-scrollbar {
    width: 6px;
  }

  #chatbot-messages::-webkit-scrollbar-thumb {
    background: var(--text-muted);
    border-radius: 8px;
  }

  #chatbot-input {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    background: var(--surface);
    border-top: 1px solid var(--border);
  }

  #chatbot-user-input {
    flex: 1;
    padding: 12px 16px;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    font-size: 0.95rem;
    background: var(--surface-elevated);
    color: var(--text-primary);
    transition: var(--transition);
  }

  #chatbot-user-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
  }

  #chatbot-send {
    padding: 12px 18px;
    border: none;
    border-radius: var(--radius);
    background: linear-gradient(135deg, var(--accent), var(--accent-dark));
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition-spring);
    box-shadow: var(--shadow);
  }

  #chatbot-send:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: var(--shadow-lg);
  }

  #chatbot-send:active {
    transform: translateY(-1px) scale(1.02);
  }

  /* Toast Notifications */
  .toast-notification {
    background: var(--surface-elevated);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border: 1px solid var(--glass-border);
    color: var(--text-primary);
    padding: 16px 20px;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-lg);
    opacity: 0;
    transform: translateY(-30px) scale(0.9);
    transition: var(--transition-spring);
    display: flex;
    align-items: center;
    font-size: 0.95rem;
    cursor: pointer;
    margin-bottom: 12px;
    border-left: 4px solid transparent;
    position: relative;
    overflow: hidden;
  }

  .toast-notification.show {
    opacity: 1;
    transform: translateY(0) scale(1);
    animation: toastSlideIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1),
               toastGlow 2s ease-in-out infinite alternate;
  }

  @keyframes toastSlideIn {
    0% { opacity: 0; transform: translateY(-30px) scale(0.8) rotate(-2deg); }
    50% { transform: translateY(5px) scale(1.05) rotate(1deg); }
    100% { opacity: 1; transform: translateY(0) scale(1) rotate(0deg); }
  }

  @keyframes toastGlow {
    0% { box-shadow: var(--shadow-lg); }
    100% { box-shadow: var(--shadow-lg), 0 0 20px rgba(99, 102, 241, 0.2); }
  }

  .toast-notification.toast-success {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.9), rgba(5, 150, 105, 0.9));
    color: white;
    border-left-color: var(--success);
  }

  .toast-notification.toast-warning {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.9), rgba(217, 119, 6, 0.9));
    color: white;
    border-left-color: var(--warning);
  }

  .toast-notification.toast-error {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.9), rgba(220, 38, 38, 0.9));
    color: white;
    border-left-color: var(--danger);
  }

  .toast-notification.toast-info {
    background: linear-gradient(135deg, rgba(6, 182, 212, 0.9), rgba(8, 145, 178, 0.9));
    color: white;
    border-left-color: var(--accent);
  }

  .toast-content {
    display: flex;
    align-items: center;
    gap: 14px;
    width: 100%;
  }

  .toast-icon {
    font-size: 1.4rem;
    animation: iconBounce 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
  }

  @keyframes iconBounce {
    0% { transform: scale(0) rotate(-180deg); }
    50% { transform: scale(1.3) rotate(-90deg); }
    100% { transform: scale(1) rotate(0deg); }
  }

  .toast-text {
    flex: 1;
    font-weight: 600;
  }

  .toast-close {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    font-size: 1.1rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
  }

  .toast-close:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1) rotate(90deg);
  }

  /* Animations */
  @keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
  }

  @keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-30px); }
    to { opacity: 1; transform: translateY(0); }
  }

  @keyframes chatSlideUp {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .sidebar {
      width: 80px;
      padding: var(--spacing);
    }
    
    .sidebar-header .label,
    .sidebar nav a .label {
      display: none !important;
    }
    
    .main, .main.full {
      margin-left: 80px;
      min-width: calc(100% - 80px);
      padding: var(--spacing-lg);
    }
    
    #chatbot-window {
      width: calc(100vw - 32px);
      left: 16px;
      right: 16px;
      bottom: 90px;
      border-radius: var(--radius-md);
    }
    
    #chatbot-button {
      bottom: 16px;
      right: 16px;
      width: 56px;
      height: 56px;
    }
    
    .chart-grid, .stats {
      grid-template-columns: 1fr;
    }
    
    .heading {
      font-size: 1.75rem;
    }
  }

  @media (max-width: 480px) {
    .main, .main.full {
      padding: var(--spacing);
    }
    
    .stats {
      gap: var(--spacing);
    }
    
    .card {
      padding: var(--spacing);
    }
    
    .heading {
      font-size: 1.5rem;
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
<!-- Toast Container -->
<div id="toast-stack" style="
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 2000;
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-width: 360px;
    width: 100%;
">
    <!-- Overdue Toast -->
    <div id="overdueToast" class="toast-notification toast-hidden">
        <div class="toast-content">
            <div class="toast-icon">🔴</div>
            <div class="toast-text">
                <strong>Books Overdue Alert</strong><br>
                <span id="overdueSummary">Loading...</span>
                <div id="overdueDetails" class="toast-details" style="display:none; margin-top:8px;"></div>
            </div>
            <button id="closeOverdue" class="toast-close">×</button>
        </div>
    </div>

    <!-- Due Soon Toast -->
    <div id="dueSoonToast" class="toast-notification toast-hidden">
        <div class="toast-content">
            <div class="toast-icon">🟡</div>
            <div class="toast-text">
                <strong>Reminder: Books Due Soon</strong><br>
                <span id="dueSoonSummary">Loading...</span>
                <div id="dueSoonDetails" class="toast-details" style="display:none; margin-top:8px;"></div>
            </div>
            <button id="closeDueSoon" class="toast-close">×</button>
        </div>
    </div>
</div>

    <!-- Scripts -->
    <script>
        const chartData = @json($last7Days);
        const visitsData = @json($visitsData);
    </script>
    <script src="{{ asset('js/dashb.js') }}"></script>
    <script src="{{ asset('js/chatbot.js') }}"></script>
    <script src="{{ asset('js/overdue.js') }}" defer></script>

<script>
    document.getElementById('toggleSidebar')?.addEventListener('click', () => {
        const sidebar = document.getElementById('sidebar');
        const main = document.getElementById('mainContent');
        sidebar.classList.toggle('collapsed');
        main.classList.toggle('full');
    });

    const darkModeToggle = document.getElementById('darkModeToggle');

    if (darkModeToggle) {
        // Apply saved preference on load
        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark-mode');
            darkModeToggle.checked = true;
        }

        // Update on toggle
        darkModeToggle.addEventListener('change', () => {
            document.body.classList.toggle('dark-mode', darkModeToggle.checked);
            localStorage.setItem('darkMode', darkModeToggle.checked);
        });
    }

    const chatbotWindow = document.getElementById('chatbot-window');
    const chatbotButton = document.getElementById('chatbot-button');
    const chatbotClose = document.getElementById('chatbot-close');

    // Open chatbot
    chatbotButton?.addEventListener('click', () => {
        chatbotWindow.style.display = chatbotWindow.style.display === 'flex' ? 'none' : 'flex';
    });

    // Close chatbot
    chatbotClose?.addEventListener('click', () => {
        chatbotWindow.style.display = 'none';
    });
</script>
</body>
</html>