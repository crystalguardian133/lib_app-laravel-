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
    text-align: center;
    width: 160px;
    min-width: 160px;
    font-weight: 600;
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
    filter: drop-shadow(0 2px 4px rgba(99, 102, 241, 0.2));
  }
  .sidebar-header .logo:hover {
    transform: scale(1.05) rotate(2deg);
  }
  .label {
    font-weight: 700;
    font-size: 1.27rem;
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
    border: 3px solid #6b7280;
    border-radius: var(--radius-lg);
    background: var(--surface);
    color: var(--text-primary);
    font-size: 0.875rem;
    transition: var(--transition-fast);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .form-input:focus {
    outline: none;
    border-color: var(--primary);
    border-width: 3px;
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
  }

  .form-input:hover {
    border-color: #4b5563;
    border-width: 3px;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.12);
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
    width: 160px;
    min-width: 160px;
    max-width: 160px;
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

  /* Modern Action Buttons in Table */
  .action-buttons {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 4px;
    position: relative;
    justify-content: center;
    min-width: 200px;
  }

  /* Primary and Secondary Action Layout */
  .action-buttons {
    display: flex;
    flex-direction: column;
    gap: 6px;
    align-items: stretch;
    justify-content: center;
    padding: 8px;
    min-width: 120px;
  }

  /* Primary Actions Row */
  .primary-actions {
    display: flex;
    gap: 6px;
    justify-content: center;
  }

  /* Secondary Actions Row */
  .secondary-actions {
    display: flex;
    gap: 6px;
    justify-content: center;
  }

  /* Action Button Styling */
  .action-buttons .btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    padding: 8px 10px;
    font-size: 0.75rem;
    font-weight: 500;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
    min-width: 32px;
    height: 32px;
    position: relative;
    overflow: hidden;
  }

  /* Button Hover Effects */
  .action-buttons .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
  }

  .action-buttons .btn:active {
    transform: translateY(0);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  }

  /* Primary Actions Styling */
  .primary-actions .btn {
    background: var(--primary);
    color: white;
  }

  .primary-actions .btn:hover {
    background: var(--primary-dark);
    box-shadow: 0 3px 8px rgba(99, 102, 241, 0.3);
  }

  /* Secondary Actions Styling */
  .secondary-actions .btn {
    background: var(--surface);
    color: var(--text-secondary);
    border: 1px solid var(--border);
  }

  .secondary-actions .btn:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
  }

  /* Info Button Special Styling */
  .btn-info {
    background: var(--accent);
    color: white;
  }

  .btn-info:hover {
    background: var(--accent-dark);
    box-shadow: 0 3px 8px rgba(6, 182, 212, 0.3);
  }

  /* Danger Button Special Styling */
  .btn-danger {
    background: var(--danger);
    color: white;
  }

  .btn-danger:hover {
    background: #dc2626;
    box-shadow: 0 3px 8px rgba(239, 68, 68, 0.3);
  }

  /* Icon Styling */
  .action-buttons .btn i {
    font-size: 0.8rem;
  }

  /* Button Text */
  .action-buttons .btn .btn-text {
    display: none;
  }

  /* Responsive Design for Action Buttons */
  @media (min-width: 768px) {
    .action-buttons .btn .btn-text {
      display: inline;
    }
    
    .action-buttons {
      min-width: 160px;
    }
  }

  /* Mobile Responsive Layout */
  @media (max-width: 767px) {
    .action-buttons {
      flex-direction: row;
      gap: 4px;
      padding: 4px;
      min-width: 120px;
    }
    
    .primary-actions,
    .secondary-actions {
      flex-direction: column;
      gap: 4px;
    }
    
    .action-buttons .btn {
      min-width: 28px;
      height: 28px;
      padding: 4px;
    }
    
    .action-buttons .btn i {
      font-size: 0.7rem;
    }
    
    .data-table td:last-child {
      width: 120px;
      min-width: 120px;
      padding: 8px 4px;
    }
  }

  /* Tooltip Styling */
  .action-buttons .btn[title]:hover::after {
    content: attr(title);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: var(--gray-900);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.7rem;
    white-space: nowrap;
    z-index: 1000;
    margin-bottom: 2px;
  }

  /* Button Loading State */
  .action-buttons .btn.loading {
    opacity: 0.6;
    cursor: not-allowed;
  }

  .action-buttons .btn.loading::after {
    content: '';
    width: 12px;
    height: 12px;
    border: 2px solid currentColor;
    border-top: 2px solid transparent;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-left: 4px;
  }

  @keyframes spin {
    to { transform: rotate(360deg); }
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
    border: 3px dashed var(--border);
    border-radius: var(--radius-lg);
    padding: var(--spacing-lg);
    text-align: center;
    transition: var(--transition-fast);
    cursor: pointer;
    background: var(--surface);
    width: 150px;
    height: 150px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    position: relative;
  }

  .photo-upload.hidden {
    display: none;
  }

  .photo-upload:hover {
    border-color: var(--primary);
    background: rgba(99, 102, 241, 0.05);
  }

  .photo-upload input[type="file"] {
    display: none;
  }

  .photo-preview {
    width: 150px;
    height: 150px;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-lg);
    object-fit: cover;
    border: 3px solid var(--primary);
    position: absolute;
    top: 0;
    left: 0;
  }

  .photo-upload-container {
    position: relative;
    width: 150px;
    height: 150px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
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
    align-items: center;
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
    display: none !important;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(8px);
    z-index: 2000;
    display: flex;
    justify-content: center;
    align-items: center;
    animation: fadeIn 0.3s ease-out;
    padding: 20px;
  }

  .card-modal.show {
    display: flex !important;
  }

  .card-modal-content {
    background: var(--surface-elevated);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-xl);
    padding: 60px 40px 40px 40px;
    box-shadow: var(--shadow-xl);
    max-width: 900px;
    width: 95%;
    max-height: 85vh;
    position: relative;
    animation: slideUp 0.3s ease-out;
    overflow-y: auto;
    margin: 40px auto;
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
    top: 20px;
    right: 20px;
    font-size: 2rem;
    color: var(--text-muted);
    cursor: pointer;
    background: var(--surface);
    border: 2px solid var(--border);
    border-radius: var(--radius-full);
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition-fast);
    z-index: 10;
    font-weight: bold;
  }

  .card-modal-content .close:hover {
    background: var(--danger);
    color: white;
    border-color: var(--danger);
    transform: rotate(90deg) scale(1.1);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
  }

  .card-layout {
    display: flex;
    gap: var(--spacing-2xl);
    justify-content: center;
    align-items: center;
    margin: var(--spacing-xl) 0;
    flex-wrap: wrap;
  }

  .card {
    width: 380px;
    height: 240px;
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-xl);
    position: relative;
    background: var(--surface);
    margin: var(--spacing-sm);
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
    top: 110px;
    left: 40px;
    right: 30px;
    text-align: left;
    font-size: 11px;
    text-transform: uppercase;
    line-height: 1.2;
  }

  .overlay.date {
    bottom: 50px;
    left: 140px;
    font-size: 13px;
    text-transform: uppercase;
  }

  .overlay.photo {
    top: 52%;
    right: 24px;
    width: 155px;
    height: 155px;
    border-radius: 50%;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: var(--glass-blur);
    transform: translateY(-50%);
    position: absolute;
    margin: 0;
  }

  .overlay.photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center center;
    display: block;
  }

  .overlay.qr {
    top: 50%;
    left: 50%;
    width: 135px;
    height: 135px;
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

  /* Dark mode photo preview styling */
  body.dark-mode .photo-preview {
    border-color: var(--primary);
    box-shadow: var(--shadow-lg);
  }

  /* Drag and drop styling for preview */
  .photo-preview.dragover {
    border-color: var(--danger) !important;
    filter: brightness(0.8) !important;
    transform: scale(1.02);
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

  /* Enhanced form input borders for better visibility */
  body.dark-mode .form-input {
    border: 3px solid #9ca3af;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
  }

  body.dark-mode .form-input:focus {
    border-color: var(--primary);
    border-width: 3px;
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2), 0 2px 6px rgba(0, 0, 0, 0.3);
  }

  body.dark-mode .form-input:hover {
    border-color: #d1d5db;
    border-width: 3px;
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
    background: rgba(99, 102, 241, 0.15);
    transform: scale(1.05);
    box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
  }

  .photo-upload:hover {
    border-color: var(--primary);
    background: rgba(99, 102, 241, 0.08);
    transform: scale(1.02);
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
    border: 3px solid #6b7280;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  body.dark-mode .form-input select {
    border: 3px solid #9ca3af;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
  }

  /* Redesigned Activity History Modal Styles */
  .activity-modal-container {
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
    border: 1px solid var(--glass-border);
  }

  .modal-overlay.active .activity-modal-container {
    transform: scale(1) translateY(0);
    opacity: 1;
  }

  .activity-modal-header {
    padding: var(--spacing-xl);
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg, var(--glass-bg), rgba(99, 102, 241, 0.05));
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
  }

  .member-info-section {
    display: flex;
    align-items: center;
    gap: var(--spacing-lg);
    flex: 1;
  }

  .member-avatar-large {
    width: 80px;
    height: 80px;
    border-radius: var(--radius-full);
    background: linear-gradient(135deg, var(--primary), var(--accent));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    box-shadow: var(--shadow-lg);
    flex-shrink: 0;
    overflow: hidden;
  }

  .member-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: var(--radius-full);
    display: block;
  }

  .member-details {
    flex: 1;
  }

  .member-name {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 var(--spacing-sm) 0;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .member-stats {
    display: flex;
    gap: var(--spacing-lg);
    flex-wrap: wrap;
  }

  .stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .stat-label {
    font-size: 0.75rem;
    color: var(--text-muted);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.25rem;
  }

  .stat-value {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--primary);
  }

  .activity-modal-close {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-full);
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition-fast);
    color: var(--text-muted);
    flex-shrink: 0;
  }

  .activity-modal-close:hover {
    background: var(--danger);
    color: white;
    border-color: var(--danger);
    transform: rotate(90deg);
  }

  .activity-tabs {
    display: flex;
    border-bottom: 1px solid var(--border);
    background: var(--surface);
  }

  .tab-button {
    flex: 1;
    padding: var(--spacing-md) var(--spacing-lg);
    border: none;
    background: transparent;
    color: var(--text-secondary);
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: var(--transition-fast);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--spacing-sm);
    position: relative;
  }

  .tab-button:hover {
    background: var(--glass-bg);
    color: var(--text-primary);
  }

  .tab-button.active {
    color: var(--primary);
    background: rgba(99, 102, 241, 0.05);
    border-bottom: 3px solid var(--primary);
  }

  .tab-button.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--primary);
  }

  .activity-content {
    max-height: 500px;
    overflow: hidden;
  }

  .tab-content {
    display: none;
    padding: var(--spacing-xl);
    max-height: 450px;
    overflow-y: auto;
  }

  .tab-content.active {
    display: block;
  }

  .activity-timeline {
    position: relative;
  }

  .timeline-container {
    position: relative;
  }

  .timeline-item {
    display: flex;
    gap: var(--spacing-sm);
    padding: var(--spacing-sm) var(--spacing-md);
    border-radius: var(--radius-md);
    background: var(--surface);
    border: 1px solid var(--border);
    margin-bottom: var(--spacing-xs);
    transition: var(--transition-fast);
    position: relative;
  }

  .timeline-item:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    border-color: var(--primary);
  }

  .timeline-item::before {
    content: '';
    position: absolute;
    left: 30px;
    top: 50%;
    width: 2px;
    height: calc(100% + var(--spacing-md));
    background: var(--border);
    z-index: 1;
  }

  .timeline-item:last-child::before {
    height: 50%;
  }

  .timeline-icon {
    width: 50px;
    height: 50px;
    border-radius: var(--radius-full);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    position: relative;
    z-index: 2;
    flex-shrink: 0;
    box-shadow: var(--shadow-md);
  }

  .timeline-icon.book {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
  }

  .timeline-icon.time-in {
    background: linear-gradient(135deg, var(--success), #059669);
    color: white;
  }

  .timeline-icon.time-out {
    background: linear-gradient(135deg, var(--warning), #d97706);
    color: white;
  }

  .timeline-content {
    flex: 1;
    min-width: 0;
  }

  .timeline-title {
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 2px;
    font-size: 0.9rem;
  }

  .timeline-details {
    color: var(--text-secondary);
    font-size: 0.8rem;
    line-height: 1.4;
    margin-bottom: var(--spacing-xs);
  }

  .timeline-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: var(--spacing-sm);
  }

  .timeline-date {
    color: var(--text-muted);
    font-size: 0.8rem;
    font-weight: 500;
  }

  .timeline-status {
    padding: 0.25rem 0.75rem;
    border-radius: var(--radius-full);
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .status-returned {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
    border: 1px solid rgba(16, 185, 129, 0.2);
  }

  .status-pending {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
    border: 1px solid rgba(245, 158, 11, 0.2);
  }

  .status-overdue {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
    border: 1px solid rgba(239, 68, 68, 0.2);
  }

  .loading-state {
    text-align: center;
    padding: var(--spacing-2xl);
    color: var(--text-muted);
  }

  .loading-spinner {
    margin-bottom: var(--spacing-md);
  }

  .loading-spinner i {
    font-size: 2.5rem;
    color: var(--primary);
  }

  .no-activity {
    text-align: center;
    padding: var(--spacing-2xl);
    color: var(--text-muted);
  }

  .no-activity i {
    font-size: 4rem;
    margin-bottom: var(--spacing-lg);
    color: var(--gray-300);
  }

  .no-activity h4 {
    color: var(--text-primary);
    margin-bottom: var(--spacing-sm);
    font-size: 1.1rem;
  }

  /* Dark mode styles */
  body.dark-mode .activity-modal-container {
    background: var(--surface-elevated);
    border-color: var(--glass-border);
  }

  body.dark-mode .activity-modal-header {
    background: rgba(30, 30, 30, 0.8);
    border-bottom-color: rgba(255, 255, 255, 0.1);
  }

  body.dark-mode .timeline-item {
    background: rgba(40, 40, 40, 0.5);
    border-color: rgba(255, 255, 255, 0.1);
  }

  body.dark-mode .timeline-item::before {
    background: rgba(255, 255, 255, 0.1);
  }

  body.dark-mode .tab-button.active {
    background: rgba(99, 102, 241, 0.1);
  }

  /* Button info style */
  .btn-info {
    background: var(--accent);
    color: white;
  }

  .btn-info:hover {
    background: var(--accent-dark);
    transform: translateY(-1px);
    box-shadow: var(--shadow-lg);
  }

  /* Responsive design */
  @media (max-width: 768px) {
    .activity-modal-container {
      max-width: 95vw;
      margin: 10px;
    }

    .activity-modal-header {
      padding: var(--spacing-lg);
      flex-direction: column;
      gap: var(--spacing-md);
      text-align: center;
    }

    .member-info-section {
      flex-direction: column;
      gap: var(--spacing-md);
    }

    .member-avatar-large {
      width: 60px;
      height: 60px;
      font-size: 1.5rem;
    }

    .member-name {
      font-size: 1.5rem;
    }

    .member-stats {
      justify-content: center;
    }

    .activity-tabs {
      flex-direction: column;
    }

    .tab-button {
      justify-content: flex-start;
      padding: var(--spacing-sm) var(--spacing-md);
    }

    .timeline-item {
      flex-direction: column;
      gap: var(--spacing-md);
      text-align: center;
    }

    .timeline-meta {
      flex-direction: column;
      align-items: center;
      gap: var(--spacing-xs);
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
    <div style="margin-top: auto; display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; max-width: 200px; margin-left: auto; margin-right: auto;">
      <button onclick="openSettingsModal()" class="settings-btn" style="display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; padding: 0; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); color: var(--text-secondary); cursor: pointer; transition: var(--transition); font-size: 16px; box-shadow: var(--shadow-sm); flex-shrink: 0;" title="Settings">
        <i class="fas fa-cog"></i>
      </button>
      <div class="logout-btn" style="flex: 1; display: flex; align-items: center; justify-content: center; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); background: linear-gradient(135deg, var(--danger), #dc2626); border: none; border-radius: var(--radius); padding: 12px 16px; color: white; text-decoration: none; font-weight: 600; box-shadow: var(--shadow); cursor: pointer;">
        <form method="POST" action="{{ route('logout') }}" style="margin: 0; padding: 0; width: 100%;">
          @csrf
          <button type="submit" style="background: none; border: none; color: white; text-decoration: none; display: flex; align-items: center; gap: 8px; width: 100%; justify-content: center; cursor: pointer; font-size: inherit; font-weight: inherit;">
            <i class="fas fa-sign-out-alt"></i>
            <span class="logout-text">Logout</span>
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
                  @if(empty($member->email) || $member->email === 'null')
                    <span class="status-badge inactive" title="Phone: {{ $member->phone_verified ? 'Verified' : 'Not Verified' }} | Email: No Email">No Email</span>
                  @elseif(!$member->email_verified)
                    <span class="status-badge pending" title="Phone: {{ $member->phone_verified ? 'Verified' : 'Not Verified' }} | Email: Unverified">Unverified Email</span>
                  @else
                    <span class="status-badge active" title="Phone: {{ $member->phone_verified ? 'Verified' : 'Not Verified' }} | Email: Verified">Verified Email</span>
                  @endif
                </td>
                <td>
                  <div class="action-buttons">
                    <div class="primary-actions">
                      <button class="btn" onclick="editMember({{ $member->id }})" title="Edit Member">
                        <i class="fas fa-edit"></i>
                        <span class="btn-text">Edit</span>
                      </button>
                      @if(!$member->email_verified && $member->email)
                        <button class="btn btn-success" id="verifyEmailBtn_{{ $member->id }}" onclick="openEmailVerificationModal({{ $member->id }}, '{{ $member->email }}')" title="Verify Email">
                          <i class="fas fa-envelope"></i>
                          <span class="btn-text">Verify Email</span>
                        </button>
                      @elseif($member->email_verified)
                        <button class="btn" disabled style="background: #10b981; color: white; cursor: not-allowed;" title="Email Verified">
                          <i class="fas fa-check"></i>
                          <span class="btn-text">Verified</span>
                        </button>
                      @endif
                    </div>
                    <div class="secondary-actions">
                      <button class="btn btn-info" onclick="viewMemberActivity({{ $member->id }})" title="View Activity History">
                        <i class="fas fa-history"></i>
                        <span class="btn-text">Activity</span>
                      </button>
                      <button class="btn" onclick="openCardModal({{ $member->id }})" title="View Membership Card">
                        <i class="fas fa-id-card"></i>
                        <span class="btn-text">Card</span>
                      </button>
                    </div>
                  </div>
                </td>
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="9" style="text-align: center; padding: 2rem;">
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

  <!-- MEMBER ACTIVITY HISTORY MODAL -->
  <div class="modal-overlay" id="activityModal">
    <div class="activity-modal-container">
      <!-- Enhanced Header with Member Info -->
      <div class="activity-modal-header">
        <div class="member-info-section">
          <div class="member-avatar-large" id="memberAvatar">
            <i class="fas fa-user"></i>
          </div>
          <div class="member-details">
            <h1 class="member-name" id="activityMemberName">Loading member details...</h1>
            <div class="member-stats">
              <div class="stat-item">
                <span class="stat-label">Total Books Borrowed:</span>
                <span class="stat-value" id="totalBorrowed">-</span>
              </div>
              <div class="stat-item">
                <span class="stat-label">Active Borrowings:</span>
                <span class="stat-value" id="activeBorrowings">-</span>
              </div>
              <div class="stat-item">
                <span class="stat-label">Library Visits:</span>
                <span class="stat-value" id="totalVisits">-</span>
              </div>
            </div>
          </div>
        </div>
        <button class="activity-modal-close" onclick="closeActivityModal()">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <!-- Activity Tabs -->
      <div class="activity-tabs">
        <button class="tab-button active" onclick="switchActivityTab('borrowing')">
          <i class="fas fa-book"></i>
          <span>Borrowing History</span>
        </button>
        <button class="tab-button" onclick="switchActivityTab('timelog')">
          <i class="fas fa-clock"></i>
          <span>Time-in/out History</span>
        </button>
      </div>

      <!-- Activity Content -->
      <div class="activity-content">
        <!-- Borrowing History Tab -->
        <div id="borrowingTab" class="tab-content active">
          <div class="activity-timeline">
            <div id="borrowingHistory" class="timeline-container">
              <div class="loading-state">
                <div class="loading-spinner">
                  <i class="fas fa-spinner fa-spin"></i>
                </div>
                <p>Loading borrowing history...</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Time-in/out History Tab -->
        <div id="timelogTab" class="tab-content">
          <div class="activity-timeline">
            <div id="timelogHistory" class="timeline-container">
              <div class="loading-state">
                <div class="loading-spinner">
                  <i class="fas fa-spinner fa-spin"></i>
                </div>
                <p>Loading time-in/out history...</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

 <!-- REGISTER MODAL (Non-Julita Residents) -->
 <div class="modal-overlay" id="registerModal">
   <div class="modal-container">
     <div class="modal-header">
       <div class="modal-header-content">
         <div class="modal-icon-wrapper">
           <i class="fas fa-user-plus"></i>
         </div>
         <div class="modal-title-section">
           <h2 class="modal-title">Register New Member</h2>
           <p class="modal-subtitle">Add a new member to the library system</p>
         </div>
       </div>
       <button class="modal-close" onclick="closeRegisterModal()">
         <i class="fas fa-times"></i>
       </button>
     </div>
     <div class="modal-body">
       <form id="registerForm" enctype="multipart/form-data">
         <!-- Personal Information Section -->
         <div class="form-section">
           <h3 class="section-title">
             <i class="fas fa-user"></i>
             Personal Information
           </h3>
           <div class="form-grid">
             <div class="form-group">
               <label for="firstName">First Name *</label>
               <input type="text" id="firstName" name="firstName" class="form-input" required>
             </div>
             <div class="form-group">
               <label for="middleName">Middle Name</label>
               <input type="text" id="middleName" name="middleName" class="form-input">
             </div>
             <div class="form-group">
               <label for="lastName">Last Name *</label>
               <input type="text" id="lastName" name="lastName" class="form-input" required>
             </div>
             <div class="form-group">
               <label for="age">Age *</label>
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
               <label for="houseNumber">House Number</label>
               <input type="text" id="houseNumber" name="houseNumber" class="form-input">
             </div>
             <div class="form-group">
               <label for="street">Street</label>
               <input type="text" id="street" name="street" class="form-input">
             </div>
             <div class="form-group">
               <label for="barangay">Barangay *</label>
               <input type="text" id="barangay" name="barangay" class="form-input" required>
             </div>
             <div class="form-group">
               <label for="municipality">Municipality/City *</label>
               <input type="text" id="municipality" name="municipality" class="form-input" required>
             </div>
             <div class="form-group">
               <label for="province">Province *</label>
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
               <label for="contactNumber">Contact Number *</label>
               <input type="tel" id="contactNumber" name="contactNumber" class="form-input" pattern="[0-9]{11}" maxlength="11" required>
             </div>
             <div class="form-group">
               <label for="email">Email Address * <span id="emailVerifiedCheck" style="display: none; color: green;">✓</span></label>
               <input type="email" id="email" name="email" class="form-input" required>
               <button type="button" class="btn btn-info btn-sm" onclick="sendRegistrationEmailCode()">Send Code</button>
               <div id="emailVerificationSection" style="display: none; margin-top: 10px;">
                 <input type="text" id="registrationEmailCode" class="form-input" maxlength="6" placeholder="Enter 6-digit code" autocomplete="off" pattern="[0-9]{6}">
                 <button type="button" class="btn btn-success btn-sm" onclick="verifyRegistrationEmailCode()">Verify Code</button>
               </div>
             </div>
             <div class="form-group">
               <label for="school">School/Institution</label>
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
             <div class="photo-upload-container">
               <div class="photo-upload">
                 <i class="fas fa-cloud-upload-alt"></i>
                 <p>Click to upload or drag and drop</p>
                 <input type="file" id="photo" name="photo" accept="image/*" class="form-input">
               </div>
               <img id="photoPreview" class="photo-preview" src="#" alt="Photo Preview" style="display: none;">
             </div>
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

  <!-- ADD MEMBER MODAL (Julita Residents) -->
  <div class="modal-overlay" id="julitaRegisterModal">
    <div class="modal-container">
      <div class="modal-header">
        <div class="modal-header-content">
          <div class="modal-icon-wrapper">
            <i class="fas fa-user-plus"></i>
          </div>
          <div class="modal-title-section">
            <h2 class="modal-title">Register Julita Resident</h2>
            <p class="modal-subtitle">Add a new member from Julita municipality</p>
          </div>
        </div>
        <button class="modal-close" onclick="closeJulitaRegisterModal()">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        <form id="julitaRegisterForm" enctype="multipart/form-data">
          <!-- Personal Information Section -->
          <div class="form-section">
            <h3 class="section-title">
              <i class="fas fa-user"></i>
              Personal Information
            </h3>
            <div class="form-grid">
              <div class="form-group">
                <label for="julitaFirstName" class="form-label">
                  <i class="fas fa-signature"></i>
                  First Name *
                </label>
                <input type="text" id="julitaFirstName" name="firstName" class="form-input" required>
              </div>
              <div class="form-group">
                <label for="julitaMiddleName" class="form-label">
                  <i class="fas fa-signature"></i>
                  Middle Name
                </label>
                <input type="text" id="julitaMiddleName" name="middleName" class="form-input">
              </div>
              <div class="form-group">
                <label for="julitaLastName" class="form-label">
                  <i class="fas fa-signature"></i>
                  Last Name *
                </label>
                <input type="text" id="julitaLastName" name="lastName" class="form-input" required>
              </div>
              <div class="form-group">
                <label for="julitaAge" class="form-label">
                  <i class="fas fa-birthday-cake"></i>
                  Age *
                </label>
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
                <label for="julitaHouseNumber" class="form-label">
                  <i class="fas fa-home"></i>
                  House Number
                </label>
                <input type="text" id="julitaHouseNumber" name="houseNumber" class="form-input">
              </div>
              <div class="form-group">
                <label for="julitaStreet" class="form-label">
                  <i class="fas fa-road"></i>
                  Street
                </label>
                <input type="text" id="julitaStreet" name="street" class="form-input">
              </div>
              <div class="form-group">
                <label for="julitaBarangay" class="form-label">
                  <i class="fas fa-map"></i>
                  Barangay *
                </label>
                <select id="julitaBarangay" name="barangay" class="form-input" required>
                  <option value="" disabled selected>Select Barangay</option>
                  <option>Alegria</option>
                  <option>Anibong</option>
                  <option>Aslum</option>
                  <option>Balante</option>
                  <option>Bongdo</option>
                  <option>Bonifacio</option>
                  <option>Bugho</option>
                  <option>Calbasag</option>
                  <option>Caridad</option>
                  <option>Cuya-e</option>
                  <option>Dita</option>
                  <option>Gitabla</option>
                  <option>Hindang</option>
                  <option>Inawangan</option>
                  <option>Jurao</option>
                  <option>Poblacion District I</option>
                  <option>Poblacion District II</option>
                  <option>Poblacion District III</option>
                  <option>Poblacion District IV</option>
                  <option>San Andres</option>
                  <option>San Pablo</option>
                  <option>Santa Cruz</option>
                  <option>Santo Niño</option>
                  <option>Tagkip</option>
                  <option>Tolosahay</option>
                  <option>Villa Hermosa</option>
                </select>
              </div>
              <div class="form-group">
                <label for="julitaMunicipality" class="form-label">
                  <i class="fas fa-city"></i>
                  Municipality *
                </label>
                <input type="text" id="julitaMunicipality" name="municipality" class="form-input" value="Julita" readonly>
              </div>
              <div class="form-group">
                <label for="julitaProvince" class="form-label">
                  <i class="fas fa-globe-asia"></i>
                  Province *
                </label>
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
                <label for="julitaContactNumber" class="form-label">
                  <i class="fas fa-mobile-alt"></i>
                  Contact Number *
                </label>
                <input type="tel" id="julitaContactNumber" name="contactNumber" class="form-input" pattern="[0-9]{11}" maxlength="11" required>
              </div>
              <div class="form-group">
                <label for="julitaEmail" class="form-label">
                  <i class="fas fa-envelope"></i>
                  Email Address * <span id="julitaEmailVerifiedCheck" style="display: none; color: green;">✓</span>
                </label>
                <input type="email" id="julitaEmail" name="email" class="form-input">
                <button type="button" class="btn btn-info btn-sm" onclick="sendRegistrationEmailCode()">Send Code</button>
                <div id="emailVerificationSection" style="display: none; margin-top: 10px;">
                  <input type="text" id="registrationEmailCode" class="form-input" maxlength="6" placeholder="Enter 6-digit code">
                  <button type="button" class="btn btn-success btn-sm" onclick="verifyRegistrationEmailCode()">Verify Code</button>
                </div>
              </div>
              <div class="form-group">
                <label for="julitaSchool" class="form-label">
                  <i class="fas fa-school"></i>
                  School/Institution
                </label>
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
              <label class="form-label">
                <i class="fas fa-image"></i>
                Profile Photo
              </label>
              <div class="photo-upload-container">
                <div class="photo-upload">
                  <div class="upload-icon-wrapper">
                    <i class="fas fa-cloud-upload-alt"></i>
                  </div>
                  <div class="upload-text">
                    <p class="upload-main-text">Click to upload or drag and drop</p>
                    <p class="upload-sub-text">JPG, PNG, GIF up to 5MB</p>
                  </div>
                  <input type="file" id="julitaPhoto" name="photo" accept="image/*" class="form-input">
                </div>
                <img id="julitaPhotoPreview" class="photo-preview" src="#" alt="Photo Preview" style="display: none;">
              </div>
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

  <!-- SMS Verification Modal -->
  <div class="modal-overlay" id="smsVerificationModal">
    <div class="modal-container">
      <div class="modal-header">
        <div class="modal-title">Verify Phone Number</div>
        <button class="modal-close" onclick="closeSmsVerificationModal()">&times;</button>
      </div>
      <div class="modal-body">
        <p id="smsModalMessage">We will send a verification code to <strong id="smsPhoneNumber"></strong></p>
        <div id="smsCodeSection" style="display: none;">
          <label for="smsCode" class="form-label">Enter Verification Code:</label>
          <input type="text" id="smsCode" class="form-input" maxlength="6" placeholder="000000">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" onclick="closeSmsVerificationModal()">Cancel</button>
        <button class="btn btn-primary" id="sendSmsBtn" onclick="sendSmsCode()">Send Code</button>
        <button class="btn btn-success" id="verifySmsBtn" style="display: none;" onclick="verifySmsCode()">Verify</button>
      </div>
    </div>
  </div>

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
            <span>System Logs</span>
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
            <form id="changePasswordForm" style="display: flex; flex-direction: column; gap: var(--spacing-md);">
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
                System Logs
              </h3>
              <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: var(--spacing-lg); line-height: 1.6;">
                View and manage system logs to monitor application activity, track errors, and troubleshoot issues. Logs contain detailed information about system events and operations.
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
            <a href="{{ route('system-logs.index') }}" class="btn btn-primary" style="text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%;">
              <i class="fas fa-external-link-alt"></i> 
              <span>Open System Logs Page</span>
            </a>
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

  <!-- Email Verification Modal -->
  <div class="modal-overlay" id="emailVerificationModal" style="z-index: 3000;">
    <div class="modal-container">
      <div class="modal-header">
        <div class="modal-title">Verify Email Address</div>
        <button class="modal-close" onclick="closeEmailVerificationModal()">&times;</button>
      </div>
      <div class="modal-body">
        <p id="emailModalMessage">We will send a verification code to <strong id="emailAddress"></strong></p>
        <div id="emailCodeSection" style="display: none;">
          <label for="emailCode" class="form-label">Enter 6-digit Verification Code:</label>
          <input type="text" id="emailCode" class="form-input" maxlength="6" placeholder="000000" pattern="[0-9]{6}" autocomplete="off">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" onclick="closeEmailVerificationModal()">Cancel</button>
        <button class="btn btn-primary" id="sendEmailBtn" onclick="sendEmailCode()">Send Code</button>
        <button class="btn btn-success" id="verifyEmailBtn" style="display: none;" onclick="verifyEmailCode()">Verify</button>
      </div>
    </div>
  </div>

  <!-- Membership Card Preview Modal -->
  <div id="cardModal" class="card-modal" style="display: none;">
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
        Download Cards (ZIP)
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
                <label for="editEmail" class="form-label">Email Address *</label>
                <input type="email" id="editEmail" name="email" class="form-input" required>
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
        <button type="button" class="btn btn-secondary" onclick="closeEditModal()">
          <i class="fas fa-times"></i> Cancel
        </button>
        <button type="button" class="btn btn-danger" onclick="deleteMember()" style="margin-left: auto;">
          <i class="fas fa-trash"></i> Delete Member
        </button>
        <button type="submit" class="btn btn-primary" form="editForm">
          <i class="fas fa-save"></i> Save Changes
        </button>
      </div>
    </div>
  </div>


<!-- External Scripts - Organized and Modern -->
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

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

<!-- Member Activity History Functions -->
<script>
let currentActivityMemberId = null;

function viewMemberActivity(memberId) {
    const modal = document.getElementById('activityModal');
    currentActivityMemberId = memberId;

    // Show modal
    modal.classList.add('active');
    document.body.classList.add('modal-open');

    // Set loading state
    document.getElementById('activityMemberName').textContent = 'Loading member details...';
    document.getElementById('totalBorrowed').textContent = '-';
    document.getElementById('activeBorrowings').textContent = '-';
    document.getElementById('totalVisits').textContent = '-';

    // Show borrowing tab by default
    switchActivityTab('borrowing');

    // Fetch member activity data
    fetchMemberActivity(memberId);
}

function closeActivityModal() {
    const modal = document.getElementById('activityModal');
    modal.classList.remove('active');
    document.body.classList.remove('modal-open');
    currentActivityMemberId = null;
}

function switchActivityTab(tabName) {
    // Update tab buttons
    document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
    document.querySelector(`[onclick="switchActivityTab('${tabName}')"]`).classList.add('active');

    // Update tab content
    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
    document.getElementById(tabName + 'Tab').classList.add('active');
}

async function fetchMemberActivity(memberId) {
    try {
        // Fetch member basic info
        const memberResponse = await fetch(`/members/${memberId}`);
        if (!memberResponse.ok) throw new Error('Failed to fetch member data');

        const member = await memberResponse.json();
        const fullName = [member.last_name, member.first_name, member.middle_name].filter(n => n && n !== 'null').join(' ');
        document.getElementById('activityMemberName').textContent = fullName || 'Unknown Member';

        // Update member avatar
        updateMemberAvatar(member.photo);

        // Fetch borrowing history
        const borrowingResponse = await fetch(`/members/${memberId}/borrowing-history`);
        const borrowingData = borrowingResponse.ok ? await borrowingResponse.json() : [];

        // Fetch timelog history
        const timelogResponse = await fetch(`/members/${memberId}/timelog-history`);
        const timelogData = timelogResponse.ok ? await timelogResponse.json() : [];

        // Calculate statistics
        const stats = calculateMemberStats(borrowingData, timelogData);
        updateMemberStats(stats);

        // Render the data
        renderBorrowingHistory(borrowingData);
        renderTimelogHistory(timelogData);

    } catch (error) {
        console.error('Error fetching member activity:', error);
        showNotification('Failed to load member activity data', 'error');
        closeActivityModal();
    }
}

function calculateMemberStats(borrowingData, timelogData) {
    const totalBorrowed = borrowingData.length;
    const activeBorrowings = borrowingData.filter(item => item.status === 'pending' || item.status === 'borrowed').length;
    const totalVisits = timelogData.length;

    return {
        totalBorrowed,
        activeBorrowings,
        totalVisits
    };
}

function updateMemberStats(stats) {
    document.getElementById('totalBorrowed').textContent = stats.totalBorrowed;
    document.getElementById('activeBorrowings').textContent = stats.activeBorrowings;
    document.getElementById('totalVisits').textContent = stats.totalVisits;
}

function updateMemberAvatar(photoFilename) {
    const avatarContainer = document.getElementById('memberAvatar');

    if (photoFilename && photoFilename !== 'null' && photoFilename !== '') {
        // Member has a photo, display it
        const photoUrl = `/resource/member_images/${photoFilename}`;
        avatarContainer.innerHTML = `<img src="${photoUrl}" alt="Member Photo" class="member-photo" onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\\'fas fa-user\\'></i>';">`;
    } else {
        // No photo, show default icon
        avatarContainer.innerHTML = '<i class="fas fa-user"></i>';
    }
}

function renderBorrowingHistory(borrowingData) {
    const container = document.getElementById('borrowingHistory');

    if (!borrowingData || borrowingData.length === 0) {
        container.innerHTML = '<div class="no-activity"><i class="fas fa-book-open"></i><h4>No Borrowing History</h4><p>This member has not borrowed any books yet.</p></div>';
        return;
    }

    const html = borrowingData.map((item, index) => {
        const statusClass = item.status === 'returned' ? 'status-returned' :
                           item.status === 'pending' ? 'status-pending' : 'status-overdue';

        const statusText = item.status === 'returned' ? 'Returned' :
                          item.status === 'pending' ? 'Pending Return' :
                          item.status === 'borrowed' ? 'Borrowed' : 'Overdue';

        return `
            <div class="timeline-item">
                <div class="timeline-icon book">
                    <i class="fas fa-book"></i>
                </div>
                <div class="timeline-content">
                    <div class="timeline-title">${item.book_title || 'Unknown Book'}</div>
                    <div class="timeline-details">
                        <strong>Borrowed:</strong> ${formatDate(item.borrowed_date)}<br>
                        <strong>Due:</strong> ${formatDate(item.due_date)}<br>
                        ${item.returned_at ? `<strong>Returned:</strong> ${formatDate(item.returned_at)}` : '<strong>Status:</strong> Not yet returned'}
                    </div>
                    <div class="timeline-meta">
                        <div class="timeline-date">${formatRelativeTime(item.borrowed_date)}</div>
                        <div class="timeline-status ${statusClass}">${statusText}</div>
                    </div>
                </div>
            </div>
        `;
    }).join('');

    container.innerHTML = html;
}

function renderTimelogHistory(timelogData) {
    const container = document.getElementById('timelogHistory');

    if (!timelogData || timelogData.length === 0) {
        container.innerHTML = '<div class="no-activity"><i class="fas fa-clock"></i><h4>No Time-in/out History</h4><p>This member has no recorded time-in/out activity.</p></div>';
        return;
    }

    const html = timelogData.map(item => {
        const action = item.action === 'time_in' ? 'Time In' : 'Time Out';
        const iconClass = item.action === 'time_in' ? 'time-in' : 'time-out';
        const icon = item.action === 'time_in' ? 'fas fa-sign-in-alt' : 'fas fa-sign-out-alt';

        return `
            <div class="timeline-item">
                <div class="timeline-icon ${iconClass}">
                    <i class="${icon}"></i>
                </div>
                <div class="timeline-content">
                    <div class="timeline-title">${action}</div>
                    <div class="timeline-details">
                        Library visit recorded
                    </div>
                    <div class="timeline-meta">
                        <div class="timeline-date">${formatDateTime(item.created_at)}</div>
                        <div class="timeline-status" style="background: rgba(99, 102, 241, 0.1); color: var(--primary); border: 1px solid rgba(99, 102, 241, 0.2);">
                            ${formatRelativeTime(item.created_at)}
                        </div>
                    </div>
                </div>
            </div>
        `;
    }).join('');

    container.innerHTML = html;
}

function formatDate(dateString) {
    if (!dateString) return 'N/A';
    try {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    } catch (e) {
        return dateString;
    }
}

function formatDateTime(dateString) {
    if (!dateString) return 'N/A';
    try {
        const date = new Date(dateString);
        return date.toLocaleString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    } catch (e) {
        return dateString;
    }
}

function formatRelativeTime(dateString) {
    if (!dateString) return '';
    try {
        const now = new Date();
        const date = new Date(dateString);
        const diffMs = now - date;
        const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));

        if (diffDays === 0) return 'Today';
        if (diffDays === 1) return 'Yesterday';
        if (diffDays < 7) return `${diffDays} days ago`;
        if (diffDays < 30) return `${Math.floor(diffDays / 7)} weeks ago`;
        return `${Math.floor(diffDays / 30)} months ago`;
    } catch (e) {
        return '';
    }
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas ${type === 'error' ? 'fa-exclamation-triangle' : type === 'success' ? 'fa-check-circle' : 'fa-info-circle'}"></i>
            <div>
                <div style="font-weight: 600;">${message}</div>
            </div>
        </div>
        <button class="notification-close" onclick="this.parentElement.remove()">&times;</button>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.classList.add('show');
    }, 100);

    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

// Enhanced button click handlers with visual feedback
function addButtonClickEffect(button) {
    button.classList.add('loading');
    
    // Remove loading state after a short delay
    setTimeout(() => {
        button.classList.remove('loading');
    }, 1000);
}

// Override existing functions to add visual feedback
const originalEditMember = editMember;
editMember = function(memberId) {
    const button = event.target.closest('.btn');
    addButtonClickEffect(button);
    originalEditMember(memberId);
};

const originalOpenCardModal = openCardModal;
openCardModal = function(memberId) {
    const button = event.target.closest('.btn');
    addButtonClickEffect(button);
    originalOpenCardModal(memberId);
};

const originalViewMemberActivity = viewMemberActivity;
viewMemberActivity = function(memberId) {
    const button = event.target.closest('.btn');
    addButtonClickEffect(button);
    originalViewMemberActivity(memberId);
};

// SMS Verification Functions
let currentSmsMemberId = null;

function openSmsVerificationModal(memberId, phoneNumber) {
    currentSmsMemberId = memberId;
    document.getElementById('smsPhoneNumber').textContent = phoneNumber;
    document.getElementById('smsVerificationModal').classList.add('active');
    document.getElementById('smsCodeSection').style.display = 'none';
    document.getElementById('sendSmsBtn').style.display = 'inline-block';
    document.getElementById('verifySmsBtn').style.display = 'none';
    document.body.classList.add('modal-open');
}

function closeSmsVerificationModal() {
    document.getElementById('smsVerificationModal').classList.remove('active');
    document.body.classList.remove('modal-open');
    currentSmsMemberId = null;
}

async function sendSmsCode() {
    if (!currentSmsMemberId) return;

    try {
        const response = await fetch(`/members/${currentSmsMemberId}/send-sms-code`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        if (response.ok) {
            document.getElementById('smsModalMessage').textContent = 'Code sent! Enter the 6-digit code below.';
            document.getElementById('smsCodeSection').style.display = 'block';
            document.getElementById('sendSmsBtn').style.display = 'none';
            document.getElementById('verifySmsBtn').style.display = 'inline-block';
        } else {
            showNotification('Failed to send SMS code', 'error');
        }
    } catch (error) {
        showNotification('Error sending SMS code', 'error');
    }
}

async function verifySmsCode() {
    const code = document.getElementById('smsCode').value;
    if (!code || code.length !== 6) {
        showNotification('Please enter a valid 6-digit code', 'error');
        return;
    }

    try {
        const response = await fetch(`/members/${currentSmsMemberId}/verify-sms-code`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ code })
        });

        if (response.ok) {
            showNotification('Phone number verified successfully!', 'success');
            closeSmsVerificationModal();
            // Reload the page to update the status
            location.reload();
        } else {
            showNotification('Invalid verification code', 'error');
        }
    } catch (error) {
        showNotification('Error verifying code', 'error');
    }
}

