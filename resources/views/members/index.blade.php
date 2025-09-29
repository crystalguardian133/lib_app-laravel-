<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>👥 Members | Julita Public Library</title>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
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

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
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
  body {
    font-family: 'Outfit', 'Inter', sans-serif;
    background: linear-gradient(135deg, var(--background), #f1f5f9);
    color: var(--text-primary);
    line-height: 1.6;
    transition: background 0.4s cubic-bezier(0.4, 0, 0.2, 1), color 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    min-height: 100vh;
    overflow-x: hidden;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    position: relative;
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

        #registerModal,
        #julitaRegisterModal {
            z-index: 1500;
        }

        /* Edit modal should have higher z-index */
        #editModal {
            z-index: 2000;
        }

        /* QR modal should have highest z-index */
        .qr-modal {
            z-index: 2500;
        }

        /* Make sure modal show state is properly defined */
        .modal.show {
            display: flex !important;
            animation: fadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Prevent body scroll when modal is open */
        body.modal-open {
            overflow: hidden;
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
  body:not(.dark-mode) .sidebar .label {
    color: #1a1a1a;
  }

        .sidebar.collapsed {
            width: 70px;
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
  .label {
    font-weight: 700;
    font-size: 1.1rem;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    transition: var(--transition);
  }

        .sidebar.collapsed .sidebar-header h3,
        .sidebar.collapsed .label {
            opacity: 0;
            pointer-events: none;
        }

        .toggle-btn {
            background: rgba(255,255,255,0.1);
            color: white;
            border: none;
            padding: 12px;
            font-size: 1.1rem;
            border-radius: 12px;
            cursor: pointer;
            margin-bottom: 1.5rem;
            transition: all 0.2s;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .toggle-btn:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-1px);
        }

        .sidebar nav {
            flex: 1;
        }

  /* Nav Links */
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
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    color: #ffffff;
    transform: translateX(6px);
    box-shadow: var(--shadow-md);
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
  /* Light mode navigation */
  body:not(.dark-mode) .sidebar nav a {
    color: rgba(0, 0, 0, 0.8);
  }
  body:not(.dark-mode) .sidebar nav a:hover {
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    color: #1a1a1a;
    box-shadow: var(--shadow-md);
  }
  body:not(.dark-mode) .sidebar nav a.active {
    background: rgba(59, 130, 246, 0.15);
    color: #3b82f6;
    border-left: 3px solid #3b82f6;
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

        .logout-link {
            display: flex;
            align-items: center;
            gap: 8px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
            padding: 8px;
            border-radius: 8px;
        }

        .logout-link:hover {
            color: white;
            background: rgba(255,255,255,0.1);
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

  /* Page Header */
  .page-header {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: var(--spacing-xl);
    flex-wrap: wrap;
    gap: var(--spacing);
  }

  .page-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    max-width: 1200px;
  }

  .page-header-left {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  /* Page Title */
  .dashboard-title {
    position: sticky;
    top: 0;
    z-index: 100;
    background: transparent;
    padding: 1rem 0;
    margin: -1rem 0 1rem 0;
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary);
    animation: fadeInDown 0.8s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .page-controls {
    display: flex;
    gap: var(--spacing-sm);
    align-items: center;
  }

  /* Search Bar */
  .search-bar {
    width: 300px;
    padding: 12px 16px 12px 40px;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    color: var(--text-primary);
    font-size: 0.95rem;
    transition: var(--transition);
    position: relative;
  }

  .search-container {
    position: relative;
  }

  .search-container::before {
    content: '\f002';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    z-index: 1;
  }

  .search-bar:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
  }

  /* Buttons */
  .btn {
    padding: 12px 20px;
    border: none;
    border-radius: var(--radius);
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition-spring);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    position: relative;
    overflow: hidden;
  }

  .btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
  }

  .btn:hover::before {
    left: 100%;
  }

  .btn-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    box-shadow: var(--shadow);
  }

  .btn-primary:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: var(--shadow-lg);
  }

  .btn-outline {
    background: transparent;
    color: var(--primary);
    border: 1px solid var(--primary);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
  }

  .btn-outline:hover {
    background: var(--glass-bg);
    transform: translateY(-2px) scale(1.05);
    box-shadow: var(--shadow-md);
  }

  .btn-sm {
    padding: 8px 12px;
    font-size: 0.85rem;
  }

  .btn-danger {
    background: linear-gradient(135deg, var(--danger), #dc2626);
    color: white;
    box-shadow: var(--shadow);
  }

  .btn-danger:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: var(--shadow-lg);
  }

  .btn-success {
    background: linear-gradient(135deg, var(--success), #059669);
    color: white;
    box-shadow: var(--shadow);
  }

  .btn-success:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: var(--shadow-lg);
  }

        .btn-sm {
            padding: 8px 16px;
            font-size: 0.8rem;
            min-width: auto;
            white-space: nowrap;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            border-radius: 6px;
            font-weight: 600;
            position: relative;
            overflow: hidden;
        }

        .btn-sm::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-sm:hover::before {
            left: 100%;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }

        .action-buttons .btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .action-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .action-buttons .btn:active {
            transform: translateY(0px) scale(1.02);
        }

        .action-buttons .btn i {
            margin-right: 4px;
            transition: transform 0.2s ease;
        }

        .action-buttons .btn:hover i {
            transform: scale(1.1);
        }

        .action-buttons .btn:focus {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        .action-buttons .btn:focus:not(:focus-visible) {
            outline: none;
        }

        .action-buttons .btn:focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        .btn-sm .icon {
            font-size: 0.875rem;
        }

        /* Bulk actions bar */
        .bulk-actions {
            background: rgba(79, 70, 229, 0.1);
            border: 2px solid rgba(79, 70, 229, 0.2);
            border-radius: 16px;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            display: none;
            align-items: center;
            gap: 1rem;
            animation: slideDown 0.3s ease-out;
        }

        .bulk-actions.show {
            display: flex;
        }

        .bulk-actions-text {
            flex: 1;
            font-weight: 600;
            color: var(--primary);
        }

        body.dark-mode .bulk-actions {
            background: rgba(6, 182, 212, 0.1);
            border-color: rgba(6, 182, 212, 0.2);
        }

        body.dark-mode .bulk-actions-text {
            color: var(--accent-light);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

  /* Table Styles */
  .table-container {
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--glass-shadow);
    margin-top: var(--spacing-lg);
    display: flex;
    justify-content: center;
    align-items: flex-start;
    max-height: 70vh;
  }

        .table-container::-webkit-scrollbar {
            height: 8px;
        }

        .table-container::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }

        .table-container::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        body.dark-mode .table-container {
            background: rgba(30, 41, 59, 0.9);
            border-color: rgba(51, 65, 85, 0.3);
        }

  .data-table {
    width: 100%;
    border-collapse: collapse;
    background: transparent;
    min-width: fit-content;
    table-layout: fixed;
    margin: 0;
  }

  .data-table th {
    background: var(--glass-bg);
    color: var(--text-primary);
    font-weight: 600;
    padding: 16px 12px;
    text-align: center;
    border-bottom: 2px solid var(--border);
    position: sticky;
    top: 0;
    z-index: 10;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
  }

        th::after {
            content: '';
            position: absolute;
            right: 0;
            top: 25%;
            height: 50%;
            width: 1px;
            background: rgba(255,255,255,0.2);
        }

        th:first-child {
            width: 200px;
            min-width: 180px;
        }

        th:nth-child(2) {
            width: 80px;
            min-width: 60px;
        }

        th:nth-child(3) {
            width: 250px;
            min-width: 200px;
        }

        th:nth-child(4) {
            width: 150px;
            min-width: 120px;
        }

        th:nth-child(5) {
            width: 200px;
            min-width: 150px;
        }

        th:nth-child(6) {
            width: 140px;
            min-width: 120px;
        }

        th:nth-child(7) {
            width: 120px;
            min-width: 100px;
        }

        th:nth-child(8) {
            width: 120px;
            min-width: 100px;
        }

  .data-table td {
    padding: 16px 12px;
    border-bottom: 1px solid var(--border-light);
    color: var(--text-secondary);
    font-size: 0.9rem;
    vertical-align: middle;
    text-align: center;
    max-width: 150px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

        td:first-child {
            text-align: left;
            width: 200px;
            min-width: 180px;
        }

        td:nth-child(2) {
            width: 80px;
            min-width: 60px;
            text-align: center;
        }

        td:nth-child(3) {
            width: 250px;
            min-width: 200px;
        }

        td:nth-child(4) {
            width: 150px;
            min-width: 120px;
        }

        td:nth-child(5) {
            width: 200px;
            min-width: 150px;
        }

        td:nth-child(6) {
            width: 140px;
            min-width: 120px;
        }

        td:nth-child(7) {
            width: 120px;
            min-width: 100px;
        }

        td:nth-child(8) {
            width: 120px;
            min-width: 100px;
        }

  .data-table tr:hover {
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
  }

  .data-table tr:last-child td {
    border-bottom: none;
  }

        .member-checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--accent);
            border-radius: 4px;
        }

        /* Select all checkbox */
        #selectAll {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--accent);
        }

  /* Modal Styles */
  .modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: 2000;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .modal.show {
    display: flex !important;
    opacity: 1;
    animation: fadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 9999 !important;
  }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

  .modal-content, .modal-card {
    background: var(--surface-elevated);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-lg);
    padding: 2rem;
    width: 100%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: var(--shadow-xl);
    animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
  }

        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(40px) scale(0.95);
            }
            to { 
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        body.dark-mode .modal-content {
            background: rgba(15, 23, 42, 0.95);
            color: var(--text-dark);
            border-color: rgba(51, 65, 85, 0.3);
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(0,0,0,0.05);
        }

        body.dark-mode .modal-header {
            border-bottom-color: rgba(255,255,255,0.1);
        }

        .modal-title {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        body.dark-mode .modal-title {
            color: var(--accent-light);
        }

        .close-modal {
            background: rgba(0,0,0,0.05);
            border: none;
            font-size: 1.5rem;
            color: var(--gray);
            cursor: pointer;
            padding: 8px;
            border-radius: 12px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .close-modal:hover {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            transform: rotate(90deg);
        }

        .form-section {
            margin-bottom: 2.5rem;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        body.dark-mode .section-title {
            color: var(--accent-light);
            border-bottom-color: rgba(255,255,255,0.1);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 0.8rem;
            color: var(--dark);
            font-size: 0.95rem;
        }

        body.dark-mode .form-group label {
            color: var(--text-dark);
        }

  .form-control {
    padding: 12px 16px;
    border: 2px solid var(--glass-border);
    border-radius: var(--radius);
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    color: var(--text-primary);
    font-size: 1rem;
    transition: var(--transition);
    box-shadow: var(--shadow-sm);
  }

  .form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1), var(--shadow);
    background: var(--surface-elevated);
    transform: translateY(-1px);
  }

  .form-control:hover {
    border-color: var(--primary);
    transform: translateY(-1px);
  }

        /* Custom Select Styling */
        .form-group select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 40px;
        }

        body.dark-mode .form-group select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%9ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        }

        .form-group select option {
            background: white;
            color: var(--dark);
            padding: 8px;
        }

        body.dark-mode .form-group select option {
            background: var(--bg-dark);
            color: var(--text-dark);
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 2px solid rgba(0,0,0,0.05);
        }

        body.dark-mode .modal-actions {
            border-top-color: rgba(255,255,255,0.1);
        }

        .modal-actions .btn {
            min-width: 140px;
            justify-content: center;
        }

        /* Photo Upload Styles */
        .photo-upload {
            border: 2px dashed #e5e7eb;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .photo-upload:hover {
            border-color: var(--accent);
            background: rgba(6, 182, 212, 0.05);
        }

        .photo-upload input {
            display: none;
        }

        #photoPreview {
            max-width: 150px;
            border-radius: 12px;
            margin-top: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        /* QR Modal Styles */
        .qr-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
            z-index: 2500;
            justify-content: center;
            align-items: center;
        }

        .qr-modal.show {
            display: flex;
            animation: fadeIn 0.3s ease-out;
        }

        .qr-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 2.5rem;
            border-radius: 24px;
            text-align: center;
            box-shadow: var(--shadow-lg);
            animation: slideUp 0.3s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        body.dark-mode .qr-content {
            background: rgba(15, 23, 42, 0.95);
            color: var(--text-dark);
            border-color: rgba(51, 65, 85, 0.3);
        }

        .qr-content h3 {
            margin-bottom: 1.5rem;
            color: var(--primary);
            font-size: 1.5rem;
        }

        body.dark-mode .qr-content h3 {
            color: var(--accent-light);
        }

        .qr-content img {
            max-width: 300px;
            margin-bottom: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .form-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

 @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
                padding: 1rem;
                max-width: 100vw;
            }

            .modal {
                padding: 1rem;
            }

            .modal-content {
                padding: 1.5rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .modal-actions {
                flex-direction: column;
            }

            .modal-actions .btn {
                width: 100%;
            }

            .top-controls {
                flex-direction: column;
                align-items: stretch;
                gap: 0.75rem;
            }

            .search-box {
                min-width: auto;
                max-width: none;
            }

            .table-container {
                margin-top: 0.75rem;
            }

            th, td {
                padding: 0.75rem 0.5rem;
                font-size: 0.85rem;
            }

            .action-buttons {
                flex-direction: column;
                gap: 4px;
            }

            .btn-sm {
                padding: 4px 8px;
                font-size: 0.75rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .bulk-actions {
                flex-direction: column;
                text-align: center;
            }
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .slide-up {
            animation: slideUp 0.6s ease-out;
        }

        /* Loading State */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Success State */
        .success-flash {
            animation: successFlash 0.5s ease-out;
        }

.card-modal {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 100; top: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.6);
  justify-content: center;
  align-items: center;
}

.card-modal-content {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  width: 420px;
  position: relative;
  box-shadow: 0 6px 18px rgba(0,0,0,0.3);
}

.card-modal-content h2 {
  text-align: center;
  margin-bottom: 20px;
}

.card-modal-content .close {
  position: absolute;
  top: 10px; right: 15px;
  font-size: 22px;
  cursor: pointer;
}
.card-layout {
  display: flex;
  gap: 20px;
  justify-content: center;
  margin-top: 20px;
}

.card {
  width: 340px;  /* driver’s license size */
  height: 216px;
  position: relative;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.card-bg {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* overlay common */
.overlay {
  position: absolute;
  color: #000;
  font-family: Arial, sans-serif;
  pointer-events: none;
}


/* Name above the "Member" text in template */
/* Name: slightly above the middle of the card */
.overlay.name {
  position: absolute;
  top: 100px;      /* adjust for your template height */
  left: 37px;
  right: 25px;
  text-align: left;
  font-weight: bold;
  font-size: 10px;
  text-transform: uppercase;
  color: #fff;
}

/* Date: positioned beside "Membership Date :" text in template */
.overlay.date {
  position: absolute;
  bottom: 43px;   /* near the bottom, adjust to match template */
  left: 127px;    /* aligns next to pre-printed label */
  font-size: 13px;
  font-weight: bold;
  text-transform: uppercase;
  font-size: 12px;
  color: #fff;
}

/* Photo circle overlay */
.overlay.photo {
  position: absolute;
  top: 42px;
  right: 20px;
  width: 141px;
  height: 141px;
  border-radius: 50%;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #ddd;
}

.overlay.photo img {
  width: 100%;
  height: 100%;
  object-fit: cover;   /* ensures it fills and stays centered */
}

/* QR square */
.overlay.qr {
  top: 50%;
  left: 50%;
  width: 120px;
  height: 120px;
  transform: translate(-50%, -50%);
}

.overlay.qr img {
  width: 100%;
  height: 100%;
  object-fit: contain;
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
  @keyframes successFlash {
    0% { background: rgba(16, 185, 129, 0.2); }
    100% { background: transparent; }
  }
    </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <img src="/images/logo.png" alt="Logo" class="logo">
      <h3 class="label">Julita Public Library</h3>
    </div>
    
    <button class="toggle-btn" id="toggleSidebar" disabled>
      <i class="fas fa-bars"></i>
    </button>
    
    <nav>
      <a href="/dashboard">
        <span class="icon">🏠</span>s2
        <span class="label">Dashboard</span>
      </a>
      <a href="/books">
        <span class="icon">📘</span>
        <span class="label">Manage Books</span>
      </a>
      <a href="/members" class="active">
        <span class="icon">👥</span>
        <span class="label">Manage Members</span>
      </a>
      <a href="/timelog">
        <span class="icon">⏰</span>
        <span class="label">Time Logs</span>
      </a>
    </nav>
    
    <div class="dark-toggle">
      <label class="switch">
        <input type="checkbox" id="darkModeToggle">
        <span class="slider"></span>
      </label>
      <a href="/logout" class="logout-link">
        <span>🚪</span>
        <span class="label">Logout</span>
      </a>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main" id="mainContent">
    <div class="page-header">
      <h1 class="page-title">
        <span>👥</span>
        Registered Members
      </h1>
    </div>

    <div class="top-controls">
      <div class="search-box">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="searchInput" placeholder="Search members by name, address, or contact...">
      </div>
      <button class="btn btn-primary" onclick="openRegisterModal()">
        <i class="fas fa-user-plus"></i>
        Register Member
      </button>

   <!-- Members Table -->
<div class="table-container">
  <table id="membersTable">
    <thead>
      <tr>
        <th>Name</th>
        <th>Age</th>
        <th>Address</th>
        <th>Contact Number</th>
        <th>School</th>
        <th>Member Since</th>
        <th>Computer Time</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="membersTableBody">
      @if(isset($members) && $members->count())
        @foreach ($members as $member)
          <tr>
            {{-- Name --}}
            <td>
              {{ (!empty($member->last_name) && $member->last_name !== 'null') ? $member->last_name : '' }}
              @if (!empty($member->first_name) && $member->first_name !== 'null')
                {{ (!empty($member->last_name) && $member->last_name !== 'null') ? ', ' : '' }}{{ $member->first_name }}
              @endif
              @if (!empty($member->middle_name) && $member->middle_name !== 'null')
                {{ ' ' . $member->middle_name }}
              @endif
            </td>

            {{-- Age --}}
            <td>{{ $member->age ?? '' }}</td>

            {{-- Full Address --}}
            <td>
              {{ collect([
                (!empty($member->house_number) && $member->house_number !== 'null') ? $member->house_number : null,
                (!empty($member->street) && $member->street !== 'null') ? $member->street : null,
                (!empty($member->barangay) && $member->barangay !== 'null') ? $member->barangay : null,
                (!empty($member->municipality) && $member->municipality !== 'null') ? $member->municipality : null,
                (!empty($member->province) && $member->province !== 'null') ? $member->province : null
              ])->filter()->implode(', ') }}
            </td>

            {{-- Contact Number --}}
            <td>{{ (!empty($member->contactnumber) && $member->contactnumber !== 'null') ? $member->contactnumber : '' }}</td>

            {{-- School --}}
            <td>{{ (!empty($member->school) && $member->school !== 'null') ? $member->school : '' }}</td>

            {{-- Member Since --}}
            <td>
              @if (!empty($member->memberdate) && $member->memberdate !== 'null')
                {{ \Carbon\Carbon::parse($member->memberdate)->format('F j, Y') }}
              @endif
            </td>

            {{-- Computer Time --}}
            <td>{{ (!empty($member->member_time) && $member->member_time !== 'null') ? $member->member_time . ' min' : '' }}</td>

            {{-- Actions - Individual Edit and Download Buttons --}}
            <td>
              <div class="action-buttons">
                  <button 
                class="btn btn-sm btn-primary editBtn" 
                data-id="{{ $member->id }}"
                title="Edit Member">
                <i class="fas fa-edit"></i> Edit
                  </button>

<a href="javascript:void(0)" 
   onclick="openCardModal({{ $member->id }})"
   class="btn btn-sm btn-success" 
   title="Download ID Card">
  <i class="fas fa-download"></i>
</a>

              </div>
            </td>
          </tr>
        @endforeach
      @else
        <tr>
          <td colspan="8" style="text-align: center;">No members found.</td>
        </tr>
      @endif
    </tbody>
  </table>
</div>
  </div>

<!-- Register Member Modal -->
  <div class="modal" id="registerModal">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">
          <i class="fas fa-user-plus"></i>
          Register New Member
        </h2>
        <button class="close-modal" onclick="closeRegisterModal()">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <form id="registerForm">
        <!-- Personal Information Section -->
        <div class="form-section">
          <h3 class="section-title">
            <i class="fas fa-user"></i>
            Personal Information
          </h3>
          <div class="form-grid">
            <div class="form-group">
              <label for="firstName">First Name *</label>
              <input type="text" id="firstName" name="firstName" required>
            </div>
            <div class="form-group">
              <label for="middleName">Middle Name</label>
              <input type="text" id="middleName" name="middleName">
            </div>
            <div class="form-group">
              <label for="lastName">Last Name *</label>
              <input type="text" id="lastName" name="lastName" required>
            </div>
            <div class="form-group">
              <label for="age">Age *</label>
              <input type="number" id="age" name="age" min="1" max="150" required>
            </div>
          </div>
        </div>

        <!-- Address Information Section -->
        <div class="form-section">
          <h3 class="section-title">
            <i class="fas fa-map-marker-alt"></i>
            Address Information
          </h3>
          <div class="form-grid">
            <div class="form-group">
              <label for="houseNumber">House Number</label>
              <input type="text" id="houseNumber" name="houseNumber">
            </div>
            <div class="form-group">
              <label for="street">Street</label>
              <input type="text" id="street" name="street">
            </div>
            <div class="form-group">
              <label for="barangay">Barangay *</label>
              <input type="text" id="barangay" name="barangay" required>
            </div>
            <div class="form-group">
              <label for="municipality">Municipality/City *</label>
              <input type="text" id="municipality" name="municipality" required>
            </div>
            <div class="form-group">
              <label for="province">Province *</label>
              <input type="text" id="province" name="province" required>
            </div>
          </div>
        </div>

        <!-- Contact Information Section -->
        <div class="form-section">
          <h3 class="section-title">
            <i class="fas fa-phone"></i>
            Contact Information
          </h3>
          <div class="form-grid">
            <div class="form-group">
              <label for="contactNumber">Contact Number *</label>
              <input type="tel" id="contactNumber" name="contactNumber" pattern="[0-9]{11}" maxlength="11" required>
            </div>
            <div class="form-group">
              <label for="school">School/Institution</label>
              <input type="text" id="school" name="school">
            </div>
          </div>
        </div>
        
        <div class="form-section">
          <h3 class="section-title">
            <i class="fas fa-camera"></i>
            Upload Photo
          </h3>
          <div class="form-group">
            <label for="photoInput">Upload Photo</label>
            <input type="file" id="photo" name="photo" accept="image/*" class="form-control" />
            <div style="margin-top: 10px;">
              <img id="photoPreview" src="#" alt="Photo Preview" style="max-width: 150px; display: none;">
            </div>
          </div>
        </div>
        
        <div class="modal-actions">
          <button type="button" class="btn btn-secondary" onclick="closeRegisterModal()">
            <i class="fas fa-times"></i>
            Cancel
          </button>
          <button type="button" class="btn btn-primary" onclick="submitRegister()">
            <i class="fas fa-save"></i>
            Register Member
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Julita Register Modal -->
  <div class="modal" id="julitaRegisterModal">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">
          <i class="fas fa-user-plus"></i>
          Register Julita Resident
        </h2>
        <button class="close-modal" onclick="closeJulitaRegisterModal()">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <form id="julitaRegisterForm">
        <!-- Personal Information Section -->
        <div class="form-section">
          <h3 class="section-title">
            <i class="fas fa-user"></i>
            Personal Information
          </h3>
          <div class="form-grid">
            <div class="form-group">
              <label for="julitaFirstName">First Name *</label>
              <input type="text" id="julitaFirstName" name="firstName" required>
            </div>
            <div class="form-group">
              <label for="julitaMiddleName">Middle Name</label>
              <input type="text" id="julitaMiddleName" name="middleName">
            </div>
            <div class="form-group">
              <label for="julitaLastName">Last Name *</label>
              <input type="text" id="julitaLastName" name="lastName" required>
            </div>
            <div class="form-group">
              <label for="julitaAge">Age *</label>
              <input type="number" id="julitaAge" name="age" min="1" max="150" required>
            </div>
          </div>
        </div>

        <!-- Address Information Section -->
        <div class="form-section">
          <h3 class="section-title">
            <i class="fas fa-map-marker-alt"></i>
            Address Information
          </h3>
          <div class="form-grid">
            <div class="form-group">
              <label for="julitaHouseNumber">House Number</label>
              <input type="text" id="julitaHouseNumber" name="houseNumber">
            </div>
            <div class="form-group">
              <label for="julitaStreet">Street</label>
              <input type="text" id="julitaStreet" name="street">
            </div>
            <div class="form-group">
              <label for="julitaBarangay">Barangay *</label>
              <select id="julitaBarangay" name="barangay" required>
                <option value="" disabled selected>Select Barangay</option>
                <option>Alegria</option>
                <option>Balante</option>
                <option>Bugho</option>
                <option>Campina</option>
                <option>Canwhaton</option>
                <option>Caridad Norte</option>
                <option>Caridad Sur</option>
                <option>Cuatro de Agosto</option>
                <option>Dita</option>
                <option>Hinalaan</option>
                <option>Hindang</option>
                <option>Iniguihan</option>
                <option>Macopa</option>
                <option>San Andres</option>
                <option>San Pablo</option>
                <option>San Roque</option>
                <option>Santo Niño</option>
                <option>Sta. Cruz</option>
                <option>Taglibas</option>
                <option>Veloso</option>
              </select>
            </div>
            <div class="form-group">
              <label for="julitaMunicipality">Municipality *</label>
              <input type="text" id="julitaMunicipality" name="municipality" value="Julita" readonly>
            </div>
            <div class="form-group">
              <label for="julitaProvince">Province *</label>
              <input type="text" id="julitaProvince" name="province" value="Leyte" readonly>
            </div>
          </div>
        </div>

        <!-- Contact Information Section -->
        <div class="form-section">
          <h3 class="section-title">
            <i class="fas fa-phone"></i>
            Contact Information
          </h3>
          <div class="form-grid">
            <div class="form-group">
              <label for="julitaContactNumber">Contact Number *</label>
              <input type="tel" id="julitaContactNumber" name="contactNumber" pattern="[0-9]{11}" maxlength="11" required>
            </div>
            <div class="form-group">
              <label for="julitaSchool">School/Institution</label>
              <input type="text" id="julitaSchool" name="school">
            </div>
          </div>
        </div>
        
        <div class="form-section">
          <h3 class="section-title">
            <i class="fas fa-camera"></i>
            Upload Photo
          </h3>
          <div class="form-group">
            <label for="julitaPhoto">Upload Photo</label>
            <input type="file" id="julitaPhoto" name="photo" accept="image/*" class="form-control" />
            <div style="margin-top: 10px;">
              <img id="julitaPhotoPreview" src="#" alt="Photo Preview" style="max-width: 150px; display: none;">
            </div>
          </div>
        </div>
        
        <div class="modal-actions">
          <button type="button" class="btn btn-secondary" onclick="closeJulitaRegisterModal()">
            <i class="fas fa-times"></i>
            Cancel
          </button>
          <button type="button" class="btn btn-primary" onclick="submitRegister()">
            <i class="fas fa-save"></i>
            Register Member
          </button>
        </div>
      </form>
    </div>
  </div>

<!-- Membership Card Preview Modal -->
<div id="cardModal" class="card-modal">
  <div class="modal-content">
    <span class="close" onclick="closeCardModal()">&times;</span>

    <h3>Membership Card Preview</h3>

    <div id="card-container" class="card-layout">
      <!-- Front -->
<!-- Front -->
<div class="card front" id="card-front">
    <img src="{{ asset('card_temp/card-1.png') }}" class="card-bg">

    <!-- Name (slightly above middle) -->
    <div class="overlay name" id="card-name"></div>

    <!-- Date (beside "Membership Date :" text) -->
    <div class="overlay date" id="card-memberdate"></div>

    <!-- Photo circle -->
    <div class="overlay photo" id="card-photo"></div>
</div>
      <!-- Back -->
      <div class="card back" id="card-back">
        <img src="{{ asset('card_temp/card-2.png') }}" class="card-bg">

        <!-- QR overlay -->
        <div class="overlay qr" id="card-qr"></div>
      </div>
    </div>

    <button onclick="downloadCard()">Download PNG</button>
  </div>
</div>

  <!-- Edit Member Modal -->
  <div class="modal" id="editModal">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">
          <i class="fas fa-edit"></i>
          Edit Member Information
        </h2>
        <button class="close-modal" onclick="closeEditModal()">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <form id="editForm">
        <input type="hidden" id="editMemberId" name="memberId">
        
        <!-- Personal Information Section -->
        <div class="form-section">
          <h3 class="section-title"><i class="fas fa-user"></i> Personal Information</h3>
          <div class="form-grid">
            <div class="form-group">
              <label for="editFirstName">First Name *</label>
              <input type="text" id="editFirstName" name="firstName" required>
            </div>
            <div class="form-group">
              <label for="editMiddleName">Middle Name</label>
              <input type="text" id="editMiddleName" name="middleName">
            </div>
            <div class="form-group">
              <label for="editLastName">Last Name *</label>
              <input type="text" id="editLastName" name="lastName" required>
            </div>
            <div class="form-group">
              <label for="editAge">Age *</label>
              <input type="number" id="editAge" name="age" min="1" max="150" required>
            </div>
          </div>
        </div>

        <!-- Address Information Section -->
        <div class="form-section">
          <h3 class="section-title"><i class="fas fa-map-marker-alt"></i> Address Information</h3>
          <div class="form-grid">
            <div class="form-group">
              <label for="editHouseNumber">House Number</label>
              <input type="text" id="editHouseNumber" name="houseNumber">
            </div>
            <div class="form-group">
              <label for="editStreet">Street</label>
              <input type="text" id="editStreet" name="street">
            </div>
            <div class="form-group">
              <label for="editBarangay">Barangay *</label>
              <input type="text" id="editBarangay" name="barangay" required>
            </div>
            <div class="form-group">
              <label for="editMunicipality">Municipality/City *</label>
              <input type="text" id="editMunicipality" name="municipality" required>
            </div>
            <div class="form-group">
              <label for="editProvince">Province *</label>
              <input type="text" id="editProvince" name="province" required>
            </div>
          </div>
        </div>

        <!-- Contact Information Section -->
        <div class="form-section">
          <h3 class="section-title"><i class="fas fa-phone"></i> Contact Information</h3>
          <div class="form-grid">
            <div class="form-group">
              <label for="editContactNumber">Contact Number *</label>
              <input type="tel" id="editContactNumber" name="contactNumber" pattern="[0-9]{11}" maxlength="11" required>
            </div>
            <div class="form-group">
              <label for="editSchool">School/Institution</label>
              <input type="text" id="editSchool" name="school">
            </div>
          </div>
        </div>
          
        <div class="modal-actions">
          <button type="button" class="btn btn-danger" onclick="deleteMember()">
            Delete
          </button>
          <button type="button" class="btn btn-secondary" onclick="closeEditModal()">
            <i class="fas fa-times"></i> Cancel
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
<script>
// Dark mode functionality
const darkToggle = document.getElementById('darkModeToggle');

// Initialize dark mode on page load
document.addEventListener('DOMContentLoaded', function() {
  const darkMode = localStorage.getItem('darkMode') === 'true';
  if (darkMode) {
    document.body.classList.add('dark-mode');
    darkToggle.checked = true;
  }
});

// Dark mode toggle event listener
darkToggle.addEventListener('change', function() {
  document.body.classList.toggle('dark-mode');
  localStorage.setItem('darkMode', this.checked);
});

// Sidebar toggle functionality
const sidebar = document.getElementById('sidebar');
const mainContent = document.getElementById('mainContent');
const toggleBtn = document.getElementById('toggleSidebar');

toggleBtn.addEventListener('click', function() {
  sidebar.classList.toggle('collapsed');
  mainContent.classList.toggle('collapsed');
});

// Card preview function
function showCardPreviewModal(cardUrl) {
  document.getElementById("cardPreviewFrame").src = cardUrl;
  document.getElementById("downloadCardBtn").href = cardUrl;
  document.getElementById("cardPreviewModal").style.display = "block";
}

function closeCardPreviewModal() {
  document.getElementById("cardPreviewModal").style.display = "none";
  document.getElementById("cardPreviewFrame").src = "";
}

// Add missing openCardModal function
function openCardModal(memberId) {
  console.log('Opening card modal for member ID:', memberId);
  
  // Create a simple modal for card generation
  const modal = document.createElement('div');
  modal.style.cssText = `
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 3000;
  `;
  
  modal.innerHTML = `
    <div style="
      background: white;
      padding: 2rem;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
      max-width: 400px;
      width: 90%;
    ">
      <h3 style="margin-bottom: 1rem; color: #333;">📄 Generate ID Card</h3>
      <p style="margin-bottom: 1.5rem; color: #666;">Generate ID card for member ID: ${memberId}</p>
      <div style="display: flex; gap: 1rem; justify-content: center;">
        <button onclick="this.closest('.modal').remove()" style="
          padding: 8px 16px;
          background: #6b7280;
          color: white;
          border: none;
          border-radius: 6px;
          cursor: pointer;
        ">Cancel</button>
        <button onclick="generateCard(${memberId})" style="
          padding: 8px 16px;
          background: #10b981;
          color: white;
          border: none;
          border-radius: 6px;
          cursor: pointer;
        ">Generate Card</button>
      </div>
    </div>
  `;
  
  modal.className = 'modal';
  document.body.appendChild(modal);
  
  // Close modal when clicking outside
  modal.addEventListener('click', function(e) {
    if (e.target === modal) {
      modal.remove();
    }
  });
}

function generateCard(memberId) {
  // This would typically generate and download the card
  alert(`Card generated for member ID: ${memberId}`);
  document.querySelector('.modal').remove();
}

// Ensure buttons work properly
document.addEventListener('DOMContentLoaded', function() {
  console.log('Members page JavaScript loaded successfully');
  
  // Test if edit buttons are being found
  const editButtons = document.querySelectorAll('.editBtn');
  console.log('Found edit buttons:', editButtons.length);
  
  // Add click event listeners to edit buttons as backup
  editButtons.forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      const memberId = this.getAttribute('data-id');
      console.log('Edit button clicked for member ID:', memberId);
      
      // Let the existing memberedit.js handle the functionality
      // This is just a backup to ensure the button is clickable
    });
  });
});

</script>

<!-- External Scripts - ONLY INCLUDE EACH ONCE -->
<script src="{{ asset('js/overdue.js') }}"></script>
<script src="{{ asset('js/photoprev.js') }}"></script>
<script src="{{ asset('js/membersearch.js') }}"></script>
<script src="{{ asset('js/memberscript.js') }}"></script>
<script src="{{ asset('js/memberedit.js') }}"></script>
<script src="{{ asset('js/sidebarcollapse.js') }}"></script>
<script src="{{ asset('js/showqr.js') }}"></script>
<script src="{{ asset('js/qrgen.js') }}"></script>
<script src="{{ asset('js/card_gen.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>


</body>
</html>