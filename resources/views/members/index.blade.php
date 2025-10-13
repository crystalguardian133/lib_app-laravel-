<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>👥 Members | Julita Public Library</title>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
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

  /* Modern CSS Reset */
  *, *::before, *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  body {
    font-family: 'Outfit', 'Inter', sans-serif;
    background: linear-gradient(135deg, var(--background), #f1f5f9);
    color: var(--text-primary);
    line-height: 1.6;
    transition: background 0.4s ease, color 0.4s ease;
    min-height: 100vh;
    overflow-x: hidden;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }

  /* Dark Mode */
  body.dark-mode {
    --background: #121212;
    --surface: rgba(30, 30, 30, 0.8);
    --surface-elevated: rgba(40, 40, 40, 0.85);
    --text-primary: var(--gray-100);
    --text-secondary: var(--gray-300);
    --text-muted: var(--gray-400);
    --border: rgba(255, 255, 255, 0.1);
    --border-light: rgba(255, 255, 255, 0.05);
    --glass-bg: rgba(40, 40, 40, 0.4);
    --glass-border: rgba(255, 255, 255, 0.08);
    --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.6);
  }

  body.dark-mode {
    background: linear-gradient(135deg, #121212, #1a1a1a);
  }

  /* Sidebar Styles */
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
    color: #ffffff;
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border: 1px solid var(--glass-border);
    box-shadow: var(--glass-shadow);
  }

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
  }

  .sidebar-logo {
    width: 40px;
    height: 40px;
    object-fit: contain;
    border-radius: var(--radius);
  }

  .sidebar-title {
    font-weight: 700;
    font-size: 1.1rem;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
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

  .nav-link:hover {
    background: var(--glass-bg);
    color: #ffffff;
    transform: translateX(6px);
  }

  .nav-link.active {
    background: rgba(59, 130, 246, 0.15);
    color: #3b82f6;
    border-left: 3px solid #3b82f6;
  }

  .sidebar-footer {
    margin-top: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: var(--spacing-lg) 0;
    border-top: 1px solid var(--border);
  }

  /* Main Content */
  .main {
    margin-left: 280px;
    padding: var(--spacing-lg);
    min-height: 100vh;
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
  }

  .page-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary);
    margin-bottom: var(--spacing-xl);
  }

  /* Members Management Header */
  .members-management-header {
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-lg);
    box-shadow: var(--glass-shadow);
    margin-bottom: var(--spacing-lg);
    overflow: hidden;
  }

  .members-management-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: var(--spacing-lg);
    gap: var(--spacing-lg);
  }

  .collection-info {
    display: flex;
    align-items: center;
    flex-shrink: 0;
  }

  .management-controls {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    flex: 1;
    justify-content: flex-end;
  }

  /* Members Content Container (matching books page) */
  .members-content {
    flex: 1;
    overflow-y: auto;
    padding-right: 8px;
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border-radius: var(--radius-lg);
    padding: var(--spacing-xl);
    border: 1px solid var(--glass-border);
    box-shadow: var(--glass-shadow);
  }

  .members-content::-webkit-scrollbar {
    width: 6px;
  }

  .members-content::-webkit-scrollbar-thumb {
    background: var(--text-muted);
    border-radius: 8px;
  }

  .members-content::-webkit-scrollbar-track {
    background: var(--border-light);
  }

  /* Header Actions */
  .header-actions {
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
    margin-bottom: var(--spacing-xl);
    flex-wrap: wrap;
  }

  .search-container {
    position: relative;
  }

  .page-controls {
    display: flex;
    gap: var(--spacing-sm);
    align-items: center;
    flex: 1;
    justify-content: flex-end;
    margin-top: 0;
  }

  .search-input {
    width: 300px;
    padding: 14px 18px 14px 45px;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    color: var(--text-primary);
    font-size: 0.95rem;
    height: 48px;
    transition: var(--transition);
    position: relative;
  }

  .search-input:focus {
    max-width: 380px;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1), var(--shadow-md);
  }

  .search-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
  }

  .search-icon {
    position: absolute;
    left: var(--spacing-md);
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    font-size: 0.75rem;
  }

  /* Buttons */
  .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--spacing-sm);
    padding: 14px var(--spacing-lg);
    border-radius: var(--radius-lg);
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: var(--transition-fast);
    height: 48px;
  }

  .btn-primary {
    background: var(--primary);
    color: white;
  }

  .btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
  }

  /* Stats Grid */
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--spacing-lg);
    margin-bottom: var(--spacing-2xl);
  }

  .stat-card {
    background: var(--surface-elevated);
    border-radius: var(--radius-xl);
    padding: var(--spacing-xl);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
  }

  .stat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: var(--spacing-md);
  }

  .stat-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .stat-value {
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary);
  }

  .stat-icon {
    width: 48px;
    height: 48px;
    border-radius: var(--radius-lg);
    background: rgba(99, 102, 241, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 1.25rem;
  }

  /* Table Styles */
  .table-container {
    background: transparent;
    border: none;
    border-radius: 0;
    overflow: hidden;
    box-shadow: none;
    margin-top: 0;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    max-height: 70vh;
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

  .data-table {
    width: 100%;
    border-collapse: collapse;
  }

  .data-table th {
    background: var(--surface);
    color: var(--text-primary);
    font-weight: 600;
    font-size: 0.875rem;
    text-align: left;
    padding: var(--spacing-lg);
    border-bottom: 2px solid var(--border);
    border-right: none;
    position: sticky;
    top: 0;
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
  }

  .data-table th:last-child {
    border-right: none;
  }

  /* Dark mode table header */
  body.dark-mode .data-table th {
    background: rgba(20, 20, 20, 0.95);
    border-bottom-color: rgba(99, 102, 241, 0.3);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
  }

  /* Dark mode members content */
  body.dark-mode .members-content {
    background: rgba(30, 30, 30, 0.8);
    border-color: rgba(255, 255, 255, 0.1);
  }

  /* Dark mode members management header */
  body.dark-mode .members-management-header {
    background: rgba(30, 30, 30, 0.8);
    border-color: rgba(255, 255, 255, 0.1);
  }

  .data-table td {
    padding: var(--spacing-lg);
    border-bottom: 1px solid var(--border-light);
    color: var(--text-secondary);
    font-size: 0.875rem;
    vertical-align: middle;
    border-right: none;
  }

  .data-table td:last-child {
    border-right: none;
  }

  /* Dark mode table cells */
  body.dark-mode .data-table td {
    border-bottom-color: rgba(255, 255, 255, 0.05);
  }

  .data-table tr:hover {
    background: var(--surface);
  }

  /* Modal Styles */
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
    z-index: 2000;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: var(--transition);
  }

  .modal-overlay.active {
    opacity: 1;
    visibility: visible;
  }

  .modal-container {
    background: var(--surface-elevated);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-xl);
    width: 100%;
    max-width: 900px;
    max-height: 90vh;
    overflow: hidden;
    transform: scale(0.9) translateY(20px);
    opacity: 0;
    transition: var(--transition);
  }

  .modal-overlay.active .modal-container {
    transform: scale(1) translateY(0);
    opacity: 1;
  }

  .modal-header {
    padding: var(--spacing-xl);
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
  }

  .modal-close {
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
  }

  .modal-close:hover {
    background: var(--danger);
    color: white;
    border-color: var(--danger);
  }

  .modal-body {
    padding: var(--spacing-xl);
    max-height: 60vh;
    overflow-y: auto;
  }

  .modal-footer {
    padding: var(--spacing-xl);
    border-top: 1px solid var(--border);
    display: flex;
    gap: var(--spacing-sm);
    justify-content: flex-end;
  }

  /* Form Styles */
  .form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: var(--spacing-lg);
    margin-bottom: var(--spacing-xl);
  }

  .form-group {
    display: flex;
    flex-direction: column;
  }

  .form-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: var(--spacing-xs);
  }

  .form-input {
    padding: var(--spacing-md);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    background: var(--surface);
    color: var(--text-primary);
    font-size: 0.875rem;
    transition: var(--transition-fast);
  }

  .form-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
  }

  /* Dark Mode Toggle - Exact Copy from Dashboard */
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

  /* Responsive Design */
  @media (max-width: 768px) {
    .sidebar {
      transform: translateX(-100%);
    }

    .main {
      margin-left: 0;
    }

    .sidebar.active {
      transform: translateX(0);
    }

    .members-management-header {
      margin-bottom: var(--spacing);
    }

    .members-management-content {
      flex-direction: column;
      align-items: stretch;
      gap: var(--spacing-lg);
    }

    .management-controls {
      flex-direction: column;
      gap: var(--spacing-md);
      align-items: stretch;
    }

    .page-controls {
      flex-direction: column;
      gap: var(--spacing-lg);
      align-items: stretch;
      justify-content: space-between;
      width: 100%;
    }

    .search-container {
      max-width: none;
      margin-right: 0;
    }

    .form-grid {
      grid-template-columns: 1fr;
    }

    .stats-grid {
      grid-template-columns: 1fr;
    }

    .data-table {
      font-size: 0.75rem;
    }

    .data-table th,
    .data-table td {
      padding: var(--spacing-md) var(--spacing-sm);
    }
  }

  /* Notification Styles */
  .notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: var(--surface-elevated);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-xl);
    padding: var(--spacing-lg);
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    z-index: 3000;
    min-width: 300px;
    animation: slideInRight 0.3s ease-out;
  }

  .notification-success {
    border-left: 4px solid var(--success);
  }

  .notification-error {
    border-left: 4px solid var(--danger);
  }

  .notification-info {
    border-left: 4px solid var(--primary);
  }

  .notification-content {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    flex: 1;
  }

  .notification-close {
    background: none;
    border: none;
    color: var(--text-muted);
    cursor: pointer;
    padding: var(--spacing-xs);
    border-radius: var(--radius-sm);
    transition: var(--transition-fast);
  }

  .notification-close:hover {
    background: var(--surface);
    color: var(--text-primary);
  }

  @keyframes slideInRight {
    from {
      transform: translateX(100%);
      opacity: 0;
    }
    to {
      transform: translateX(0);
      opacity: 1;
    }
  }

  /* Button Small Styles */
  .btn-sm {
    padding: var(--spacing-xs) var(--spacing-md);
    font-size: 0.75rem;
  }

  /* Status Badge */
  .status-badge {
    padding: var(--spacing-xs) var(--spacing-sm);
    border-radius: var(--radius-full);
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .status-badge.active {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
    border: 1px solid rgba(16, 185, 129, 0.2);
  }

  /* Loading States */
  .btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
  }

  .spinner {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s linear infinite;
  }

  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }

  /* Sidebar - Matching Dashboard */
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

  /* Nav Links - Matching Dashboard */
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

  .sidebar-footer {
    margin-top: auto;
    padding: var(--spacing-lg);
    border-top: 1px solid var(--border);
  }

  /* Main Content - Matching Dashboard */
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

  .page-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary);
    margin-bottom: var(--spacing-xl);
    animation: fadeInDown 0.8s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .dashboard-title {
    font-size: 2rem;
    font-weight: 800;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: var(--spacing-xl);
    animation: fadeInDown 0.8s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .header-actions {
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
  }

  .main-body {
    flex: 1;
    padding: var(--spacing-2xl);
  }

  /* Dashboard Content - Matching Dashboard */
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

  /* Modern Buttons */
  .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--spacing-sm);
    padding: var(--spacing-sm) var(--spacing-lg);
    border-radius: var(--radius-lg);
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: var(--transition-fast);
    position: relative;
    overflow: hidden;
  }

  .btn:focus {
    outline: 2px solid var(--primary);
    outline-offset: 2px;
  }

  .btn-primary {
    background: var(--primary);
    color: white;
    box-shadow: var(--shadow);
  }

  .btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
    box-shadow: var(--shadow-lg);
  }

  .btn-secondary {
    background: var(--surface);
    color: var(--text-primary);
    border: 1px solid var(--border);
  }

  .btn-secondary:hover {
    background: var(--gray-100);
    border-color: var(--gray-300);
  }

  .btn-success {
    background: var(--success);
    color: white;
    box-shadow: var(--shadow);
  }

  .btn-success:hover {
    background: #059669;
    transform: translateY(-1px);
    box-shadow: var(--shadow-lg);
  }

  .btn-danger {
    background: var(--danger);
    color: white;
    box-shadow: var(--shadow);
  }

  .btn-danger:hover {
    background: #dc2626;
    transform: translateY(-1px);
    box-shadow: var(--shadow-lg);
  }

  .btn-sm {
    padding: var(--spacing-xs) var(--spacing-md);
    font-size: 0.75rem;
  }

  .btn-lg {
    padding: var(--spacing-md) var(--spacing-xl);
    font-size: 1rem;
  }

  /* Modern Form Styles */
  .form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: var(--spacing-lg);
    margin-bottom: var(--spacing-xl);
  }

  .form-group {
    display: flex;
    flex-direction: column;
  }

  .form-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: var(--spacing-xs);
  }

  .form-input {
    padding: var(--spacing-md);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    background: var(--surface);
    color: var(--text-primary);
    font-size: 0.875rem;
    transition: var(--transition-fast);
  }

  .form-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
  }

  .form-input:hover {
    border-color: var(--gray-300);
  }

  .form-input::placeholder {
    color: var(--text-muted);
  }

  .form-section {
    background: var(--surface);
    border-radius: var(--radius-xl);
    padding: var(--spacing-xl);
    margin-bottom: var(--spacing-xl);
    border: 1px solid var(--border);
  }

  .section-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: var(--spacing-lg);
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
  }

  .section-title i {
    color: var(--primary);
  }

  /* Modern Search Bar */
  .search-container {
    position: relative;
    max-width: 400px;
  }

  .search-input {
    width: 100%;
    padding: var(--spacing-md) var(--spacing-lg);
    padding-left: 3rem;
    border: 1px solid var(--border);
    border-radius: 50px;
    background: var(--surface);
    color: var(--text-primary);
    font-size: 0.875rem;
    transition: var(--transition-fast);
    height: 42px;
    box-shadow: var(--shadow-sm);
  }

  .search-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
  }

  .search-input::placeholder {
    color: var(--text-muted);
  }

  .search-icon {
    position: absolute;
    left: var(--spacing-lg);
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    pointer-events: none;
  }

  /* Modern Table */
  .table-container {
    background: var(--surface-elevated);
    border-radius: var(--radius-xl);
    border: 1px solid var(--border);
    overflow: hidden;
    box-shadow: var(--shadow);
  }

  .data-table {
    width: 100%;
    border-collapse: collapse;
  }

  /* Remove vertical borders for seamless look */
  .data-table th,
  .data-table td {
    border-left: none;
  }

  .data-table th:first-child,
  .data-table td:first-child {
    border-left: none;
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

  .data-table tr:last-child td {
    border-bottom: none;
  }

  /* Modern Cards */
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--spacing-lg);
    margin-bottom: var(--spacing-2xl);
  }

  .stat-card {
    background: var(--surface-elevated);
    border-radius: var(--radius-xl);
    padding: var(--spacing-xl);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
  }

  .stat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: var(--spacing-md);
  }

  .stat-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .stat-value {
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary);
  }

  .stat-icon {
    width: 48px;
    height: 48px;
    border-radius: var(--radius-lg);
    background: rgba(99, 102, 241, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 1.25rem;
  }

  /* Modern Dark Mode Toggle */
  .theme-toggle {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-full);
    padding: var(--spacing-xs);
    cursor: pointer;
    transition: var(--transition-fast);
  }

  .theme-toggle:hover {
    background: var(--gray-100);
  }

  .theme-toggle input[type="checkbox"] {
    display: none;
  }

  .theme-toggle-label {
    width: 40px;
    height: 20px;
    background: var(--gray-300);
    border-radius: var(--radius-full);
    position: relative;
    transition: var(--transition-fast);
  }

  .theme-toggle-label::after {
    content: '';
    position: absolute;
    top: 2px;
    left: 2px;
    width: 16px;
    height: 16px;
    background: white;
    border-radius: 50%;
    transition: var(--transition-fast);
    box-shadow: var(--shadow-sm);
  }

  input[type="checkbox"]:checked + .theme-toggle-label {
    background: var(--primary);
  }

  input[type="checkbox"]:checked + .theme-toggle-label::after {
    transform: translateX(20px);
  }

  /* Modern Responsive Design */
  @media (max-width: 1024px) {
    .sidebar {
      transform: translateX(-100%);
    }

    .main-content {
      margin-left: 0;
    }

    .sidebar.active {
      transform: translateX(0);
    }
  }

  @media (max-width: 768px) {
    .main-header {
      padding: var(--spacing-lg);
      flex-direction: column;
      gap: var(--spacing-md);
      align-items: stretch;
    }

    .header-actions {
      justify-content: space-between;
    }

    .main-body {
      padding: var(--spacing-lg);
    }

    .form-grid {
      grid-template-columns: 1fr;
    }

    .stats-grid {
      grid-template-columns: 1fr;
    }

    .data-table {
      font-size: 0.75rem;
    }

    .data-table th,
    .data-table td {
      padding: var(--spacing-md) var(--spacing-sm);
    }
  }

  /* Modern Animations */
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes slideIn {
    from {
      opacity: 0;
      transform: translateX(-20px);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }

  .fade-in {
    animation: fadeIn 0.6s ease-out;
  }

  .slide-in {
    animation: slideIn 0.6s ease-out;
  }

  /* Modern Loading States */
  .loading {
    position: relative;
    overflow: hidden;
  }

  .loading::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    animation: shimmer 1.5s infinite;
  }

  @keyframes shimmer {
    0% {
      left: -100%;
    }
    100% {
      left: 100%;
    }
  }

  .spinner {
    width: 20px;
    height: 20px;
    border: 2px solid var(--gray-200);
    border-top: 2px solid var(--primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  /* Modern Empty States */
  .empty-state {
    text-align: center;
    padding: var(--spacing-3xl);
    color: var(--text-muted);
  }

  .empty-state i {
    font-size: 3rem;
    margin-bottom: var(--spacing-lg);
    color: var(--gray-300);
  }

  .empty-state h3 {
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: var(--spacing-sm);
    color: var(--text-primary);
  }

  .empty-state p {
    margin-bottom: var(--spacing-lg);
  }

  /* Modern Action Buttons */
  .action-buttons {
    display: flex;
    gap: var(--spacing-xs);
    align-items: center;
  }

  .action-btn {
    padding: var(--spacing-sm);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    background: var(--surface);
    color: var(--text-secondary);
    cursor: pointer;
    transition: var(--transition-fast);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .action-btn:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
  }

  .action-btn.edit:hover {
    background: var(--primary);
    color: white;
  }

  .action-btn.delete:hover {
    background: var(--danger);
    color: white;
    border-color: var(--danger);
  }

  /* Modern Table Container */
  .table-container {
    overflow-x: auto;
    border-radius: var(--radius-xl);
  }

  .table-container::-webkit-scrollbar {
    height: 8px;
  }

  .table-container::-webkit-scrollbar-track {
    background: var(--gray-100);
    border-radius: var(--radius-full);
  }

  .table-container::-webkit-scrollbar-thumb {
    background: var(--gray-300);
    border-radius: var(--radius-full);
  }

  .table-container::-webkit-scrollbar-thumb:hover {
    background: var(--gray-400);
  }

  /* Modern Checkbox */
  .checkbox {
    width: 18px;
    height: 18px;
    border: 2px solid var(--border);
    border-radius: var(--radius-sm);
    background: var(--surface);
    cursor: pointer;
    transition: var(--transition-fast);
    position: relative;
  }

  .checkbox:checked {
    background: var(--primary);
    border-color: var(--primary);
  }

  .checkbox:checked::after {
    content: '✓';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 12px;
    font-weight: bold;
  }

  /* Table Actions */
  .table-actions {
    position: sticky;
    right: 0;
    background: inherit;
    padding-left: var(--spacing-md);
  }

  /* Modern Status Badges */
  .status-badge {
    padding: var(--spacing-xs) var(--spacing-sm);
    border-radius: var(--radius-full);
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .status-badge.active {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
    border: 1px solid rgba(16, 185, 129, 0.2);
  }

  .status-badge.inactive {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
    border: 1px solid rgba(239, 68, 68, 0.2);
  }

  .status-badge.pending {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
    border: 1px solid rgba(245, 158, 11, 0.2);
  }

  /* Modern Photo Upload */
  .photo-upload {
    border: 2px dashed var(--border);
    border-radius: var(--radius-lg);
    padding: var(--spacing-xl);
    text-align: center;
    transition: var(--transition-fast);
    cursor: pointer;
    background: var(--surface);
  }

  .photo-upload:hover {
    border-color: var(--primary);
    background: rgba(99, 102, 241, 0.05);
  }

  .photo-upload input[type="file"] {
    display: none;
  }

  .photo-preview {
    max-width: 150px;
    border-radius: var(--radius-lg);
    margin-top: var(--spacing-md);
    box-shadow: var(--shadow);
  }

  /* Modern QR Modal */
  .qr-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(8px);
    z-index: 2000;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: var(--transition);
  }

  .qr-modal-overlay.active {
    opacity: 1;
    visibility: visible;
  }

  .qr-modal-content {
    background: var(--surface-elevated);
    border-radius: var(--radius-2xl);
    padding: var(--spacing-2xl);
    text-align: center;
    box-shadow: var(--shadow-2xl);
    max-width: 400px;
    width: 90%;
  }

  .qr-code {
    max-width: 250px;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-lg);
  }

  /* Edit Modal Styling */
  .edit-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(8px);
    z-index: 3000;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: var(--transition);
  }

  .edit-modal.show {
    opacity: 1;
    visibility: visible;
  }

  .edit-modal-content {
    background: var(--surface-elevated);
    border-radius: var(--radius-xl);
    width: 90%;
    max-width: 800px;
    max-height: 90vh;
    overflow: hidden;
    box-shadow: var(--shadow-xl);
    border: 1px solid var(--glass-border);
    transform: scale(0.9) translateY(20px);
    opacity: 0;
    transition: var(--transition);
  }

  .edit-modal.show .edit-modal-content {
    transform: scale(1) translateY(0);
    opacity: 1;
  }

  .edit-modal-header {
    padding: var(--spacing-xl);
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--glass-bg);
  }

  .edit-modal-header h3 {
    margin: 0;
    color: var(--text-primary);
    font-size: 1.5rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
  }

  .edit-modal-header h3 i {
    color: var(--primary);
  }

  .edit-modal-close {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition-fast);
    color: var(--text-muted);
    font-size: 1.4rem;
    font-weight: bold;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
  }

  .edit-modal-close::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: var(--danger);
    border-radius: 50%;
    transition: var(--transition-fast);
    transform: translate(-50%, -50%);
    z-index: -1;
  }

  .edit-modal-close:hover {
    background: var(--danger);
    color: white;
    border-color: var(--danger);
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(239, 68, 68, 0.3);
    border-radius: 16px;
  }

  .edit-modal-close:hover::before {
    width: 100%;
    height: 100%;
    border-radius: 16px;
  }

  .edit-modal-close:active {
    transform: scale(0.98);
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
    border-radius: 12px;
  }

  .edit-modal-body {
    padding: var(--spacing-xl);
    max-height: 60vh;
    overflow-y: auto;
  }

  .edit-modal-footer {
    padding: var(--spacing-xl);
    border-top: 1px solid var(--border);
    display: flex;
    gap: var(--spacing-sm);
    justify-content: flex-end;
    background: var(--glass-bg);
  }

  /* Dark mode styling for edit modal */
  body.dark-mode .edit-modal-content {
    background: var(--surface-elevated);
    border-color: var(--glass-border);
  }

  body.dark-mode .edit-modal-header {
    background: rgba(30, 30, 30, 0.8);
    border-bottom-color: rgba(255, 255, 255, 0.1);
  }

  body.dark-mode .edit-modal-header h3 {
    color: var(--text-primary);
  }

  body.dark-mode .edit-modal-close {
    background: rgba(30, 41, 59, 0.9);
    border-color: rgba(71, 85, 105, 0.5);
    color: var(--text-muted);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border-radius: 12px;
  }

  body.dark-mode .edit-modal-close:hover {
    background: var(--danger);
    border-color: var(--danger);
    box-shadow: 0 6px 20px rgba(239, 68, 68, 0.5);
    transform: scale(1.05);
    border-radius: 16px;
  }

  body.dark-mode .edit-modal-close:active {
    transform: scale(0.98);
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.6);
    border-radius: 12px;
  }

  body.dark-mode .edit-modal-footer {
    background: rgba(30, 30, 30, 0.8);
    border-top-color: rgba(255, 255, 255, 0.1);
  }

  /* Form styling for edit modal */
  .form-section {
    margin-bottom: var(--spacing-xl);
  }

  .form-section h4 {
    margin: 0 0 var(--spacing-lg) 0;
    color: var(--text-primary);
    font-size: 1.125rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
  }

  .form-section h4::before {
    color: var(--primary);
  }

  .form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--spacing-lg);
    margin-bottom: var(--spacing-md);
  }

  .form-section .form-group {
    display: flex;
    flex-direction: column;
  }

  .form-section .form-group label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: var(--spacing-xs);
  }

  .form-section .form-input {
    padding: var(--spacing-md);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    background: var(--surface);
    color: var(--text-primary);
    font-size: 0.875rem;
    transition: var(--transition-fast);
  }

  .form-section .form-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
  }

  /* Modern Card Modal - Updated Styling */
  .card-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(8px);
    z-index: 2000;
    justify-content: center;
    align-items: center;
    animation: fadeIn 0.3s ease-out;
  }

  .card-modal.show {
    display: flex;
  }

  .card-modal-content {
    background: var(--surface-elevated);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-xl);
    padding: var(--spacing-2xl);
    box-shadow: var(--shadow-xl);
    max-width: 500px;
    width: 90%;
    position: relative;
    animation: slideUp 0.3s ease-out;
  }

  .card-modal-content h3 {
    margin: 0 0 var(--spacing-xl) 0;
    color: var(--text-primary);
    font-size: 1.5rem;
    font-weight: 700;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--spacing-sm);
  }

  .card-modal-content .close {
    position: absolute;
    top: var(--spacing-lg);
    right: var(--spacing-lg);
    font-size: 1.5rem;
    color: var(--text-muted);
    cursor: pointer;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-full);
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition-fast);
  }

  .card-modal-content .close:hover {
    background: var(--danger);
    color: white;
    border-color: var(--danger);
    transform: rotate(90deg);
  }

  .card-layout {
    display: flex;
    gap: var(--spacing-lg);
    justify-content: center;
    margin: var(--spacing-xl) 0;
  }

  .card {
    width: 340px;
    height: 216px;
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-xl);
    position: relative;
    background: var(--surface);
  }

  .card-bg {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* Card overlay elements */
  .overlay {
    position: absolute;
    color: white;
    font-family: 'Inter', sans-serif;
    pointer-events: none;
    font-weight: bold;
  }

  .overlay.name {
    top: 100px;
    left: 37px;
    right: 25px;
    text-align: left;
    font-size: 10px;
    text-transform: uppercase;
    line-height: 1.2;
  }

  .overlay.date {
    bottom: 43px;
    left: 127px;
    font-size: 12px;
    text-transform: uppercase;
  }

  .overlay.photo {
    top: 42px;
    right: 20px;
    width: 141px;
    height: 141px;
    border-radius: 50%;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: var(--glass-blur);
  }

  .overlay.photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

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

  /* Dark mode styling for card modal */
  body.dark-mode .card-modal-content {
    background: var(--surface-elevated);
    border-color: var(--glass-border);
  }

  body.dark-mode .card-modal-content h3 {
    color: var(--text-primary);
  }

  body.dark-mode .card-modal-content .close {
    background: rgba(30, 41, 59, 0.9);
    border-color: rgba(71, 85, 105, 0.5);
    color: var(--text-muted);
  }

  /* Animations for card modal */
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

  /* Modern Mobile Menu Toggle */
  .mobile-menu-toggle {
    display: none;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: var(--spacing-sm);
    cursor: pointer;
    transition: var(--transition-fast);
  }

  .mobile-menu-toggle:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
  }

  @media (max-width: 768px) {
    .mobile-menu-toggle {
      display: flex;
      align-items: center;
      justify-content: center;
    }
  }

  /* Modern Utility Classes */
  .text-center { text-align: center; }
  .text-left { text-align: left; }
  .text-right { text-align: right; }

  .mb-0 { margin-bottom: 0; }
  .mb-1 { margin-bottom: var(--spacing-xs); }
  .mb-2 { margin-bottom: var(--spacing-sm); }
  .mb-3 { margin-bottom: var(--spacing-md); }
  .mb-4 { margin-bottom: var(--spacing-lg); }
  .mb-5 { margin-bottom: var(--spacing-xl); }

  .mt-0 { margin-top: 0; }
  .mt-1 { margin-top: var(--spacing-xs); }
  .mt-2 { margin-top: var(--spacing-sm); }
  .mt-3 { margin-top: var(--spacing-md); }
  .mt-4 { margin-top: var(--spacing-lg); }
  .mt-5 { margin-top: var(--spacing-xl); }

  .hidden { display: none; }
  .block { display: block; }
  .flex { display: flex; }
  .grid { display: grid; }

  .w-full { width: 100%; }
  .h-full { height: 100%; }

  .rounded { border-radius: var(--radius); }
  .rounded-lg { border-radius: var(--radius-lg); }
  .rounded-full { border-radius: var(--radius-full); }

  .shadow { box-shadow: var(--shadow); }
  .shadow-lg { box-shadow: var(--shadow-lg); }
  .shadow-xl { box-shadow: var(--shadow-xl); }

  .cursor-pointer { cursor: pointer; }
  .cursor-not-allowed { cursor: not-allowed; }

  .select-none { user-select: none; }
  .select-text { user-select: text; }

  .transition { transition: var(--transition); }
  .transition-fast { transition: var(--transition-fast); }
  .transition-slow { transition: var(--transition-slow); }

  /* Additional Enhancements */
  .member-info {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
  }

  .member-avatar {
    width: 32px;
    height: 32px;
    border-radius: var(--radius-full);
    background: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.75rem;
  }

  .member-name {
    font-weight: 600;
    color: var(--text-primary);
  }

  .address {
    color: var(--text-secondary);
    font-size: 0.875rem;
  }

  /* Enhanced table styling */
  .data-table tbody tr {
    transition: var(--transition-fast);
  }

  .data-table tbody tr:hover {
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
  }

  /* ✨ Glassmorphism Enforcement & Modal Exclusion - Matching Dashboard */
  /* Apply glass to all intended elements */
  .sidebar,
  .main,
  .card,
  .table-container,
  .dashboard-content,
  #chatbot-window,
  .stats-overview-card,
  .form-control,
  .btn-outline,
  .data-table th,
  .data-table td {
    background: var(--glass-bg) !important;
    backdrop-filter: var(--glass-blur) !important;
    -webkit-backdrop-filter: var(--glass-blur) !important;
    border: 1px solid var(--glass-border) !important;
    box-shadow: var(--glass-shadow) !important;
  }
  /* Dark mode tweaks for form controls */
  body.dark-mode .form-control {
    background: rgba(30, 41, 59, 0.6) !important;
  }
  /* ❌ EXCLUDE MODALS AND TOASTS FROM GLASS STYLING */
  .modal,
  .modal *,
  .modal-content,
  .modal-card,
  .card-modal,
  .card-modal *,
  .toast-notification,
  .toast-notification * {
    background: unset !important;
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
    border: unset !important;
    box-shadow: unset !important;
  }
  /* But restore intended modal styles */
  .modal-content,
  .modal-card,
  .card-modal-content {
    background: rgba(255, 255, 255, 0.95) !important;
    backdrop-filter: blur(20px) !important;
    box-shadow: var(--shadow-lg) !important;
    border-radius: 24px !important;
  }
  body.dark-mode .modal-content,
  body.dark-mode .modal-card,
  body.dark-mode .card-modal-content {
    background: rgba(15, 23, 42, 0.95) !important;
  }

  /* Dark mode transition animation */
  .dark-mode-transition {
    animation: darkModePulse 0.6s cubic-bezier(0.4, 0, 0.2, 1);
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
  body.dark-mode {
    background: linear-gradient(135deg, #121212, #1a1a1a);
  }

  /* Modern Notifications */
  .notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: var(--surface-elevated);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-xl);
    padding: var(--spacing-lg);
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    z-index: 3000;
    min-width: 300px;
    animation: slideInRight 0.3s ease-out;
  }

  .notification-success {
    border-left: 4px solid var(--success);
  }

  .notification-error {
    border-left: 4px solid var(--danger);
  }

  .notification-info {
    border-left: 4px solid var(--primary);
  }

  .notification-content {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    flex: 1;
  }

  .notification-close {
    background: none;
    border: none;
    color: var(--text-muted);
    cursor: pointer;
    padding: var(--spacing-xs);
    border-radius: var(--radius-sm);
    transition: var(--transition-fast);
  }

  .notification-close:hover {
    background: var(--surface);
    color: var(--text-primary);
  }

  @keyframes slideInRight {
    from {
      transform: translateX(100%);
      opacity: 0;
    }
    to {
      transform: translateX(0);
      opacity: 1;
    }
  }

  /* Dashboard Animations */
  @keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
  }
  @keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-30px); }
    to { opacity: 1; transform: translateY(0); }
  }
  @keyframes darkModePulse {
    0% {
      box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.4);
    }
    70% {
      box-shadow: 0 0 0 10px rgba(99, 102, 241, 0);
    }
    100% {
      box-shadow: 0 0 0 0 rgba(99, 102, 241, 0);
    }
  }

  /* Photo Preview Enhancement */
  .photo-upload.dragover {
    border-color: var(--primary);
    background: rgba(99, 102, 241, 0.05);
  }

  .photo-upload i {
    font-size: 2rem;
    color: var(--text-muted);
    margin-bottom: var(--spacing-sm);
  }

  .photo-upload p {
    color: var(--text-secondary);
    font-size: 0.875rem;
    margin: 0;
  }

  /* Enhanced form styling */
  .form-input[type="file"] {
    padding: 0;
    border: none;
    background: transparent;
    height: auto;
  }

  /* Better select styling */
  .form-input select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 12px center;
    background-repeat: no-repeat;
    background-size: 16px;
    padding-right: 40px;
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
      <a href="{{ route('books.index') }}" data-label="Books">
        <span class="icon"><i class="fas fa-book"></i></span>
        <span class="label">Books</span>
      </a>
      <a href="{{ route('members.index') }}" class="active" data-label="Members">
        <span class="icon"><i class="fas fa-users"></i></span>
        <span class="label">Members</span>
      </a>
      <a href="{{ route('timelog.index') }}" data-label="Member Time-in/out">
        <span class="icon"><i class="fas fa-user-clock"></i></span>
        <span class="label">Member Time-in/out</span>
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
  </div>

  <!-- Main Content -->
  <div class="main" id="mainContent">
    <div class="page-title">
      <i class="fas fa-users"></i>
      Registered Members
    </div>

    <!-- Members Content Container (matching books page structure) -->
    <div class="members-content">
      <!-- Members Management Container -->
      <div class="members-management-header">
        <div class="members-management-content">
          <div class="collection-info">
            <i class="fas fa-users" style="color: var(--primary); font-size: 1.5rem; margin-right: 12px;"></i>
            <span style="font-size: 1.2rem; font-weight: 600; color: var(--text-primary);">Members Collection</span>
          </div>
          <div class="management-controls">
            <div class="search-container">
              <input type="text" class="search-input" placeholder="Search members by name, address, or contact..." id="searchInput">
              <i class="fas fa-search search-icon"></i>
            </div>
            <button class="btn btn-primary" onclick="openRegisterModal()">
              <i class="fas fa-user-plus"></i> Register Member
            </button>
          </div>
        </div>
      </div>

      <!-- Members Table -->
      <div class="table-container">
      <div class="table-wrapper">
        <table class="data-table" id="membersTable">
        <thead>
          <tr>
            <th>Name</th>
            <th>Age</th>
            <th>Address</th>
            <th>Contact</th>
            <th>School</th>
            <th>Member Since</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="membersTableBody">
          @if(isset($members) && $members->count())
            @foreach ($members as $member)
              <tr>
                <td>
                  {{ (!empty($member->last_name) && $member->last_name !== 'null') ? $member->last_name : '' }}
                  @if (!empty($member->first_name) && $member->first_name !== 'null')
                    {{ (!empty($member->last_name) && $member->last_name !== 'null') ? ', ' : '' }}{{ $member->first_name }}
                  @endif
                  @if (!empty($member->middle_name) && $member->middle_name !== 'null')
                    {{ ' ' . $member->middle_name }}
                  @endif
                </td>
                <td>{{ $member->age ?? '-' }}</td>
                <td>
                  {{ collect([
                    (!empty($member->house_number) && $member->house_number !== 'null') ? $member->house_number : null,
                    (!empty($member->street) && $member->street !== 'null') ? $member->street : null,
                    (!empty($member->barangay) && $member->barangay !== 'null') ? $member->barangay : null,
                    (!empty($member->municipality) && $member->municipality !== 'null') ? $member->municipality : null,
                    (!empty($member->province) && $member->province !== 'null') ? $member->province : null
                  ])->filter()->implode(', ') }}
                </td>
                <td>{{ (!empty($member->contactnumber) && $member->contactnumber !== 'null') ? $member->contactnumber : '-' }}</td>
                <td>{{ (!empty($member->school) && $member->school !== 'null') ? $member->school : '-' }}</td>
                <td>
                  @if (!empty($member->memberdate) && $member->memberdate !== 'null')
                    {{ \Carbon\Carbon::parse($member->memberdate)->format('M j, Y') }}
                  @else
                    -
                  @endif
                </td>
                <td>
                  <span class="status-badge active">Active</span>
                </td>
                <td>
                  <div class="action-buttons">
                    <button class="btn btn-primary btn-sm" onclick="editMember({{ $member->id }})" title="Edit Member">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-outline btn-sm" onclick="openCardModal({{ $member->id }})" title="View Card">
                      <i class="fas fa-id-card"></i>
                    </button>
                  </div>
                </td>
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="8" style="text-align: center; padding: 2rem;">
                <i class="fas fa-users" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem;"></i>
                <h3 style="color: #6b7280; margin-bottom: 0.5rem;">No Members Found</h3>
                <p style="color: #9ca3af; margin-bottom: 1.5rem;">Start by registering your first member to get started.</p>
                <button class="btn btn-primary" onclick="openRegisterModal()">
                  <i class="fas fa-user-plus"></i>
                  Register First Member
                </button>
              </td>
            </tr>
          @endif
        </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>

  <!-- Register Member Modal -->
  <div class="modal-overlay" id="registerModal">
    <div class="modal-container">
      <div class="modal-header">
        <h2 class="modal-title">
          <i class="fas fa-user-plus"></i>
          Register New Member
        </h2>
        <button class="modal-close" onclick="closeRegisterModal()">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        <form id="registerForm">
          <!-- Personal Information Section -->
          <div class="form-section">
            <h3 class="section-title">
              <i class="fas fa-user"></i>
              Personal Information
            </h3>
            <div class="form-grid">
              <div class="form-group">
                <label for="firstName" class="form-label">First Name *</label>
                <input type="text" id="firstName" name="firstName" class="form-input" required>
              </div>
              <div class="form-group">
                <label for="middleName" class="form-label">Middle Name</label>
                <input type="text" id="middleName" name="middleName" class="form-input">
              </div>
              <div class="form-group">
                <label for="lastName" class="form-label">Last Name *</label>
                <input type="text" id="lastName" name="lastName" class="form-input" required>
              </div>
              <div class="form-group">
                <label for="age" class="form-label">Age *</label>
                <input type="number" id="age" name="age" class="form-input" min="1" max="150" required>
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
                <label for="houseNumber" class="form-label">House Number</label>
                <input type="text" id="houseNumber" name="houseNumber" class="form-input">
              </div>
              <div class="form-group">
                <label for="street" class="form-label">Street</label>
                <input type="text" id="street" name="street" class="form-input">
              </div>
              <div class="form-group">
                <label for="barangay" class="form-label">Barangay *</label>
                <input type="text" id="barangay" name="barangay" class="form-input" required>
              </div>
              <div class="form-group">
                <label for="municipality" class="form-label">Municipality/City *</label>
                <input type="text" id="municipality" name="municipality" class="form-input" required>
              </div>
              <div class="form-group">
                <label for="province" class="form-label">Province *</label>
                <input type="text" id="province" name="province" class="form-input" required>
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
                <label for="contactNumber" class="form-label">Contact Number *</label>
                <input type="tel" id="contactNumber" name="contactNumber" class="form-input" pattern="[0-9]{11}" maxlength="11" required>
              </div>
              <div class="form-group">
                <label for="school" class="form-label">School/Institution</label>
                <input type="text" id="school" name="school" class="form-input">
              </div>
            </div>
          </div>

          <!-- Photo Upload Section -->
          <div class="form-section">
            <h3 class="section-title">
              <i class="fas fa-camera"></i>
              Upload Photo
            </h3>
            <div class="form-group">
              <label class="form-label">Profile Photo</label>
              <div class="photo-upload" onclick="document.getElementById('photo').click()">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Click to upload or drag and drop</p>
                <input type="file" id="photo" name="photo" accept="image/*" class="form-input">
              </div>
              <img id="photoPreview" class="photo-preview" src="#" alt="Photo Preview" style="display: none;">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeRegisterModal()">
          <i class="fas fa-times"></i>
          Cancel
        </button>
        <button type="button" class="btn btn-primary" onclick="submitRegister()">
          <i class="fas fa-save"></i>
          Register Member
        </button>
      </div>
    </div>
  </div>

  <!-- Julita Register Modal -->
  <div class="modal-overlay" id="julitaRegisterModal">
    <div class="modal-container">
      <div class="modal-header">
        <h2 class="modal-title">
          <i class="fas fa-user-plus"></i>
          Register Julita Resident
        </h2>
        <button class="modal-close" onclick="closeJulitaRegisterModal()">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        <form id="julitaRegisterForm">
          <!-- Personal Information Section -->
          <div class="form-section">
            <h3 class="section-title">
              <i class="fas fa-user"></i>
              Personal Information
            </h3>
            <div class="form-grid">
              <div class="form-group">
                <label for="julitaFirstName" class="form-label">First Name *</label>
                <input type="text" id="julitaFirstName" name="firstName" class="form-input" required>
              </div>
              <div class="form-group">
                <label for="julitaMiddleName" class="form-label">Middle Name</label>
                <input type="text" id="julitaMiddleName" name="middleName" class="form-input">
              </div>
              <div class="form-group">
                <label for="julitaLastName" class="form-label">Last Name *</label>
                <input type="text" id="julitaLastName" name="lastName" class="form-input" required>
              </div>
              <div class="form-group">
                <label for="julitaAge" class="form-label">Age *</label>
                <input type="number" id="julitaAge" name="age" class="form-input" min="1" max="150" required>
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
                <label for="julitaHouseNumber" class="form-label">House Number</label>
                <input type="text" id="julitaHouseNumber" name="houseNumber" class="form-input">
              </div>
              <div class="form-group">
                <label for="julitaStreet" class="form-label">Street</label>
                <input type="text" id="julitaStreet" name="street" class="form-input">
              </div>
              <div class="form-group">
                <label for="julitaBarangay" class="form-label">Barangay *</label>
                <select id="julitaBarangay" name="barangay" class="form-input" required>
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
                <label for="julitaMunicipality" class="form-label">Municipality *</label>
                <input type="text" id="julitaMunicipality" name="municipality" class="form-input" value="Julita" readonly>
              </div>
              <div class="form-group">
                <label for="julitaProvince" class="form-label">Province *</label>
                <input type="text" id="julitaProvince" name="province" class="form-input" value="Leyte" readonly>
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
                <label for="julitaContactNumber" class="form-label">Contact Number *</label>
                <input type="tel" id="julitaContactNumber" name="contactNumber" class="form-input" pattern="[0-9]{11}" maxlength="11" required>
              </div>
              <div class="form-group">
                <label for="julitaSchool" class="form-label">School/Institution</label>
                <input type="text" id="julitaSchool" name="school" class="form-input">
              </div>
            </div>
          </div>

          <!-- Photo Upload Section -->
          <div class="form-section">
            <h3 class="section-title">
              <i class="fas fa-camera"></i>
              Upload Photo
            </h3>
            <div class="form-group">
              <label class="form-label">Profile Photo</label>
              <div class="photo-upload" onclick="document.getElementById('julitaPhoto').click()">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Click to upload or drag and drop</p>
                <input type="file" id="julitaPhoto" name="photo" accept="image/*" class="form-input">
              </div>
              <img id="julitaPhotoPreview" class="photo-preview" src="#" alt="Photo Preview" style="display: none;">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeJulitaRegisterModal()">
          <i class="fas fa-times"></i>
          Cancel
        </button>
        <button type="button" class="btn btn-primary" onclick="submitJulitaRegister()">
          <i class="fas fa-save"></i>
          Register Member
        </button>
      </div>
    </div>
  </div>

  <!-- Membership Card Preview Modal -->
  <div id="cardModal" class="card-modal">
    <div class="card-modal-content">
      <span class="close" onclick="closeCardModal()">&times;</span>

      <h3>Membership Card Preview</h3>

      <div id="card-container" class="card-layout">
        <!-- Front Card -->
        <div class="card front" id="card-front">
          <img src="{{ asset('card_temp/card-1.png') }}" class="card-bg">

          <!-- Name overlay -->
          <div class="overlay name" id="card-name"></div>

          <!-- Date overlay -->
          <div class="overlay date" id="card-memberdate"></div>

          <!-- Photo overlay -->
          <div class="overlay photo" id="card-photo"></div>
        </div>

        <!-- Back Card -->
        <div class="card back" id="card-back">
          <img src="{{ asset('card_temp/card-2.png') }}" class="card-bg">

          <!-- QR overlay -->
          <div class="overlay qr" id="card-qr"></div>
        </div>
      </div>

      <button class="btn btn-primary" onclick="downloadCard()" style="margin-top: 1rem;">
        <i class="fas fa-download"></i>
        Download PNG
      </button>
    </div>
  </div>

  <!-- Edit Member Modal -->
  <div id="editModal" class="edit-modal" style="display: none;">
    <div class="edit-modal-content">
      <div class="edit-modal-header">
        <h3><i class="fas fa-edit"></i> Edit Member Information</h3>
        <button class="edit-modal-close" onclick="closeEditModal()">&times;</button>
      </div>
      <div class="edit-modal-body">
        <form id="editForm">
          <input type="hidden" id="editMemberId" name="memberId">

          <!-- Personal Information Section -->
          <div class="form-section">
            <h4><i class="fas fa-user"></i> Personal Information</h4>
            <div class="form-grid">
              <div class="form-group">
                <label for="editFirstName" class="form-label">First Name *</label>
                <input type="text" id="editFirstName" name="firstName" class="form-input" required>
              </div>
              <div class="form-group">
                <label for="editMiddleName" class="form-label">Middle Name</label>
                <input type="text" id="editMiddleName" name="middleName" class="form-input">
              </div>
              <div class="form-group">
                <label for="editLastName" class="form-label">Last Name *</label>
                <input type="text" id="editLastName" name="lastName" class="form-input" required>
              </div>
              <div class="form-group">
                <label for="editAge" class="form-label">Age *</label>
                <input type="number" id="editAge" name="age" class="form-input" min="1" max="150" required>
              </div>
            </div>
          </div>

          <!-- Address Information Section -->
          <div class="form-section">
            <h4><i class="fas fa-map-marker-alt"></i> Address Information</h4>
            <div class="form-grid">
              <div class="form-group">
                <label for="editHouseNumber" class="form-label">House Number</label>
                <input type="text" id="editHouseNumber" name="houseNumber" class="form-input">
              </div>
              <div class="form-group">
                <label for="editStreet" class="form-label">Street</label>
                <input type="text" id="editStreet" name="street" class="form-input">
              </div>
              <div class="form-group">
                <label for="editBarangay" class="form-label">Barangay *</label>
                <input type="text" id="editBarangay" name="barangay" class="form-input" required>
              </div>
              <div class="form-group">
                <label for="editMunicipality" class="form-label">Municipality/City *</label>
                <input type="text" id="editMunicipality" name="municipality" class="form-input" required>
              </div>
              <div class="form-group">
                <label for="editProvince" class="form-label">Province *</label>
                <input type="text" id="editProvince" name="province" class="form-input" required>
              </div>
            </div>
          </div>

          <!-- Contact Information Section -->
          <div class="form-section">
            <h4><i class="fas fa-phone"></i> Contact Information</h4>
            <div class="form-grid">
              <div class="form-group">
                <label for="editContactNumber" class="form-label">Contact Number *</label>
                <input type="tel" id="editContactNumber" name="contactNumber" class="form-input" pattern="[0-9]{11}" maxlength="11" required>
              </div>
              <div class="form-group">
                <label for="editSchool" class="form-label">School/Institution</label>
                <input type="text" id="editSchool" name="school" class="form-input">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="edit-modal-footer">
        <button type="button" class="btn btn-danger" onclick="deleteMember()">
          <i class="fas fa-trash"></i> Delete
        </button>
        <button type="button" class="btn btn-secondary" onclick="closeEditModal()">
          <i class="fas fa-times"></i> Cancel
        </button>
        <button type="submit" class="btn btn-primary" form="editForm">
          <i class="fas fa-save"></i> Save Changes
        </button>
      </div>
    </div>
  </div>


<!-- External Scripts - Organized and Modern -->
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

<!-- Custom Scripts -->
<script src="{{ asset('js/photoprev.js') }}"></script>
<script src="{{ asset('js/membersearch.js') }}"></script>
<script src="{{ asset('js/memberscript.js') }}"></script>
<script src="{{ asset('js/memberedit.js') }}"></script>
<script src="{{ asset('js/sidebarcollapse.js') }}"></script>
<script src="{{ asset('js/dashb.js') }}"></script>
<script src="{{ asset('js/showqr.js') }}"></script>
<script src="{{ asset('js/qrgen.js') }}"></script>
<script src="{{ asset('js/card_gen.js') }}"></script>


</body>
</html>