// ============================================
// EMAIL VERIFICATION FUNCTIONS
// ============================================

// For existing members (via modal)
let currentEmailMemberId = null;

function openEmailVerificationModal(memberId, email) {
    currentEmailMemberId = memberId;
    window.registrationEmail = null; // Clear registration email if set
    
    // Update modal content
    document.getElementById('emailAddress').textContent = email;
    document.getElementById('emailModalMessage').textContent = `We will send a verification code to <strong>${email}</strong>`;
    
    // Reset modal state
    const codeInput = document.getElementById('emailCode');
    if (codeInput) codeInput.value = '';
    document.getElementById('emailCodeSection').style.display = 'none';
    document.getElementById('sendEmailBtn').style.display = 'inline-block';
    document.getElementById('verifyEmailBtn').style.display = 'none';
    
    // Show modal
    document.getElementById('emailVerificationModal').classList.add('active');
    document.body.classList.add('modal-open');
}

function closeEmailVerificationModal() {
    document.getElementById('emailVerificationModal').classList.remove('active');
    document.body.classList.remove('modal-open');
    
    // Reset state
    const codeInput = document.getElementById('emailCode');
    if (codeInput) codeInput.value = '';
    document.getElementById('emailCodeSection').style.display = 'none';
    document.getElementById('sendEmailBtn').style.display = 'inline-block';
    document.getElementById('verifyEmailBtn').style.display = 'none';
    
    currentEmailMemberId = null;
}

