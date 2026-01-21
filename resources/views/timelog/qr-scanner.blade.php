<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>🕒 QR Scanner | Julita Leyte</title>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
  :root {
    /* Color Palette */
    --primary: #2fb9eb;
    --primary-dark: #1a9bcf;
    --secondary: #8b5cf6;
    --accent: #06b6d4;
    --accent-dark: #0891b2;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;

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

    /* Light Mode */
    --background: #f8fafc;
    --surface: rgba(255, 255, 255, 0.9);
    --surface-elevated: rgba(255, 255, 255, 0.95);
    --text-primary: var(--gray-900);
    --text-secondary: var(--gray-600);
    --text-muted: var(--gray-500);
    --border: rgba(226, 232, 240, 0.7);
    --border-light: rgba(241, 245, 249, 0.8);

    /* Glassmorphism */
    --glass-bg: rgba(255, 255, 255, 0.4);
    --glass-border: rgba(255, 255, 255, 0.3);
    --glass-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
    --glass-blur: blur(12px);

    /* Shadows */
    --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.04);
    --shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 10px 15px rgba(0, 0, 0, 0.08);
    --shadow-lg: 0 20px 25px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 25px 50px rgba(0, 0, 0, 0.15);

    /* Border Radius */
    --radius-sm: 8px;
    --radius: 12px;
    --radius-lg: 16px;
    --radius-xl: 24px;

    /* Transitions */
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --transition-slow: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);

    /* Spacing */
    --spacing-xs: 0.5rem;
    --spacing-sm: 0.75rem;
    --spacing: 1rem;
    --spacing-lg: 1.5rem;
    --spacing-xl: 2rem;
    --spacing-2xl: 3rem;
  }

  /* Dark Mode */
  body.dark-mode {
    --background: #0a0a0a;
    --surface: rgba(20, 20, 20, 0.85);
    --surface-elevated: rgba(30, 30, 30, 0.9);
    --text-primary: var(--gray-100);
    --text-secondary: var(--gray-300);
    --text-muted: var(--gray-400);
    --border: rgba(255, 255, 255, 0.1);
    --border-light: rgba(255, 255, 255, 0.05);
    --glass-bg: rgba(30, 30, 30, 0.5);
    --glass-border: rgba(255, 255, 255, 0.1);
    --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
  }

  /* Dark mode sidebar */
  body.dark-mode .sidebar {
    background: rgba(20, 20, 20, 0.9);
    border-right-color: rgba(255, 255, 255, 0.1);
  }

  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  body {
    font-family: 'Inter', sans-serif;
    background: linear-gradient(135deg, var(--background), var(--gray-100));
    color: var(--text-primary);
    line-height: 1.6;
    transition: var(--transition-slow);
    height: 100vh;
    overflow: hidden;
  }

  body.dark-mode {
    background: linear-gradient(135deg, #0a0a0a, #1a1a1a);
  }

  /* Sidebar - Legacy Gradient */
  .sidebar {
    width: 280px;
    background: linear-gradient(180deg, rgba(30, 64, 175, 0.95), rgba(124, 58, 237, 0.95));
    border-right: 1px solid rgba(255, 255, 255, 0.1);
    padding: var(--spacing-lg);
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    color: #ffffff;
    transform: translateZ(0);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
  }
  /* Light mode sidebar - Legacy */
  body:not(.dark-mode) .sidebar {
    background: linear-gradient(180deg, rgba(30, 64, 175, 0.95), rgba(124, 58, 237, 0.95));
    border-right: 1px solid rgba(255, 255, 255, 0.1);
    color: #ffffff;
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
  }
  body:not(.dark-mode) .sidebar .label {
    color: #1a1a1a;
  }
  /* Enhanced sidebar header label visibility */
  .sidebar-header .label {
    display: block !important;
    font-weight: 700;
    font-size: 1.27rem;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    transition: var(--transition);
    opacity: 1;
    color: var(--primary) !important;
    visibility: visible !important;
  }
  .sidebar-header {
   display: flex;
   flex-direction: column;
   align-items: center;
   gap: 12px;
   margin-bottom: var(--spacing-xl);
   transition: var(--transition);
  }
  .sidebar-header .logo {
   width: 170px;
   height: 170px;
   object-fit: contain;
   border-radius: var(--radius);
   transition: var(--transition-spring);
   filter: drop-shadow(0 4px 8px rgba(99, 102, 241, 0.3));
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
    color: var(--primary) !important;
    opacity: 1 !important;
    visibility: visible !important;
  }
  /* Nav Links - Legacy */
  .sidebar nav a {
    display: flex;
    align-items: center;
    gap: 12px;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    padding: 14px 16px;
    border-radius: 12px;
    transition: all 0.3s ease;
    font-weight: 500;
    position: relative;
    margin-bottom: 8px;
    font-size: 14px;
  }
  .sidebar nav a:hover {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    color: #ffffff;
    transform: translateX(6px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    border-left: 3px solid var(--accent);
  }
  .sidebar nav a.active {
    background: rgba(59, 130, 246, 0.15);
    color: #3b82f6;
    font-weight: 600;
    border-left: 3px solid #3b82f6;
  }
  .sidebar nav a .icon {
    width: 20px;
    text-align: center;
    font-size: 18px;
  }
  /* Light mode navigation - Legacy */
  body:not(.dark-mode) .sidebar nav a {
    color: rgba(255, 255, 255, 0.8);
  }
  body:not(.dark-mode) .sidebar nav a .label {
    color: rgba(255, 255, 255, 0.8);
    transition: var(--transition);
    opacity: 1 !important;
    visibility: visible !important;
    display: inline !important;
  }
  body:not(.dark-mode) .sidebar nav a:hover {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-left: 3px solid var(--primary);
  }
  body:not(.dark-mode) .sidebar nav a:hover .label {
    color: #ffffff;
  }
  body:not(.dark-mode) .sidebar nav a.active {
    background: rgba(59, 130, 246, 0.15);
    color: #3b82f6;
    border-left: 3px solid #3b82f6;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
  }

  .sidebar-header {
    display: flex;
    align-items: center;
    gap: var(--spacing);
    margin-bottom: var(--spacing-xl);
  }

  .logo {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
  }

  .label {
    font-weight: 700;
    font-size: 1.1rem;
  }

  nav {
    flex: 1;
  }

  .nav-link {
    display: flex;
    align-items: center;
    gap: var(--spacing);
    padding: var(--spacing);
    margin-bottom: var(--spacing-xs);
    border-radius: var(--radius);
    text-decoration: none;
    color: rgba(255, 255, 255, 0.9);
    transition: var(--transition);
  }

  .nav-link:hover,
  .nav-link.active {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    transform: translateX(5px);
  }

  .nav-link .icon {
    width: 20px;
    text-align: center;
  }

  .dark-toggle {
    display: flex;
    align-items: center;
    gap: var(--spacing);
    margin-bottom: var(--spacing-lg);
  }

  .switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
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
    border-radius: 24px;
  }

  .slider-thumb {
    position: absolute;
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
  }

  input:checked + .slider .slider-thumb {
    transform: translateX(26px);
  }

  .icon-sun,
  .icon-moon {
    display: none;
  }

  input:checked + .slider .icon-sun {
    display: block;
  }

  input:not(:checked) + .slider .icon-moon {
    display: block;
  }

  .settings-btn {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    color: var(--text-secondary);
    cursor: pointer;
    transition: var(--transition);
    font-size: 16px;
    box-shadow: var(--shadow-sm);
  }

  .settings-btn:hover {
    background: var(--surface-elevated);
    transform: translateY(-2px);
    box-shadow: var(--shadow);
  }

  .logout-btn {
    background: linear-gradient(135deg, var(--danger), #dc2626);
    color: white;
    border: none;
    padding: 12px 16px;
    border-radius: var(--radius);
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: var(--transition);
    box-shadow: var(--shadow);
    cursor: pointer;
  }

  .logout-btn:hover {
    background: linear-gradient(135deg, #dc2626, var(--danger));
    color: white !important;
    border-color: var(--danger) !important;
    box-shadow: var(--shadow) !important;
    transform: translateY(-2px);
  }

  /* Main Content */
  .main {
    margin-left: 280px;
    height: 100vh;
    overflow-y: auto;
    overflow-x: hidden;
  }

  .main::-webkit-scrollbar {
    width: 8px;
  }

  .main::-webkit-scrollbar-thumb {
    background: var(--text-muted);
    border-radius: 8px;
  }

  .main::-webkit-scrollbar-track {
    background: var(--border-light);
  }

  .main-content-wrapper {
    padding: var(--spacing-lg);
  }

  /* Hero Section */
  .hero-section {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: white;
    padding: var(--spacing-2xl);
    border-radius: var(--radius-xl);
    margin-bottom: var(--spacing-xl);
    position: relative;
    overflow: hidden;
  }
  /* Dark mode hero */
  body.dark-mode .hero-section {
    background: linear-gradient(135deg, #1a1a1a, #2d3748);
  }

  .hero-content {
    position: relative;
    z-index: 2;
  }

  .hero-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: var(--spacing);
    display: flex;
    align-items: center;
    gap: var(--spacing);
  }

  .hero-subtitle {
    font-size: 1.1rem;
    opacity: 0.95;
    max-width: 600px;
    margin-bottom: var(--spacing-xl);
  }

  /* QR Scanner Section */
  .scanner-section {
    background: var(--surface);
    border-radius: var(--radius-xl);
    padding: var(--spacing-2xl);
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--border);
    text-align: center;
  }

  .scanner-container {
    max-width: 600px;
    margin: 0 auto;
  }

  #qr-reader {
    width: 100%;
    max-width: 500px;
    height: 400px;
    margin: 0 auto var(--spacing-xl);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-md);
  }

  .scanner-instructions {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    padding: var(--spacing-lg);
    border-radius: var(--radius-lg);
    margin-bottom: var(--spacing-xl);
  }

  .scanner-instructions h3 {
    margin-bottom: var(--spacing);
    font-size: 1.25rem;
  }

  .scanner-instructions p {
    opacity: 0.9;
    line-height: 1.6;
  }

  .status-message {
    padding: var(--spacing-lg);
    border-radius: var(--radius-lg);
    margin-top: var(--spacing-lg);
    font-weight: 600;
    display: none;
  }

  .status-success {
    background: linear-gradient(135deg, var(--success), #059669);
    color: white;
  }

  .status-error {
    background: linear-gradient(135deg, var(--danger), #dc2626);
    color: white;
  }

  .status-info {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
  }

  /* Toast Notifications */
  .toast-notification {
    background: var(--surface-elevated);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-xl);
    padding: 0;
    margin-bottom: var(--spacing);
    min-width: 350px;
    max-width: 500px;
    position: relative;
    transform: translateY(-30px) scale(0.8) rotate(-2deg);
    opacity: 0;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    display: none;
  }
  .toast-notification.show {
    display: flex !important;
    opacity: 1;
    transform: translateY(0) scale(1);
    animation: toastSlideIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1),
               toastGlow 2s ease-in-out infinite alternate;
  }
  .toast-notification.toast-hidden {
    display: none !important;
  }
  @keyframes toastSlideIn {
    0% { opacity: 0; transform: translateY(-30px) scale(0.8) rotate(-2deg); }
    100% { opacity: 1; transform: translateY(0) scale(1) rotate(0deg); }
  }
  @keyframes toastGlow {
    0% { box-shadow: var(--shadow-lg); }
    100% { box-shadow: var(--shadow-glow); }
  }
  .toast-notification.toast-success {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.9), rgba(5, 150, 105, 0.9));
    border-color: rgba(16, 185, 129, 0.5);
    color: white;
  }
  .toast-notification.toast-warning {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.9), rgba(217, 119, 6, 0.9));
    border-color: rgba(245, 158, 11, 0.5);
    color: white;
  }
  .toast-notification.toast-error {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.9), rgba(220, 38, 38, 0.9));
    border-color: rgba(239, 68, 68, 0.5);
    color: white;
  }
  .toast-notification.toast-info {
    background: linear-gradient(135deg, rgba(6, 182, 212, 0.9), rgba(8, 145, 178, 0.9));
    border-color: rgba(6, 182, 212, 0.5);
    color: white;
  }
  .toast-content {
    display: flex;
    align-items: center;
    gap: var(--spacing);
    padding: var(--spacing-lg);
    width: 100%;
  }
  .toast-icon {
    font-size: 1.4rem;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .toast-text {
    flex: 1;
    font-weight: 500;
    line-height: 1.4;
  }
  .toast-close {
    background: rgba(255, 255, 255, 0.3);
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    color: white;
    transition: all 0.2s ease;
    flex-shrink: 0;
  }
  .toast-close:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
  }

  /* Toast Stack Positioning */
  #toast-stack {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 10000;
    display: flex;
    flex-direction: column;
    gap: var(--spacing);
    pointer-events: none;
  }
  #toast-stack .toast-notification {
    pointer-events: auto;
  }

  /* Responsive Design */
  @media (max-width: 1024px) {
    .sidebar {
      width: 80px;
    }

    .sidebar .label,
    .nav-link span,
    .logout-btn span,
    #darkModeLabel {
      display: none !important;
    }

    .main {
      margin-left: 80px;
    }

    /* Mobile toast positioning */
    #toast-stack {
      left: var(--spacing);
      right: auto;
      top: var(--spacing);
    }
  }

  @media (max-width: 768px) {
    .hero-title {
      font-size: 1.75rem;
    }

    #qr-reader {
      height: 300px;
    }

    #toast-stack {
      left: var(--spacing-sm);
      right: var(--spacing-sm);
      top: var(--spacing);
    }

    .toast-notification {
      min-width: auto;
      max-width: none;
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
    <nav>
      <a href="{{ route('timelog.index') }}" data-label="Back to Time Logs">
        <span class="icon"><i class="fas fa-arrow-left"></i></span>
        <span class="label">Back to Time Logs</span>
      </a>
    </nav>
    <div class="dark-toggle">
      <label class="switch" title="Toggle Dark Mode">
        <input type="checkbox" id="darkModeToggle">
        <span class="slider">
          <span class="slider-thumb">
            <span class="icon-sun">🌞</span>
            <span class="icon-moon">🌙</span>
          </span>
        </span>
      </label>
      <span id="darkModeLabel" style="color: var(--text-muted); font-size: 0.8rem; margin-left: 8px;">Light Mode</span>
    </div>
    <!-- Settings and Logout Buttons -->
    <div style="margin-top: auto; margin-bottom: var(--spacing-lg); display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; max-width: 200px; margin-left: auto; margin-right: auto;">
      <button onclick="openSettingsModal()" class="settings-btn" style="display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; padding: 0; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); color: var(--text-secondary); cursor: pointer; transition: var(--transition); font-size: 16px; box-shadow: var(--shadow-sm); flex-shrink: 0;" title="Settings">
        <i class="fas fa-cog"></i>
      </button>
      <div class="logout-section" style="flex: 1; display: flex; justify-content: center;">
        <form method="POST" action="{{ route('logout') }}" style="margin: 0; padding: 0; width: 100%;">
          @csrf
          <button type="submit" class="logout-btn" style="background: linear-gradient(135deg, var(--danger), #dc2626); color: white; border: none; padding: 12px 16px; border-radius: var(--radius); font-weight: 600; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; transition: var(--transition); box-shadow: var(--shadow); cursor: pointer; width: 100%;">
            <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
            <span class="label logout-text" style="font-size: 13.5px; font-weight: bold;">Logout</span>
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main">
    <div class="main-content-wrapper">
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-content">
        <h1 class="hero-title">
          <i class="fas fa-qrcode"></i>
          QR Scanner
        </h1>
        <p class="hero-subtitle">Scan member QR codes for time-in/time-out</p>
      </div>
    </div>

    <!-- Scanner Section -->
    <div class="scanner-section">
      <div class="scanner-container">
        <div class="scanner-instructions">
          <h3><i class="fas fa-info-circle"></i> Instructions</h3>
          <p>Point your camera at a member's QR code. The system will automatically detect and process time-in or time-out based on their current status.</p>
        </div>

        <div id="qr-reader"></div>

        <div id="statusMessage" class="status-message"></div>
      </div>
    </div>
    </div>
  </div>

  <!-- Toast Stack -->
  <div id="toast-stack"></div>

  <!-- Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
  <script src="/js/html5-qrcode.min.js"></script>
  <script src="/js/dashb_iScripts.js"></script>
  <script>
    // Dark mode toggle
    const darkModeToggle = document.getElementById('darkModeToggle');
    const body = document.body;
    const darkModeLabel = document.getElementById('darkModeLabel');

    // Check for saved theme preference or default to light mode
    const currentTheme = localStorage.getItem('theme') || 'light';
    if (currentTheme === 'dark') {
      body.classList.add('dark-mode');
      darkModeToggle.checked = true;
      darkModeLabel.textContent = 'Dark Mode';
    }

    darkModeToggle.addEventListener('change', function() {
      if (this.checked) {
        body.classList.add('dark-mode');
        localStorage.setItem('theme', 'dark');
        darkModeLabel.textContent = 'Dark Mode';
      } else {
        body.classList.remove('dark-mode');
        localStorage.setItem('theme', 'light');
        darkModeLabel.textContent = 'Light Mode';
      }
    });

    // QR Scanner
    let html5QrCode;
    let qrScannerRunning = false;
    let lastScanTime = 0;
    const SCAN_COOLDOWN = 3000; // 3 seconds

    function startQRScan() {
      if (!html5QrCode) {
        html5QrCode = new Html5Qrcode("qr-reader");
      }

      Html5Qrcode.getCameras().then(cameras => {
        if (cameras && cameras.length) {
          html5QrCode.start(
            { facingMode: "environment" },
            {
              fps: 10,
              qrbox: 250
            },
            (decodedText, decodedResult) => {
              handleQRScan(decodedText);
            },
            errorMessage => {
              // console.log(`QR Code no match: ${errorMessage}`);
            }
          ).then(() => {
            qrScannerRunning = true;
          }).catch(err => {
            console.error("Failed to start QR scanner:", err);
            showStatus("❌ Failed to start camera. Please check permissions.", "error");
          });
        } else {
          showStatus("❌ No camera found.", "error");
        }
      }).catch(err => {
        console.error("Error getting camera:", err);
        showStatus("❌ Camera access denied.", "error");
      });
    }

    function stopQRScan() {
      if (html5QrCode && qrScannerRunning) {
        html5QrCode.stop().then(() => {
          html5QrCode.clear();
          qrScannerRunning = false;
        }).catch(err => {
          console.error("Failed to stop scanner:", err);
        });
      }
    }

    function handleQRScan(data) {
      const currentTime = Date.now();

      // Check cooldown
      if (currentTime - lastScanTime < SCAN_COOLDOWN) {
        return; // Ignore scan if within cooldown period
      }

      lastScanTime = currentTime;

      const memberIdMatch = data.match(/\/members\/(\d+)/);
      if (memberIdMatch) {
        const memberId = memberIdMatch[1];
        processTimeLog(memberId);
      } else {
        showStatus("❌ Invalid QR code. Please scan a valid member QR code.", "error");
      }
    }

    function processTimeLog(memberId) {
      const token = document.querySelector('meta[name="csrf-token"]').content;

      fetch(`/time-log/scan/${memberId}`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": token
        }
      })
      .then(res => res.json())
      .then(data => {
        if (data.message.includes("✅") || data.message.includes("👋")) {
          // Use toast notification for success
          showToast(data.message.replace(/[✅👋]/g, '').trim(), "success");
        } else if (data.message.includes("❌")) {
          showStatus(data.message, "error");
        } else {
          showStatus(data.message, "info");
        }
      })
      .catch(err => {
        console.error("Error processing time log:", err);
        showStatus("❌ Failed to process time log.", "error");
      });
    }

    function showStatus(message, type) {
      const statusEl = document.getElementById('statusMessage');
      statusEl.textContent = message;
      statusEl.className = `status-message status-${type}`;
      statusEl.style.display = 'block';

      // Auto-hide after 5 seconds
      setTimeout(() => {
        statusEl.style.display = 'none';
      }, 5000);
    }

    // Start scanner on page load
    document.addEventListener('DOMContentLoaded', function() {
      startQRScan();
    });

    // Stop scanner when page unloads
    window.addEventListener('beforeunload', function() {
      stopQRScan();
    });

    function openSettingsModal() {
      // Placeholder for settings modal
      alert('Settings modal not implemented yet.');
    }
  </script>
</body>
</html>