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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('css/christmas-effects.css') }}">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
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
    --white: #ffffff
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
    /*Google Color Scheme*/
    --google-blue: #4285F4;
    --google-red: #EA4335 ;
    --google-yellow: #FBBC05;
    --google-green: #34A853;
    
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
    height: 100vh;
    overflow: hidden;
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
  /* Enhanced sidebar header label visibility */
  .sidebar-header .label {
    display: block !important;
    font-weight: 700;
    font-size: 1.1rem;
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
    color: var(--primary) !important;
    opacity: 1 !important;
    visibility: visible !important;
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
    color: rgba(0, 0, 0, 0.9);
  }
  body:not(.dark-mode) .sidebar nav a .label {
    color: rgba(0, 0, 0, 0.9);
    transition: var(--transition);
    opacity: 1 !important;
    visibility: visible !important;
    display: inline !important;
  }
  body:not(.dark-mode) .sidebar nav a:hover {
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    color: #1a1a1a;
    box-shadow: var(--shadow-md);
  }
  body:not(.dark-mode) .sidebar nav a:hover .label {
    color: #1a1a1a;
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
    background: transparent;
    border: none;
    box-shadow: none;
  }
  /* Dashboard Content - Only Scrollable Area */
  .dashboard-content {
    background: transparent;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: none !important;
    box-shadow: none !important;
    padding: var(--spacing-lg);
    margin: 0;
    flex: 1;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    height: calc(100vh - var(--spacing-lg) * 2);
    max-height: none;
}
  .dashboard-content::-webkit-scrollbar {
    width: 6px;
  }
  .dashboard-content::-webkit-scrollbar-thumb {
    background: rgba(99, 102, 241, 0.3);
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.1);
  }
  .dashboard-content::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
  }
  .table-container::-webkit-scrollbar {
    width: 10px;
  }
  .table-container::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.2);
  }
  .table-container::-webkit-scrollbar-track {
    background: rgba(99, 102, 241, 0.1);
  }
  /* Modal table container scrollbar styling */
  .modal-body .table-container::-webkit-scrollbar {
    width: 8px;
  }
  .modal-body .table-container::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius: 6px;
    border: 1px solid rgba(255, 255, 255, 0.2);
  }
  .modal-body .table-container::-webkit-scrollbar-track {
    background: rgba(99, 102, 241, 0.1);
  }
  body.dark-mode .table-container {
    border-color: rgba(99, 102, 241, 0.4);
    box-shadow: var(--shadow-lg), 0 0 30px rgba(99, 102, 241, 0.15);
  }
  body.dark-mode .modal-body .table-container {
    border-color: rgba(99, 102, 241, 0.4);
    box-shadow: var(--shadow-lg), 0 0 30px rgba(99, 102, 241, 0.15);
  }
  body.dark-mode .table-container::-webkit-scrollbar-track {
    background: rgba(99, 102, 241, 0.2);
  }
  /* Dark mode adjustments for transparent main container */
  body.dark-mode .main {
    background: transparent;
  }
  body.dark-mode .dashboard-content {
    background: transparent;
  }
  body.dark-mode footer {
    background: rgba(0, 0, 0, 0.1);
    border-top-color: rgba(255, 255, 255, 0.1);
  }
  body.dark-mode .modal-body .table-container::-webkit-scrollbar-track {
    background: rgba(99, 102, 241, 0.2);
  }
  /* Enhanced borrower table styles for grouped display */
  .books-tooltip {
    position: absolute;
    background: var(--surface-elevated);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 8px;
    max-width: 300px;
    z-index: 1000;
    box-shadow: var(--shadow-lg);
    font-size: 0.8rem;
    line-height: 1.4;
  }
  body.dark-mode .books-tooltip {
    background: rgba(30, 30, 30, 0.95);
    border-color: rgba(255, 255, 255, 0.1);
  }
  /* Multiple book return button styling */
  .btn-return-multiple {
    background: linear-gradient(135deg, var(--success), #059669);
    border: none;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  .btn-return-multiple:hover {
    background: linear-gradient(135deg, #059669, var(--success));
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
  }
  /* Enhanced book display in table cells */
  .books-cell {
    position: relative;
    cursor: help;
  }
  .books-cell:hover .books-tooltip {
    display: block !important;
  }
  /* Status indicators for grouped rows */
  .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
  }
  .status-returned {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
    border: 1px solid rgba(16, 185, 129, 0.3);
  }
  .status-pending {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
    border: 1px solid rgba(245, 158, 11, 0.3);
  }
  .status-overdue {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
    border: 1px solid rgba(239, 68, 68, 0.3);
  }
  /* Borrower Status Row Styling */
  .returned-row {
    background: rgba(16, 185, 129, 0.05) !important;
    border-left: 4px solid #10b981;
  }
  .pending-row {
    background: rgba(245, 158, 11, 0.05) !important;
    border-left: 4px solid #f59e0b;
  }
  .overdue-row {
    background: rgba(239, 68, 68, 0.08) !important;
    border-left: 4px solid #ef4444;
    animation: overduePulse 2s ease-in-out infinite;
  }
  @keyframes overduePulse {
    0%, 100% { background-color: rgba(239, 68, 68, 0.08); }
    50% { background-color: rgba(239, 68, 68, 0.12); }
  }
  body.dark-mode .returned-row {
    background: rgba(16, 185, 129, 0.1) !important;
  }
  body.dark-mode .pending-row {
    background: rgba(245, 158, 11, 0.1) !important;
  }
  body.dark-mode .overdue-row {
    background: rgba(239, 68, 68, 0.15) !important;
  }
  /* Subtle table header sorting indicators */
  .sortable-header {
    user-select: none;
    transition: all 0.2s ease;
    position: relative;
  }
  .sortable-header:hover {
    background: rgba(99, 102, 241, 0.05);
    color: var(--primary);
  }
  .sortable-header:hover .sort-indicator {
    opacity: 0.6 !important;
  }
  .sortable-header .sort-indicator {
    transition: all 0.2s ease;
    font-weight: normal;
    display: inline-block;
    transform-origin: center;
  }
  .sortable-header:hover .sort-indicator {
    transform: scale(1.1);
  }
  body.dark-mode .sortable-header:hover {
    background: rgba(99, 102, 241, 0.1);
  }
  /* Mobile responsive sort indicators */
  @media (max-width: 768px) {
    .sortable-header .sort-indicator {
      font-size: 0.7rem;
      opacity: 0.2;
    }
    .sortable-header:hover .sort-indicator {
      opacity: 0.5 !important;
    }
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
  /* Stats Cards */
  .stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: var(--spacing);
    margin-top: var(--spacing);
  }
  .card {
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-lg);
    overflow: visible;
    box-shadow: var(--glass-shadow);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    padding: var(--spacing);
    position: relative;
    transform: scale(0.95);
    cursor: pointer;
    display: flex;
    flex-direction: column;
  }
  .card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
    border-radius: var(--radius-lg);
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.3s ease;
  }
  .card:hover::before {
    opacity: 1;
  }
  .card:hover {
    transform: scale(1) !important;
    box-shadow: var(--shadow-xl), var(--shadow-glow) !important;
    border-color: rgba(99, 102, 241, 0.3) !important;
    z-index: 10 !important;
  }
  /* Simplified hover system - ensure buttons work properly */
  .card-actions-inline .btn {
    position: relative;
    z-index: 3;
    pointer-events: auto;
  }
  /* Ensure card hover works properly */
  .card:hover {
    transform: scale(1) !important;
    box-shadow: var(--shadow-xl), var(--shadow-glow) !important;
    border-color: rgba(99, 102, 241, 0.3) !important;
    z-index: 10 !important;
  }
  .card:hover::before {
    opacity: 1;
  }
  .card h3 {
    font-size: 0.9rem;
    color: var(--text-muted);
    margin-bottom: var(--spacing-sm);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  /* Enhanced card header visibility */
  .card-header h3 {
    font-size: 0.9rem;
    color: var(--text-muted);
    margin: 0;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .card .count {
    font-size: 2.2rem;
    font-weight: 900;
    color: var(--primary);
    line-height: 1.2;
  }
  .card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
  }
  .card-header h3 {
    margin: 0;
    font-size: 0.9rem;
    color: var(--text-muted);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  /* New header layout with title and buttons side by side */
  .card-header-with-buttons {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
    width: 100%;
    position: relative;
    z-index: 2;
  }
  .card-header-with-buttons h3 {
    margin: 0;
    flex: 1;
  }
  .card-actions-inline {
    display: flex;
    gap: 8px;
    flex-shrink: 0;
    position: relative;
    z-index: 3;
  }
  /* Ensure buttons don't break card hover */
  .card-actions-inline .btn {
    position: relative;
    z-index: 4;
  }
  .card-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    align-items: center;
  }
  /* Ensure buttons don't break card hover */
  .card-actions .btn {
    flex-shrink: 0;
  }
  /* Bottom positioned action buttons — GLASSMORPHISM REMOVED */
  .card-actions-bottom {
    display: flex;
    gap: 8px;
    justify-content: flex-end;
    align-items: center;
    margin-top: auto;
    padding-top: var(--spacing-sm);
    position: relative;
    z-index: 3;
    background: transparent !important;
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
    border: none !important;
    box-shadow: none !important;
}
  /* ✨ ENHANCED CARD ACTION BUTTONS WITH ENCIRCLING HOVER ANIMATION */
  .card-actions-bottom .btn {
    position: relative;
    z-index: 4;
    pointer-events: auto;
    min-width: 36px;
    min-height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: transparent !important;
    color: var(--primary) !important;
    border: 2px solid transparent !important;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1) !important;
    transition: 
        border-color 0.5s cubic-bezier(0.4, 0, 0.2, 1),
        color 0.5s cubic-bezier(0.4, 0, 0.2, 1)
        box-shadow 0.25s ease, transform 0.25s ease;
}
.card-actions-bottom .btn i {
    color: var(--primary) !important;
    font-size: 16px;
    font-weight: 900;
    transition: color 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}