// Close settings modal when clicking outside
document.addEventListener('click', function(e) {
    const modal = document.getElementById('settingsModal');
    if (e.target === modal && modal.style.display === 'flex') {
        closeSettingsModal();
    }
});

async function sendEmailCode() {
    if (!currentEmailMemberId) {
        showNotification('No member selected', 'error');
        return;
    }

    const sendBtn = document.getElementById('sendEmailBtn');
    if (sendBtn) {
        sendBtn.disabled = true;
        sendBtn.textContent = 'Sending...';
    }

    try {
        const response = await fetch(`/members/${currentEmailMemberId}/send-email-code`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        const result = await response.json();

        if (response.ok && result.success) {
            document.getElementById('emailModalMessage').textContent = 'Code sent! Enter the 6-digit code below.';
            document.getElementById('emailCodeSection').style.display = 'block';
            document.getElementById('sendEmailBtn').style.display = 'none';
            document.getElementById('verifyEmailBtn').style.display = 'inline-block';
            
            // Focus on code input
            const codeInput = document.getElementById('emailCode');
            if (codeInput) {
                setTimeout(() => codeInput.focus(), 100);
            }
            
            showNotification('Verification code sent to your email!', 'success');
        } else {
            const errorMsg = result.message || 'Failed to send email code';
            console.error('Email send error:', result);
            showNotification(errorMsg + (result.error ? ' (' + result.error + ')' : ''), 'error');
            if (sendBtn) {
                sendBtn.disabled = false;
                sendBtn.textContent = 'Send Code';
            }
        }
    } catch (error) {
        console.error('Error sending email code:', error);
        showNotification('Error sending email code: ' + error.message, 'error');
        if (sendBtn) {
            sendBtn.disabled = false;
            sendBtn.textContent = 'Send Code';
        }
    }
}

async function verifyEmailCode() {
    if (!currentEmailMemberId) {
        showNotification('No member selected', 'error');
        return;
    }

    const codeInput = document.getElementById('emailCode');
    const code = codeInput ? codeInput.value.trim() : '';
    
    if (!code || code.length !== 6 || !/^\d{6}$/.test(code)) {
        showNotification('Please enter a valid 6-digit code', 'error');
        if (codeInput) codeInput.focus();
        return;
    }

    const verifyBtn = document.getElementById('verifyEmailBtn');
    if (verifyBtn) {
        verifyBtn.disabled = true;
        verifyBtn.textContent = 'Verifying...';
    }

    try {
        const response = await fetch(`/members/${currentEmailMemberId}/verify-email-code`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ code })
        });

        const result = await response.json();

        if (response.ok && result.success) {
            showNotification('Email verified successfully!', 'success');
            closeEmailVerificationModal();

            // Update the button to show verified state
            const verifyBtn = document.getElementById(`verifyEmailBtn_${currentEmailMemberId}`);
            if (verifyBtn) {
                verifyBtn.outerHTML = '<button class="btn" disabled style="background: #10b981; color: white; cursor: not-allowed;" title="Email Verified"><i class="fas fa-check"></i><span class="btn-text">Verified</span></button>';
            }

            // Reload the page to update the status
            setTimeout(() => location.reload(), 1500);
        } else {
            showNotification(result.message || 'Invalid verification code', 'error');
            if (codeInput) {
                codeInput.value = '';
                codeInput.focus();
            }
            if (verifyBtn) {
                verifyBtn.disabled = false;
                verifyBtn.textContent = 'Verify';
            }
        }
    } catch (error) {
        console.error('Error verifying code:', error);
        showNotification('Error verifying code', 'error');
        if (verifyBtn) {
            verifyBtn.disabled = false;
            verifyBtn.textContent = 'Verify';
        }
    }
}

