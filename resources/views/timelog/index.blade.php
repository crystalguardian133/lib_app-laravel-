<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>🕒 Member Time Logs | Julita Leyte</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
  <style>
  :root {
    /* Shared Color Palette */
    --primary: #2fb9eb;           /* Indigo */
    --primary-dark: #4f46e5
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
  /* Additional dark mode styles */
  body.dark-mode .sidebar {
    background: rgba(20, 20, 20, 0.9);
    border-right-color: rgba(255, 255, 255, 0.1);
  }
  body.dark-mode .card {
    background: rgba(30, 30, 30, 0.7);
    border-color: rgba(255, 255, 255, 0.1);
  }
  body.dark-mode .btn-outline {
    border-color: rgba(255, 255, 255, 0.2);
    color: var(--text-secondary);
  }
  body.dark-mode .btn-outline:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: var(--primary);
    color: var(--primary);
  }
  body.dark-mode .data-table th {
    background: rgba(20, 20, 20, 0.8);
    border-bottom-color: rgba(255, 255, 255, 0.1);
  }
  body.dark-mode .data-table td {
    border-bottom-color: rgba(255, 255, 255, 0.05);
  }
  body.dark-mode .data-table tr:hover {
    background: rgba(255, 255, 255, 0.05);
  }
  body.dark-mode .form-control {
    background: rgba(30, 41, 59, 0.9);
    border-color: rgba(71, 85, 105, 0.5);
    color: var(--text-primary);
  }
  body.dark-mode .form-control:focus {
    background: rgba(30, 41, 59, 1);
    border-color: var(--accent);
  }
  body.dark-mode .form-control:hover {
    border-color: rgba(255, 255, 255, 0.2);
  }

  /* Global Reset */
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  html {
    font-size: 16px;
    zoom: 1;
  }

  body {
    font-family: 'Outfit', 'Inter', sans-serif;
    font-size: 16px;
    background: linear-gradient(135deg, var(--background), #f1f5f9);
    color: var(--text-primary);
    line-height: 1.6;
    transition: background 0.4s cubic-bezier(0.4, 0, 0.2, 1), color 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    min-height: 100vh;
    overflow-x: hidden;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    position: relative;
    zoom: 1;
  }
  /* Dark mode transition overlay */
  body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle at center, rgba(99, 102, 241, 0.1) 0%, transparent 70%);
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 9999;
  }
  body.dark-mode::before {
    opacity: 1;
  }
  /* Animated elements during transition */
  body.dark-mode-transition * {
    transition: background-color 0.4s ease, color 0.4s ease, border-color 0.4s ease, box-shadow 0.4s ease !important;
  }
  body.dark-mode {
    background: linear-gradient(135deg, #121212, #1a1a1a);
  }

    /* Sidebar */
    .sidebar {
      width: 280px;
      background: #1a1a1a;
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
      /* Glassmorphism */
      background: var(--glass-bg);
      backdrop-filter: var(--glass-blur);
      -webkit-backdrop-filter: var(--glass-blur);
      border: 1px solid var(--glass-border);
      box-shadow: var(--glass-shadow);
    }
    /* Light mode sidebar */
    body:not(.dark-mode) .sidebar {
      background: var(--glass-bg);
      border-right: 1px solid var(--glass-border);
      color: #1a1a1a;
    }

    .sidebar-header {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: var(--spacing-xl);
      transition: var(--transition);
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

    /* Ensure sidebar header text is visible */
    .sidebar-header .label {
      color: var(--primary) !important;
      opacity: 1 !important;
      visibility: visible !important;
      font-weight: 700 !important;
      display: block !important;
      background: none !important;
      -webkit-text-fill-color: var(--primary) !important;
    }

    /* Light mode sidebar header */
    body:not(.dark-mode) .sidebar-header .label {
      color: var(--primary) !important;
      -webkit-text-fill-color: var(--primary) !important;
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
    /* Toast Notification */
.toast-notification {
    position: fixed;
    top: 24px;
    right: 24px;
    background: var(--danger);
    color: white;
    padding: 16px;
    border-radius: var(--border-radius-sm);
    box-shadow: var(--modal-shadow);
    z-index: 2000;
    max-width: 380px;
    opacity: 0;
    transform: translateY(-20px);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: flex-start;
    font-size: 0.95rem;
    line-height: 1.5;
}

.toast-notification.show {
    opacity: 1;
    transform: translateY(0);
}

.toast-content {
    display: flex;
    gap: 10px;
    width: 100%;
}

.toast-icon {
    font-size: 1.4rem;
    flex-shrink: 0;
}

.toast-text strong {
    display: block;
    margin-top: 4px;
}

.toast-close {
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    font-size: 1.2rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: -4px;
}

.toast-close:hover {
    background: rgba(255,255,255,0.3);
}

    .sidebar.collapsed {
      width: 60px;
    }

    .sidebar.collapsed .label {
      display: none !important;
    }

    .sidebar.collapsed .sidebar-header {
      justify-content: center;
    }

    /* Ensure labels are visible in normal sidebar */
    .sidebar:not(.collapsed) .label {
      display: inline !important;
      opacity: 1 !important;
      visibility: visible !important;
    }

    .sidebar-nav {
      flex: 1;
    }

    .nav-item {
      margin-bottom: var(--spacing-xs);
    }

    .nav-link {
      display: flex;
      align-items: center;
      gap: 12px;
      color: rgba(255, 255, 255, 0.8);
      text-decoration: none;
      padding: 14px 16px;
      border-radius: 12px;
      transition: all 0.3s ease;
      font-weight: 500;
    }
    .nav-link span {
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.7));
      background-clip: text;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .nav-link:hover {
      background: var(--glass-bg);
      color: #ffffff;
      transform: translateX(6px);
    }
    .nav-link:hover span {
      background: linear-gradient(135deg, #ffffff, #f8fafc);
      background-clip: text;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .nav-link.active {
      background: rgba(59, 130, 246, 0.15);
      color: #3b82f6;
      border-left: 3px solid #3b82f6;
    }
    .nav-link.active span {
      background: linear-gradient(135deg, #3b82f6, #1d4ed8);
      background-clip: text;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    /* Dark Mode Toggle - Simple Slider Design */
    .dark-toggle {
      margin-top: auto;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      gap: 12px;
      align-self: center;
      margin-left: auto;
      margin-right: auto;
    }
    /* Animated label */
    #darkModeLabel {
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      font-weight: 500;
      color: rgba(255, 255, 255, 0.8);
      font-size: 14px;
    }
    /* Light mode label */
    body:not(.dark-mode) #darkModeLabel {
      color: rgba(0, 0, 0, 0.8);
    }

    .switch {
      position: relative;
      width: 60px;
      height: 34px;
      display: inline-block;
      vertical-align: middle;
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
      display: flex;
      align-items: center;
      padding: 0 6px;
    }
    body.dark-mode .slider {
      background: linear-gradient(135deg, var(--accent), var(--accent-dark));
    }
    .slider-thumb {
      position: absolute;
      width: 28px;
      height: 28px;
      background: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      box-shadow: var(--shadow);
      transition: var(--transition-spring);
      z-index: 2;
    }
    .icon-sun, .icon-moon {
      position: absolute;
      transition: var(--transition);
    }
    .icon-sun {
      opacity: 1;
    }
    .icon-moon {
      opacity: 0;
    }
    input:not(:checked) + .slider .slider-thumb {
      transform: translateX(0);
    }
    input:checked + .slider .slider-thumb {
      transform: translateX(26px);
    }
    input:checked + .slider .icon-sun {
      opacity: 0;
    }
    input:checked + .slider .icon-moon {
      opacity: 1;
    }

    /* Main Content */
    .main {
      margin-left: 280px;
      padding: var(--spacing-lg);
      flex-grow: 1;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      min-width: calc(100% - 280px);
      animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
      height: 100vh;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transform: translateZ(0);
      background: var(--glass-bg);
      backdrop-filter: var(--glass-blur);
      -webkit-backdrop-filter: var(--glass-blur);
      border: 1px solid var(--glass-border);
      box-shadow: var(--glass-shadow);
    }
    /* Dashboard Content */
    .dashboard-content {
      flex: 1;
      overflow-y: auto;
      padding-right: 8px;
      background: var(--glass-bg);
      backdrop-filter: var(--glass-blur);
      -webkit-backdrop-filter: var(--glass-blur);
      border-radius: var(--radius-lg);
      padding: var(--spacing-lg);
      margin: var(--spacing-sm) 0;
      border: 1px solid var(--glass-border);
      box-shadow: var(--glass-shadow);
    }
    .dashboard-content::-webkit-scrollbar {
      width: 6px;
    }
    .dashboard-content::-webkit-scrollbar-thumb {
      background: var(--text-muted);
      border-radius: 8px;
    }
    .dashboard-content::-webkit-scrollbar-track {
      background: var(--border-light);
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
    .dashboard-title {
      font-size: 2rem;
      font-weight: 800;
      color: var(--primary);
      margin-bottom: var(--spacing-xl);
      animation: fadeInDown 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    h2 {
      text-align: center;
      color: var(--primary);
    }
  

    .top-controls {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
      justify-content: center;
      margin-bottom: 1.5rem;
    }

    .top-controls input {
      width: 300px;
      padding: 0.75rem 1rem;
      font-size: 0.95rem;
      border-radius: var(--radius);
      border: 2px solid var(--glass-border);
      background: var(--glass-bg);
      backdrop-filter: var(--glass-blur);
      -webkit-backdrop-filter: var(--glass-blur);
      color: var(--text-primary);
      transition: var(--transition);
    }

    .top-controls button {
      background: var(--accent);
      color: white;
      padding: 0.75rem 1rem;
      border-radius: 8px;
      border: none;
      font-weight: 600;
      cursor: pointer;
    }

    #suggestionBox {
      position: absolute;
      width: 300px;
      max-height: 180px;
      overflow-y: auto;
      border: 1px solid var(--glass-border);
      background: var(--glass-bg);
      backdrop-filter: var(--glass-blur);
      -webkit-backdrop-filter: var(--glass-blur);
      border-radius: var(--radius);
      box-shadow: var(--glass-shadow);
      z-index: 999;
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
      margin-top: 1.5rem;
      border-radius: var(--radius-lg);
      overflow: hidden;
      background: var(--glass-bg);
      backdrop-filter: var(--glass-blur);
      -webkit-backdrop-filter: var(--glass-blur);
      border: 1px solid var(--glass-border);
      box-shadow: var(--glass-shadow);
    }

    th, td {
      padding: 16px 14px;
      border-bottom: 1px solid var(--border-light);
      color: var(--text-secondary);
      font-size: 0.9rem;
    }

    th {
      background: var(--glass-bg);
      color: var(--text-primary);
      font-weight: 600;
      text-align: left;
      border-bottom: 2px solid var(--border);
      position: sticky;
      top: 0;
      z-index: 10;
      backdrop-filter: var(--glass-blur);
      -webkit-backdrop-filter: var(--glass-blur);
    }

    .logout {
      background: var(--danger);
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 6px;
      cursor: pointer;
    }

    .corner-popup {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: var(--accent);
      color: white;
      padding: 12px 18px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
      font-size: 0.95rem;
      z-index: 1000;
    }

    .modal {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
      z-index: 999;
    }

    .modal-content {
      background: var(--white);
      padding: 1.5rem;
      border-radius: 12px;
      width: 90%;
      max-width: 500px;
      box-shadow: 0 20px 25px rgba(0, 0, 0, 0.1);
    }

    .modal-content label {
      display: block;
      margin-top: 1rem;
      font-weight: 600;
    }

    .modal-content input {
      width: 100%;
      padding: 0.6rem;
      margin-top: 0.4rem;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .actions {
      display: flex;
      justify-content: flex-end;
      gap: 1rem;
      margin-top: 1.5rem;
    }

    .cancel {
      background: #94a3b8;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      cursor: pointer;
      color: white;
    }
    body.dark-mode .modal-content {
  background-color: #1e293b;
  color: var(--text-dark);
}

body.dark-mode .modal-content input {
  background-color: #0f172a;
  color: var(--text-dark);
  border: 1px solid #475569;
}

body.dark-mode .modal-content input::placeholder {
  color: #9ca3af;
}

body.dark-mode .actions .cancel {
  background: #475569;
  color: #e2e8f0;
}

body.dark-mode .actions .submit {
  background: var(--accent);
  color: white;
}

body.dark-mode .actions .delete {
  background: #ef4444;
  color: white;
}

    .submit {
      background: var(--accent);
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      cursor: pointer;
      color: white;
    }

    /* Custom Button Styles for Modals */
    .btn-cancel {
      background: linear-gradient(135deg, #9ca3af, #6b7280);
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-cancel:hover {
      transform: translateY(-2px) scale(1.05);
      box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
      background: linear-gradient(135deg, #6b7280, #4b5563);
    }

    .btn-confirm {
      background: linear-gradient(135deg, #10b981, #059669);
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-confirm:hover {
      transform: translateY(-2px) scale(1.05);
      box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
      background: linear-gradient(135deg, #059669, #047857);
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
    /* Responsive Design */
    @media (max-width: 768px) {
      .sidebar {
        width: 80px;
        padding: var(--spacing);
      }
      .sidebar-header .label,
      .nav-link span {
        display: none !important;
      }
      .main {
        margin-left: 80px;
        min-width: calc(100% - 80px);
        padding: var(--spacing-lg);
      }
      .dashboard-title {
        font-size: 1.75rem;
      }
      .heading {
        font-size: 1.75rem;
      }
    }
    @media (max-width: 480px) {
      .main {
        padding: var(--spacing);
      }
      .dashboard-content {
        padding: var(--spacing);
      }
      .dashboard-title {
        font-size: 1.5rem;
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
    <div class="sidebar-nav">
      <div class="nav-item">
        <a href="{{ route('dashboard') }}" class="nav-link" data-label="Dashboard">
          <i class="fas fa-home"></i>
          <span>Dashboard</span>
        </a>
      </div>
      <div class="nav-item">
        <a href="{{ route('books.index') }}" class="nav-link" data-label="Books">
          <i class="fas fa-book"></i>
          <span>Books</span>
        </a>
      </div>
      <div class="nav-item">
        <a href="{{ route('members.index') }}" class="nav-link" data-label="Members">
          <i class="fas fa-users"></i>
          <span>Members</span>
        </a>
      </div>
      <div class="nav-item">
        <a href="{{ route('timelog.index') }}" class="nav-link active" data-label="Member Time-in/out">
          <i class="fas fa-user-clock"></i>
          <span>Member Time-in/out</span>
        </a>
      </div>
    </div>
    <div class="logout-btn" style="margin-top: auto; display: flex; align-items: center; justify-content: center; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); position: relative; gap: 12px; align-self: center; margin-left: auto; margin-right: auto; background: linear-gradient(135deg, var(--danger), #dc2626); border: none; border-radius: var(--radius); padding: 12px 16px; color: white; text-decoration: none; font-weight: 600; box-shadow: var(--shadow); cursor: pointer; width: 100%; max-width: 200px;">
      <form method="POST" action="{{ route('logout') }}" style="margin: 0; padding: 0; width: 100%;">
        @csrf
        <button type="submit" style="background: none; border: none; color: white; text-decoration: none; display: flex; align-items: center; gap: 8px; width: 100%; justify-content: center; cursor: pointer; font-size: inherit; font-weight: inherit;">
          <i class="fas fa-sign-out-alt"></i>
          <span class="logout-text">Logout</span>
        </button>
      </form>
    </div>
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
  </div>
  <!-- Overdue Toast Notification -->
<div id="overdueToast" class="toast-notification">
    <div class="toast-content">
        <div class="toast-icon">⚠️</div>
        <div class="toast-text">
            <strong>Overdue Alert!</strong><br>
            <span id="toastMessage">Loading...</span>
        </div>
        <button id="closeToast" class="toast-close">×</button>
    </div>
</div>

  <!-- Main Content -->
  <div class="main" id="mainContent">
    <div class="dashboard-title" style="position: sticky; top: 0; z-index: 100; background: transparent; padding: 1rem 0; margin: -1rem 0 1rem 0;">MEMBER TIME LOGS</div>
    <div class="dashboard-content">
      <div class="heading"><i class="fas fa-clock"></i> Time In / Time Out</div>
      <div class="top-controls">
        <div style="position: relative;">
          <input type="text" id="memberInput" placeholder="Search member..." autocomplete="off">
          <div id="suggestionBox"></div>
        </div>
        
      <button onclick="openScanQRModal()" id="scanQRBtn"><i class="fas fa-qrcode"></i> Scan QR</button>


      <table>
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
          <tr>
            <td>{{ $log->member->name }}</td>
            <td>{{ $log->member->school }}</td>
            <td>{{ \Carbon\Carbon::parse($log->time_in)->format('h:i A') }}</td>
            <td><button class="logout" onclick="timeOut({{ $log->id }}, this)">Time Out</button></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    </div>
  </div>

  <div class="modal" id="registerModal">
    <div class="modal-content">
      <h3>Register New Member</h3>
      <label>Full Name</label>
      <input type="text" id="name">

      <label>Age</label>
      <input type="number" id="age">

      <label>Address</label>
      <input type="text" id="address">

      <label>Contact Number</label>
      <input type="text" id="contactnumber" maxlength="11" pattern="\d{11}" oninput="this.value = this.value.replace(/\D/g, '')">

      <label>School</label>
      <input type="text" id="school">

      <div class="actions">
        <button class="btn-cancel" onclick="closeRegisterModal()">Cancel</button>
        <button class="btn-confirm" onclick="submitRegister()">Submit</button>
      </div>
    </div>
  </div>
  <div class="modal" id="scanQRModal">
  <div class="modal-content" style="max-width: 500px;">
    <h3>📷 Scan Member QR</h3>
    <div id="qr-reader" style="width: 100%; height: auto;"></div>
    <div class="actions">
      <button class="btn-cancel" onclick="closeScanQRModal()">Cancel</button>
    </div>
  </div>
</div>



  <div class="corner-popup" id="popup" style="display:none;"></div>

  <script>
    // Dark mode functionality
    document.addEventListener('DOMContentLoaded', function() {
      const darkModeToggle = document.getElementById('darkModeToggle');
      const darkModeLabel = document.getElementById('darkModeLabel');

      // Detect system preference
      const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
      const savedMode = localStorage.getItem('darkMode');
      const isDark = savedMode ? savedMode === 'true' : prefersDarkMode;

      // Apply mode
      document.body.classList.toggle('dark-mode', isDark);
      darkModeToggle.checked = isDark;
      darkModeLabel.textContent = isDark ? 'Dark Mode' : 'Light Mode';

      // Toggle dark mode
      darkModeToggle.addEventListener('change', () => {
        const isChecked = darkModeToggle.checked;
        document.body.classList.toggle('dark-mode', isChecked);
        localStorage.setItem('darkMode', isChecked);
        darkModeLabel.textContent = isChecked ? 'Dark Mode' : 'Light Mode';

        // Add transition class for smooth animation
        document.body.classList.add('dark-mode-transition');
        setTimeout(() => {
          document.body.classList.remove('dark-mode-transition');
        }, 600);
      });
    });
  </script>
  <script src="{{ asset('js/timelog.js') }}"></script>
  <script src="{{ asset('js/memberscript.js') }}"></script>
  <script src="{{ asset('js/sidebarcollapse.js')}}"></script>
  <script src="{{ asset('js/scanqr.js')}}"></script>
  <script src="{{ asset('js/overdue.js') }}"></script>
</body>
</html>