.card-actions-bottom .btn:hover {
    border-color: var(--primary) !important;
    background: transparent !important;
    color: var(--primary) !important;
    transform: translateY(-2px) scale(1.03);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25) !important;
}
.card-actions-bottom .btn:hover i {
    color: var(--primary) !important;
}
  /* Stats Overview Card */
  .stats-overview-card {
    cursor: default;
  }
  .stats-subcard {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
  }
  .stats-subcard:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    background: rgba(99, 102, 241, 0.05);
    border-color: rgba(99, 102, 241, 0.2);
  }
  .btn {
    padding: 8px 12px;
    border: none;
    border-radius: var(--radius);
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
  }
  .btn-sm {
    padding: 6px 10px;
    font-size: 0.8rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
  .btn-sm:hover {
    transform: translateY(-2px) scale(1.05) !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    background-color: rgba(99, 102, 241, 0.1) !important;
  }
  .btn-sm:active {
    transform: translateY(0px) scale(1.02);
  }
  .btn-sm:focus {
    outline: 2px solid var(--primary);
    outline-offset: 2px;
  }
  .btn-sm:focus:not(:focus-visible) {
    outline: none;
  }
  .btn-sm:focus-visible {
    outline: 2px solid var(--primary);
    outline-offset: 2px;
  }
  /* Light mode specific enhancements */
  body:not(.dark-mode) .card-actions-bottom .btn i {
    color: var(--primary);
  }
  body:not(.dark-mode) .card-actions-bottom .btn:hover i {
    color: var(--primary);
  }
  /* Additional button enhancements for better visibility */
  .btn-sm i {
    transition: transform 0.2s ease;
  }
  .btn-sm:hover i {
    transform: scale(1.1);
  }
  .btn-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
  }
  .btn-primary:hover {
    background: linear-gradient(135deg, var(--primary-dark), var(--secondary));
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
  }
  .btn-outline {
    background: transparent;
    color: var(--text-secondary);
    border: 1px solid var(--border);
  }
  .btn-outline:hover {
    background: transparent;
    color: var(--primary);
    border-color: var(--primary);
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }
  /* Modal Overlay Styles - UPDATED TO MATCH BOOKS/MEMBERS */
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
  /* New Modal Styles to Match Members/Index */
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
    display: flex;
    flex-direction: column;
    transform: scale(0.9) translateY(20px);
    opacity: 0;
    transition: var(--transition);
  }
  .modal-overlay.active .modal-container {
    transform: scale(1) translateY(0);
    opacity: 1;
  }
  .modal-header {
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
    padding: var(--spacing-xl) var(--spacing-2xl);
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    min-height: 0;
  }
  .modal-body::-webkit-scrollbar {
    width: 8px;
  }
  .modal-body::-webkit-scrollbar-thumb {
    background: var(--primary);
    border-radius: var(--radius);
  }
  .modal-body::-webkit-scrollbar-track {
    background: var(--border-light);
  }
  .modal-footer {
    padding: var(--spacing-sm) var(--spacing-xl);
    border-top: 1px solid var(--border);
    display: flex;
    gap: var(--spacing-sm);
    justify-content: flex-end;
    flex-shrink: 0;
    align-items: center;
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
  body.dark-mode .modal-body::-webkit-scrollbar-thumb {
    background: var(--accent);
  }
  body.dark-mode .modal-body::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
  }
  body.dark-mode .form-section::-webkit-scrollbar-thumb {
    background: var(--text-muted);
  }
  body.dark-mode .form-section::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
  }
  body.dark-mode .form-section.no-scroll {
    max-height: none;
    overflow: visible;
  }
  /* Ensure modal footer buttons are visible and clickable */
  .modal-footer .btn,
  .modal-actions .btn {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    opacity: 1 !important;
    visibility: visible !important;
    pointer-events: auto !important;
    min-width: 140px;
    position: relative !important;
    z-index: 100 !important;
  }
  /* Form Styles - Copied from Members Index */
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
  .form-input, .form-control {
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
    width: 100%;
  }
  .form-input:focus, .form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1), var(--shadow);
    background: var(--surface-elevated);
    transform: translateY(-1px);
  }
  .form-input:hover, .form-control:hover {
    border-color: var(--primary);
    transform: translateY(-1px);
  }
  .form-input[type="file"] {
    display: none;
  }
  .form-input select, .form-control select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 12px center;
    background-repeat: no-repeat;
    background-size: 16px;
    padding-right: 40px;
    border: 2px solid var(--glass-border);
    box-shadow: var(--shadow-sm);
  }
  /* Photo Upload Styles - Matching Books/Members Design */
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
  .photo-upload:hover {
    border-color: var(--primary);
    background: rgba(99, 102, 241, 0.05);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
  }
  .photo-upload input[type="file"] {
    display: none;
  }
  .photo-upload i {
    font-size: 2.5rem;
    color: var(--text-muted);
    transition: var(--transition);
    margin-bottom: var(--spacing-sm);
  }
  .photo-upload:hover i {
    color: var(--primary);
    transform: scale(1.1);
  }
  .photo-upload p {
    color: var(--text-muted);
    margin: 0;
    font-weight: 500;
    font-size: 1rem;
  }
  .photo-preview {
    width: 100%;
    height: 200px;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-lg);
    object-fit: cover;
    border: 2px solid var(--primary);
    position: absolute;
    top: 0;
    left: 0;
  }
  .photo-upload-container {
    position: relative;
    width: 100%;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  /* Button Styles - MATCHING BOOKS/MEMBERS DESIGN */
  .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--spacing-sm);
    padding: 12px 24px;
    border-radius: var(--radius-lg);
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: var(--transition-fast);
    min-width: 140px;
  }
  .btn-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    box-shadow: var(--shadow);
  }
  .btn-primary:hover {
    background: linear-gradient(135deg, var(--primary-dark), var(--secondary));
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
  }
  .btn-secondary {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
    box-shadow: var(--shadow);
  }
  .btn-secondary:hover {
    background: linear-gradient(135deg, #4b5563, #374151);
    transform: translateY(-2px);
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
  /* Dark Mode Adjustments for Modals */
  body.dark-mode .modal-content,
  body.dark-mode .modal-card {
    background: var(--surface-elevated);
    color: var(--text-primary);
    border-color: var(--glass-border);
  }
  body.dark-mode .modal-header {
    background: rgba(30, 30, 30, 0.8);
    border-bottom-color: rgba(255, 255, 255, 0.1);
  }
  body.dark-mode .modal-close, body.dark-mode .close-modal {
    background: rgba(30, 41, 59, 0.9);
    border-color: rgba(71, 85, 105, 0.5);
    color: var(--text-muted);
  }
  body.dark-mode .modal-close:hover, body.dark-mode .close-modal:hover {
    background: var(--danger);
    border-color: var(--danger);
    color: white;
  }
  body.dark-mode .form-input, body.dark-mode .form-control {
    background: rgba(30, 41, 59, 0.9);
    border-color: rgba(71, 85, 105, 0.5);
    color: var(--text-primary);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  }
  body.dark-mode .form-input:focus, body.dark-mode .form-control:focus {
    background: rgba(30, 41, 59, 1);
    border-color: var(--accent);
    box-shadow: 0 0 0 4px rgba(6, 182, 212, 0.1), 0 4px 12px rgba(0, 0, 0, 0.3);
  }
  body.dark-mode .form-input:hover, body.dark-mode .form-control:hover {
    border-color: rgba(255, 255, 255, 0.2);
  }
  body.dark-mode .form-input select, body.dark-mode .form-control select {
    border-color: rgba(71, 85, 105, 0.5);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  }
  body.dark-mode .photo-upload {
    background: rgba(30, 41, 59, 0.3);
    border-color: #9ca3af;
  }
  body.dark-mode .photo-upload:hover {
    background: rgba(6, 182, 212, 0.1);
    border-color: var(--accent);
  }
  .form-section {
    margin-bottom: 2rem;
    overflow: visible;
  }
  .form-section::-webkit-scrollbar {
    width: 6px;
  }
  .form-section::-webkit-scrollbar-thumb {
    background: var(--text-muted);
    border-radius: var(--radius);
  }
  .form-section::-webkit-scrollbar-track {
    background: var(--border-light);
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
  .section-icon {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
    box-shadow: var(--shadow-sm);
  }
  .form-label {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .form-label i {
    color: var(--primary);
    font-size: 0.85rem;
  }
  .photo-upload-container {
    position: relative;
    width: 100%;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .photo-upload {
    border: 3px dashed var(--border);
    border-radius: var(--radius-lg);
    padding: var(--spacing-xl);
    text-align: center;
    transition: var(--transition-fast);
    cursor: pointer;
    background: var(--surface);
    width: 200px;
    height: 200px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    position: relative;
    overflow: hidden;
  }
  .photo-upload:hover {
    border-color: var(--primary);
    background: rgba(99, 102, 241, 0.05);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
  }
  .upload-icon-wrapper {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    margin-bottom: var(--spacing-sm);
    box-shadow: var(--shadow-md);
    animation: iconBounce 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
  }
  .upload-text {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }
  .upload-main-text {
    color: var(--text-primary);
    font-weight: 600;
    font-size: 1rem;
    margin: 0;
  }
  .upload-sub-text {
    color: var(--text-muted);
    font-size: 0.85rem;
    margin: 0;
  }
  .photo-preview {
    width: 100%;
    height: 100%;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-lg);
    object-fit: cover;
    border: 3px solid var(--primary);
    position: absolute;
    top: 0;
    left: 0;
  }
  .modal.show {
    display: flex !important;
    animation: fadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  }
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  .modal-card {
    background: rgba(255, 255, 255, 0);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 2.5rem;
    width: 100%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: var(--shadow-lg);
    animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
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
  @keyframes slideInFromLeft {
    from {
      opacity: 0;
      transform: translateX(-20px);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }
  @keyframes slideInFromRight {
    from {
      opacity: 0;
      transform: translateX(20px);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }
  @keyframes bounceIn {
    0% {
      opacity: 0;
      transform: scale(0.3);
    }
    50% {
      opacity: 1;
      transform: scale(1.05);
    }
    70% {
      transform: scale(0.9);
    }
    100% {
      opacity: 1;
      transform: scale(1);
    }
  }
  body.dark-mode .modal-title {
    color: var(--accent);
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
  }
  body.dark-mode .modal-header {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.08), rgba(6, 182, 212, 0.08));
    border-bottom-color: rgba(99, 102, 241, 0.4);
  }
  .modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--border-light);
    padding: 1.5rem;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.08), rgba(6, 182, 212, 0.08));
    border-radius: var(--radius-lg) var(--radius-lg) 0 0;
    position: relative;
    overflow: hidden;
  }
  .modal-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(6, 182, 212, 0.05));
    z-index: 1;
  }
  .modal-header > * {
    position: relative;
    z-index: 2;
  }
  .modal-header-content {
    display: flex;
    align-items: center;
    gap: 1rem;
  }
  .modal-icon-wrapper {
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
  .modal-title-section {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }
  .modal-title {
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
  .modal-subtitle {
    font-size: 0.9rem;
    color: var(--text-muted);
    margin: 0;
    font-weight: 500;
  }
  .modal-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(6, 182, 212, 0.05));
    z-index: 1;
  }
  .modal-header > * {
    position: relative;
    z-index: 2;
  }
  body.dark-mode .modal-header {
    border-bottom-color: rgba(255,255,255,0.1);
  }
  .modal-title {
    font-size: 2.2rem;
    font-weight: 900;
    color: var(--primary);
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
    z-index: 10;
    pointer-events: none;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
  }
  body.dark-mode .modal-title {
    color: var(--accent-light);
  }
  .modal-body {
    padding: 0;
  }
  .modal-footer, .modal-actions {
    display: flex !important;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: -2rem;
    padding-top: 1.5rem;
    border-top: 2px solid rgba(0,0,0,0.05);
    background: var(--glass-bg) !important;
    backdrop-filter: var(--glass-blur) !important;
    -webkit-backdrop-filter: var(--glass-blur) !important;
    position: sticky !important;
    bottom: 0 !important;
    z-index: 50 !important;
    border-radius: 0 0 var(--radius-xl) var(--radius-xl);
    padding: var(--spacing-lg) var(--spacing-xl);
    flex-shrink: 0;
  }
  body.dark-mode .modal-actions {
    border-top-color: rgba(255,255,255,0.1);
  }
  .modal-actions .btn {
    min-width: 140px;
    justify-content: center;
    animation: slideInFromLeft 0.5s ease-out;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-radius: var(--radius-lg);
    padding: 12px 24px;
    transition: var(--transition-spring);
  }
  .modal-actions .btn:nth-child(2) {
    animation: slideInFromRight 0.5s ease-out;
  }
  .modal-actions .btn:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
  }
  .modal-actions .btn-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    border: none;
    box-shadow: var(--shadow-lg);
  }
  .modal-actions .btn-primary:hover {
    background: linear-gradient(135deg, var(--primary-dark), var(--secondary));
    box-shadow: var(--shadow-xl);
  }
  .modal-actions .btn-secondary {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
    border: none;
    box-shadow: var(--shadow-lg);
  }
  .modal-actions .btn-secondary:hover {
    background: linear-gradient(135deg, #4b5563, #374151);
    box-shadow: var(--shadow-xl);
  }
  .form-section {
    margin-bottom: 2.5rem;
    margin-left: var(--spacing-sm);
    margin-right: var(--spacing-sm);
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
  .form-section:nth-child(even) {
    animation: slideInFromRight 0.6s ease-out;
  }
  .form-section:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg), var(--shadow-glow);
    border-color: rgba(99, 102, 241, 0.3);
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
  .form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
  }
  .form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 0;
    animation: bounceIn 0.5s ease-out;
    padding: 0 var(--spacing-sm);
  }
  .form-group:nth-child(1) { animation-delay: 0.1s; }
  .form-group:nth-child(2) { animation-delay: 0.2s; }
  .form-group:nth-child(3) { animation-delay: 0.3s; }
  .form-group:nth-child(4) { animation-delay: 0.4s; }
  .form-group:nth-child(5) { animation-delay: 0.5s; }
  .form-group label {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
  }
  .form-control {
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
  }
  .form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1), 0 4px 12px rgba(0, 0, 0, 0.1);
    background: rgba(255, 255, 255, 1);
    transform: translateY(-1px);
  }
  .form-control:hover {
    border-color: var(--primary);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
    transform: translateY(-1px);
  }
  .form-control::placeholder {
    color: var(--text-muted);
    opacity: 0.7;
  }
  body.dark-mode .form-control {
    background: rgba(30, 41, 59, 0.9);
    border-color: rgba(71, 85, 105, 0.5);
    color: var(--text-dark);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  }
  body.dark-mode .form-control:focus {
    background: rgba(30, 41, 59, 1);
    border-color: var(--accent);
    box-shadow: 0 0 0 4px rgba(6, 182, 212, 0.1), 0 4px 12px rgba(0, 0, 0, 0.3);
  }
  body.dark-mode .form-control:hover {
    border-color: #64748b;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
  }
  /* Prevent body scroll when modal is open */
  body.modal-open {
    overflow: hidden;
  }
  .btn-secondary {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
  }
  .btn-secondary:hover {
    background: linear-gradient(135deg, #4b5563, #374151);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(107, 114, 128, 0.4);
  }
  /* Table Styles */
  .table-container {
    max-height: 450px;
    overflow-y: auto;
    border-radius: var(--radius-lg);
    border: 2px solid rgba(99, 102, 241, 0.2);
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    box-shadow: var(--shadow-lg), 0 0 20px rgba(99, 102, 241, 0.1);
    position: relative;
    overflow: hidden;
  }
  .table-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--primary), var(--accent));
    z-index: 1;
  }
  .data-table {
    width: 100%;
    border-collapse: collapse;
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
  }
  .data-table th {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    color: #ffffff;
    font-weight: 700;
    padding: 16px 12px;
    text-align: left;
    border-bottom: 2px solid rgba(255, 255, 255, 0.2);
    position: sticky;
    top: 0;
    z-index: 10;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    box-shadow: 0 2px 4px rgba(99, 102, 241, 0.3);
  }
  .data-table td {
    padding: 14px 12px;
    border-bottom: 1px solid var(--border-light);
    color: var(--text-primary);
    font-size: 0.95rem;
    font-weight: 500;
    transition: var(--transition);
  }
  .data-table tr:hover {
    background: rgba(99, 102, 241, 0.08);
    transform: translateX(2px);
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.15);
  }
  .data-table tr:last-child td {
    border-bottom: none;
  }
  .loading {
    text-align: center;
    color: var(--text-muted);
    font-style: italic;
    padding: 20px;
  }
  /* Charts */
  .chart-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--spacing-lg);
    margin-top: var(--spacing-xl);
  }
  canvas {
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-md);
    padding: var(--spacing);
    margin-top: var(--spacing);
    box-shadow: var(--glass-shadow);
    transition: var(--transition);
  }
  canvas:hover {
    box-shadow: var(--shadow-lg), var(--shadow-glow);
    transform: translateY(-2px);
  }
  /* Chatbot Button */
  #chatbot-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 50px;
    height: 50px;
    display: grid;
    place-items: center;
    background: linear-gradient(135deg, var(--accent), var(--primary));
    color: #fff;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    box-shadow: var(--shadow-xl), 0 0 30px rgba(99, 102, 241, 0.4);
    cursor: pointer;
    z-index: 2200;
    transition: var(--transition-spring);
    animation: pulse 3s infinite alternate;
    font-size: 18px;
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
    bottom: 80px;
    right: 20px;
    width: 320px;
    max-width: calc(100vw - 40px);
    background: var(--surface-elevated);
    backdrop-filter: none;
    -webkit-backdrop-filter: none;
    border: 2px solid var(--glass-border);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-xl);
    display: none;
    flex-direction: column;
    overflow: hidden;
    z-index: 2300;
    animation: chatSlideUp 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
  }

  /* Message Container */
  .message-container {
    margin-bottom: 8px;
    padding: 6px 12px;
    position: relative;
    display: flex;
    justify-content: flex-start;
  }

  .message-container.user {
    justify-content: flex-end;
  }

  .message-container i {
    font-size: 14px;
    position: absolute;
    top: 10px;
    color: var(--primary);
  }

  .message-container.bot i {
    left: 6px;
  }

  .message-container.user i {
    right: 6px;
  }

  .message-container .msg {
    padding: 8px 12px;
    border-radius: var(--radius);
    max-width: 80%;
    word-wrap: break-word;
    margin-left: 20px;
    font-size: 0.9rem;
  }

  .message-container.user .msg {
    margin-left: 0;
    margin-right: 20px;
  }

  .message-container .msg.user {
    background: var(--primary);
    color: white;
    text-align: left;
  }

  .message-container .msg.bot {
    background: var(--surface);
    color: var(--text-primary);
  }

  /* Typing Indicator */
  .typing-indicator {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    background: var(--surface);
    border-radius: var(--radius);
    margin-right: auto;
    max-width: 80%;
  }

  .ripple-container {
    display: flex;
    align-items: center;
    gap: 4px;
  }

  .ripple-circle {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--primary);
    animation: ripple 1.4s ease-in-out infinite both;
  }

  .ripple-circle:nth-child(1) { animation-delay: -0.32s; }
  .ripple-circle:nth-child(2) { animation-delay: -0.16s; }

  @keyframes ripple {
    0%, 80%, 100% {
      transform: scale(0);
      opacity: 0.5;
    }
    40% {
      transform: scale(1);
      opacity: 1;
    }
  }
  #chatbot-header {
    padding: 12px 16px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: var(--shadow-lg);
    border-bottom: 2px solid rgba(255, 255, 255, 0.2);
    font-size: 14px;
  }
  #chatbot-close {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: rgba(255, 255, 255, 0.8);
    font-size: 16px;
    width: 28px;
    height: 28px;
    border-radius: 6px;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.7;
  }
  #chatbot-close:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.4);
    color: white;
    opacity: 1;
    transform: scale(1.05);
  }
  #chatbot-messages {
    height: 280px;
    overflow-y: auto;
    padding: 12px;
    background: var(--surface);
    color: var(--text-primary);
    border-bottom: 1px solid var(--border);
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
    gap: 6px;
    padding: 10px;
    background: var(--surface);
    border-top: 2px solid var(--border);
  }
  #chatbot-user-input {
    flex: 1;
    padding: 8px 10px;
    border: 2px solid var(--border);
    border-radius: var(--radius);
    font-size: 0.85rem;
    background: var(--surface-elevated);
    color: var(--text-primary);
    transition: var(--transition);
  }
  #chatbot-user-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
  }
  #chatbot-user-input {
    transition: all 0.3s ease-in-out;
    position: relative;
  }
  #chatbot-user-input::placeholder {
    transition: opacity 0.3s ease-in-out, color 0.3s ease-in-out;
  }
  .gemini-branding {
    transition: opacity 0.3s ease-in-out;
  }
  /* Thinking animation for input box */
  #chatbot-user-input.thinking {
    animation: thinkingPulse 1.5s ease-in-out infinite;
    border-color: var(--primary) !important;
    box-shadow: 0 0 10px rgba(99, 102, 241, 0.3) !important;
  }
  @keyframes thinkingPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.02); }
  }
  @keyframes spinningGradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
  @keyframes geminiGradient {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
  }
  #chatbot-send {
    padding: 8px 12px;
    border: 2px solid transparent;
    border-radius: var(--radius);
    background: linear-gradient(135deg, var(--accent), var(--accent-dark));
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition-spring);
    box-shadow: var(--shadow-lg);
    font-size: 0.85rem;
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
    backdrop-filter: none;
    -webkit-backdrop-filter: none;
    border: 2px solid var(--glass-border);
    color: var(--text-primary);
    padding: 16px 20px;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-xl);
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
    background: rgba(255, 255, 255, 0.3);
    backdrop-filter: none;
    -webkit-backdrop-filter: none;
    border: 2px solid rgba(255, 255, 255, 0.2);
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
  @keyframes slideInFromTop {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  /* Dark mode transition animation */
  .dark-mode-transition {
    animation: darkModePulse 0.6s cubic-bezier(0.4, 0, 0.2, 1);
  }
  /* ✨ Glassmorphism Enforcement & Modal Exclusion — FIXED */
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
  /* Override for modal footer buttons to ensure visibility */
  .modal-footer .btn,
  .modal-actions .btn {
    background: var(--primary) !important;
    color: white !important;
    border: 2px solid var(--primary) !important;
    box-shadow: var(--shadow-lg) !important;
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
  }
  /* Large Desktop - Enhanced Layout */
  @media (min-width: 1200px) {
    .sidebar {
      width: 300px;
    }
    .main {
      margin-left: 300px;
      min-width: calc(100% - 300px);
    }
    .stats {
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }
  }
  /* Tablet Landscape and Small Desktop */
  @media (min-width: 769px) and (max-width: 1199px) {
    .sidebar {
      width: 240px;
      padding: var(--spacing-lg);
    }
    .main {
      margin-left: 240px;
      min-width: calc(100% - 240px);
      padding: var(--spacing-lg);
    }
    .sidebar-header .label {
      font-size: 1rem;
    }
    .stats {
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: var(--spacing-lg);
    }
    .card {
      min-height: 160px;
    }
    .dashboard-content {
      padding: var(--spacing-xl);
    }
  }
  /* Enhanced Mobile-First Design */
  @media (max-width: 768px) {
    /* Collapsible Sidebar for Mobile */
    .sidebar {
      width: 70px;
      padding: var(--spacing-sm);
      position: fixed;
      z-index: 1000;
    }
    /* Compact sidebar header */
    .sidebar-header {
      margin-bottom: var(--spacing-lg);
      flex-direction: column;
      align-items: center;
      gap: 8px;
    }
    .sidebar-header .logo {
      width: 32px;
      height: 32px;
    }
    .sidebar-header .label {
      display: block !important;
      font-size: 0.75rem;
      font-weight: 700;
      color: var(--primary) !important;
      text-align: center;
      line-height: 1.2;
      opacity: 1 !important;
      visibility: visible !important;
    }
    /* Icon-only navigation for mobile */
    .sidebar nav a {
      padding: 12px;
      justify-content: center;
      margin-bottom: var(--spacing-xs);
    }
    .sidebar nav a .label {
      display: none !important;
    }
    .sidebar nav a .icon {
      font-size: 20px;
      width: 24px;
    }
    /* Full-width main content */
    .main {
      margin-left: 70px;
      width: calc(100% - 70px);
      padding: var(--spacing);
      height: 100vh;
      overflow: hidden;
      min-height: 100vh;
    }
    /* Mobile-friendly dashboard title */
    .dashboard-title {
      font-size: 1.5rem;
      text-align: center;
      margin-bottom: var(--spacing-lg);
      padding: 0 var(--spacing-sm);
    }
    /* Enhanced card layout for mobile */
    .card {
      min-height: 140px;
      padding: var(--spacing-lg);
      margin-bottom: var(--spacing-lg);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .card-header {
      margin-bottom: var(--spacing);
    }
    .card-header h3 {
      font-size: 0.9rem;
      margin-bottom: var(--spacing-sm);
      text-align: center;
      line-height: 1.3;
    }
    .card .count {
      font-size: 2.2rem;
      text-align: center;
      margin: var(--spacing) 0;
      font-weight: 900;
    }
    /* Touch-friendly buttons */
    .card-actions-bottom {
      justify-content: space-between;
      margin-top: auto;
      padding-top: var(--spacing-lg);
      gap: var(--spacing);
      width: 100%;
    }
    .card-actions-bottom .btn {
      flex: 1;
      min-width: 48px; /* Minimum touch target */
      min-height: 48px;
      padding: var(--spacing-sm) var(--spacing-xs);
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
    }
    .card-actions-bottom .btn i {
      font-size: 18px;
    }
    .card-actions-bottom .btn:first-child {
      margin-right: var(--spacing-xs);
    }
    /* Single column layouts */
    .stats {
      grid-template-columns: 1fr;
      gap: var(--spacing-lg);
      margin-bottom: var(--spacing-xl);
      width: 100%;
    }
    /* Optimized dashboard content scrolling */
    .dashboard-content {
      height: calc(100vh - var(--spacing) - 100px);
      max-height: calc(100vh - var(--spacing) - 100px);
      padding: var(--spacing);
      margin: var(--spacing-sm) 0;
      display: flex;
      flex-direction: column;
    }
    /* Thinner scrollbar for mobile */
    .dashboard-content::-webkit-scrollbar {
      width: 4px;
    }
    /* Mobile chatbot */
    #chatbot-window {
      width: calc(100vw - 32px);
      left: 16px;
      right: 16px;
      bottom: 90px;
      max-height: 60vh;
      border-radius: var(--radius-md);
    }
    #chatbot-button {
      bottom: 16px;
      right: 16px;
      width: 56px;
      height: 56px;
      z-index: 1500;
    }
    /* Single column charts */
    .chart-grid {
      grid-template-columns: 1fr;
      gap: var(--spacing);
    }
    /* Mobile-optimized modals */
    .modal-content {
      max-width: 95vw;
      max-height: 90vh;
      margin: 5vh auto;
      padding: var(--spacing-lg);
    }
    .modal-header {
      padding: var(--spacing-lg) var(--spacing-lg) var(--spacing);
      margin: -var(--spacing-lg) -var(--spacing-lg) var(--spacing-lg);
    }
    /* Single column forms */
    .form-grid {
      grid-template-columns: 1fr;
      gap: var(--spacing);
    }
    /* Mobile-friendly tables */
    .data-table {
      font-size: 0.85rem;
    }
    .data-table th,
    .data-table td {
      padding: var(--spacing-sm) 6px;
    }
    /* Mobile toast positioning */
    #toast-stack {
      left: var(--spacing);
      right: var(--spacing);
      max-width: none;
      bottom: var(--spacing);
      top: auto;
    }
    /* Mobile filter controls */
    .card-actions {
      flex-direction: column;
      gap: var(--spacing-sm);
      align-items: stretch;
    }
    .card-actions select {
      width: 100%;
      margin-bottom: 0;
    }
    /* Better touch targets for mobile */
    .btn, button {
      min-height: 44px;
      min-width: 44px;
      padding: 10px 16px;
    }
    /* Improved form elements for mobile */
    .form-control {
      padding: 14px 16px;
      font-size: 16px; /* Prevents zoom on iOS */
      border-radius: var(--radius);
    }
    select.form-control {
      padding: 12px 14px;
      font-size: 16px;
    }
    /* Better spacing for mobile */
    .card {
      margin-bottom: var(--spacing-lg);
    }
    /* Mobile-optimized headings */
    h3, .card-header h3 {
      font-size: 0.9rem;
      line-height: 1.3;
    }
    /* Landscape orientation improvements */
    @media (max-width: 768px) and (orientation: landscape) {
      .main {
        padding: 8px;
      }
      .dashboard-content {
        height: calc(100vh - 8px - 50px - 1rem);
        padding: 8px;
      }
      .card {
        min-height: 100px;
        padding: 12px;
      }
      .sidebar {
        width: 60px;
      }
      .main {
        margin-left: 60px;
        width: calc(100% - 60px);
      }
    }
  }
  /* Extra Small Mobile Devices */
  @media (max-width: 480px) {
    /* Further reduced sidebar */
    .sidebar {
      width: 60px;
      padding: 6px;
    }
    .main {
      margin-left: 60px;
      width: calc(100% - 60px);
      padding: var(--spacing-sm);
      height: 100vh;
      overflow: hidden;
    }
    /* Smaller dashboard content */
    .dashboard-content {
      height: calc(100vh - var(--spacing-sm) - 80px);
      max-height: calc(100vh - var(--spacing-sm) - 80px);
      padding: var(--spacing-sm);
      margin: 8px 0;
    }
    /* Compact dashboard title */
    .dashboard-title {
      font-size: 1.25rem;
      margin-bottom: var(--spacing);
    }
    /* Smaller cards for very small screens */
    .card {
      min-height: 130px;
      padding: var(--spacing);
      margin-bottom: var(--spacing);
    }
    .card .count {
      font-size: 1.9rem;
      margin: var(--spacing-sm) 0;
    }
    .card-actions-bottom .btn {
      min-width: 44px;
      min-height: 44px;
      padding: 8px 10px;
      font-size: 0.85rem;
    }
    /* Compact stats layout */
    .stats {
      gap: 12px;
      margin-bottom: var(--spacing);
    }
    /* Smaller text in tables */
    .data-table {
      font-size: 0.8rem;
    }
    .data-table th,
    .data-table td {
      padding: 8px 4px;
    }
    /* Compact modal for very small screens */
    .modal-content {
      max-width: 98vw;
      padding: var(--spacing);
    }
    /* Smaller chatbot on very small screens */
    #chatbot-window {
      max-height: 50vh;
    }
    #chatbot-button {
      width: 50px;
      height: 50px;
    }
    /* Hide non-essential elements on very small screens */
    .sidebar-header .label {
      display: none !important;
    }
    /* Compact navigation for very small screens */
    .sidebar nav a {
      padding: 10px;
    }
  }
  /* Prevent horizontal scroll on all devices */
  * {
    max-width: 100%;
  }
  html {
    scroll-behavior: smooth;
  }
  /* Ensure proper viewport handling */
  @media (max-width: 768px) {
    .main, .dashboard-content {
      width: 100%;
      box-sizing: border-box;
    }
    /* Better button spacing on mobile */
    .card-actions-bottom {
      gap: var(--spacing-sm);
      margin-top: var(--spacing);
    }
    .card-actions-bottom .btn {
      font-size: 0.9rem;
      padding: var(--spacing-sm) var(--spacing);
    }
    /* Ensure proper card content spacing */
    .card-header {
      margin-bottom: var(--spacing-sm);
    }
    .card .count {
      margin: var(--spacing-sm) 0 var(--spacing) 0;
    }
  }
  /* Additional mobile layout fixes */
  @media (max-width: 768px) {
    /* Ensure no horizontal overflow */
    * {
      box-sizing: border-box;
    }
    /* Better main content layout */
    .main {
      position: relative;
      z-index: 1;
    }
    /* Proper dashboard content structure */
    .dashboard-content > * {
      margin-bottom: var(--spacing-lg);
    }
    .dashboard-content > *:last-child {
      margin-bottom: 0;
    }
    /* Mobile-friendly borrower table */
    .books-tooltip {
      position: fixed;
      left: 10px;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      max-width: none;
      z-index: 9999;
    }
    /* Mobile action buttons */
    .btn-return-multiple {
      font-size: 0.7rem;
      padding: 4px 8px;
    }
    /* Compact book display on mobile */
    .books-cell {
      max-width: 120px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
    /* Mobile bulk return section */
    #bulkReturnSection {
      margin: 0.5rem;
      padding: 0.75rem;
    }
    #bulkReturnSection .btn {
      font-size: 0.7rem;
      padding: 6px 10px;
    }
  }
  /* Enhanced table row hover effects for grouped data */
  .data-table tr {
    transition: all 0.3s ease;
  }
  .data-table tr:hover .books-tooltip {
    display: block !important;
  }
  /* Loading state improvements */
  .loading-shimmer {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
  }
  @keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
  }
  /* Button states for return operations */
  .btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
  }
  .btn-return-multiple:disabled {
    background: var(--warning) !important;
    color: white !important;
  }
  /* Enhanced tooltip positioning */
  .books-tooltip {
    position: absolute;
    background: var(--surface-elevated);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 8px;
    max-width: 300px;
    z-index: 1000;
    box-shadow: var(--shadow-lg);
    font-size: 0.8rem;
    line-height: 1.4;
    word-wrap: break-word;
  }
  body.dark-mode .books-tooltip {
    background: rgba(30, 30, 30, 0.95);
    border-color: rgba(255, 255, 255, 0.1);
  }
  /* Mobile tooltip improvements */
  @media (max-width: 768px) {
    .books-tooltip {
      position: fixed;
      left: 10px;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      max-width: none;
      z-index: 9999;
      max-height: 70vh;
      overflow-y: auto;
    }
  }
  /* Select all checkbox styling */
  #selectAllBooks {
    cursor: pointer;
    accent-color: var(--primary);
    transform: scale(1.2);
  }