// For registration (inline in form)
let lastEmailSend = 0;

function sendRegistrationEmailCode() {
    // Prevent spam: allow only once per minute
    const now = Date.now();
    if (now - lastEmailSend < 60000) {
        const remaining = Math.ceil((60000 - (now - lastEmailSend)) / 1000);
        showNotification(`Please wait ${remaining} seconds before sending another code`, 'error');
        return;
    }

    const modal = document.getElementById('registerModal')?.classList.contains('active') 
        ? document.getElementById('registerModal') 
        : document.getElementById('julitaRegisterModal');
    
    if (!modal) {
        showNotification('Registration modal not found', 'error');
        return;
    }

    const emailInput = modal.querySelector('#email') || modal.querySelector('#julitaEmail');
    if (!emailInput || !emailInput.value.trim()) {
        showNotification('Please enter an email address first', 'error');
        if (emailInput) emailInput.focus();
        return;
    }

    const email = emailInput.value.trim();
    
    // Basic email validation
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        showNotification('Please enter a valid email address', 'error');
        if (emailInput) emailInput.focus();
        return;
    }

    const sendBtn = modal.querySelector('button[onclick="sendRegistrationEmailCode()"]');
    if (sendBtn) {
        sendBtn.disabled = true;
        sendBtn.textContent = 'Sending...';
    }

    fetch('/members/send-email-code-registration', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ email })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            lastEmailSend = Date.now();
            
            // Show verification section
            const section = modal.querySelector('#emailVerificationSection');
            if (section) {
                section.style.display = 'block';
                // Focus on code input
                const codeInput = section.querySelector('#registrationEmailCode') || section.querySelector('#julitaRegistrationEmailCode');
                if (codeInput) {
                    setTimeout(() => codeInput.focus(), 100);
                }
            }
            
            // Hide send button
            if (sendBtn) sendBtn.style.display = 'none';
            
            // Store email for verification
            window.registrationEmail = email;
            window.emailVerified = false; // Reset verification status
            
            // Show debug code if available (development mode)
            let notificationMsg = 'Verification code sent to your email!';
            if (data.debug_code) {
                notificationMsg += ` (Debug code: ${data.debug_code})`;
                console.log('Debug verification code:', data.debug_code);
            }
            showNotification(notificationMsg, 'success');
        } else {
            const errorMsg = data.message || 'Failed to send verification code';
            console.error('Email send error:', data);
            showNotification(errorMsg + (data.error ? ' (' + data.error + ')' : ''), 'error');
            if (sendBtn) {
                sendBtn.disabled = false;
                sendBtn.textContent = 'Send Code';
            }
        }
    })
    .catch(error => {
        console.error('Error sending verification code:', error);
        showNotification('Error sending verification code: ' + error.message, 'error');
        if (sendBtn) {
            sendBtn.disabled = false;
            sendBtn.textContent = 'Send Code';
        }
    });
}

