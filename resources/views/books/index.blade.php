<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>📚 Library Admin - Books</title>
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
  body:not(.dark-mode) .sidebar .label {
    color: #1a1a1a;
  }
  /* Sidebar Header Styles - Ensure these are in your CSS */
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
  .label {
    font-weight: 700;
    font-size: 1.1rem;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    transition: var(--transition);
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
  /* Logout Button */
  .logout-section {
    margin-top: 16px;
    display: flex;
    justify-content: center;
  }
  .logout-btn {
    background: linear-gradient(135deg, var(--danger), #dc2626);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: var(--radius);
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: var(--transition);
    box-shadow: var(--shadow);
  }
  .logout-btn:hover {
    background: linear-gradient(135deg, var(--danger), #dc2626) !important;
    color: white !important;
    border-color: var(--danger) !important;
    box-shadow: var(--shadow) !important;
    transform: translateY(-2px);
  }
  .logout-btn:hover .logout-text {
    color: white !important;
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

  /* Books Content */
  .books-content {
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


  .books-content::-webkit-scrollbar {
    width: 6px;
  }
  
  .books-content::-webkit-scrollbar-thumb {
    background: var(--text-muted);
    border-radius: 8px;
  }
  
  .books-content::-webkit-scrollbar-track {
    background: var(--border-light);
  }

  .table-wrapper {
    width: 100%;
    display: flex;
    justify-content: center;
    max-height: 70vh;
    overflow: auto;
    min-width: fit-content;
  }

  .table-wrapper::-webkit-scrollbar {
    width: 6px;
  }

  .table-wrapper::-webkit-scrollbar-thumb {
    background: var(--text-muted);
    border-radius: 8px;
  }

  .table-wrapper::-webkit-scrollbar-track {
    background: var(--border-light);
  }

  .table-wrapper {
    max-height: 70vh;
    overflow: auto;
    border-radius: var(--radius-lg);
  }

  /* Tooltip Styles */
  .data-table td[title]:hover::after {
    content: attr(title);
    position: absolute;
    background: var(--surface-elevated);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-sm);
    padding: 8px 12px;
    font-size: 0.85rem;
    color: var(--text-primary);
    box-shadow: var(--shadow-lg);
    z-index: 1000;
    white-space: nowrap;
    max-width: 300px;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-top: -40px;
    margin-left: 10px;
  }

  .data-table .status-badge[title]:hover::after {
    margin-top: -30px;
    margin-left: 0;
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

  /* Custom Button Styles for Modals */
  .btn-cancel {
    background: linear-gradient(135deg, #9ca3af, #6b7280);
    color: white;
    box-shadow: var(--shadow);
    transition: var(--transition-spring);
  }

  .btn-cancel:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: var(--shadow-lg);
    background: linear-gradient(135deg, #6b7280, #4b5563);
  }

  .btn-confirm {
    background: linear-gradient(135deg, var(--success), #059669);
    color: white;
    box-shadow: var(--shadow);
    transition: var(--transition-spring);
  }

  .btn-confirm:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: var(--shadow-lg);
    background: linear-gradient(135deg, #059669, #047857);
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

  .data-table td:last-child {
    width: 120px;
    min-width: 120px;
    max-width: 120px;
    padding-left: 8px;
    padding-right: 12px;
  }

  .data-table tr:hover {
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
  }

  .data-table tr:last-child td {
    border-bottom: none;
  }

  /* Book Cover in Table */
  .book-cover-small {
    width: 40px;
    height: 55px;
    object-fit: cover;
    border-radius: var(--radius-sm);
    box-shadow: var(--shadow);
    transition: var(--transition);
  }

  .book-cover-small:hover {
    transform: scale(2.5);
    z-index: 100;
    box-shadow: var(--shadow-xl);
  }

  /* Action Buttons in Table */
  .action-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 1fr 1fr;
    gap: 4px;
    align-items: center;
    justify-items: center;
    width: 110px;
    height: 55px;
    padding: 3px;
    position: relative;
    margin: 0 0 0 8px;
    justify-self: start;
  }

  /* Grid layout for action buttons */
  .action-buttons .btn {
    width: 100%;
    height: 100%;
    min-height: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    padding: 3px 4px;
    cursor: pointer;
    pointer-events: auto;
    position: relative;
    z-index: 1;
  }

  /* Enhanced button hover effects for scroll */
  .action-buttons .btn {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
  }

  .action-buttons .btn:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
  }

  /* Grid button hover effects */
  .action-buttons .btn:hover {
    transform: translateY(-1px) scale(1.02);
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.2);
    z-index: 10;
  }

  /* Active button state */
  .action-buttons .btn:active {
    transform: translateY(0) scale(0.98);
    box-shadow: 0 1px 4px rgba(99, 102, 241, 0.3);
  }

  /* Button click animation */
  .action-buttons .btn.clicked {
    animation: buttonClick 0.2s ease-out;
  }

  @keyframes buttonClick {
    0% {
      transform: translateY(0) scale(1);
    }
    50% {
      transform: translateY(1px) scale(0.95);
    }
    100% {
      transform: translateY(0) scale(1);
    }
  }

  /* Scroll indicator for action buttons */
  .action-buttons.scrollable::after {
    content: '⟨⟩';
    position: absolute;
    right: 2px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 12px;
    color: var(--text-muted);
    opacity: 0.7;
    pointer-events: none;
  }

  .action-buttons .btn {
    padding: 6px 8px;
    font-size: 0.8rem;
    min-width: 40px;
    justify-content: center;
  }

  /* Status badges */
  .status-badge {
    padding: 4px 12px;
    border-radius: var(--radius);
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .status-available {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));
    color: var(--success);
    border: 1px solid rgba(16, 185, 129, 0.2);
  }

  .status-unavailable {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1));
    color: var(--danger);
    border: 1px solid rgba(239, 68, 68, 0.2);
  }

  /* Loading state */
  .loading {
    text-align: center;
    color: var(--text-muted);
    font-style: italic;
    padding: 40px 20px;
  }

  /* Selection Mode */
  .selection-mode {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background: linear-gradient(135deg, var(--accent), var(--accent-dark));
    color: white;
    padding: var(--spacing-lg) var(--spacing-xl);
    z-index: 1000;
    display: none;
    justify-content: space-between;
    align-items: center;
    font-weight: 600;
    box-shadow: var(--shadow-lg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
  }

  .selection-info {
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
  }

  .selection-controls {
    display: flex;
    gap: var(--spacing-sm);
  }

  .selection-actions {
    display: flex;
    gap: var(--spacing-sm);
  }

  /* Select All / Unselect All buttons */
  .btn-select-all {
    background: rgba(16, 185, 129, 0.2);
    color: var(--success);
    border: 1px solid rgba(16, 185, 129, 0.3);
    padding: 8px 12px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border-radius: var(--radius);
  }

  .btn-select-all:hover {
    background: rgba(16, 185, 129, 0.3);
    border-color: var(--success);
    transform: translateY(-1px);
  }

  .btn-unselect-all {
    background: rgba(107, 114, 128, 0.2);
    color: var(--text-muted);
    border: 1px solid rgba(107, 114, 128, 0.3);
    padding: 8px 12px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border-radius: var(--radius);
  }

  .btn-unselect-all:hover {
    background: rgba(107, 114, 128, 0.3);
    border-color: var(--text-muted);
    color: var(--text-primary);
    transform: translateY(-1px);
  }

  /* Row selection */
  .data-table tr.selected {
    background: rgba(99, 102, 241, 0.1) !important;
    border-left: 4px solid var(--primary);
  }

  .data-table tr.selected td {
    color: var(--primary);
  }

  /* Checkbox styling */
  .checkbox-cell {
    width: 40px;
    text-align: center;
  }

  .book-checkbox {
    width: 18px;
    height: 18px;
    accent-color: var(--primary);
    cursor: pointer;
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
    z-index: 999997; /* Base modal z-index */
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: 999997; /* Base modal overlay z-index */
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .modal-overlay.active {
    opacity: 1;
  }

  .modal.show {
    display: flex !important;
    opacity: 1;
    animation: fadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  }

  /* Z-index hierarchy for modals - Highest to Lowest */
  #borrowModal {
    z-index: 999998 !important; /* Borrow modal above base modals */
  }

  #qrScannerModal {
    z-index: 999999 !important; /* QR scanner modal highest among modals */
  }
@keyframes slideUp {
    from { 
        opacity: 0; 
        transform: translateY(30px) scale(0.95); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0) scale(1); 
    }
}

  /* Ensure borrow modal remains functional */
  #borrowModal {
    pointer-events: auto !important;
    user-select: text !important;
  }

  #borrowModal.show {
    pointer-events: auto !important;
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
      transform: translateY(30px) scale(0.95); 
    }
    to { 
      opacity: 1; 
      transform: translateY(0) scale(1); 
    }
  }

  body.dark-mode .modal-content,
  body.dark-mode .modal-card {
    background: var(--surface-elevated);
    color: var(--text-primary);
    border-color: var(--glass-border);
  }

  .modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--border-light);
  }

  body.dark-mode .modal-header {
    border-bottom-color: var(--border);
  }

  .modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0;
  }

  .modal-close, .close-modal {
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    font-size: 1.2rem;
    color: var(--text-secondary);
    cursor: pointer;
    padding: 8px 12px;
    border-radius: var(--radius);
    transition: var(--transition);
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .modal-close:hover, .close-modal:hover {
    background: var(--glass-bg);
    color: var(--danger);
    transform: scale(1.1);
    border-color: var(--danger);
  }

  .modal-body {
    padding: 0;
    margin-bottom: 1.5rem;
  }

  .modal-footer, .modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 2px solid var(--border-light);
  }

  body.dark-mode .modal-footer,
  body.dark-mode .modal-actions {
    border-top-color: var(--border);
  }

  .form-section {
    margin-bottom: 2rem;
  }

  .section-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 10px;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid var(--border-light);
  }

  .form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
  }

  .form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 1.5rem;
  }

  .form-group label {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
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

  /* Custom Time Picker Styling */
  .custom-time-picker select {
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border: 2px solid var(--glass-border);
    color: var(--text-primary);
    transition: var(--transition);
    border-radius: var(--radius);
    padding: 8px 12px;
    font-size: 1rem;
    font-weight: 500;
  }

  .custom-time-picker select:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    background: var(--surface-elevated);
  }

  /* Books List Styling */
  .books-list-container ul li {
    padding: 12px 16px;
    margin-bottom: 8px;
    background: var(--surface);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: var(--transition);
  }

  .books-list-container ul li:hover {
    background: var(--surface-elevated);
    border-color: var(--primary);
    transform: translateY(-1px);
  }

  .books-list-container ul li button {
    background: var(--danger);
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
    font-size: 12px;
  }

  .books-list-container ul li button:hover {
    background: #dc2626;
    transform: scale(1.1);
  }

  /* Cover Preview Area */
  #cover-preview-area {
    border: 2px dashed var(--border);
    border-radius: var(--radius-md);
    padding: 2rem;
    text-align: center;
    transition: var(--transition);
    cursor: pointer;
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    margin-bottom: 1.5rem;
  }

  #cover-preview-area:hover {
    border-color: var(--primary);
    background: rgba(99, 102, 241, 0.05);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
  }

  #cover-preview-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
  }

  #cover-upload-icon {
    font-size: 2.5rem;
    color: var(--text-muted);
    transition: var(--transition);
  }

  #cover-preview-area:hover #cover-upload-icon {
    color: var(--primary);
    transform: scale(1.1);
  }

  #cover-preview-text {
    color: var(--text-muted);
    margin: 0;
    font-weight: 500;
    font-size: 1rem;
  }

  .cover-input {
    display: none;
  }

  /* Toast Notifications */
  .toast-notification {
    position: fixed;
    top: 100px;
    right: 20px;
    padding: 12px 20px;
    border-radius: var(--radius);
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    box-shadow: var(--shadow-lg);
    z-index: 99999999999;
    animation: toastSlideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    max-width: 320px;
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border: 1px solid rgba(255, 255, 255, 0.1);
  }

  @keyframes toastSlideIn {
    from {
      opacity: 0;
      transform: translateX(100%) scale(0.8);
    }
    to {
      opacity: 1;
      transform: translateX(0) scale(1);
    }
  }

  .toast-notification.toast-info {
    background: linear-gradient(135deg, var(--accent), var(--accent-dark));
  }

  .toast-notification.toast-success {
    background: linear-gradient(135deg, var(--success), #059669);
  }

  .toast-notification.toast-warning {
    background: linear-gradient(135deg, var(--warning), #d97706);
  }

  .toast-notification.toast-error {
    background: linear-gradient(135deg, var(--danger), #dc2626);
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
    .sidebar nav a .label {
      display: none !important;
    }
    .main {
      margin-left: 80px;
      min-width: calc(100% - 80px);
      padding: var(--spacing-lg);
    }
    .page-header {
      flex-direction: column;
      align-items: stretch;
    }
    .page-header-content {
      flex-direction: column;
      gap: var(--spacing);
    }
    .page-controls {
      justify-content: space-between;
      flex-wrap: wrap;
    }
    .search-bar {
      width: 100%;
      max-width: none;
      margin-top: var(--spacing);
    }
    .data-table {
      font-size: 0.8rem;
    }
    .data-table th,
    .data-table td {
      padding: 10px 8px;
    }
    .table-container {
      max-height: 60vh;
    }
    .table-wrapper {
        max-height: 60vh;
    }

    /* Selection mode responsive */
    .selection-mode {
      flex-direction: column;
      gap: var(--spacing);
      padding: var(--spacing);
    }

    .selection-info {
      flex-direction: column;
      gap: var(--spacing-sm);
      align-items: flex-start;
    }

    .selection-controls {
      width: 100%;
      justify-content: space-between;
    }

    .btn-select-all,
    .btn-unselect-all {
      flex: 1;
      justify-content: center;
      font-size: 0.8rem;
      padding: 6px 8px;
    }

    .action-buttons {
        width: 95px;
        height: 48px;
        gap: 3px;
        padding: 2px;
        margin: 0 0 0 6px;
        justify-self: start;
    }

    .action-buttons .btn {
        min-height: 20px;
        font-size: 0.65rem;
        padding: 2px 3px;
    }
}
  @media (max-width: 480px) {
    .main {
      padding: var(--spacing);
    }
    .books-content {
      padding: var(--spacing);
    }
    .dashboard-title {
      font-size: 1.5rem;
    }
    .table-container {
      max-height: 50vh;
    }
    .table-wrapper {
        max-height: 50vh;
    }

    /* Mobile selection mode */
    .selection-info {
      width: 100%;
    }

    .selection-controls {
      flex-direction: column;
      gap: var(--spacing-xs);
    }

    .btn-select-all,
    .btn-unselect-all {
      width: 100%;
      font-size: 0.75rem;
      padding: 8px;
    }

    .action-buttons {
        width: 85px;
        height: 42px;
        gap: 2px;
        padding: 2px;
        margin: 0 0 0 4px;
        justify-self: start;
    }

    .action-buttons .btn {
        min-height: 18px;
        font-size: 0.6rem;
        padding: 2px 3px;
    }
}

/* Modern Modal Styles */
.modern-modal-container {
  background: var(--surface-elevated);
  border-radius: var(--radius-xl);
  box-shadow: var(--shadow-xl);
  width: 100%;
  max-width: 800px;
  max-height: 450px;
  aspect-ratio: 16 / 9;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transform: scale(0.9) translateY(20px);
  opacity: 0;
  transition: var(--transition);
}

.modal-overlay.active .modern-modal-container {
  transform: scale(1) translateY(0);
  opacity: 1;
}

.modern-modal-header {
  padding: var(--spacing-lg) var(--spacing-xl);
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-shrink: 0;
  position: sticky;
  top: 0;
  z-index: 10;
  background: var(--surface-elevated);
  backdrop-filter: var(--glass-blur);
  -webkit-backdrop-filter: var(--glass-blur);
}

.header-gradient-bg {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(135deg, rgba(99, 102, 241, 0.08), rgba(6, 182, 212, 0.08));
  z-index: 1;
}

.header-content {
  display: flex;
  align-items: center;
  gap: 1rem;
  position: relative;
  z-index: 2;
}

.modal-icon-container {
  width: 48px;
  height: 48px;
  background: linear-gradient(135deg, var(--primary), var(--accent));
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 1.2rem;
  box-shadow: var(--shadow-lg);
  animation: iconBounce 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.icon-glow {
  animation: iconBounce 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.title-section {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}

.modal-main-title {
  font-size: 1.8rem;
  font-weight: 700;
  color: var(--text-primary);
  margin: 0;
  background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.modal-description {
  font-size: 0.9rem;
  color: var(--text-muted);
  margin: 0;
  font-weight: 500;
}

.modern-close-btn {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-full);
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: var(--transition-fast);
  color: var(--text-muted);
  position: relative;
  z-index: 2;
}

.modern-close-btn:hover {
  background: var(--danger);
  color: white;
  border-color: var(--danger);
}

.modern-modal-body {
  padding: var(--spacing-xl) var(--spacing-2xl);
  flex: 1;
  overflow-y: auto;
  overflow-x: hidden;
  min-height: 0;
}

.modern-modal-body::-webkit-scrollbar {
  width: 8px;
}

.modern-modal-body::-webkit-scrollbar-thumb {
  background: var(--primary);
  border-radius: var(--radius);
}

.modern-modal-body::-webkit-scrollbar-track {
  background: var(--border-light);
}

.modern-modal-footer {
  padding: var(--spacing-sm) var(--spacing-xl);
  border-top: 1px solid var(--border);
  display: flex;
  gap: var(--spacing-sm);
  justify-content: flex-end;
  flex-shrink: 0;
  align-items: center;
}

.footer-actions {
  display: flex;
  gap: var(--spacing-sm);
}

.btn-cancel-premium {
  background: linear-gradient(135deg, #9ca3af, #6b7280);
  color: white;
  box-shadow: var(--shadow);
  transition: var(--transition-spring);
  border: none;
  padding: 12px 24px;
  border-radius: var(--radius-lg);
  font-weight: 600;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.btn-cancel-premium:hover {
  transform: translateY(-2px) scale(1.05);
  box-shadow: var(--shadow-lg);
  background: linear-gradient(135deg, #6b7280, #4b5563);
}

.btn-submit-premium {
  background: linear-gradient(135deg, var(--success), #059669);
  color: white;
  box-shadow: var(--shadow);
  transition: var(--transition-spring);
  border: none;
  padding: 12px 24px;
  border-radius: var(--radius-lg);
  font-weight: 600;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  position: relative;
  overflow: hidden;
}

.btn-submit-premium:hover {
  transform: translateY(-2px) scale(1.05);
  box-shadow: var(--shadow-lg);
  background: linear-gradient(135deg, #059669, #047857);
}

.btn-glow {
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
  transition: left 0.5s ease;
}

.btn-submit-premium:hover .btn-glow {
  left: 100%;
}

/* Premium Form Styles */
.premium-form-section {
  margin-bottom: 2rem;
  animation: slideInFromLeft 0.6s ease-out;
  background: var(--glass-bg);
  backdrop-filter: var(--glass-blur);
  -webkit-backdrop-filter: var(--glass-blur);
  border: 1px solid var(--glass-border);
  border-radius: var(--radius-lg);
  padding: var(--spacing-lg) var(--spacing-xl);
  box-shadow: var(--glass-shadow);
  transition: var(--transition);
}

.premium-form-section:nth-child(even) {
  animation: slideInFromRight 0.6s ease-out;
}

.premium-form-section:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow-lg), var(--shadow-glow);
  border-color: rgba(99, 102, 241, 0.3);
}

.section-header {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 1.5rem;
}

.section-icon-box {
  width: 40px;
  height: 40px;
  background: linear-gradient(135deg, var(--primary), var(--accent));
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 1rem;
  box-shadow: var(--shadow-sm);
}

.section-info h3 {
  font-size: 1.3rem;
  font-weight: 600;
  color: var(--primary);
  margin: 0 0 0.25rem 0;
}

.section-info p {
  font-size: 0.9rem;
  color: var(--text-muted);
  margin: 0;
  font-weight: 500;
}

.premium-upload-area {
  border: 3px dashed var(--border);
  border-radius: var(--radius-lg);
  padding: var(--spacing-xl);
  text-align: center;
  transition: var(--transition-fast);
  cursor: pointer;
  background: var(--surface);
  position: relative;
  overflow: hidden;
}

.premium-upload-area:hover {
  border-color: var(--primary);
  background: rgba(99, 102, 241, 0.05);
  transform: translateY(-2px);
  box-shadow: var(--shadow-md);
}

.upload-zone {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 16px;
}

.upload-visual {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
}

.upload-icon-circle {
  width: 48px;
  height: 48px;
  background: linear-gradient(135deg, var(--primary), var(--accent));
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 1.2rem;
  box-shadow: var(--shadow-md);
  animation: iconBounce 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.upload-animations .floating-dots span {
  width: 6px;
  height: 6px;
  background: var(--primary);
  border-radius: 50%;
  display: inline-block;
  animation: floatingDots 2s ease-in-out infinite;
}

.upload-animations .floating-dots span:nth-child(1) { animation-delay: 0s; }
.upload-animations .floating-dots span:nth-child(2) { animation-delay: 0.2s; }
.upload-animations .floating-dots span:nth-child(3) { animation-delay: 0.4s; }

@keyframes floatingDots {
  0%, 100% { transform: translateY(0); opacity: 0.5; }
  50% { transform: translateY(-10px); opacity: 1; }
}

.upload-text-content {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.upload-title {
  font-size: 1.2rem;
  font-weight: 600;
  color: var(--text-primary);
  margin: 0;
}

.upload-subtitle {
  font-size: 0.9rem;
  color: var(--text-muted);
  margin: 0;
}

.upload-requirements {
  display: flex;
  gap: 12px;
  justify-content: center;
  flex-wrap: wrap;
}

.req-item {
  display: flex;
  align-items: center;
  gap: 4px;
  font-size: 0.8rem;
  color: var(--text-muted);
}

.req-item i {
  color: var(--success);
}

.hidden-file-input {
  display: none;
}

.elegant-form-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.5rem;
}

.premium-form-group {
  display: flex;
  flex-direction: column;
  animation: bounceIn 0.5s ease-out;
  padding: 0 var(--spacing-sm);
}

.premium-form-group:nth-child(1) { animation-delay: 0.1s; }
.premium-form-group:nth-child(2) { animation-delay: 0.2s; }
.premium-form-group:nth-child(3) { animation-delay: 0.3s; }
.premium-form-group:nth-child(4) { animation-delay: 0.4s; }
.premium-form-group:nth-child(5) { animation-delay: 0.5s; }

.premium-label {
  font-weight: 600;
  color: var(--text-primary);
  margin-bottom: 0.5rem;
  font-size: 0.95rem;
  display: flex;
  align-items: center;
  gap: 8px;
}

.premium-label i {
  color: var(--primary);
  font-size: 0.85rem;
}

.required-indicator {
  color: var(--danger);
  font-weight: bold;
}

.input-wrapper {
  position: relative;
}

.premium-input {
  padding: 12px 16px;
  border: 2px solid var(--glass-border);
  border-radius: 12px;
  background: var(--glass-bg);
  backdrop-filter: var(--glass-blur);
  -webkit-backdrop-filter: var(--glass-blur);
  color: var(--text-primary);
  font-size: 1rem;
  transition: all 0.3s ease;
  box-shadow: var(--glass-shadow);
  width: 100%;
}

.premium-input:focus {
  outline: none;
  border-color: var(--primary);
  box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1), 0 4px 12px rgba(0, 0, 0, 0.1);
  background: rgba(255, 255, 255, 1);
  transform: translateY(-1px);
}

.premium-input:hover {
  border-color: var(--primary);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
  transform: translateY(-1px);
}

.input-focus-line {
  position: absolute;
  bottom: 0;
  left: 50%;
  width: 0;
  height: 2px;
  background: linear-gradient(135deg, var(--primary), var(--accent));
  transition: all 0.3s ease;
  transform: translateX(-50%);
}

.premium-input:focus + .input-focus-line {
  width: 100%;
}

.full-width {
  grid-column: 1 / -1;
}

/* Dark mode adjustments for modern modal */
body.dark-mode .modern-modal-container {
  background: var(--surface-elevated);
  color: var(--text-primary);
  border-color: var(--glass-border);
}

body.dark-mode .modern-modal-header {
  background: rgba(30, 30, 30, 0.8);
  border-bottom-color: rgba(255, 255, 255, 0.1);
}

body.dark-mode .modern-close-btn {
  background: rgba(30, 41, 59, 0.9);
  border-color: rgba(71, 85, 105, 0.5);
  color: var(--text-muted);
}

body.dark-mode .modern-close-btn:hover {
  background: var(--danger);
  border-color: var(--danger);
  color: white;
}

body.dark-mode .premium-input {
  background: rgba(30, 41, 59, 0.9);
  border-color: rgba(71, 85, 105, 0.5);
  color: var(--text-primary);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

body.dark-mode .premium-input:focus {
  background: rgba(30, 41, 59, 1);
  border-color: var(--accent);
  box-shadow: 0 0 0 4px rgba(6, 182, 212, 0.1), 0 4px 12px rgba(0, 0, 0, 0.3);
}

body.dark-mode .premium-input:hover {
  border-color: rgba(255, 255, 255, 0.2);
}

body.dark-mode .premium-upload-area {
  background: rgba(30, 41, 59, 0.3);
  border-color: #9ca3af;
}

body.dark-mode .premium-upload-area:hover {
  background: rgba(6, 182, 212, 0.1);
  border-color: var(--accent);
}

/* QR Scanner Modal - Right Side */
.qr-scanner-modal {
  position: fixed;
  top: 0;
  right: 0;
  width: 350px;
  height: 100vh;
  background: var(--surface-elevated);
  backdrop-filter: var(--glass-blur);
  -webkit-backdrop-filter: var(--glass-blur);
  border-left: 1px solid var(--glass-border);
  box-shadow: var(--shadow-xl);
  z-index: 9999;
  transform: translateX(100%);
  transition: transform 0.3s ease;
  display: flex;
  flex-direction: column;
}

.qr-scanner-modal.active {
  transform: translateX(0);
}

.qr-scanner-content {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.qr-scanner-header {
  padding: var(--spacing-lg);
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: var(--surface-elevated);
}

.qr-scanner-header h3 {
  margin: 0;
  color: var(--text-primary);
  font-size: 1.2rem;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 8px;
}

.qr-scanner-close {
  background: none;
  border: none;
  color: var(--text-muted);
  font-size: 1.2rem;
  cursor: pointer;
  padding: 8px;
  border-radius: var(--radius);
  transition: var(--transition);
}

.qr-scanner-close:hover {
  background: var(--glass-bg);
  color: var(--danger);
}

.qr-scanner-body {
  flex: 1;
  padding: var(--spacing-lg);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: var(--spacing-md);
}

.qr-reader-container {
  width: 100%;
  height: 300px;
  border: 2px solid var(--border);
  border-radius: var(--radius);
  background: var(--surface);
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
}

.qr-placeholder {
  text-align: center;
  color: var(--text-muted);
}

.qr-placeholder i {
  font-size: 3rem;
  margin-bottom: 10px;
  display: block;
}

.qr-instruction {
  text-align: center;
  color: var(--text-muted);
  font-size: 0.9rem;
  margin: 0;
}

/* QR Scanner Modal - Right Side */
.qr-scanner-modal {
  position: fixed;
  top: 0;
  right: 0;
  width: 350px;
  height: 100vh;
  background: var(--surface-elevated);
  backdrop-filter: var(--glass-blur);
  -webkit-backdrop-filter: var(--glass-blur);
  border-left: 1px solid var(--glass-border);
  box-shadow: var(--shadow-xl);
  z-index: 9999;
  transform: translateX(100%);
  transition: transform 0.3s ease;
  display: flex;
  flex-direction: column;
}

.qr-scanner-modal.active {
  transform: translateX(0);
}

.qr-scanner-content {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.qr-scanner-header {
  padding: var(--spacing-lg);
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: var(--surface-elevated);
}

.qr-scanner-header h3 {
  margin: 0;
  color: var(--text-primary);
  font-size: 1.2rem;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 8px;
}

.qr-scanner-close {
  background: none;
  border: none;
  color: var(--text-muted);
  font-size: 1.2rem;
  cursor: pointer;
  padding: 8px;
  border-radius: var(--radius);
  transition: var(--transition);
}

.qr-scanner-close:hover {
  background: var(--glass-bg);
  color: var(--danger);
}

.qr-scanner-body {
  flex: 1;
  padding: var(--spacing-lg);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: var(--spacing-md);
}

.qr-reader-container {
  width: 100%;
  height: 300px;
  border: 2px solid var(--border);
  border-radius: var(--radius);
  background: var(--surface);
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
}

.qr-placeholder {
  text-align: center;
  color: var(--text-muted);
}

.qr-placeholder i {
  font-size: 3rem;
  margin-bottom: 10px;
  display: block;
}

.qr-instruction {
  text-align: center;
  color: var(--text-muted);
  font-size: 0.9rem;
  margin: 0;
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

@keyframes iconBounce {
  0% { transform: scale(0) rotate(-180deg); }
  50% { transform: scale(1.3) rotate(-90deg); }
  100% { transform: scale(1) rotate(0deg); }
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
            <a href="{{ route('dashboard') }}" data-label="Dashboard">
                <span class="icon"><i class="fas fa-home"></i></span>
                <span class="label">Dashboard</span>
            </a>
            <a href="{{ route('books.index') }}" class="active" data-label="Books">
                <span class="icon"><i class="fas fa-book"></i></span>
                <span class="label">Books</span>
            </a>
            <a href="{{ route('members.index') }}" data-label="Members">
                <span class="icon"><i class="fas fa-users"></i></span>
                <span class="label">Members</span>
            </a>
            <a href="{{ route('timelog.index') }}" data-label="Member Time-in/out">
                <span class="icon"><i class="fas fa-user-clock"></i></span>
                <span class="label">Member Time-in/out</span>
            </a>
        </nav>
         <!-- Settings and Logout Buttons -->
         <div style="margin-top: auto; margin-bottom: var(--spacing-lg); display: flex; align-items: center; justify-content: center; gap: 8px;">
            <button onclick="openSettingsModal()" class="settings-btn" style="display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; padding: 0; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); color: var(--text-secondary); cursor: pointer; transition: var(--transition); font-size: 16px; box-shadow: var(--shadow-sm); flex-shrink: 0;" title="Settings">
                <i class="fas fa-cog"></i>
            </button>
            <div class="logout-section" style="display: flex; justify-content: center; flex: 1;">
                <form method="POST" action="{{ route('logout') }}" style="margin: 0; padding: 0; width: 100%;">
                    @csrf
                    <button type="submit" class="logout-btn" style="
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        gap: 8px;
                        width: 100%;
                        padding: 10px 12px;
                        background: transparent;
                        color: var(--text-secondary);
                        border: 1px solid var(--border);
                        border-radius: var(--radius);
                        font-size: 12px;
                        font-weight: 600;
                        cursor: pointer;
                        transition: all 0.3s ease;
                        box-shadow: none;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                    ">
                        <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                        <span class="label logout-text" style="font-size: 13.5px; font-weight: bold;">Logout</span>
                    </button>
                </form>
            </div>
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

    <!-- Main Content -->
    <div class="main" id="mainContent">
        <div class="dashboard-title">BOOKS MANAGEMENT</div>
        <div class="books-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <div class="page-header-left">
                        <i class="fas fa-book" style="color: var(--primary); font-size: 1.5rem;"></i>
                        <span style="font-size: 1.2rem; font-weight: 600; color: var(--text-primary);">Book Collection</span>
                    </div>
                    <div class="page-controls">
                        <div class="search-container">
                            <input type="text" class="search-bar" placeholder="Search by title, author, or genre..." id="searchInput">
                        </div>
                        <button class="btn btn-success" onclick="openQuickBorrowModal()">
                            <i class="fas fa-hand-holding"></i> Quick Borrow
                        </button>
                        <button class="btn btn-outline" onclick="enterSelectionMode()" id="selectButton">
                            <i class="fas fa-check-square"></i> Select
                        </button>
                        <button class="btn btn-primary" onclick="openAddBookModal()">
                            <i class="fas fa-plus"></i> Add Book
                        </button>
                    </div>
                </div>
            </div>
            <!-- Books Table -->
            <div class="table-container">
                <div class="table-wrapper">
                    <table class="data-table" id="booksTable">
                    <thead>
                        <tr>
                            <th>Cover</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Genre</th>
                            <th>Year</th>
                            <th>Status</th>
                            <th>Available</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="booksTableBody">
                        @forelse($books as $book)
                        <tr data-id="{{ $book->id }}"
                            data-title="{{ $book->title }}"
                            data-author="{{ $book->author }}"
                            data-genre="{{ $book->genre }}"
                            data-published-year="{{ $book->published_year }}"
                            data-availability="{{ $book->availability }}"
                            data-cover-image="{{ $book->cover_image ?? '' }}"
                            data-qr-url="{{ $book->qr_url ?? '' }}">
                            <td>
                                <img src="{{ $book->cover_image ?? '/images/no-cover.png' }}" alt="Cover" class="book-cover-small">
                            </td>
                            <td style="font-weight: 600; color: var(--text-primary);" title="{{ $book->title }}">{{ $book->title }}</td>
                            <td title="{{ $book->author }}">{{ $book->author }}</td>
                            <td title="{{ $book->genre }}">
                                <span style="background: rgba(99, 102, 241, 0.1); color: var(--primary); padding: 4px 8px; border-radius: 6px; font-size: 0.8rem; font-weight: 500;">
                                    {{ $book->genre }}
                                </span>
                            </td>
                            <td title="{{ $book->published_year }}">{{ $book->published_year }}</td>
                            <td title="{{ $book->availability > 0 ? 'Available' : 'Out of Stock' }}">
                                <span class="status-badge {{ $book->availability > 0 ? 'status-available' : 'status-unavailable' }}">
                                    {{ $book->availability > 0 ? 'Available' : 'Out of Stock' }}
                                </span>
                            </td>
                            <td title="{{ $book->availability }} copies">
                                <strong style="color: var(--text-primary);">{{ $book->availability }}</strong> copies
                            </td>
                            <td>
                                <div class="action-buttons">
                                    @if(!empty($book->qr_url))
                                        <button class="btn btn-outline btn-sm" onclick="showQRModal('{{ $book->title }}', '{{ $book->qr_url }}')" title="View QR Code">
                                            <i class="fas fa-qrcode"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-outline btn-sm" onclick="window.generateQr({{ $book->id }})" title="Generate QR Code">
                                            <i class="fas fa-qrcode"></i> Gen
                                        </button>
                                    @endif
                                    <button class="btn btn-success btn-sm" onclick="window.borrowOne({{ $book->id }})" title="Borrow Book" {{ $book->availability <= 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-hand-holding"></i>
                                    </button>
                                    <button class="btn btn-primary btn-sm" onclick="window.editBook({{ $book->id }})" title="Edit Book">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="window.deleteBook({{ $book->id }})" title="Delete Book">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="loading" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                <i class="fas fa-book" style="font-size: 3rem; margin-bottom: 15px; display: block;"></i>
                                <p>No books found. Add your first book to get started!</p>
                                <button class="btn btn-primary" onclick="openAddBookModal()" style="margin-top: 15px;">
                                    <i class="fas fa-plus"></i> Add Book
                                </button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination-container" style="margin-top: var(--spacing-lg); display: flex; justify-content: center;">
                {{ $books->links() }}
            </div>
        </div>
    </div>

    <!-- Selection Mode Bar -->
    <div class="selection-mode" id="selectionBar">
      <div class="selection-info">
        <span id="selectedCount">0 books selected</span>
        <div class="selection-controls">
          <button class="btn btn-select-all" onclick="selectAllBooks()">
            <i class="fas fa-check-square"></i> Select All
          </button>
          <button class="btn btn-unselect-all" onclick="unselectAllBooks()">
            <i class="fas fa-square"></i> Unselect All
          </button>
        </div>
      </div>
      <div class="selection-actions">
        <button class="btn btn-outline" style="color:white; border-color: white;" onclick="exitSelectionMode()">
          <i class="fas fa-times"></i> Cancel
        </button>
        <button class="btn" style="background:white; color:var(--accent);" onclick="openBorrowModal()">
          <i class="fas fa-hand-holding"></i> Borrow Selected
        </button>
        <button class="btn" id="editButton" style="background:white; color:#7e22ce; display:none;" onclick="openEditModal()">
          <i class="fas fa-edit"></i> Edit
        </button>
        <button class="btn btn-danger" style="background: var(--danger);" onclick="deleteSelected()">
          <i class="fas fa-trash"></i> Delete
        </button>
      </div>
    </div>

    <!-- ADD BOOK MODAL - FULLY REDESIGNED -->
    <div class="modal-overlay" id="addBookModal">
      <div class="modern-modal-container">
        <!-- Animated Header with Gradient Background -->
        <div class="modern-modal-header">
          <div class="header-gradient-bg"></div>
          <div class="header-content">
            <div class="modal-icon-container">
              <div class="icon-glow">
                <i class="fas fa-plus-circle"></i>
              </div>
            </div>
            <div class="title-section">
              <h1 class="modal-main-title">Add New Book</h1>
              <p class="modal-description">Expand your library collection with a new book entry</p>
            </div>
          </div>
          <button class="modern-close-btn" onclick="closeAddBookModal()" aria-label="Close modal">
            <i class="fas fa-times"></i>
          </button>
        </div>

        <!-- Enhanced Scrollable Body -->
        <div class="modern-modal-body">
          <form id="addBookForm" enctype="multipart/form-data" novalidate>

            <!-- Premium Cover Upload Section -->
            <div class="premium-form-section cover-section">
              <div class="section-header">
                <div class="section-icon-box">
                  <i class="fas fa-camera-retro"></i>
                </div>
                <div class="section-info">
                  <h3 class="section-title">Book Cover Image</h3>
                  <p class="section-subtitle">Upload a stunning cover image for your book</p>
                </div>
              </div>

              <div class="premium-upload-area" id="cover-preview-area">
                <div class="upload-zone" id="cover-preview-content">
                  <div class="upload-visual">
                    <div class="upload-icon-circle">
                      <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div class="upload-animations">
                      <div class="floating-dots">
                        <span></span><span></span><span></span>
                      </div>
                    </div>
                  </div>
                  <div class="upload-text-content">
                    <h4 class="upload-title">Drop your image here</h4>
                    <p class="upload-subtitle">or click to browse files</p>
                    <div class="upload-requirements">
                      <span class="req-item"><i class="fas fa-check-circle"></i> JPG, PNG, GIF</span>
                      <span class="req-item"><i class="fas fa-check-circle"></i> Max 5MB</span>
                      <span class="req-item"><i class="fas fa-check-circle"></i> High quality</span>
                    </div>
                  </div>
                  <input type="file" id="cover-input" name="cover" class="hidden-file-input" accept="image/*">
                </div>
              </div>
            </div>

            <!-- Elegant Book Details Section -->
            <div class="premium-form-section details-section">
              <div class="section-header">
                <div class="section-icon-box">
                  <i class="fas fa-book-open"></i>
                </div>
                <div class="section-info">
                  <h3 class="section-title">Book Details</h3>
                  <p class="section-subtitle">Enter the essential information about your book</p>
                </div>
              </div>

              <div class="elegant-form-grid">
                <div class="premium-form-group">
                  <label for="bookTitle" class="premium-label">
                    <i class="fas fa-heading"></i>
                    <span class="label-text">Book Title</span>
                    <span class="required-indicator">*</span>
                  </label>
                  <div class="input-wrapper">
                    <input type="text" id="bookTitle" name="title" class="premium-input" required placeholder="Enter the book title" autocomplete="off">
                    <div class="input-focus-line"></div>
                  </div>
                </div>

                <div class="premium-form-group">
                  <label for="bookAuthor" class="premium-label">
                    <i class="fas fa-user-edit"></i>
                    <span class="label-text">Author Name</span>
                    <span class="required-indicator">*</span>
                  </label>
                  <div class="input-wrapper">
                    <input type="text" id="bookAuthor" name="author" class="premium-input" required placeholder="Enter author name" autocomplete="off">
                    <div class="input-focus-line"></div>
                  </div>
                </div>

                <div class="premium-form-group">
                  <label for="bookGenre" class="premium-label">
                    <i class="fas fa-tags"></i>
                    <span class="label-text">Genre/Category</span>
                  </label>
                  <div class="input-wrapper">
                    <input type="text" id="bookGenre" name="genre" class="premium-input" placeholder="e.g., Fiction, Science, History" autocomplete="off">
                    <div class="input-focus-line"></div>
                  </div>
                </div>

                <div class="premium-form-group">
                  <label for="bookYear" class="premium-label">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="label-text">Publication Year</span>
                    <span class="required-indicator">*</span>
                  </label>
                  <div class="input-wrapper">
                    <input type="number" id="bookYear" name="published_year" class="premium-input" required min="1000" max="2099" placeholder="e.g., 2023">
                    <div class="input-focus-line"></div>
                  </div>
                </div>

                <div class="premium-form-group full-width">
                  <label for="bookAvailability" class="premium-label">
                    <i class="fas fa-hashtag"></i>
                    <span class="label-text">Available Copies</span>
                    <span class="required-indicator">*</span>
                  </label>
                  <div class="input-wrapper">
                    <input type="number" id="bookAvailability" name="availability" class="premium-input" required min="0" placeholder="Number of copies available">
                    <div class="input-focus-line"></div>
                  </div>
                </div>
              </div>
            </div>

          </form>
        </div>

        <!-- Premium Footer with Enhanced Actions -->
        <div class="modern-modal-footer">
          <div class="footer-actions">
            <button type="button" class="btn-cancel-premium" onclick="closeAddBookModal()">
              <i class="fas fa-times"></i>
              <span>Cancel</span>
            </button>
            <button type="button" class="btn-submit-premium" onclick="submitAddBookFromBooksIndex()">
              <i class="fas fa-plus-circle"></i>
              <span>Add Book</span>
              <div class="btn-glow"></div>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- EDIT BOOK MODAL -->
    <div class="modal" id="manage-modal">
        <div class="modal-content" style="max-width: 600px;">
            <div class="modal-header">
                <h2 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Edit Book
                </h2>
                <button class="close-modal" onclick="closeEditBookModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="editBookForm" enctype="multipart/form-data">
                    <!-- Cover Image Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-image"></i>
                            Book Cover
                        </h3>
                        <div id="cover-preview-area" style="border: 2px dashed var(--border); border-radius: var(--radius-md); padding: 2rem; text-align: center; cursor: pointer; background: var(--glass-bg); margin-bottom: 1.5rem;">
                            <div id="cover-preview-content">
                                <i id="cover-upload-icon" class="fas fa-cloud-upload-alt" style="font-size: 2.5rem; color: var(--text-muted);"></i>
                                <p id="cover-preview-text" style="color: var(--text-muted); margin: 0; font-weight: 500; font-size: 1rem;">Click or drag image here...</p>
                                <small style="color: var(--text-muted); margin-top: 8px; display: block;">
                                    Supports JPG, PNG, GIF (max 5MB)
                                </small>
                                <input type="file" id="cover-input" class="cover-input" accept="image/*" style="display: none;">
                            </div>
                        </div>
                    </div>
                    <!-- Book Information Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-book"></i>
                            Book Information
                        </h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="edit-title">Title *</label>
                                <input type="text" id="edit-title" name="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-author">Author *</label>
                                <input type="text" id="edit-author" name="author" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-genre">Genre</label>
                                <input type="text" id="edit-genre" name="genre" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="edit-published-year">Published Year *</label>
                                <input type="number" id="edit-published-year" name="published_year" class="form-control" required min="1000" max="2099">
                            </div>
                            <div class="form-group">
                                <label for="edit-availability">Availability *</label>
                                <input type="number" id="edit-availability" name="availability" class="form-control" required min="0">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-cancel" onclick="closeEditBookModal()">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <button type="button" class="btn btn-danger" id="delete-button" onclick="deleteBook()">
                    <i class="fas fa-trash"></i>
                    Delete
                </button>
                <button type="button" class="btn btn-confirm" id="save-button" onclick="saveChanges()">
                    <i class="fas fa-save"></i>
                    Save Changes
                </button>
            </div>
        </div>
    </div>

    <!-- DELETE CONFIRMATION MODAL -->
    <div class="modal" id="deleteModal">
        <div class="modal-content" style="max-width: 400px;">
            <div class="modal-header">
                <h2 class="modal-title" style="color: var(--danger);">
                    <i class="fas fa-exclamation-triangle"></i>
                    Delete Book
                </h2>
                <button class="close-modal" onclick="closeDeleteModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" style="text-align: center;">
                <div style="margin: 20px 0;">
                    <i class="fas fa-trash-alt" style="font-size: 48px; color: var(--danger); margin-bottom: 15px;"></i>
                    <h3 id="deleteBookTitle" style="margin-bottom: 15px; color: var(--text-primary);">Book Title</h3>
                    <p style="color: var(--text-secondary); margin-bottom: 20px;">
                        Are you sure you want to delete this book? This action cannot be undone.
                    </p>
                    <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: var(--radius); padding: 15px; margin: 15px 0;">
                        <strong style="color: var(--danger);">Warning:</strong> This will permanently remove the book from the library system.
                    </div>
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-cancel" onclick="closeDeleteModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i> Delete Book
                </button>
            </div>
        </div>
    </div>

    <!-- QR CODE MODAL -->
    <div class="modal" id="qrModal">
        <div class="modal-content" style="max-width: 500px; text-align: center;">
            <div class="modal-header">
                <h3 class="modal-title">QR Code</h3>
                <button class="close-modal" onclick="closeQRModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <div id="qrContent">
                    <div id="qrPlaceholder" style="display: block;">
                        <i class="fas fa-qrcode" style="font-size: 80px; color: var(--text-muted); margin: 20px 0;"></i>
                        <p style="color: var(--text-muted); margin: 10px 0;">QR Code will appear here</p>
                        <p style="font-size: 0.9rem; color: var(--text-secondary);" id="qrBookTitle">Book Title</p>
                    </div>
                    <div id="qrCodeContainer" style="display: none;">
                        <img id="qrImage" src="" alt="QR Code" style="margin: 20px auto; display: block; border: 2px solid var(--border); border-radius: var(--radius); max-width: 250px; height: 250px;">
                        <p style="font-size: 1rem; color: var(--text-primary); margin: 15px 0; font-weight: 600;" id="qrBookTitleDisplay">Book Title</p>
                        <div style="margin-top: 20px;">
                            <button class="btn btn-cancel" onclick="downloadQR()" style="margin-right: 10px;">
                                <i class="fas fa-download"></i> Download QR
                            </button>
                            <button class="btn btn-confirm" onclick="printQR()">
                                <i class="fas fa-print"></i> Print QR
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- QR SCANNER MODAL - RIGHT SIDE -->
    <div class="qr-scanner-modal" id="qrScannerModal">
        <div class="qr-scanner-content">
            <div class="qr-scanner-header">
                <h3><i class="fas fa-qrcode"></i> QR Scanner</h3>
                <button class="qr-scanner-close" onclick="closeQRScannerModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="qr-scanner-body">
                <div class="qr-reader-container" id="qr-reader-container">
                    <div class="qr-placeholder">
                        <i class="fas fa-camera"></i>
                        <p>Initializing camera...</p>
                    </div>
                </div>
                <p class="qr-instruction">Point camera at QR codes to scan</p>
            </div>
        </div>
    </div>

    <!-- MEDIA PICKER MODAL -->
    <div class="modal" id="mediaPickerModal">
        <div class="modal-content" style="max-width: 800px;">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-images"></i>
                    Select Book Cover
                </h3>
                <button class="close-modal" onclick="closeMediaPicker()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-section">
                    <div class="form-group">
                        <label for="mediaSearch">Search Images</label>
                        <input type="text" id="mediaSearch" class="form-control" placeholder="Search by filename...">
                    </div>
                </div>

                <!-- Upload Area -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-cloud-upload-alt"></i>
                        Or Upload New Image
                    </h4>
                    <div id="media-upload-area" style="border: 2px dashed var(--border); border-radius: var(--radius-md); padding: 2rem; text-align: center; cursor: pointer; background: var(--glass-bg); margin-bottom: 1.5rem; transition: var(--transition);">
                        <div id="media-upload-content">
                            <i id="media-upload-icon" class="fas fa-cloud-upload-alt" style="font-size: 2.5rem; color: var(--text-muted); margin-bottom: 12px;"></i>
                            <p style="color: var(--text-muted); margin: 0; font-weight: 500; font-size: 1rem;">Drag and drop image here or click to browse</p>
                            <small style="color: var(--text-muted); margin-top: 8px; display: block;">Supports JPG, PNG, GIF (max 5MB)</small>
                            <input type="file" id="media-file-input" accept="image/*" style="display: none;">
                        </div>
                    </div>
                </div>

                <!-- Image Gallery -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-th"></i>
                        Available Images
                    </h4>
                    <div id="media-gallery" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 1rem; max-height: 300px; overflow-y: auto; padding: 1rem; border: 1px solid var(--border-light); border-radius: var(--radius-sm); background: var(--glass-bg);">
                        <!-- Images will be loaded here -->
                        <div id="media-loading" style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: var(--text-muted);">
                            <i class="fas fa-spinner fa-spin" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                            <p>Loading images...</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-cancel" onclick="closeMediaPicker()">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <!-- BORROW MODAL - PREMIUM REDESIGNED -->
    <div class="modal-overlay" id="borrowModal">
        <div class="modern-modal-container">
            <!-- Premium Header with Gradient Background -->
            <div class="modern-modal-header">
                <div class="header-gradient-bg"></div>
                <div class="header-content">
                    <div class="modal-icon-container">
                        <div class="icon-glow">
                            <i class="fas fa-hand-holding"></i>
                        </div>
                    </div>
                    <div class="title-section">
                        <h1 class="modal-main-title">Borrow Books</h1>
                        <p class="modal-description">Select books and set borrowing details</p>
                    </div>
                </div>
                <button class="modern-close-btn" onclick="closeBorrowModalWithScanner()" aria-label="Close modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- Enhanced Scrollable Body -->
            <div class="modern-modal-body">
                    <!-- Premium Member Information Section -->
                    <div class="premium-form-section member-section">
                    <div class="section-header">
                        <div class="section-icon-box">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="section-info">
                            <h3 class="section-title">Member Information</h3>
                            <p class="section-subtitle">Scan member QR code to identify borrower</p>
                        </div>
                    </div>

                    <div class="elegant-form-grid">
                        <div class="premium-form-group full-width">
                            <label for="memberName" class="premium-label">
                                <i class="fas fa-id-card"></i>
                                <span class="label-text">Member Name</span>
                            </label>
                            <div class="input-wrapper">
                                <input type="text" id="memberName" class="premium-input" placeholder="Scan QR code to fill member information" readonly style="background-color: var(--surface-elevated); cursor: not-allowed;">
                                <div class="input-focus-line"></div>
                            </div>
                            <input type="hidden" id="memberId">
                            <small style="display:block; margin-top:8px; color:var(--text-muted); font-size:0.85rem;">
                                <i class="fas fa-info-circle"></i> This field is automatically filled when you scan a member QR code
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Premium Borrow Details Section -->
                <div class="premium-form-section details-section">
                    <div class="section-header">
                        <div class="section-icon-box">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="section-info">
                            <h3 class="section-title">Borrow Details</h3>
                            <p class="section-subtitle">Set the due date and time for book return</p>
                        </div>
                    </div>

                    <div class="elegant-form-grid">
                        <div class="premium-form-group">
                            <label class="premium-label">
                                <i class="fas fa-calendar-day"></i>
                                <span class="label-text">Due Date</span>
                                <span class="required-indicator">*</span>
                            </label>
                            <div class="input-wrapper">
                                <div id="dueDateDisplay" class="premium-input" style="background: var(--surface-elevated); cursor: default; color: var(--text-primary); font-weight: 600; display: flex; align-items: center; padding: 12px 16px;">
                                    <i class="fas fa-calendar-check" style="margin-right: 8px; color: var(--primary);"></i>
                                    <span id="dueDateText">Today</span>
                                </div>
                                <div class="input-focus-line"></div>
                            </div>
                            <!-- Hidden input to store the actual date value -->
                            <input type="hidden" id="dueDate" name="dueDate" value="">
                            <small style="display:block; margin-top:8px; color:var(--text-secondary); font-size:0.85rem;">
                                <i class="fas fa-info-circle"></i> Automatically set to today's date
                            </small>
                        </div>

                        <div class="premium-form-group">
                            <label for="dueTime" class="premium-label">
                                <i class="fas fa-clock"></i>
                                <span class="label-text">Due Time</span>
                                <span class="required-indicator">*</span>
                            </label>
                            <div class="input-wrapper">
                                <div id="dueTimeDisplay" class="premium-input" style="background: var(--surface-elevated); cursor: default; color: var(--text-primary); font-weight: 600; display: flex; align-items: center; padding: 12px 16px;">
                                    <i class="fas fa-clock" style="margin-right: 8px; color: var(--primary);"></i>
                                    <span id="dueTimeText">4:30 PM</span>
                                </div>
                                <div class="input-focus-line"></div>
                            </div>
                            <!-- Hidden input to store the actual time value -->
                            <input type="hidden" id="dueTime" name="dueTime" value="16:30">
                            <small style="display:block; margin-top:8px; color:var(--text-secondary); font-size:0.85rem;">
                                <i class="fas fa-info-circle"></i> Due time is automatically set to 4:30 PM (maximum allowed)
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Premium Selected Books Section -->
                <div class="premium-form-section books-section">
                    <div class="section-header">
                        <div class="section-icon-box">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="section-info">
                            <h3 class="section-title">Selected Books</h3>
                            <p class="section-subtitle">Books selected for borrowing</p>
                        </div>
                    </div>

                    <div class="elegant-form-grid">
                        <div class="premium-form-group full-width">
                            <div class="books-list-container" style="border: 2px solid var(--glass-border); border-radius: var(--radius-lg); padding: var(--spacing-lg); background: var(--glass-bg); backdrop-filter: var(--glass-blur); -webkit-backdrop-filter: var(--glass-blur); min-height: 120px; max-height: 200px; overflow-y: auto;">
                                <ul id="selectedBooksList" style="list-style: none; padding: 0; margin: 0;"></ul>
                                <div id="emptyBooksMessage" style="text-align: center; color: var(--text-muted); padding: var(--spacing);">
                                    <i class="fas fa-book-open" style="font-size: 2rem; margin-bottom: 8px; display: block;"></i>
                                    <p style="margin: 0; font-size: 0.9rem;">No books selected yet</p>
                                    <small style="color: var(--text-secondary);">Use the buttons below to scan books</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- QR SCANNER MODAL - RIGHT SIDE -->
    <div class="qr-scanner-modal" id="qrScannerModal">
        <div class="qr-scanner-content">
            <div class="qr-scanner-header">
                <h3><i class="fas fa-qrcode"></i> QR Scanner</h3>
                <button class="qr-scanner-close" onclick="closeQRScannerModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="qr-scanner-body">
                <div class="qr-reader-container" id="qr-reader-container">
                    <div class="qr-placeholder">
                        <i class="fas fa-camera"></i>
                        <p>Initializing camera...</p>
                    </div>
                </div>
                <p class="qr-instruction">Point camera at QR codes to scan</p>
            </div>
        </div>
    </div>
   <script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
  <script src="{{ asset('js/borrow.js') }}"></script>
  <script src="{{ asset('js/bookadd.js') }}"></script>
  <script src="{{ asset('js/bookmanage.js') }}"></script>
  <script src="{{ asset('js/qrgen.js') }}"></script>
  <script src="{{ asset('js/showqr.js') }}"></script>
  <script src="{{ asset('js/overdue.js') }}"></script>

    <script>
        // Global variables
        let currentBookId = null;
        let isSelectionMode = false;
        // selectedBooks is declared in borrow.js - use that global variable

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

            // Initialize cover upload functionality
            initializeCoverUpload();
            initializeEditCoverUpload();
   
            // Override resetCoverPreview to also clear media picker selections
            const originalResetCoverPreview = window.resetCoverPreview;
            window.resetCoverPreview = function() {
                // Call original function if it exists
                if (originalResetCoverPreview) {
                    originalResetCoverPreview();
                }
   
                // Clear media picker selections
                window.selectedCoverImage = null;
                window.uploadedMediaFile = null;
            };

            // Philippine holidays for 2025
            const philippineHolidays = [
                '2025-01-01', '2025-02-25', '2025-04-17', '2025-04-18', '2025-04-19',
                '2025-05-01', '2025-06-12', '2025-08-25', '2025-11-01', '2025-11-30',
                '2025-12-25', '2025-12-30', '2025-12-31'
            ];

            window.isPhilippineHoliday = function(dateString) {
                return philippineHolidays.includes(dateString);
            };

            // Set default due date and time using Philippine timezone and business days
            function calculatePhilippineBusinessDueDate() {

                // Get current date in Philippine timezone (Asia/Manila, UTC+8)
                const now = new Date();
                const philippineOffset = 8 * 60; // 8 hours in minutes
                const utcTime = now.getTime() + (now.getTimezoneOffset() * 60000);
                const philippineTime = new Date(utcTime + (philippineOffset * 60000));

                // Start from current date for due date calculation
                const startDate = new Date(philippineTime);

                // Calculate 10 working days (Monday to Friday, excluding weekends and holidays)
                let workingDaysCount = 0;
                let currentDate = new Date(startDate);

                while (workingDaysCount < 10) {
                    // Move to next day
                    currentDate.setDate(currentDate.getDate() + 1);

                    // Check if it's a weekday (Monday = 1, Friday = 5) and not a holiday
                    const dayOfWeek = currentDate.getDay();
                    const dateString = currentDate.toISOString().split('T')[0];
                    if (dayOfWeek >= 1 && dayOfWeek <= 5 && !isPhilippineHoliday(dateString)) {
                        workingDaysCount++;
                    }
                }

                return {
                    date: currentDate.toISOString().split('T')[0],
                    time: '23:59' // End of day
                };
            }

            // Global function to set automatic due date
            window.setAutomaticDueDate = function() {
                // Get current date in Philippine timezone (Asia/Manila, UTC+8)
                const now = new Date();
                const philippineOffset = 8 * 60; // 8 hours in minutes
                const utcTime = now.getTime() + (now.getTimezoneOffset() * 60000);
                const philippineTime = new Date(utcTime + (philippineOffset * 60000));
                
                // Format date to YYYY-MM-DD for the input
                const year = philippineTime.getFullYear();
                const month = String(philippineTime.getMonth() + 1).padStart(2, '0');
                const day = String(philippineTime.getDate()).padStart(2, '0');
                const dateString = `${year}-${month}-${day}`;
                
                const dueDateInput = document.getElementById('dueDate');
                const dueDateText = document.getElementById('dueDateText');

                if (dueDateInput && dueDateText) {
                    // Set the hidden input value
                    dueDateInput.value = dateString;
                    
                    // Format date to readable format
                    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                    const formattedDate = philippineTime.toLocaleDateString('en-US', options);
                    dueDateText.textContent = formattedDate;
                    
                    console.log('Automatic due date set to today:', formattedDate);
                }
            };

            // Initialize automatic due date setting
            window.setAutomaticDueDate();



            // Initialize search functionality
            initializeSearch();

            // Initialize confirm button state - use the one from borrow.js
            if (typeof window.updateConfirmButtonState === 'function') {
                window.updateConfirmButtonState();
            }

            // Add event listeners for selected books list changes
            const selectedBooksList = document.getElementById('selectedBooksList');
            const emptyBooksMessage = document.getElementById('emptyBooksMessage');

            function updateBooksListDisplay() {
                if (selectedBooksList && emptyBooksMessage) {
                    const hasBooks = selectedBooksList.children.length > 0;
                    emptyBooksMessage.style.display = hasBooks ? 'none' : 'block';
                }
                if (typeof window.updateConfirmButtonState === 'function') {
                    window.updateConfirmButtonState();
                }
            }

            if (selectedBooksList) {
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        updateBooksListDisplay();
                    });
                });
                observer.observe(selectedBooksList, { childList: true });

                // Also add manual update when books are removed via remove buttons
                selectedBooksList.addEventListener('click', function(e) {
                    if (e.target && e.target.matches('button')) {
                        setTimeout(() => {
                            updateBooksListDisplay();
                        }, 100);
                    }
                });
            }

            // Initialize empty message display
            updateBooksListDisplay();

        });

        // Initialize QR Scanner for Modal
        function initializeQRScannerModal() {
            const qrReaderElement = document.getElementById('qr-reader-container');
            if (!qrReaderElement || typeof Html5Qrcode === 'undefined') {
                console.log('QR Scanner not available');
                return;
            }

            // Stop any existing scanner
            if (window.modalQrCode) {
                window.modalQrCode.stop().catch(() => {});
            }

            // Clear any existing content
            qrReaderElement.innerHTML = '';

            const html5QrCode = new Html5Qrcode("qr-reader-container");

            // Configure scanner for continuous operation
            const config = {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0,
                supportedScanTypes: [Html5QrcodeSupportedFormats.QR_CODE]
            };

            // Start scanning
            html5QrCode.start(
                { facingMode: "environment" },
                config,
                (decodedText, decodedResult) => {
                    // Handle successful scan
                    handleModalQRScan(decodedText);
                },
                (errorMessage) => {
                    // Ignore scanning errors, keep scanner running
                }
            ).then(() => {
                console.log('Modal QR Scanner started successfully');
                qrReaderElement.style.borderColor = 'var(--success)';
            }).catch((err) => {
                console.error('Modal QR Scanner initialization failed:', err);
                qrReaderElement.innerHTML = `
                    <div class="qr-placeholder">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>Camera access denied or unavailable</p>
                        <button onclick="initializeQRScannerModal()" class="btn btn-primary btn-sm" style="margin-top: 10px;">
                            <i class="fas fa-redo"></i> Retry
                        </button>
                    </div>
                `;
                qrReaderElement.style.borderColor = 'var(--danger)';
            });

            // Store scanner instance globally
            window.modalQrCode = html5QrCode;
        }

        // Stop modal QR scanner
        function stopQRScannerModal() {
            if (window.modalQrCode) {
                window.modalQrCode.stop().catch(() => {});
                window.modalQrCode = null;
            }
        }

        // Close borrow modal with scanner cleanup
        function closeBorrowModalWithScanner() {
            // Stop the QR scanner modal
            closeQRScannerModal();

            // Call the original close function
            if (typeof closeBorrowModal === 'function') {
                closeBorrowModal();
            } else {
                // Fallback: manually close modal
                const modal = document.getElementById('borrowModal');
                if (modal) {
                    modal.classList.remove('active');
                    setTimeout(() => {
                        modal.style.display = 'none';
                    }, 300);
                }
            }
        }

        // Global cooldown flag
        let qrScanCooldown = false;

        // Handle QR scan result for modal
        function handleModalQRScan(decodedText) {
            // Check if we're in cooldown
            if (qrScanCooldown) {
                return; // Ignore scans during cooldown
            }

            // Clean the decoded text
            const cleanText = decodedText.trim();

            // Try to parse QR code with multiple validation strategies
            const qrData = parseQRCode(cleanText);

            if (qrData) {
                if (qrData.type === 'member') {
                    handleModalMemberQR(qrData);
                } else if (qrData.type === 'book') {
                    handleModalBookQR(qrData);
                } else {
                    showToast('Unknown QR code type', 'error');
                }
            } else {
                showToast('Invalid QR code format', 'error');
            }

            // Start cooldown regardless of success/failure
            startQRScanCooldown();
        }

        // Robust QR code parsing function
        function parseQRCode(text) {
            try {
                // Strategy 1: Try parsing as JSON
                const jsonData = JSON.parse(text);

                // Validate JSON structure
                if (validateQRData(jsonData)) {
                    return jsonData;
                }
            } catch (e) {
                // Strategy 2: Try parsing as URL-encoded JSON
                try {
                    const urlDecoded = decodeURIComponent(text);
                    const jsonData = JSON.parse(urlDecoded);

                    if (validateQRData(jsonData)) {
                        return jsonData;
                    }
                } catch (e2) {
                    // Strategy 3: Try parsing as URL (for generated QR codes)
                    try {
                        const url = new URL(text);

                        // Check if it's a book URL pattern: /books/{id}
                        const bookMatch = url.pathname.match(/^\/books\/(\d+)$/);
                        if (bookMatch) {
                            return {
                                type: 'book',
                                id: parseInt(bookMatch[1])
                            };
                        }

                        // Check if it's a member URL pattern: /members/{id}
                        const memberMatch = url.pathname.match(/^\/members\/(\d+)$/);
                        if (memberMatch) {
                            // For members, we need more data, but we can at least identify it as a member
                            return {
                                type: 'member',
                                id: parseInt(memberMatch[1])
                            };
                        }

                        // Strategy 4: Try parsing URL parameters
                        const params = new URLSearchParams(url.search);
                        const type = params.get('type');
                        const id = params.get('id');

                        if (type && id) {
                            return {
                                type: type,
                                id: parseInt(id) || id
                            };
                        }
                    } catch (e3) {
                        // Strategy 5: Try parsing as plain numeric ID (legacy support)
                        const numericId = parseInt(text.trim());
                        if (!isNaN(numericId) && numericId > 0) {
                            return {
                                type: 'book',
                                id: numericId
                            };
                        }
                    }
                }
            }

            return null; // Could not parse
        }

        // Validate QR data structure
        function validateQRData(data) {
            if (!data || typeof data !== 'object') {
                return false;
            }

            // Check for required fields
            if (!data.type || !data.id) {
                return false;
            }

            // Validate type
            if (!['member', 'book'].includes(data.type)) {
                return false;
            }

            // Validate ID
            if (data.type === 'member' || data.type === 'book') {
                if (typeof data.id !== 'number' && typeof data.id !== 'string') {
                    return false;
                }
                if (typeof data.id === 'string' && data.id.trim() === '') {
                    return false;
                }
                if (typeof data.id === 'number' && (isNaN(data.id) || data.id <= 0)) {
                    return false;
                }
            }

            // Additional validation for member QR
            if (data.type === 'member' && !data.name) {
                return false;
            }

            return true;
        }

        // Start QR scan cooldown
        function startQRScanCooldown() {
            qrScanCooldown = true;

            // Visual feedback - change scanner border to indicate cooldown
            const scannerContainer = document.getElementById('qr-reader-container');
            if (scannerContainer) {
                scannerContainer.style.borderColor = 'var(--warning)';
                scannerContainer.style.backgroundColor = 'rgba(245, 158, 11, 0.1)';
            }

            // Show cooldown message
            const instruction = document.querySelector('.qr-instruction');
            if (instruction) {
                instruction.textContent = 'Scan cooldown... Please wait';
                instruction.style.color = 'var(--warning)';
            }

            // End cooldown after 3 seconds
            setTimeout(() => {
                qrScanCooldown = false;

                // Reset visual feedback
                if (scannerContainer) {
                    scannerContainer.style.borderColor = 'var(--border)';
                    scannerContainer.style.backgroundColor = '';
                }

                if (instruction) {
                    instruction.textContent = 'Point camera at QR codes to scan';
                    instruction.style.color = 'var(--text-muted)';
                }
            }, 3000);
        }

        // Handle member QR scan for modal
        function handleModalMemberQR(data) {
            // Check if borrow modal is open
            const borrowModal = document.getElementById('borrowModal');
            if (!borrowModal || borrowModal.style.display === 'none') {
                showToast('Please open borrow modal first', 'warning');
                return;
            }

            // If we have name from QR, use it directly
            if (data.name) {
                setMemberInModal(data.id, data.name);
            } else {
                // If only ID, fetch member data
                fetchMemberData(data.id);
            }
        }

        // Fetch member data by ID
        function fetchMemberData(memberId) {
            console.log('Fetching member data for ID:', memberId);

            fetch(`/api/members/${memberId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => {
                    console.log('API response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: Member not found`);
                    }
                    return response.json();
                })
                .then(member => {
                    console.log('Member data received:', member);

                    // Construct full name from member data
                    const first = member.first_name || '';
                    const middle = member.middle_name || '';
                    const last = member.last_name || '';
                    const fullName = `${first} ${middle} ${last}`.trim().replace(/\s+/g, ' ');

                    console.log('Constructed name:', fullName);

                    setMemberInModal(member.id, fullName || 'Unknown Member');
                })
                .catch(error => {
                    console.error('Error fetching member:', error);
                    showToast('Member not found or network error', 'error');
                    // Fallback: set with ID only
                    setMemberInModal(memberId, `Member #${memberId}`);
                });
        }

        // Set member information in borrow modal
        function setMemberInModal(id, name) {
            const memberName = document.getElementById('memberName');
            const memberId = document.getElementById('memberId');

            if (memberName && memberId) {
                memberName.value = name;
                memberId.value = id;
                memberName.style.backgroundColor = 'var(--surface-elevated)';
                memberName.style.cursor = 'default';

                showToast(`Member scanned: ${name}`, 'success');

                // Check for auto-confirm - trigger borrow process when member is scanned
                checkAutoConfirmBorrow();
            }
        }

        // Handle book QR scan for modal
        function handleModalBookQR(data) {
            const bookId = data.id;

            // Check if borrow modal is open
            const borrowModal = document.getElementById('borrowModal');
            if (!borrowModal || borrowModal.style.display === 'none') {
                showToast('Please open borrow modal first', 'warning');
                return;
            }

            // Add book to selected books
            if (typeof window.addBookToBorrow === 'function') {
                window.addBookToBorrow(bookId);
                showToast(`Book added to borrow list`, 'success');
            } else {
                // Fallback: manually add to selectedBooks array
                if (typeof selectedBooks !== 'undefined') {
                    if (!selectedBooks.includes(bookId)) {
                        selectedBooks.push(bookId);

                        // Update the UI manually
                        updateSelectedBooksUI(bookId);

                        showToast(`Book added to borrow list`, 'success');

                        // Check for auto-confirm
                        checkAutoConfirmBorrow();
                    } else {
                        showToast('Book already in borrow list', 'info');
                    }
                }
            }
        }

        // Manually update selected books UI
        function updateSelectedBooksUI(bookId) {
            const selectedBooksList = document.getElementById('selectedBooksList');
            if (!selectedBooksList) return;

            // Get book title from the table
            const bookRow = document.querySelector(`tr[data-id="${bookId}"]`);
            const bookTitle = bookRow ? bookRow.dataset.title : `Book ${bookId}`;

            // Create list item
            const listItem = document.createElement('li');
            listItem.innerHTML = `
                <span>${bookTitle}</span>
                <button onclick="removeBookFromBorrow(${bookId})" style="background: var(--danger); color: white; border: none; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 12px;">×</button>
            `;

            selectedBooksList.appendChild(listItem);

            // Hide empty message
            const emptyMessage = document.getElementById('emptyBooksMessage');
            if (emptyMessage) {
                emptyMessage.style.display = 'none';
            }
        }

        // Remove book from borrow list
        function removeBookFromBorrow(bookId) {
            // Remove from array
            if (typeof selectedBooks !== 'undefined') {
                const index = selectedBooks.indexOf(bookId);
                if (index > -1) {
                    selectedBooks.splice(index, 1);
                }
            }

            // Remove from UI
            const selectedBooksList = document.getElementById('selectedBooksList');
            if (selectedBooksList) {
                const items = selectedBooksList.querySelectorAll('li');
                items.forEach(item => {
                    const button = item.querySelector('button');
                    if (button && button.onclick.toString().includes(bookId.toString())) {
                        item.remove();
                    }
                });

                // Show empty message if no books left
                if (selectedBooksList.children.length === 0) {
                    const emptyMessage = document.getElementById('emptyBooksMessage');
                    if (emptyMessage) {
                        emptyMessage.style.display = 'block';
                    }
                }
            }
        }

        // Check for automatic borrow confirmation
        function checkAutoConfirmBorrow() {
            const memberId = document.getElementById('memberId')?.value;
            const hasMember = memberId && memberId.trim() !== '';

            const hasBooks = (typeof selectedBooks !== 'undefined' && selectedBooks.length > 0) ||
                            (document.getElementById('selectedBooksList')?.children.length > 0);

            if (hasMember && hasBooks) {
                // Auto-confirm borrow after a short delay
                setTimeout(() => {
                    performAutoBorrow();
                }, 500); // Faster confirmation when member is scanned
            }
        }

        // Perform automatic borrow transaction
        function performAutoBorrow() {
            const memberName = document.getElementById('memberName')?.value;
            const memberId = document.getElementById('memberId')?.value;
            const dueDate = document.getElementById('dueDate')?.value;
            const dueTime = document.getElementById('dueTime')?.value;

            if (!memberName || !memberId) {
                showToast('Member information missing', 'error');
                return;
            }

            if (!dueTime) {
                showToast('Due time not set', 'error');
                return;
            }

            // Get book IDs from selectedBooks array
            const bookIds = [];
            if (typeof selectedBooks !== 'undefined') {
                bookIds.push(...selectedBooks);
            }

            if (bookIds.length === 0) {
                showToast('No books selected', 'error');
                return;
            }

            // Get CSRF token
            const tokenElement = document.querySelector('meta[name="csrf-token"]');
            if (!tokenElement) {
                showToast('CSRF token not found', 'error');
                return;
            }
            const token = tokenElement.content;

            // Prepare borrow data
            const borrowData = {
                member_name: memberName,
                member_id: memberId,
                due_date: dueDate,
                due_time: dueTime,
                book_ids: bookIds,
                books_data: bookIds.map(id => ({ id: id })), // Simple book data
                books_count: bookIds.length,
                transaction_summary: {
                    member: `${memberName} (ID: ${memberId})`,
                    books: `Selected ${bookIds.length} book(s)`,
                    due_datetime: `${dueDate} ${dueTime}`,
                    total_books: bookIds.length
                }
            };

            console.log('Performing auto borrow:', borrowData);

            // Send borrow request
            fetch('/borrow/process', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(borrowData)
            })
            .then(response => {
                console.log('Borrow response status:', response.status);
                if (!response.ok) throw new Error(`HTTP ${response.status}`);
                return response.json();
            })
            .then(data => {
                console.log('Borrow success:', data);
                showToast(data.message || 'Books borrowed successfully!', 'success');

                // Refresh the page to update book availability
                setTimeout(() => {
                    showToast('Refreshing page...', 'info');
                    window.location.reload();
                }, 1500);
            })
            .catch(error => {
                console.error('Borrow error:', error);
                showToast('Failed to borrow books: ' + error.message, 'error');
            });
        }

        // Search functionality
        function initializeSearch() {
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('booksTableBody');
            const rows = Array.from(tableBody.querySelectorAll('tr'));

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                
                rows.forEach(row => {
                    const title = row.dataset.title?.toLowerCase() || '';
                    const author = row.dataset.author?.toLowerCase() || '';
                    const genre = row.dataset.genre?.toLowerCase() || '';
                    
                    const matches = title.includes(searchTerm) || 
                                   author.includes(searchTerm) || 
                                   genre.includes(searchTerm);
                    
                    row.style.display = matches ? '' : 'none';
                });
            });
        }

        // Cover upload functionality for Add Book Modal
        function initializeCoverUpload() {
            const coverPreviewArea = document.getElementById('cover-preview-area');
            const coverInput = document.getElementById('cover-input');
            const coverPreviewContent = document.getElementById('cover-preview-content');
            
            if (coverPreviewArea && coverInput) {
                coverPreviewArea.addEventListener('click', () => coverInput.click());
                
                coverInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            coverPreviewContent.innerHTML = `
                                <img src="${e.target.result}" alt="Cover Preview" style="max-width: 150px; max-height: 200px; object-fit: cover; border-radius: var(--radius); margin-bottom: 10px;">
                                <p style="color: var(--text-primary); font-weight: 600;">${file.name}</p>
                                <small style="color: var(--text-muted);">Click to change</small>
                            `;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        }

        // Cover upload functionality for Edit Book Modal
        function initializeEditCoverUpload() {
            const editCoverPreviewArea = document.getElementById('edit-cover-preview-area');
            const editCoverInput = document.getElementById('edit-cover-input');
            const editCoverPreviewContent = document.getElementById('edit-cover-preview-content');
            
            if (editCoverPreviewArea && editCoverInput) {
                editCoverPreviewArea.addEventListener('click', () => editCoverInput.click());
                
                editCoverInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            editCoverPreviewContent.innerHTML = `
                                <img src="${e.target.result}" alt="Cover Preview" style="max-width: 150px; max-height: 200px; object-fit: cover; border-radius: var(--radius); margin-bottom: 10px;">
                                <p style="color: var(--text-primary); font-weight: 600;">${file.name}</p>
                                <small style="color: var(--text-muted);">Click to change</small>
                            `;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        }

        // Toast notification function
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `toast-notification toast-${type}`;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }


        // Clear member information
        function clearMemberInfo() {
            const memberName = document.getElementById('memberName');
            const memberId = document.getElementById('memberId');

            if (memberName) {
                memberName.value = '';
                memberName.style.backgroundColor = 'var(--surface-elevated)';
                memberName.style.cursor = 'not-allowed';
            }

            if (memberId) {
                memberId.value = '';
            }

            // Use the function from borrow.js
            if (typeof window.updateConfirmButtonState === 'function') {
                window.updateConfirmButtonState();
            }
        }

        // Quick Borrow Modal function
        function openQuickBorrowModal() {
            // Clear member information
            clearMemberInfo();

            // Clear selected books
            if (typeof selectedBooks !== 'undefined') {
                selectedBooks = [];
            }

            // Clear the selected books list display
            const selectedBooksList = document.getElementById('selectedBooksList');
            if (selectedBooksList) {
                selectedBooksList.innerHTML = '';
            }
            const emptyBooksMessage = document.getElementById('emptyBooksMessage');
            if (emptyBooksMessage) {
                emptyBooksMessage.style.display = 'block';
            }

            // Open the borrow modal
            const modal = document.getElementById('borrowModal');
            modal.classList.add('active');
            modal.style.display = 'flex';

            // Open QR scanner modal
            openQRScannerModal();
        }

        // Open QR Scanner Modal
        function openQRScannerModal() {
            const modal = document.getElementById('qrScannerModal');
            modal.classList.add('active');

            // Reset cooldown state
            qrScanCooldown = false;

            // Start QR scanner
            setTimeout(() => {
                initializeQRScannerModal();
            }, 300);
        }

        // Close QR Scanner Modal
        function closeQRScannerModal() {
            const modal = document.getElementById('qrScannerModal');
            modal.classList.remove('active');

            // Stop QR scanner
            stopQRScannerModal();

            // Reset cooldown state
            qrScanCooldown = false;
        }

        // Modal functions
        function openAddBookModal() {
            const modal = document.getElementById('addBookModal');
            modal.classList.add('active');
            modal.style.display = 'flex';
        }

        function closeAddBookModal() {
            const modal = document.getElementById('addBookModal');
            modal.classList.remove('active');
            setTimeout(() => {
                modal.style.display = 'none';
                document.getElementById('addBookForm').reset();
                // Reset cover preview
                const coverPreviewContent = document.getElementById('cover-preview-content');
                coverPreviewContent.innerHTML = `
                    <i id="cover-upload-icon" class="fas fa-cloud-upload-alt"></i>
                    <p id="cover-preview-text">Click or drag image here...</p>
                    <small style="color: var(--text-muted); margin-top: 8px; display: block;">
                        Supports JPG, PNG, GIF (max 5MB)
                    </small>
                    <input type="file" id="cover-input" class="cover-input" accept="image/*">
                `;
                initializeCoverUpload();
            }, 300);
        }

        function editBook(bookId) {
            // Use the external script function
            if (typeof window.manageBooks === 'function') {
                // Clear any existing selections
                document.querySelectorAll('tr.selected').forEach(r => r.classList.remove('selected'));
                // Select the specific row
                const row = document.querySelector(`tr[data-id="${bookId}"]`);
                if (row) {
                    row.classList.add('selected');
                    // Set global variable for external script
                    window.selectedBookId = bookId;
                    window.manageBooks();
                }
            } else {
                showToast('Edit functionality not available', 'error');
            }
        }


        function showDeleteConfirmation(bookId) {
            const row = document.querySelector(`tr[data-id="${bookId}"]`);
            if (!row) return;

            const bookTitle = row.dataset.title || 'Unknown Book';

            if (confirm(`Are you sure you want to delete "${bookTitle}"? This action cannot be undone.`)) {
                // Remove the row immediately for better UX
                row.remove();

                // Show success message
                showToast(`Book "${bookTitle}" deleted successfully`, 'success');

                // Check if table is empty and show appropriate message
                const tableBody = document.getElementById('booksTableBody');
                if (tableBody.children.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="8" class="loading" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                <i class="fas fa-book" style="font-size: 3rem; margin-bottom: 15px; display: block;"></i>
                                <p>No books found. Add your first book to get started!</p>
                                <button class="btn btn-primary" onclick="openAddBookModal()" style="margin-top: 15px;">
                                    <i class="fas fa-plus"></i> Add Book
                                </button>
                            </td>
                        </tr>
                    `;
                }
            }
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
                currentBookId = null;
            }, 300);
        }

        function closeEditBookModal() {
            // Use the external script function
            if (typeof window.closeModal === 'function') {
                // Call the external close modal function
                window.closeModal();
            } else {
                // Fallback: basic modal closing
                const modal = document.getElementById('manage-modal');
                if (modal) {
                    modal.classList.remove('show');
                    setTimeout(() => {
                        modal.style.display = 'none';
                        // Reset any unsaved changes flags
                        window.hasUnsavedChanges = false;
                        window.selectedBookId = null;
                    }, 300);
                }
            }
        }




        // QR Code functions - use external script
        function generateQr(bookId) {
            // Use the external script function
            if (typeof window.generateQr === 'function') {
                // Call the external QR generation function
                window.generateQr(bookId);
            } else {
                showToast('QR generation functionality not available', 'error');
            }
        }

        function showQRModal(bookTitle, qrUrl) {
            document.getElementById('qrBookTitleDisplay').textContent = bookTitle;
            document.getElementById('qrImage').src = qrUrl;
            document.getElementById('qrCodeContainer').style.display = 'block';
            document.getElementById('qrPlaceholder').style.display = 'none';
            
            const modal = document.getElementById('qrModal');
            modal.classList.add('show');
            modal.style.display = 'flex';
        }

        function closeQRModal() {
            const modal = document.getElementById('qrModal');
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
                document.getElementById('qrCodeContainer').style.display = 'none';
                document.getElementById('qrPlaceholder').style.display = 'block';
            }, 300);
        }

        function downloadQR() {
            const qrImage = document.getElementById('qrImage');
            const link = document.createElement('a');
            link.download = 'book-qr-code.png';
            link.href = qrImage.src;
            link.click();
            showToast('QR Code downloaded', 'success');
        }

        function printQR() {
            const qrImage = document.getElementById('qrImage');
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                <head><title>Print QR Code</title></head>
                <body style="text-align: center; padding: 20px;">
                    <h2>${document.getElementById('qrBookTitleDisplay').textContent}</h2>
                    <img src="${qrImage.src}" style="max-width: 300px;">
                </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        }

        // Borrow functions - use external script


        // Selection mode functions
        function enterSelectionMode() {
            isSelectionMode = true;
            selectedBooks = [];

            // Disable the select button when selection mode is active
            const selectButton = document.getElementById('selectButton');
            if (selectButton) {
                selectButton.disabled = true;
            }

            // Add checkboxes to table
            const table = document.getElementById('booksTable');
            const headerRow = table.querySelector('thead tr');
            const checkboxHeader = document.createElement('th');
            checkboxHeader.innerHTML = '<input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll()">';
            checkboxHeader.className = 'checkbox-cell';
            headerRow.insertBefore(checkboxHeader, headerRow.firstChild);
            
            // Add checkboxes to each row
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const checkboxCell = document.createElement('td');
                checkboxCell.className = 'checkbox-cell';
                checkboxCell.innerHTML = `<input type="checkbox" class="book-checkbox" value="${row.dataset.id}" onchange="toggleBookSelection(this)">`;
                row.insertBefore(checkboxCell, row.firstChild);
            });
            
            // Show selection bar
            document.getElementById('selectionBar').style.display = 'flex';
            updateSelectedCount();
        }

        function exitSelectionMode() {
            isSelectionMode = false;
            selectedBooks = [];

            // Re-enable the select button when exiting selection mode
            const selectButton = document.getElementById('selectButton');
            if (selectButton) {
                selectButton.disabled = false;
            }

            // Remove checkboxes
            const table = document.getElementById('booksTable');
            const checkboxHeaders = table.querySelectorAll('.checkbox-cell');
            checkboxHeaders.forEach(cell => cell.remove());
            
            // Hide selection bar
            document.getElementById('selectionBar').style.display = 'none';
        }

        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const bookCheckboxes = document.querySelectorAll('.book-checkbox');
            
            bookCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
                toggleBookSelection(checkbox);
            });
        }

        function toggleBookSelection(checkbox) {
            const bookId = parseInt(checkbox.value);
            
            if (checkbox.checked) {
                if (!selectedBooks.includes(bookId)) {
                    selectedBooks.push(bookId);
                    checkbox.closest('tr').classList.add('selected');
                }
            } else {
                const index = selectedBooks.indexOf(bookId);
                if (index > -1) {
                    selectedBooks.splice(index, 1);
                    checkbox.closest('tr').classList.remove('selected');
                }
            }
            
            updateSelectedCount();
            updateSelectAllCheckbox();
        }

        function updateSelectedCount() {
            const count = selectedBooks.length;
            document.getElementById('selectedCount').textContent = `${count} book${count !== 1 ? 's' : ''} selected`;
            
            // Show/hide edit button based on selection
            const editButton = document.getElementById('editButton');
            if (count === 1) {
                editButton.style.display = 'inline-flex';
            } else {
                editButton.style.display = 'none';
            }
        }

        function updateSelectAllCheckbox() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const bookCheckboxes = document.querySelectorAll('.book-checkbox');
            const checkedBoxes = document.querySelectorAll('.book-checkbox:checked');
            
            if (checkedBoxes.length === 0) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = false;
            } else if (checkedBoxes.length === bookCheckboxes.length) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = true;
            } else {
                selectAllCheckbox.indeterminate = true;
            }
        }

        function selectAllBooks() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            selectAllCheckbox.checked = true;
            toggleSelectAll();
        }

        function unselectAllBooks() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            selectAllCheckbox.checked = false;
            toggleSelectAll();
        }

        function openEditModal() {
            if (selectedBooks.length === 1) {
                editBook(selectedBooks[0]);
            }
        }


        // QR Scanner functions are now handled by qrscanner-borrow.js

        // Form submission handlers
        document.addEventListener('DOMContentLoaded', function() {
            // Add Book Form
            const addBookForm = document.getElementById('addBookForm');
            if (addBookForm) {
                addBookForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const title = formData.get('title');
                    const author = formData.get('author');
                    const genre = formData.get('genre') || 'General';
                    const year = formData.get('published_year');
                    const availability = formData.get('availability');
                    
                    // Simulate adding book to table
                    const tableBody = document.getElementById('booksTableBody');
                    const newId = Date.now(); // Simple ID generation
                    
                    const newRow = document.createElement('tr');
                    newRow.dataset.id = newId;
                    newRow.dataset.title = title;
                    newRow.dataset.author = author;
                    newRow.dataset.genre = genre;
                    newRow.dataset.publishedYear = year;
                    newRow.dataset.availability = availability;
                    newRow.dataset.coverImage = '';
                    
                    newRow.innerHTML = `
                        <td>
                            <img src="/images/no-cover.png" alt="Cover" class="book-cover-small">
                        </td>
                        <td style="font-weight: 600; color: var(--text-primary);" title="${title}">${title}</td>
                        <td title="${author}">${author}</td>
                        <td title="${genre}">
                            <span style="background: rgba(99, 102, 241, 0.1); color: var(--primary); padding: 4px 8px; border-radius: 6px; font-size: 0.8rem; font-weight: 500;">
                                ${genre}
                            </span>
                        </td>
                        <td title="${year}">${year}</td>
                        <td title="${availability > 0 ? 'Available' : 'Out of Stock'}">
                            <span class="status-badge ${availability > 0 ? 'status-available' : 'status-unavailable'}">
                                ${availability > 0 ? 'Available' : 'Out of Stock'}
                            </span>
                        </td>
                        <td title="${availability} copies">
                            <strong style="color: var(--text-primary);">${availability}</strong> copies
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn btn-outline btn-sm" onclick="window.generateQr(${newId})" title="Generate QR Code">
                                    <i class="fas fa-qrcode"></i> Gen
                                </button>
                                <button class="btn btn-success btn-sm" onclick="window.borrowOne(${newId})" title="Borrow Book">
                                    <i class="fas fa-hand-holding"></i>
                                </button>
                                <button class="btn btn-primary btn-sm" onclick="window.editBook(${newId})" title="Edit Book">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="window.deleteBook(${newId})" title="Delete Book">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    `;
                    
                    // Remove "no books found" message if it exists
                    const noBooks = tableBody.querySelector('.loading');
                    if (noBooks && noBooks.parentElement) {
                        noBooks.parentElement.remove();
                    }
                    
                    tableBody.appendChild(newRow);
                    
                    showToast('Book added successfully', 'success');
                    closeAddBookModal();
                });
            }

            // Edit Book Form
            const editBookForm = document.getElementById('editBookForm');
            if (editBookForm) {
                editBookForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    if (!currentBookId) return;
                    
                    const formData = new FormData(this);
                    const title = formData.get('title');
                    const author = formData.get('author');
                    const genre = formData.get('genre') || 'General';
                    const year = formData.get('published_year');
                    const availability = formData.get('availability');
                    
                    // Update the row
                    const row = document.querySelector(`tr[data-id="${currentBookId}"]`);
                    if (row) {
                        row.dataset.title = title;
                        row.dataset.author = author;
                        row.dataset.genre = genre;
                        row.dataset.publishedYear = year;
                        row.dataset.availability = availability;
                        
                        // Update the displayed content
                        const cells = row.querySelectorAll('td');
                        cells[1].textContent = title;
                        cells[1].title = title;
                        cells[2].textContent = author;
                        cells[2].title = author;
                        cells[3].innerHTML = `
                            <span style="background: rgba(99, 102, 241, 0.1); color: var(--primary); padding: 4px 8px; border-radius: 6px; font-size: 0.8rem; font-weight: 500;">
                                ${genre}
                            </span>
                        `;
                        cells[3].title = genre;
                        cells[4].textContent = year;
                        cells[4].title = year;
                        cells[5].innerHTML = `
                            <span class="status-badge ${availability > 0 ? 'status-available' : 'status-unavailable'}">
                                ${availability > 0 ? 'Available' : 'Out of Stock'}
                            </span>
                        `;
                        cells[5].title = availability > 0 ? 'Available' : 'Out of Stock';
                        cells[6].innerHTML = `<strong style="color: var(--text-primary);">${availability}</strong> copies`;
                        cells[6].title = `${availability} copies`;
                    }
                    
                    showToast('Book updated successfully', 'success');
                    closeEditBookModal();
                });
            }
        });

        // Close modals when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal') && e.target.id !== 'qrScannerModal') {
                const modal = e.target;
                modal.classList.remove('show');
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 300);
            }
            // Handle modal-overlay (borrow modal) click outside
            if (e.target.classList.contains('modal-overlay') && e.target.id !== 'qrScannerModal') {
                const modal = e.target;
                modal.classList.remove('active');
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 300);
            }
            // Handle QR scanner modal click outside
            if (e.target.id === 'qrScannerModal') {
                if (typeof window.closeQRScanner === 'function') {
                    window.closeQRScanner();
                }
            }
        });

        // Media Picker Functions
        function openMediaPicker() {
            const modal = document.getElementById('mediaPickerModal');
            if (modal) {
                modal.classList.add('show');
                modal.style.display = 'flex';
                loadAvailableImages();
            }
        }

        function closeMediaPicker() {
            const modal = document.getElementById('mediaPickerModal');
            if (modal) {
                modal.classList.remove('show');
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 300);
            }
        }

        async function loadAvailableImages() {
            const gallery = document.getElementById('media-gallery');
            const loading = document.getElementById('media-loading');

            try {
                // Show loading state
                loading.style.display = 'block';

                // Fetch available images from server
                const response = await fetch('/api/media/images');
                let images = [];

                if (response.ok) {
                    images = await response.json();
                } else {
                    // Fallback: scan common image directories
                    images = await scanImageDirectories();
                }

                // Filter to only include image files
                const imageExtensions = ['.jpg', '.jpeg', '.png', '.gif', '.webp'];
                const imageFiles = images.filter(img =>
                    imageExtensions.some(ext => img.toLowerCase().includes(ext))
                );

                displayImagesInGallery(imageFiles);

            } catch (error) {
                console.error('Error loading images:', error);
                showToast('Error loading images', 'error');
                loading.innerHTML = '<p style="color: var(--danger);">Error loading images</p>';
            }
        }

        async function scanImageDirectories() {
            // This is a fallback function that would scan common directories
            // In a real implementation, this would be handled by a backend API
            const commonPaths = [
                '/images/',
                '/cover/',
                '/public/images/',
                '/public/cover/',
                '/storage/app/public/images/',
                '/storage/app/public/cover/'
            ];

            const images = [];

            // For demo purposes, return some sample images
            // In production, this would scan actual directories
            return [
                'book-1.jpg',
                'book-2.png',
                'book-3.jpg',
                'cover-1756669537.jpg',
                'no-cover.png'
            ];
        }

        function displayImagesInGallery(images) {
            const gallery = document.getElementById('media-gallery');
            const loading = document.getElementById('media-loading');

            // Clear loading state
            loading.style.display = 'none';

            if (images.length === 0) {
                gallery.innerHTML = '<p style="grid-column: 1 / -1; text-align: center; padding: 2rem; color: var(--text-muted);">No images found</p>';
                return;
            }

            gallery.innerHTML = '';

            images.forEach(imageName => {
                const imageItem = document.createElement('div');
                imageItem.className = 'media-item';
                imageItem.style.cssText = `
                    cursor: pointer;
                    border: 2px solid var(--border-light);
                    border-radius: var(--radius-sm);
                    overflow: hidden;
                    transition: var(--transition);
                    background: var(--surface);
                `;

                const imageUrl = `/images/${imageName}`;

                imageItem.innerHTML = `
                    <img src="${imageUrl}" alt="${imageName}"
                         style="width: 100%; height: 100px; object-fit: cover;"
                         onerror="this.src='/images/no-cover.png'">
                    <div style="padding: 8px; text-align: center; font-size: 0.8rem; color: var(--text-secondary);">
                        ${imageName.length > 15 ? imageName.substring(0, 15) + '...' : imageName}
                    </div>
                `;

                imageItem.addEventListener('click', () => selectMediaImage(imageUrl, imageName));
                imageItem.addEventListener('mouseenter', () => {
                    imageItem.style.borderColor = 'var(--primary)';
                    imageItem.style.transform = 'translateY(-2px)';
                    imageItem.style.boxShadow = 'var(--shadow-md)';
                });
                imageItem.addEventListener('mouseleave', () => {
                    imageItem.style.borderColor = 'var(--border-light)';
                    imageItem.style.transform = '';
                    imageItem.style.boxShadow = '';
                });

                gallery.appendChild(imageItem);
            });
        }

        function selectMediaImage(imageUrl, imageName) {
            // Update the cover preview area with selected image
            const coverPreviewContent = document.getElementById('cover-preview-content');
            if (coverPreviewContent) {
                coverPreviewContent.innerHTML = `
                    <img src="${imageUrl}" alt="Book Cover" style="max-width: 150px; max-height: 200px; object-fit: cover; border-radius: var(--radius); margin-bottom: 10px;">
                    <p style="color: var(--text-primary); font-weight: 600;">${imageName}</p>
                    <small style="color: var(--text-muted);">Click to change</small>
                `;

                // Store the selected image URL for form submission
                window.selectedCoverImage = imageUrl;

                // Also update the file input to ensure form submission works
                updateFormWithSelectedImage(imageUrl, imageName);
            }

            // Close media picker
            closeMediaPicker();

            showToast(`Selected: ${imageName}`, 'success');
        }

        async function updateFormWithSelectedImage(imageUrl, imageName) {
            try {
                // Fetch the image and convert to blob
                const response = await fetch(imageUrl);
                const blob = await response.blob();

                // Create a File object
                const file = new File([blob], imageName, { type: blob.type });

                // Set the file to the cover input
                const coverInput = document.getElementById('cover-input');
                if (coverInput) {
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    coverInput.files = dt.files;

                    console.log('Updated form with selected image:', imageName);
                }
            } catch (error) {
                console.error('Error updating form with selected image:', error);
                // Fallback: just store the URL
                window.selectedCoverImage = imageUrl;
            }
        }

        // Initialize media picker upload area drag and drop
        function initializeMediaPickerUpload() {
            const uploadArea = document.getElementById('media-upload-area');
            const uploadContent = document.getElementById('media-upload-content');
            const fileInput = document.getElementById('media-file-input');

            if (!uploadArea || !fileInput) return;

            // Click to open file picker or select uploaded file
            uploadArea.addEventListener('click', () => {
                if (window.uploadedMediaFile) {
                    // If file is already uploaded, select it
                    selectUploadedMediaFile();
                } else {
                    // Otherwise open file picker
                    fileInput.click();
                }
            });

            // File selection handler
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    handleMediaFileUpload(file);
                }
            });

            // Drag and drop functionality
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            uploadArea.addEventListener('dragenter', () => {
                uploadArea.style.transform = 'scale(1.02)';
                uploadArea.style.borderColor = 'var(--primary)';
            });

            uploadArea.addEventListener('dragover', () => {
                uploadContent.style.backgroundColor = 'rgba(99, 102, 241, 0.1)';
            });

            uploadArea.addEventListener('dragleave', () => {
                uploadArea.style.transform = '';
                uploadArea.style.borderColor = 'var(--border)';
                uploadContent.style.backgroundColor = 'var(--glass-bg)';
            });

            uploadArea.addEventListener('drop', (e) => {
                uploadArea.style.transform = '';
                uploadArea.style.borderColor = 'var(--border)';
                uploadContent.style.backgroundColor = 'var(--glass-bg)';

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    handleMediaFileUpload(files[0]);
                }
            });
        }

        function handleMediaFileUpload(file) {
            // Validate file type
            if (!file.type.match('image/jpeg') && !file.type.match('image/png') && !file.type.match('image/gif')) {
                showToast('Only JPG, PNG, and GIF images are allowed.', 'error');
                return;
            }

            // Validate file size (5MB max)
            if (file.size > 5 * 1024 * 1024) {
                showToast('Image too large! Maximum size is 5MB.', 'error');
                return;
            }

            // Create preview in media picker
            const reader = new FileReader();
            reader.onload = function(e) {
                const uploadContent = document.getElementById('media-upload-content');
                uploadContent.innerHTML = `
                    <img src="${e.target.result}" alt="Upload Preview" style="max-width: 150px; max-height: 150px; object-fit: cover; border-radius: var(--radius); margin-bottom: 10px;">
                    <p style="color: var(--text-primary); font-weight: 600;">${file.name}</p>
                    <small style="color: var(--text-muted);">Click to select this image</small>
                `;

                // Store the uploaded file for later use
                window.uploadedMediaFile = file;

                // Update form with uploaded file
                updateFormWithUploadedFile(file);
            };
            reader.readAsDataURL(file);
        }

        function updateFormWithUploadedFile(file) {
            // Set the file to the cover input
            const coverInput = document.getElementById('cover-input');
            if (coverInput) {
                const dt = new DataTransfer();
                dt.items.add(file);
                coverInput.files = dt.files;

                console.log('Updated form with uploaded file:', file.name);
            }
        }

        function selectUploadedMediaFile() {
            if (!window.uploadedMediaFile) return;

            const file = window.uploadedMediaFile;

            // Update the cover preview area with uploaded file
            const coverPreviewContent = document.getElementById('cover-preview-content');
            if (coverPreviewContent) {
                // Create preview using FileReader
                const reader = new FileReader();
                reader.onload = function(e) {
                    coverPreviewContent.innerHTML = `
                        <img src="${e.target.result}" alt="Book Cover" style="max-width: 150px; max-height: 200px; object-fit: cover; border-radius: var(--radius); margin-bottom: 10px;">
                        <p style="color: var(--text-primary); font-weight: 600;">${file.name}</p>
                        <small style="color: var(--text-muted);">Click to change</small>
                    `;
                };
                reader.readAsDataURL(file);
            }

            // Update form with uploaded file
            updateFormWithUploadedFile(file);

            // Close media picker
            closeMediaPicker();

            showToast(`Selected: ${file.name}`, 'success');
        }

        // Media search functionality
        function initializeMediaSearch() {
            const searchInput = document.getElementById('mediaSearch');
            if (!searchInput) return;

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                const mediaItems = document.querySelectorAll('.media-item');

                mediaItems.forEach(item => {
                    const imageName = item.querySelector('div').textContent.toLowerCase();
                    const shouldShow = imageName.includes(searchTerm);
                    item.style.display = shouldShow ? 'block' : 'none';
                });
            });
        }

        // Initialize media picker when modal opens
        document.addEventListener('DOMContentLoaded', function() {
            // Override the existing click handler to open media picker instead
            const coverPreviewContent = document.getElementById('cover-preview-content');
            if (coverPreviewContent) {
                coverPreviewContent.removeEventListener('click', initializeCoverUpload); // Remove old handler
                coverPreviewContent.addEventListener('click', openMediaPicker);
            }

            // Initialize media picker upload area when modal is shown
            const mediaPickerModal = document.getElementById('mediaPickerModal');
            if (mediaPickerModal) {
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.attributeName === 'class') {
                            if (mediaPickerModal.classList.contains('show')) {
                                initializeMediaPickerUpload();
                                initializeMediaSearch();
                            }
                        }
                    });
                });
                observer.observe(mediaPickerModal, { attributes: true });
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // ESC to close modals
            if (e.key === 'Escape') {
                const openModal = document.querySelector('.modal.show');
                if (openModal) {
                    const closeButton = openModal.querySelector('.close-modal');
                    if (closeButton) {
                        closeButton.click();
                    }
                }

                // Exit selection mode
                if (isSelectionMode) {
                    exitSelectionMode();
                }
            }

            // Ctrl/Cmd + A to select all in selection mode
            if ((e.ctrlKey || e.metaKey) && e.key === 'a' && isSelectionMode) {
                e.preventDefault();
                selectAllBooks();
            }
        });
    </script>

    <!-- System Settings Modal -->
    <div class="modal-overlay" id="settingsModal" style="z-index: 3000; display: none;">
        <div class="modal-container" style="max-width: 600px;">
            <div class="modal-header">
                <div class="modal-title" style="display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-cog" style="color: var(--primary); font-size: 20px;"></i>
                    <span>System Settings</span>
                </div>
                <button class="modal-close" onclick="closeSettingsModal()">&times;</button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <!-- Tabs Navigation -->
                <div class="settings-tabs" style="display: flex; border-bottom: 2px solid var(--border); background: var(--surface-elevated);">
                    <button class="settings-tab active" onclick="switchSettingsTab('password')" data-tab="password" style="flex: 1; padding: var(--spacing-md) var(--spacing-lg); background: none; border: none; border-bottom: 3px solid transparent; color: var(--text-secondary); font-weight: 600; font-size: 14px; cursor: pointer; transition: var(--transition); display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <i class="fas fa-key"></i>
                        <span>Password</span>
                    </button>
                    <button class="settings-tab" onclick="switchSettingsTab('logs')" data-tab="logs" style="flex: 1; padding: var(--spacing-md) var(--spacing-lg); background: none; border: none; border-bottom: 3px solid transparent; color: var(--text-secondary); font-weight: 600; font-size: 14px; cursor: pointer; transition: var(--transition); display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <i class="fas fa-file-alt"></i>
                        <span>Logs and History</span>
                    </button>
                </div>

                <!-- Tab Content -->
                <div style="padding: var(--spacing-xl);">
                    <!-- Password Tab -->
                    <div id="passwordTab" class="settings-tab-content active">
                        <div style="margin-bottom: var(--spacing-lg);">
                            <h3 style="color: var(--text-primary); font-size: 18px; font-weight: 600; margin-bottom: var(--spacing-sm); display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-lock" style="color: var(--primary);"></i>
                                Change Admin Password
                            </h3>
                            <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: var(--spacing-lg);">
                                Update your administrator account password. Make sure to use a strong password.
                            </p>
                        </div>
                        <form id="profileForm" style="display: flex; flex-direction: column; gap: var(--spacing-md);">
                            <div class="form-group">
                                <label class="form-label" style="display: flex; align-items: center; gap: 8px; margin-bottom: var(--spacing-sm); font-weight: 600;">
                                    <i class="fas fa-lock" style="color: var(--text-muted); font-size: 14px;"></i>
                                    Current Password
                                </label>
                                <input type="password" id="currentPassword" class="form-input" required placeholder="Enter current password">
                            </div>
                            <div class="form-group">
                                <label class="form-label" style="display: flex; align-items: center; gap: 8px; margin-bottom: var(--spacing-sm); font-weight: 600;">
                                    <i class="fas fa-key" style="color: var(--text-muted); font-size: 14px;"></i>
                                    New Password
                                </label>
                                <input type="password" id="newPassword" class="form-input" required minlength="4" placeholder="Enter new password (min. 4 characters)">
                            </div>
                            <div class="form-group">
                                <label class="form-label" style="display: flex; align-items: center; gap: 8px; margin-bottom: var(--spacing-sm); font-weight: 600;">
                                    <i class="fas fa-check-double" style="color: var(--text-muted); font-size: 14px;"></i>
                                    Confirm New Password
                                </label>
                                <input type="password" id="confirmPassword" class="form-input" required minlength="4" placeholder="Confirm new password">
                            </div>
                            <button type="submit" class="btn btn-success" style="margin-top: var(--spacing-sm); width: 100%;">
                                <i class="fas fa-save"></i> 
                                <span>Change Password</span>
                            </button>
                        </form>
                    </div>

                    <!-- System Logs Tab -->
                    <div id="logsTab" class="settings-tab-content" style="display: none;">
                        <div style="margin-bottom: var(--spacing-lg);">
                            <h3 style="color: var(--text-primary); font-size: 18px; font-weight: 600; margin-bottom: var(--spacing-sm); display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-file-alt" style="color: var(--accent);"></i>
                                Logs and History
                            </h3>
                            <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: var(--spacing-lg); line-height: 1.6;">
                                View system logs and borrow history to monitor application activity, track book transactions, and review library operations.
                            </p>
                        </div>
                        <div style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: var(--spacing-lg); margin-bottom: var(--spacing-md);">
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: var(--spacing-md);">
                                <div style="width: 48px; height: 48px; border-radius: var(--radius); background: linear-gradient(135deg, var(--accent), var(--accent-dark)); display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow);">
                                    <i class="fas fa-file-alt" style="color: white; font-size: 20px;"></i>
                                </div>
                                <div style="flex: 1;">
                                    <h4 style="color: var(--text-primary); font-size: 16px; font-weight: 600; margin-bottom: 4px;">
                                        Application Logs
                                    </h4>
                                    <p style="color: var(--text-secondary); font-size: 13px; margin: 0;">
                                        Access detailed system logs and activity records
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: var(--spacing-lg); margin-bottom: var(--spacing-md);">
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: var(--spacing-md);">
                                <div style="width: 48px; height: 48px; border-radius: var(--radius); background: linear-gradient(135deg, var(--primary), var(--primary-dark)); display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow);">
                                    <i class="fas fa-history" style="color: white; font-size: 20px;"></i>
                                </div>
                                <div style="flex: 1;">
                                    <h4 style="color: var(--text-primary); font-size: 16px; font-weight: 600; margin-bottom: 4px;">
                                        Borrow History
                                    </h4>
                                    <p style="color: var(--text-secondary); font-size: 13px; margin: 0;">
                                        View complete borrow history with year-based filtering
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; gap: var(--spacing-sm);">
                            <a href="{{ route('system-logs.index') }}" class="btn btn-primary" onclick="checkSystemLogsAccess(event)" style="text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; flex: 1;">
                                <i class="fas fa-external-link-alt"></i>
                                <span>Open System Logs</span>
                            </a>
                            <a href="{{ route('borrow.history') }}" class="btn btn-secondary" style="text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; flex: 1;">
                                <i class="fas fa-history"></i>
                                <span>View Borrow History</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
      .settings-btn:hover {
          background: var(--surface-elevated) !important;
          border-color: var(--primary) !important;
          color: var(--primary) !important;
          transform: translateY(-2px);
          box-shadow: var(--shadow-md) !important;
      }

      .settings-btn:hover i {
          animation: rotate 0.6s ease;
      }

      @keyframes rotate {
          from { transform: rotate(0deg); }
          to { transform: rotate(360deg); }
      }

      .settings-tab {
          position: relative;
      }

      .settings-tab.active {
          color: var(--primary) !important;
          border-bottom-color: var(--primary) !important;
          background: var(--surface) !important;
      }

      .settings-tab:hover:not(.active) {
          background: var(--surface) !important;
          color: var(--text-primary) !important;
      }

      .settings-tab-content {
          animation: fadeIn 0.3s ease;
      }

      .settings-tab-content.active {
          display: block !important;
      }

      @keyframes fadeIn {
          from {
              opacity: 0;
              transform: translateY(5px);
          }
          to {
              opacity: 1;
              transform: translateY(0);
          }
      }

      .form-group {
          margin-bottom: var(--spacing-md);
      }

      .form-input {
          width: 100%;
          padding: 12px 16px;
          border: 1px solid var(--border);
          border-radius: var(--radius);
          background: var(--surface);
          color: var(--text-primary);
          font-size: 14px;
          transition: var(--transition);
          font-family: 'Outfit', sans-serif;
      }

      .form-input:focus {
          outline: none;
          border-color: var(--primary);
          box-shadow: 0 0 0 3px rgba(47, 185, 235, 0.1);
          background: var(--surface-elevated);
      }

      .form-input:hover {
          border-color: var(--gray-400);
      }

      body.dark-mode .form-input {
          background: rgba(30, 41, 59, 0.9);
          border-color: rgba(71, 85, 105, 0.5);
      }

      body.dark-mode .form-input:focus {
          background: rgba(30, 41, 59, 1);
          border-color: var(--primary);
      }
  </style>

    <script>
        // Settings Modal Functions
        function openSettingsModal() {
            const modal = document.getElementById('settingsModal');
            if (modal) {
                modal.style.display = 'flex';
                modal.classList.add('active');
                document.body.classList.add('modal-open');
                // Reset to password tab
                switchSettingsTab('password');
            }
        }

        function closeSettingsModal() {
            const modal = document.getElementById('settingsModal');
            if (modal) {
                modal.style.display = 'none';
                modal.classList.remove('active');
                document.body.classList.remove('modal-open');
                const form = document.getElementById('profileForm');
                if (form) form.reset();
            }
        }

        function switchSettingsTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.settings-tab-content').forEach(content => {
                content.classList.remove('active');
                content.style.display = 'none';
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.settings-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Show selected tab content
            const selectedContent = document.getElementById(tabName + 'Tab');
            if (selectedContent) {
                selectedContent.classList.add('active');
                selectedContent.style.display = 'block';
            }
            
            // Add active class to selected tab
            const selectedTab = document.querySelector(`.settings-tab[data-tab="${tabName}"]`);
            if (selectedTab) {
                selectedTab.classList.add('active');
            }
        }

        function updateProfile() {
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (!currentPassword || !newPassword || !confirmPassword) {
                alert('Please fill in all fields');
                return;
            }

            if (newPassword.length < 4) {
                alert('New password must be at least 4 characters');
                return;
            }

            if (newPassword !== confirmPassword) {
                alert('New passwords do not match');
                return;
            }

            const submitBtn = document.querySelector('#profileForm button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Changing...';

            fetch('{{ route("admin.update-profile") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    current_password: currentPassword,
                    new_password: newPassword,
                    new_password_confirmation: confirmPassword
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Password changed successfully!');
                    closeSettingsModal();
                } else {
                    alert(data.message || 'Failed to change password');
                }
            })
            .catch(error => {
                console.error('Error changing password:', error);
                alert('Error changing password');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const passwordForm = document.getElementById('profileForm');
            if (passwordForm) {
                passwordForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    updateProfile();
                });
            }

            document.addEventListener('click', function(e) {
                const modal = document.getElementById('settingsModal');
                if (e.target === modal && modal.style.display === 'flex') {
                    closeSettingsModal();
                }
            });
        });
    </script>
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
    <div id="toast-container" class="toast-container"></div>
    <script src="{{ asset('js/toast.js') }}"></script>
    
    <script>
    function checkSystemLogsAccess(event) {
        const isAdmin = {{ auth()->check() && auth()->user()->hasPermission('view_system_logs') ? 'true' : 'false' }};
        
        if (!isAdmin) {
            event.preventDefault();
            if (typeof toast !== 'undefined') {
                toast.accessDenied('System Logs');
            } else {
                alert('Access Denied: You do not have permission to access System Logs.');
            }
        }
    }
    </script>

</body>
</html>