</style>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="/images/logo.png" alt="Library Logo" class="logo">
            <span class="label">Julita Public Library</span>
        </div>
        <nav>
            <a href="{{ route('dashboard') }}" class="active" data-label="Dashboard">
                <span class="icon"><i class="fas fa-home"></i></span>
                <span class="label">Dashboard</span>
            </a>
            <a href="{{ route('books.index') }}" data-label="Books">
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
        <!-- Christmas Effects Toggle -->
        <div class="christmas-toggle" id="christmasToggle" title="Toggle Christmas Effects">
            <span class="icon">🎄</span>
            <span id="christmasToggleText">Enable Christmas</span>
        </div>
        <script>
            // Initialize Christmas effects toggle with persistent state
            document.addEventListener('DOMContentLoaded', function() {
                const christmasToggle = document.getElementById('christmasToggle');
                const christmasToggleText = document.getElementById('christmasToggleText');

                if (christmasToggle && christmasToggleText) {
                    // Check localStorage for saved preference
                    const savedPreference = localStorage.getItem('christmasEffects');
                    const shouldBeActive = savedPreference === 'true';

                    // Apply saved state on page load
                    if (shouldBeActive) {
                        document.body.classList.add('christmas-theme');
                        christmasToggle.classList.add('active');
                        christmasToggleText.textContent = 'Disable Christmas';
                    } else {
                        document.body.classList.remove('christmas-theme');
                        christmasToggle.classList.remove('active');
                        christmasToggleText.textContent = 'Enable Christmas';
                    }

                    // Add click handler
                    christmasToggle.addEventListener('click', function() {
                        const isCurrentlyActive = document.body.classList.contains('christmas-theme');

                        if (isCurrentlyActive) {
                            // Disable Christmas effects
                            document.body.classList.remove('christmas-theme');
                            christmasToggle.classList.remove('active');
                            christmasToggleText.textContent = 'Enable Christmas';
                            localStorage.setItem('christmasEffects', 'false');
                        } else {
                            // Enable Christmas effects
                            document.body.classList.add('christmas-theme');
                            christmasToggle.classList.add('active');
                            christmasToggleText.textContent = 'Disable Christmas';
                            localStorage.setItem('christmasEffects', 'true');
                        }
                    });
                }
            });
        </script>
    </div>
    <!-- Main Content -->
    <div class="main" id="mainContent">
        <div class="dashboard-title">DASHBOARD</div>
        <div class="dashboard-content">
        <!-- Stats Cards -->
        <div class="stats">
            <div class="card" id="booksCard">
                <div class="card-header">
                    <h3 style="font-size: 0.9rem; color: var(--text-muted); margin: 0; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; opacity: 1;">Books</h3>
                </div>
                <div class="count">{{ $booksCount }}</div>
                <div class="card-actions-bottom">
                    <button class="btn btn-sm btn-primary" onclick="openAddBookModal()">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button class="btn btn-sm btn-outline" onclick="openBooksTable()">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            <div class="card" id="membersCard">
                <div class="card-header">
                    <h3 style="font-size: 0.9rem; color: var(--text-muted); margin: 0; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; opacity: 1;">Members</h3>
                </div>
                <div class="count">{{ $membersCount }}</div>
                <div class="card-actions-bottom">
                    <button class="btn btn-sm btn-primary" onclick="openJulitaRegisterModal()">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button class="btn btn-sm btn-outline" onclick="openMembersTable()">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Combined Borrowers Table and Weekly Chart -->
        <div class="card" style="margin-top: 2rem; display: flex; flex-direction: column;">
            <div class="card-header">
                <h3 style="opacity: 1; color: var(--text-muted);">📚 Borrower List</h3>
                <div class="card-actions" style="display: flex; gap: 8px; align-items: center;">
                    <select id="borrowersFilter" class="form-control" style="width: auto; padding: 6px 12px; font-size: 0.85rem;" onchange="filterBorrowers(this.value)">
                        <option value="all">All Borrowers</option>
                        <option value="today">Today</option>
                        <option value="weekly">This Week</option>
                    </select>
                    <select id="returnStatusFilter" class="form-control" style="width: auto; padding: 6px 12px; font-size: 0.85rem;" onchange="filterByReturnStatus(this.value)">
                        <option value="all">All Books</option>
                        <option value="returned">Returned Only</option>
                        <option value="pending">Pending Return</option>
                        <option value="overdue">Overdue Only</option>
                    </select>
                </div>
            </div>
            <!-- Borrowers Table -->
            <div style="flex: 1; display: flex; flex-direction: column;">
                <!-- Search Bar -->
                <div style="padding: 0.75rem; background: var(--glass-bg); border-radius: var(--radius) var(--radius) 0 0; border: 1px solid var(--border); border-bottom: none;">
                    <div style="position: relative;">
                        <input type="text" id="borrowerSearch" placeholder="Search borrowers..." style="width: 100%; padding: 0.5rem 0.75rem 0.5rem 2rem; border: 1px solid var(--border); border-radius: var(--radius); background: var(--surface-elevated); color: var(--text-primary); font-size: 0.85rem; transition: var(--transition);" onkeyup="searchBorrowers(this.value)" onkeydown="if(event.keyCode===13) searchBorrowers(this.value)">
                        <i class="fas fa-search" style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.8rem;"></i>
            </div>
        </div>
                <!-- Table Container -->
                <div style="overflow-y: auto; max-height: 250px; border: 1px solid var(--border); border-top: none; border-radius: 0 0 var(--radius) var(--radius);">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary); text-align: center; width: 50px;">
                                    <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll()" style="transform: scale(1.2); cursor: pointer;" title="Select All">
                                </th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary); cursor: pointer;" onclick="sortTable(0)" data-sort="number" class="sortable-header">
                                    <div style="display: flex; align-items: center; gap: 4px;">
                                        #
                                        <span class="sort-indicator" style="opacity: 0.3; font-size: 0.8rem;">↕</span>
                                    </div>
                                </th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary); cursor: pointer;" onclick="sortTable(1)" data-sort="text" class="sortable-header">
                                    <div style="display: flex; align-items: center; gap: 4px;">
                                        Name
                                        <span class="sort-indicator" style="opacity: 0.3; font-size: 0.8rem;">↕</span>
                                    </div>
                                </th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary); cursor: pointer;" onclick="sortTable(2)" data-sort="text" class="sortable-header">
                                    <div style="display: flex; align-items: center; gap: 4px;">
                                        Title
                                        <span class="sort-indicator" style="opacity: 0.3; font-size: 0.8rem;">↕</span>
                                    </div>
                                </th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary); cursor: pointer;" onclick="sortTable(3)" data-sort="date" class="sortable-header">
                                    <div style="display: flex; align-items: center; gap: 4px;">
                                        Borrowed Date
                                        <span class="sort-indicator" style="opacity: 0.3; font-size: 0.8rem;">↕</span>
                                    </div>
                                </th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary); cursor: pointer;" onclick="sortTable(4)" data-sort="date" class="sortable-header">
                                    <div style="display: flex; align-items: center; gap: 4px;">
                                        Due Date
                                        <span class="sort-indicator" style="opacity: 0.3; font-size: 0.8rem;">↕</span>
                                    </div>
                                </th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary); cursor: pointer;" onclick="sortTable(5)" data-sort="date" class="sortable-header">
                                    <div style="display: flex; align-items: center; gap: 4px;">
                                        Returned At
                                        <span class="sort-indicator" style="opacity: 0.3; font-size: 0.8rem;">↕</span>
                                    </div>
                                </th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary); cursor: pointer;" onclick="sortTable(6)" data-sort="status" class="sortable-header">
                                    <div style="display: flex; align-items: center; gap: 4px;">
                                        Return Status
                                        <span class="sort-indicator" style="opacity: 0.3; font-size: 0.8rem;">↕</span>
                                    </div>
                                </th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary);">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="borrowersTableBody">
                            <tr>
                                <td colspan="9" class="loading">Loading borrowers...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Weekly Chart -->
            <div style="margin-top: 0.75rem; padding: 0.75rem; background: var(--glass-bg); border-radius: var(--radius); border: 1px solid var(--border);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                    <h4 style="margin: 0; color: var(--text-primary); font-size: 0.9rem; font-weight: 600;">📈 Borrower Statistics</h4>
                    <div style="display: flex; gap: 6px;">
                        <select id="monthFilter" class="form-control" style="width: auto; padding: 3px 6px; font-size: 0.75rem;" onchange="updateWeeklyChart()">
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        <select id="yearFilter" class="form-control" style="width: auto; padding: 3px 6px; font-size: 0.75rem;" onchange="updateWeeklyChart()">
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                        </select>
                    </div>
                </div>
                <div style="position: relative; height: 150px;">
                    <canvas id="weeklyChart"></canvas>
                </div>
            </div>
            </div>
        <!-- Analytics Section -->
        <div class="analytics-section" style="margin-top: 2rem; display: grid; grid-template-columns: 1fr; gap: 2rem;">
            <!-- Book Popularity Analytics (Full Width) -->
            <div class="card">
                <div class="card-header">
                    <h3 style="opacity: 1; color: var(--text-muted);">📚 Book Popularity by Genre</h3>
                </div>
                <div style="padding: 1rem; height: 400px; position: relative;">
                    <div style="display: flex; height: 360px; gap: 2rem;">
                        <div style="flex: 1; display: flex; flex-direction: column; align-items: center;">
                            <canvas id="bookPopularityChart" style="height: 300px; width: 300px; margin-bottom: 10px;"></canvas>
                            <div style="text-align: center; color: var(--text-muted); font-size: 0.9rem; font-weight: 500;">
                                Genre Distribution
                            </div>
                        </div>
                        <div id="bookLegend" style="width: 280px; height: 360px; overflow-y: auto; padding: 15px; background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border);">
                            <h4 style="margin: 0 0 15px 0; color: var(--text-primary); font-size: 1rem; font-weight: 600; text-align: center;">📊 Genre Breakdown</h4>
                            <div id="legendItems" style="display: flex; flex-direction: column; gap: 8px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Age Distribution -->
            <div class="card">
                <div class="card-header">
                    <h3 style="opacity: 1; color: var(--text-muted);">🎂 Age Distribution</h3>
                </div>
                <div style="padding: 1rem; height: 300px;">
                    <canvas id="ageDistributionChart"></canvas>
                </div>
            </div>

            <!-- Top Books and Active Members -->
            <div class="card">
                <div class="card-header">
                    <h3 style="opacity: 1; color: var(--text-muted);">🏆 Top Books & Active Members</h3>
                    <div class="card-actions">
                        <select id="activityFilter" class="form-control" style="width: auto; padding: 4px 8px; font-size: 0.8rem;" onchange="switchActivityView(this.value)">
                            <option value="borrowing">By Borrowing Frequency</option>
                            <option value="timelog">By Time-in/out Frequency</option>
                        </select>
                    </div>
                </div>
                <div style="padding: 1rem;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                        <!-- Top 10 Most Borrowed Books -->
                        <div>
                            <h4 style="margin: 0 0 1rem 0; color: var(--text-primary); font-size: 1rem; font-weight: 600;">📖 Top 10 Most Borrowed Books</h4>
                            <div style="max-height: 300px; overflow-y: auto; padding: 0.5rem; background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border);">
                                <div id="topBooksList" style="display: flex; flex-direction: column; gap: 8px;">
                                    <!-- Books will be loaded here -->
                                </div>
                            </div>
                        </div>

                        <!-- Most Active Members -->
                        <div>
                            <h4 style="margin: 0 0 1rem 0; color: var(--text-primary); font-size: 1rem; font-weight: 600;">👤 Most Active Members</h4>
                            <div style="max-height: 300px; overflow-y: auto; padding: 0.5rem; background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border);">
                                <div id="activeMembersList" style="display: flex; flex-direction: column; gap: 8px;">
                                    <!-- Members will be loaded here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Member Demographics (Full Width) -->
        <div class="card" style="margin-top: 2rem;">
            <div class="card-header">
                <h3 style="opacity: 1; color: var(--text-muted);">👥 Member Demographics</h3>
                <div class="card-actions">
                    <select id="demographicsFilter" class="form-control" style="width: auto; padding: 4px 8px; font-size: 0.8rem;" onchange="switchDemographicsView(this.value)">
                        <option value="julita">Julita Residents</option>
                        <option value="non-julita">Other Municipalities</option>
                    </select>
                </div>
            </div>
            <div style="padding: 1rem;">
                <div id="julitaDemographics" style="height: 450px;">
                    <h4 style="text-align: center; margin-bottom: 1rem; color: var(--text-primary);">Julita Barangay Distribution</h4>
                    <div id="barangayMap" style="height: 400px; width: 100%; border-radius: var(--radius); border: 1px solid var(--border);"></div>
                </div>
                <div id="nonJulitaDemographics" style="height: 450px; display: none;">
                    <h4 style="text-align: center; margin-bottom: 1rem; color: var(--text-primary);">Other Municipalities</h4>
                    <canvas id="municipalityChart" style="max-height: 400px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Consolidated Statistics with Line Graph -->
        <div class="card stats-overview-card" style="margin-top: 2rem; display: flex; flex-direction: column;">
            <div class="card-header">
                <h3 style="opacity: 1; color: var(--text-muted);">📊 Statistics Overview</h3>
                <div class="card-actions">
                    <select id="statsFilter" class="form-control" style="width: auto; padding: 6px 12px; font-size: 0.85rem;" onchange="filterStats(this.value)">
                        <option value="lifetime">Lifetime</option>
                        <option value="today">Today</option>
                        <option value="weekly">This Week</option>
                    </select>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; padding: 0.5rem;">
                <!-- Stats Numbers -->
                <div id="statsDisplay" style="text-align: center; display: flex; flex-direction: column; justify-content: center;">
                    <div class="count" id="mainCount" style="font-size: 2.5rem; margin-bottom: 0.25rem; opacity: 1; color: var(--primary);">{{ $lifetimeCount }}</div>
                    <p id="mainLabel" style="font-size: 1rem; margin-bottom: 1rem; color: var(--text-secondary); opacity: 1;">Total Transactions</p>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="stats-subcard" style="text-align: center; padding: 0.75rem; background: var(--glass-bg); border-radius: var(--radius); border: 1px solid var(--border);">
                            <div class="count" style="font-size: 1.5rem; margin-bottom: 0.25rem;" id="booksCount">{{ $booksCount }}</div>
                            <p style="margin: 0; color: var(--text-muted); font-weight: 600; font-size: 0.9rem; opacity: 1;">Books</p>
                        </div>
                        <div class="stats-subcard" style="text-align: center; padding: 0.75rem; background: var(--glass-bg); border-radius: var(--radius); border: 1px solid var(--border);">
                            <div class="count" style="font-size: 1.5rem; margin-bottom: 0.25rem;" id="membersCount">{{ $membersCount }}</div>
                            <p style="margin: 0; color: var(--text-muted); font-weight: 600; font-size: 0.9rem; opacity: 1;">Members</p>
                        </div>
                    </div>
                </div>
                <!-- Line Graph -->
                <div style="position: relative; height: 250px;">
                    <canvas id="statsChart"></canvas>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer style="margin-top: auto; padding: var(--spacing-lg); text-align: center; color: var(--text-muted); font-size: 0.9rem; background: rgba(0, 0, 0, 0.1); border-top: 1px solid rgba(255, 255, 255, 0.1); width: 100%; min-height: 60px; display: flex; align-items: center; justify-content: center;">
            &copy; {{ date('Y') }} Julita Public Library. All rights reserved.
        </footer>
        </div>
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
            <div style="position: relative; display: flex; align-items: center; gap: 8px;">
                <input type="text" id="chatbot-user-input" placeholder="Ask me anything..." data-original-placeholder="Ask me anything..." data-hover-placeholder="Powered by Gemini 2.0" style="width: 230px;" />
                <div id="gemini-branding" class="gemini-branding" style="display: none; position: absolute; left: 10px; top: 50%; transform: translateY(-50%); font-size: 0.85rem; font-weight: 600; pointer-events: none;">
                    <span style="color: var(--text-muted);">Powered by </span>
                    <span style="background: linear-gradient(90deg, #4285f4 0%, #34a853 25%, #fbbc04 50%, #ea4335 75%, #4285f4 100%); background-size: 200% 200%; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; animation: geminiGradient 3s ease-in-out infinite;">Gemini 2.0</span>
                </div>
                <button id="chatbot-send">Send</button>
            </div>
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
    <!-- ADD BOOK MODAL -->
    <div class="modal-overlay" id="addBookModal">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-header-content">
                    <div class="modal-icon-wrapper">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="modal-title-section">
                        <h2 class="modal-title">Add New Book</h2>
                        <p class="modal-subtitle">Add a new book to the library collection</p>
                    </div>
                </div>
                <button class="modal-close" onclick="closeAddBookModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="addBookForm" enctype="multipart/form-data">
                    <!-- Cover Image Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-image"></i>
                            </div>
                            <span>Book Cover</span>
                        </h3>
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-camera"></i>
                                Cover Image
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
                                    <input type="file" id="cover-input" name="cover" accept="image/*" class="form-input">
                                </div>
                                <img id="cover-preview" class="photo-preview" src="#" alt="Cover Preview" style="display: none;">
                            </div>
                        </div>
                    </div>
                    <!-- Book Information Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <span>Book Information</span>
                        </h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="bookTitle" class="form-label">
                                    <i class="fas fa-heading"></i>
                                    Title *
                                </label>
                                <input type="text" id="bookTitle" name="title" class="form-input" required placeholder="Enter book title">
                            </div>
                            <div class="form-group">
                                <label for="bookAuthor" class="form-label">
                                    <i class="fas fa-user-edit"></i>
                                    Author *
                                </label>
                                <input type="text" id="bookAuthor" name="author" class="form-input" required placeholder="Enter author name">
                            </div>
                            <div class="form-group">
                                <label for="bookGenre" class="form-label">
                                    <i class="fas fa-tags"></i>
                                    Genre
                                </label>
                                <input type="text" id="bookGenre" name="genre" class="form-input" placeholder="Enter book genre">
                            </div>
                            <div class="form-group">
                                <label for="bookYear" class="form-label">
                                    <i class="fas fa-calendar-alt"></i>
                                    Published Year *
                                </label>
                                <input type="number" id="bookYear" name="published_year" class="form-input" required min="1000" max="2099" placeholder="Enter publication year">
                            </div>
                            <div class="form-group">
                                <label for="bookAvailability" class="form-label">
                                    <i class="fas fa-hashtag"></i>
                                    Availability *
                                </label>
                                <input type="number" id="bookAvailability" name="availability" class="form-input" required min="0" placeholder="Enter number of copies">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeAddBookModal()">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <button type="button" class="btn btn-primary" onclick="submitAddBook()">
                    <i class="fas fa-save"></i>
                    Add Book
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
                            <div class="section-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <span>Personal Information</span>
                        </h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="julitaFirstName" class="form-label">
                                    <i class="fas fa-signature"></i>
                                    First Name *
                                </label>
                                <input type="text" id="julitaFirstName" name="firstName" class="form-input" required placeholder="Enter first name">
                            </div>
                            <div class="form-group">
                                <label for="julitaMiddleName" class="form-label">
                                    <i class="fas fa-signature"></i>
                                    Middle Name
                                </label>
                                <input type="text" id="julitaMiddleName" name="middleName" class="form-input" placeholder="Enter middle name (optional)">
                            </div>
                            <div class="form-group">
                                <label for="julitaLastName" class="form-label">
                                    <i class="fas fa-signature"></i>
                                    Last Name *
                                </label>
                                <input type="text" id="julitaLastName" name="lastName" class="form-input" required placeholder="Enter last name">
                            </div>
                            <div class="form-group">
                                <label for="julitaAge" class="form-label">
                                    <i class="fas fa-birthday-cake"></i>
                                    Age *
                                </label>
                                <input type="number" id="julitaAge" name="age" class="form-input" min="1" max="150" required placeholder="Enter age">
                            </div>
                        </div>
                    </div>
                    <!-- Address Information Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <span>Address Information</span>
                        </h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="julitaHouseNumber" class="form-label">
                                    <i class="fas fa-home"></i>
                                    House Number
                                </label>
                                <input type="text" id="julitaHouseNumber" name="houseNumber" class="form-input" placeholder="Enter house number">
                            </div>
                            <div class="form-group">
                                <label for="julitaStreet" class="form-label">
                                    <i class="fas fa-road"></i>
                                    Street
                                </label>
                                <input type="text" id="julitaStreet" name="street" class="form-input" placeholder="Enter street name">
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
                            <div class="section-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <span>Contact Information</span>
                        </h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="julitaContactNumber" class="form-label">
                                    <i class="fas fa-mobile-alt"></i>
                                    Contact Number *
                                </label>
                                <input type="tel" id="julitaContactNumber" name="contactNumber" class="form-input" pattern="[0-9]{11}" maxlength="11" required placeholder="09XXXXXXXXX">
                            </div>
                            <div class="form-group">
                                <label for="julitaSchool" class="form-label">
                                    <i class="fas fa-school"></i>
                                    School/Institution
                                </label>
                                <input type="text" id="julitaSchool" name="school" class="form-input" placeholder="Enter school or institution name">
                            </div>
                        </div>
                    </div>
                    <!-- Photo Upload Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-camera"></i>
                            </div>
                            <span>Upload Photo</span>
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
    <!-- REGISTER MODAL (Non-Julita Residents) -->
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
    <!-- BOOKS TABLE MODAL -->
    <div class="modal" id="booksTableModal">
        <div class="modal-content" style="max-width: 900px;">
            <div class="modal-header">
                <h2 class="modal-title">
                    <i class="fas fa-book"></i>
                    Book List
                </h2>
                <button class="close-modal" onclick="closeBooksTable()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-container" style="max-height: 60vh; overflow-y: auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary);">#</th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary);">Title</th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary);">Author</th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary);">Genre</th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary);">Year</th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary);">Available</th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary);">Added</th>
                            </tr>
                        </thead>
                        <tbody id="booksTableBody">
                            <tr>
                                <td colspan="7" class="loading">Loading books...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
    <!-- BORROW MODAL -->
    <div class="modal" id="borrowModal">
        <div class="modal-content" style="max-width: 900px;">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-book-reader"></i>
                    Borrow Books
                </h3>
                <button class="close-modal" onclick="closeBorrowModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="memberName">Member Name</label>
                    <input type="text" id="memberName" class="form-control" placeholder="Scan QR code to fill" readonly>
                    <input type="hidden" id="memberId">
                </div>
                <div class="form-group">
                    <label for="dueDate">Due Date</label>
                    <input type="date" id="dueDate" class="form-control">
                </div>
                <div class="form-group">
                    <label for="dueTime">Due Time</label>
                    <input type="time" id="dueTime" class="form-control">
                    <small style="display:block; margin-top:5px; color:var(--text-secondary); font-size:0.85rem;">
                        Default time set to end of day (11:59 PM)
                    </small>
                </div>
                <div class="form-group">
                    <label for="selectedBooksList">Selected Books</label>
                    <ul id="selectedBooksList" style="list-style: none; padding: 0; max-height: 150px; overflow-y: auto; border: 1px solid var(--border); border-radius: var(--radius); padding: 10px; background: var(--surface);"></ul>
                </div>
                <div style="display: flex; gap: 10px; margin-top: 1rem;">
                    <button type="button" class="btn btn-outline" onclick="startQRScan('member')">
                        <i class="fas fa-user"></i> Scan Member
                    </button>
                    <button type="button" class="btn btn-outline" onclick="startQRScan('book')">
                        <i class="fas fa-book"></i> Scan Books
                    </button>
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn btn-cancel" onclick="closeBorrowModal()">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <button class="btn btn-confirm" onclick="confirmBorrow()">
                    <i class="fas fa-check"></i>
                    Confirm
                </button>
            </div>
        </div>
    </div>
    <!-- MEMBERS TABLE MODAL -->
    <div class="modal" id="membersTableModal">
        <div class="modal-content" style="max-width: 900px;">
            <div class="modal-header">
                <h2 class="modal-title">
                    <i class="fas fa-users"></i>
                    Member List
                </h2>
                <button class="close-modal" onclick="closeMembersTable()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-container" style="max-height: 60vh; overflow-y: auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary);">#</th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary);">Name</th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary);">Age</th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary);">Barangay</th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary);">Contact</th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary);">Registered</th>
                            </tr>
                        </thead>
                        <tbody id="membersTableBody">
                            <tr>
                                <td colspan="6" class="loading">Loading members...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script>
        function closeRegisterModal() {
            const registerModal = document.getElementById("registerModal");
            const julitaModal = document.getElementById("julitaRegisterModal");
            if (registerModal) {
                registerModal.classList.remove("active");
            }
            if (julitaModal) {
                julitaModal.classList.remove("active");
            }
            document.body.classList.remove("modal-open");
        }
        function closeJulitaRegisterModal() {
            closeRegisterModal();
        }
        function openRegisterModal() {
            const modal = document.getElementById("registerModal");
            if (modal) {
                modal.classList.add("active");
                document.body.classList.add("modal-open");
            }
        }
        function openJulitaRegisterModal() {
            const modal = document.getElementById("julitaRegisterModal");
            if (modal) {
                modal.classList.add("active");
                document.body.classList.add("modal-open");
            }
        }
        // Close modal when clicking on overlay
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal-overlay')) {
                event.target.classList.remove('active');
                document.body.classList.remove('modal-open');
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
            // Find the active modal
            const activeModal = document.querySelector('.modal.show');
            if (!activeModal) return;
            // Update the cover preview area with selected image
            const coverPreviewContent = activeModal.querySelector('#cover-preview-content');
            if (coverPreviewContent) {
                coverPreviewContent.innerHTML = `
                    <img src="${imageUrl}" alt="Book Cover" style="max-width: 150px; max-height: 200px; object-fit: cover; border-radius: var(--radius); margin-bottom: 10px;">
                    <p style="color: var(--text-primary); font-weight: 600;">${imageName}</p>
                    <small style="color: var(--text-muted);">Click to change</small>
                `;
                // Store the selected image URL for form submission
                window.selectedCoverImage = imageUrl;
                // Also update the file input to ensure form submission works
                updateFormWithSelectedImage(imageUrl, imageName, activeModal);
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
            // Override the existing click handler to directly open file picker for all cover preview contents
            const coverPreviewContents = document.querySelectorAll('#cover-preview-content');
            coverPreviewContents.forEach(content => {
                // Remove old handler if it exists (safe check)
                if (typeof initializeCoverUpload === 'function') {
                    content.removeEventListener('click', initializeCoverUpload);
                }
                // Directly trigger file input click instead of opening media picker modal
                content.addEventListener('click', function() {
                    const fileInput = document.getElementById('cover-input');
                    if (fileInput) {
                        fileInput.click();
                    }
                });
            });
        });
        // Cover preview area now opens media picker on click
    </script>
    <script>
        const weeklyData = @json($weeklyData);
        const visitsData = @json($visitsData);
        const borrowersData = @json($borrowers);
        const analyticsData = @json($analytics);
        window.dashboardStats = {
            lifetimeCount: {{ $lifetimeCount }},
            booksCount: {{ $booksCount }},
            membersCount: {{ $membersCount }},
            dailyCount: {{ $dailyCount }},
            booksToday: {{ $booksToday }},
            membersToday: {{ $membersToday }},
            weeklyCount: {{ $weeklyCount }},
            booksThisWeek: {{ $booksThisWeek }},
            membersThisWeek: {{ $membersThisWeek }}
        };
    </script>
    <script src="{{ asset('js/dashb.js') }}"></script>
    <script src="{{ asset('js/dashb_iScripts.js') }}"></script>
    <script src="{{ asset('js/analytics.js') }}"></script>
    <script src="{{ asset('js/chatbot.js') }}"></script>
    <script>
        // Function to switch between demographics views
        function switchDemographicsView(viewType) {
            const julitaView = document.getElementById('julitaDemographics');
            const nonJulitaView = document.getElementById('nonJulitaDemographics');

            if (viewType === 'julita') {
                julitaView.style.display = 'block';
                nonJulitaView.style.display = 'none';
            } else {
                julitaView.style.display = 'none';
                nonJulitaView.style.display = 'block';
            }
        }

        // Function to switch between activity views
        function switchActivityView(viewType) {
            loadTopBooks();
            loadActiveMembers(viewType);
        }

        // Load top 10 most borrowed books
        function loadTopBooks() {
            const topBooks = @json($analytics['topBooks']);
            const container = document.getElementById('topBooksList');

            if (topBooks.length === 0) {
                container.innerHTML = '<p style="color: var(--text-muted); text-align: center; margin: 2rem 0;">No borrowing data available</p>';
                return;
            }

            container.innerHTML = topBooks.map((book, index) => `
                <div style="display: flex; align-items: center; gap: 12px; padding: 8px 12px; background: var(--glass-bg); border-radius: var(--radius); border: 1px solid var(--border);">
                    <div style="width: 24px; height: 24px; background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 600;">
                        ${index + 1}
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 600; color: var(--text-primary); font-size: 0.9rem;">${book.title}</div>
                        <div style="color: var(--text-muted); font-size: 0.8rem;">by ${book.author}</div>
                    </div>
                    <div style="background: var(--success); color: white; padding: 2px 8px; border-radius: 12px; font-size: 0.8rem; font-weight: 600;">
                        ${book.borrow_count} borrows
                    </div>
                </div>
            `).join('');
        }

        // Load most active members
        function loadActiveMembers(viewType = 'borrowing') {
            const members = viewType === 'borrowing'
                ? @json($analytics['mostActiveMembers'])
                : @json($analytics['mostActiveTimeLogMembers']);
            const container = document.getElementById('activeMembersList');

            if (members.length === 0) {
                container.innerHTML = '<p style="color: var(--text-muted); text-align: center; margin: 2rem 0;">No activity data available</p>';
                return;
            }

            const countLabel = viewType === 'borrowing' ? 'borrows' : 'visits';

            container.innerHTML = members.map((member, index) => `
                <div style="display: flex; align-items: center; gap: 12px; padding: 8px 12px; background: var(--glass-bg); border-radius: var(--radius); border: 1px solid var(--border);">
                    <div style="width: 24px; height: 24px; background: linear-gradient(135deg, var(--secondary), var(--primary)); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 600;">
                        ${index + 1}
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 600; color: var(--text-primary); font-size: 0.9rem;">${member.name}</div>
                        <div style="color: var(--text-muted); font-size: 0.8rem;">${member.barangay}</div>
                    </div>
                    <div style="background: var(--accent); color: white; padding: 2px 8px; border-radius: 12px; font-size: 0.8rem; font-weight: 600;">
                        ${member.borrow_count || member.visit_count} ${countLabel}
                    </div>
                </div>
            `).join('');
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadTopBooks();
            loadActiveMembers('borrowing');

            // Check for Christmas effects preference on load
            const christmasPreference = localStorage.getItem('christmasEffects');
            if (christmasPreference === 'true') {
                document.body.classList.add('christmas-theme');
            }
        });
    </script>
    <script src="{{ asset('js/overdue.js') }}" defer></script>
    <script src="{{ asset('js/bookadd.js') }}"></script>
    <script src="{{ asset('js/memberscript.js') }}"></script>
    <script src="{{ asset('js/borrow.js') }}"></script>
    <!-- ✅ ENHANCED COVER UPLOAD LOGIC FOR ADD BOOK MODAL -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
      const coverPreviewArea = document.getElementById('cover-preview-area');
      const coverInput = document.getElementById('cover-input');
      const coverPreviewContent = document.getElementById('cover-preview-content');

      if (!coverPreviewArea || !coverInput || !coverPreviewContent) return;

      // Style the drop zone
      Object.assign(coverPreviewArea.style, {
        height: '250px',
        border: '3px dashed var(--gray-light, #d1d5db)',
        borderRadius: '16px',
        overflow: 'hidden',
        cursor: 'pointer',
        transition: 'all 0.3s ease',
        marginTop: '1rem',
        marginBottom: '1.5rem',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center'
      });

      // Update preview with image
      function updateCoverPreview(file) {
        if (!file) return;

        if (!file.type.match('image/jpeg') && !file.type.match('image/png') && !file.type.match('image/gif')) {
          alert('Only JPG, PNG, and GIF images are allowed.');
          return;
        }

        if (file.size > 5 * 1024 * 1024) {
          alert('Image too large! Maximum size is 5MB.');
          return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
          coverPreviewContent.innerHTML = `
            <img src="${e.target.result}" alt="Book Cover Preview" style="
              max-width: 100%;
              max-height: 100%;
              width: auto;
              height: auto;
              border-radius: 12px;
              box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
              object-fit: contain;
            ">
            <p style="
              position: absolute;
              bottom: 10px;
              left: 50%;
              transform: translateX(-50%);
              background: rgba(0, 0, 0, 0.7);
              color: white;
              padding: 4px 8px;
              border-radius: 6px;
              font-size: 0.8rem;
              margin: 0;
              max-width: 90%;
              text-overflow: ellipsis;
              overflow: hidden;
              white-space: nowrap;
            ">${file.name}</p>
          `;
          coverPreviewContent.style.position = 'relative';
          coverPreviewContent.style.backgroundColor = '#f1f5f9';
          coverPreviewArea.style.borderColor = 'var(--primary, #2fb9eb)';
        };
        reader.readAsDataURL(file);
      }

      // Click to open file picker
      coverPreviewContent.addEventListener('click', () => {
        coverInput.click();
      });

      // Handle file selection
      coverInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) updateCoverPreview(file);
      });

      // Prevent default drag behaviors
      function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
      }

      ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        coverPreviewArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
      });

      // Visual feedback
      coverPreviewArea.addEventListener('dragenter', () => {
        coverPreviewArea.style.borderColor = 'var(--accent, #0891b2)';
      });

      coverPreviewArea.addEventListener('dragover', () => {
        coverPreviewArea.style.backgroundColor = 'rgba(8, 145, 178, 0.1)';
      });

      coverPreviewArea.addEventListener('dragleave', () => {
        coverPreviewArea.style.borderColor = 'var(--gray-light, #d1d5db)';
        coverPreviewArea.style.backgroundColor = '';
      });

      // Handle drop
      coverPreviewArea.addEventListener('drop', (e) => {
        const files = e.dataTransfer.files;
        if (files.length) {
          const dt = new DataTransfer();
          dt.items.add(files[0]);
          coverInput.files = dt.files;
          updateCoverPreview(files[0]);
        }
        coverPreviewArea.style.borderColor = 'var(--gray-light, #d1d5db)';
        coverPreviewArea.style.backgroundColor = '';
      });

      // Expose reset function globally
      window.resetCoverPreview = function () {
        coverPreviewContent.innerHTML = `
          <i id="cover-upload-icon" class="fas fa-cloud-upload-alt" style="font-size: 2.5rem; color: var(--text-muted, #6b7280); margin-bottom: 12px;"></i>
          <p id="cover-preview-text" style="color: var(--text-muted, #6b7280); margin: 0; font-weight: 500; font-size: 1.1rem;">
            Click or drag image here...
          </p>
          <small style="color: var(--text-muted, #6b7280); margin-top: 8px; display: block;">
            Supports JPG, PNG, GIF (max 5MB)
          </small>
        `;
        coverInput.value = '';
        coverPreviewArea.style.borderColor = 'var(--gray-light, #d1d5db)';
        coverPreviewContent.style.backgroundColor = '';
      };
    });

    // Ensure resetCoverPreview is called on modal close
    function closeAddBookModal() {
      const modal = document.getElementById('addBookModal');
      if (modal) {
        modal.classList.remove('active');
        modal.style.display = 'none';
        document.body.classList.remove('modal-open');
        // Reset form and preview
        document.getElementById('addBookForm').reset();
        if (typeof resetCoverPreview === 'function') resetCoverPreview();
      }
    }
    </script>
  </body>
</html>