function verifyRegistrationEmailCode() {
    const modal = document.getElementById('registerModal')?.classList.contains('active') 
        ? document.getElementById('registerModal') 
        : document.getElementById('julitaRegisterModal');
    
    if (!modal) {
        showNotification('Registration modal not found', 'error');
        return;
    }

    if (!window.registrationEmail) {
        showNotification('Please send a verification code first', 'error');
        return;
    }

    const codeInput = modal.querySelector('#registrationEmailCode') || modal.querySelector('#julitaRegistrationEmailCode');
    const code = codeInput ? codeInput.value.trim() : '';
    
    if (!code || code.length !== 6 || !/^\d{6}$/.test(code)) {
        showNotification('Please enter a valid 6-digit code', 'error');
        if (codeInput) codeInput.focus();
        return;
    }

    const verifyBtn = modal.querySelector('button[onclick="verifyRegistrationEmailCode()"]');
    if (verifyBtn) {
        verifyBtn.disabled = true;
        verifyBtn.textContent = 'Verifying...';
    }

    fetch('/members/verify-email-code-registration', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ email: window.registrationEmail, code })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Email verified successfully!', 'success');
            
            // Update UI
            const section = modal.querySelector('#emailVerificationSection');
            if (section) section.style.display = 'none';
            
            const check = modal.querySelector('#emailVerifiedCheck') || modal.querySelector('#julitaEmailVerifiedCheck');
            if (check) check.style.display = 'inline';
            
            // Show send button again (disabled state)
            const sendBtn = modal.querySelector('button[onclick="sendRegistrationEmailCode()"]');
            if (sendBtn) {
                sendBtn.style.display = 'inline-block';
                sendBtn.disabled = true;
                sendBtn.textContent = 'Verified';
                sendBtn.classList.remove('btn-info');
                sendBtn.classList.add('btn-success');
            }
            
            window.emailVerified = true;
        } else {
            showNotification(data.message || 'Invalid verification code', 'error');
            if (codeInput) {
                codeInput.value = '';
                codeInput.focus();
            }
            if (verifyBtn) {
                verifyBtn.disabled = false;
                verifyBtn.textContent = 'Verify Code';
            }
        }
    })
    .catch(error => {
        console.error('Error verifying code:', error);
        showNotification('Error verifying code', 'error');
        if (verifyBtn) {
            verifyBtn.disabled = false;
            verifyBtn.textContent = 'Verify Code';
        }
    });
}

// Allow Enter key to submit code in modal
document.addEventListener('DOMContentLoaded', function() {
    const emailCodeInput = document.getElementById('emailCode');
    if (emailCodeInput) {
        emailCodeInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                verifyEmailCode();
            }
        });
    }

    // Setup password change form
    const passwordForm = document.getElementById('changePasswordForm');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            changePassword();
        });
    }
});

// Settings Modal Functions
function openSettingsModal() {
    document.getElementById('settingsModal').style.display = 'flex';
    document.body.classList.add('modal-open');
    // Reset to password tab
    switchSettingsTab('password');
}

function closeSettingsModal() {
    document.getElementById('settingsModal').style.display = 'none';
    document.body.classList.remove('modal-open');
    // Reset form
    const form = document.getElementById('changePasswordForm');
    if (form) form.reset();
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

function changePassword() {
    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (!currentPassword || !newPassword || !confirmPassword) {
        showNotification('Please fill in all fields', 'error');
        return;
    }

    if (newPassword.length < 4) {
        showNotification('New password must be at least 4 characters', 'error');
        return;
    }

    if (newPassword !== confirmPassword) {
        showNotification('New passwords do not match', 'error');
        return;
    }

    const submitBtn = document.querySelector('#changePasswordForm button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Changing...';

    fetch('{{ route("admin.change-password") }}', {
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
            showNotification('Password changed successfully!', 'success');
            closeSettingsModal();
        } else {
            showNotification(data.message || 'Failed to change password', 'error');
        }
    })
    .catch(error => {
        console.error('Error changing password:', error);
        showNotification('Error changing password', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
}

</script>


</body>
</html>