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
    /* Legacy Color Palette */
    --primary: #1e40af;           /* Modern Blue */
    --primary-dark: #1e3a8a;
    --secondary: #7c3aed;         /* Vibrant Purple */
    --accent: #06b6d4;            /* Cyan */
    --accent-dark: #0891b2;
    --success: #059669;           /* Emerald */
    --warning: #f59e0b;           /* Amber */
    --danger: #ef4444;            /* Red */
    --info: #3b82f6;              /* Blue */
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
  .sidebar-header .logo {
    transition: var(--transition-spring);
    filter: drop-shadow(0 2px 4px rgba(99, 102, 241, 0.2));
  }
  .sidebar-header .logo:hover {
    transform: scale(1.05) rotate(2deg);
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
    background: linear-gradient(135deg, var(--background), #e0f2fe);
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
    width: 80px;
    height: 80px;
    object-fit: contain;
    border-radius: var(--radius);
    transition: var(--transition-spring);
    filter: drop-shadow(0 4px 8px rgba(99, 102, 241, 0.3));
    margin-bottom: 10px;
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
  /* Logout Button Hover Effects */
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
  .christmas-text {
    transition: all 0.3s ease;
  }
  .christmas-toggle {
    display: none; /* Hidden by default */
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.3s ease;
  }
  .christmas-toggle.visible {
    display: flex;
    opacity: 1;
    transform: translateY(0);
  }
  .christmas-toggle:hover {
    box-shadow: var(--shadow), 0 0 15px rgba(34, 197, 94, 0.3);
  }
  .christmas-toggle:hover .christmas-text {
    background: linear-gradient(90deg, #dc2626, #16a34a, #ca8a04, #dc2626);
    background-size: 300% 100%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: christmasShift 4s linear infinite;
    transform: scale(1.05);
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
  .logout-text{

  }
  @keyframes christmasShift {
    0% {
      background-position: 0% 50%;
    }
    100% {
      background-position: 300% 50%;
    }
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
    margin-left: 300px;
    padding: var(--spacing-lg);
    flex-grow: 1;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    min-width: calc(100% - 300px);
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
  /* Stats Cards - Legacy Glassmorphism */
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
  .toast-notification.music-toast {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.9), rgba(22, 163, 74, 0.9));
    color: white;
    border-left-color: var(--success);
    animation: musicPulse 0.6s ease-in-out;
  }
  @keyframes musicPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
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
  /* Animations */
  @keyframes iconBounce {
    0% { transform: scale(0) rotate(-180deg); }
    50% { transform: scale(1.3) rotate(-90deg); }
    100% { transform: scale(1) rotate(0deg); }
  }
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
      width: 280px;
    }
    .main {
      margin-left: 280px;
      min-width: calc(100% - 280px);
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
        <!-- Logout Button -->
        <div class="logout-section" style="margin-top: auto; margin-bottom: var(--spacing-lg); display: flex; justify-content: center;">
            <form method="POST" action="{{ route('logout') }}" style="margin: 0; padding: 0;">
                @csrf
                <button type="submit" class="logout-btn" style="
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 8px;
                    width: 160px;
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
            <span id="christmasToggleText" class="christmas-text">Enable Christmas</span>
        </div>
        <script>
            // Christmas Effects Manager - Refactored for better organization
            class ChristmasEffectsManager {
                constructor() {
                    this.musicPlayer = null;
                    this.christmasToggle = null;
                    this.christmasToggleText = null;
                    this.isInitialized = false;
                    this.init();
                }
                async init() {
                    if (this.isInitialized) return;
                    // Get DOM elements
                    this.christmasToggle = document.getElementById('christmasToggle');
                    this.christmasToggleText = document.getElementById('christmasToggleText');
                    // Initialize music player
                    this.musicPlayer = new ChristmasMusicPlayer();
                    // Setup toggle functionality
                    this.setupToggle();
                    // Load saved preference
                    this.loadSavedPreference();
                    this.isInitialized = true;
                }
                setupToggle() {
                    if (!this.christmasToggle) return;
                    this.christmasToggle.addEventListener('click', () => this.toggleChristmasEffects());
                }
                async toggleChristmasEffects() {
                    const isCurrentlyActive = document.body.classList.contains('christmas-theme');
                    if (isCurrentlyActive) {
                        this.disableChristmasEffects();
                    } else {
                        await this.enableChristmasEffects();
                    }
                }
                async enableChristmasEffects() {
                    // Check for new audio files before enabling
                    await this.musicPlayer.checkForNewFiles();
                    // Enable Christmas effects
                    document.body.classList.add('christmas-theme');
                    this.christmasToggle?.classList.add('active');
                    localStorage.setItem('christmasEffects', 'true');
                    // Update toggle button text
                    this.updateToggleButtonText();
                    // Show and start playing music automatically
                    this.musicPlayer.showPlayer();
                    await this.musicPlayer.play();
                    // Show success toast
                    this.showChristmasToast('Christmas theme enabled! Enjoy the festive music and effects.');
                }
                disableChristmasEffects() {
                    // Disable Christmas effects
                    document.body.classList.remove('christmas-theme');
                    this.christmasToggle?.classList.remove('active');
                    localStorage.setItem('christmasEffects', 'false');
                    // Update toggle button text
                    this.updateToggleButtonText();
                    // Stop music and hide player
                    this.musicPlayer.pause();
                    this.musicPlayer.hidePlayer();
                }
                loadSavedPreference() {
                    const savedPreference = localStorage.getItem('christmasEffects');
                    const shouldBeActive = savedPreference === 'true';
                    if (shouldBeActive) {
                        document.body.classList.add('christmas-theme');
                        this.christmasToggle?.classList.add('active');
                        this.christmasToggleText.textContent = 'Disable Christmas';
                        // Show player and start playing music automatically
                        this.musicPlayer.showPlayer();
                        this.musicPlayer.play();
                    } else {
                        document.body.classList.remove('christmas-theme');
                        this.christmasToggle?.classList.remove('active');
                        this.christmasToggleText.textContent = 'Enable Christmas';
                        this.musicPlayer.hidePlayer();
                    }
                    // Update toggle button text based on current state
                    this.updateToggleButtonText();
                }
                updateToggleButtonText() {
                    const isActive = document.body.classList.contains('christmas-theme');
                    if (this.christmasToggleText) {
                        this.christmasToggleText.textContent = isActive ? 'Disable Christmas' : 'Enable Christmas';
                    }
                }
                showChristmasToast(message) {
                    const toastContainer = document.getElementById('christmasToastContainer');
                    if (!toastContainer) return;
                    const toast = document.createElement('div');
                    toast.className = 'toast-notification toast-success christmas-toast';
                    toast.style.cssText = 'position: absolute; top: 10px; right: 10px; min-width: 350px; max-width: 450px; height: auto; pointer-events: auto; z-index: 1000;';
                    toast.innerHTML = '<div class="toast-content"><div class="toast-icon">🎄</div><div class="toast-text">' + message + '</div><button class="toast-close" onclick="this.parentElement.parentElement.remove()">×</button></div>';
                    toastContainer.appendChild(toast);
                    setTimeout(() => toast.classList.add('show'), 100);
                    setTimeout(() => {
                        toast.classList.remove('show');
                        setTimeout(() => toast.remove(), 300);
                    }, 5000); // 5 seconds for Christmas toast
                }
            }
            // Christmas Music Player Class - Refactored for better organization
            class ChristmasMusicPlayer {
                constructor() {
                    this.audio = new Audio();
                    this.tracks = [];
                    this.currentTrackIndex = 0;
                    this.isPlaying = false;
                    this.isShuffle = false;
                    this.repeatMode = 0; // 0: no repeat, 1: repeat all, 2: repeat one
                    // Load saved volume or default to 0.3
                    this.volume = parseFloat(localStorage.getItem('christmasPlayerVolume')) || 0.3;
                    this.lastAudioCheck = 0;
                    this.AUDIO_CHECK_INTERVAL = 30000; // Check every 30 seconds
                    this.CACHE_KEY = 'christmas_audio_files';
                    this.CACHE_TIMESTAMP_KEY = 'christmas_audio_timestamp';
                    this.eventListenersAttached = false;
                    this.initializeElements();
                    this.setupEventListeners();
                    this.loadAudioFiles();
                }
                initializeElements() {
                    this.musicPlayer = document.getElementById('christmasMusicPlayer');
                    this.playPauseBtn = document.getElementById('playPauseBtn');
                    this.prevTrackBtn = document.getElementById('prevTrack');
                    this.nextTrackBtn = document.getElementById('nextTrack');
                    this.shuffleBtn = document.getElementById('shuffleBtn');
                    this.repeatBtn = document.getElementById('repeatBtn');
                    this.progressBar = document.getElementById('progressBar');
                    this.volumeSlider = document.getElementById('volumeSlider');
                    this.currentTrackDisplay = document.getElementById('currentTrack');
                    this.currentTimeDisplay = document.getElementById('currentTime');
                    this.durationDisplay = document.getElementById('duration');
                    this.closeMusicPlayer = document.getElementById('closeMusicPlayer');
                    // Set initial volume from saved value
                    if (this.volumeSlider) {
                        this.volumeSlider.value = this.volume;
                        this.audio.volume = this.volume;
                    }
                }
                setupEventListeners() {
                    // Prevent duplicate event listeners
                    if (this.eventListenersAttached) return;
                    this.eventListenersAttached = true;
                    // Audio events
                    this.audio.addEventListener('loadedmetadata', () => this.onMetadataLoaded());
                    this.audio.addEventListener('timeupdate', () => this.onTimeUpdate());
                    this.audio.addEventListener('ended', () => this.onTrackEnded());
                    this.audio.addEventListener('error', (e) => this.onAudioError(e));
                    // Control events - bind methods to preserve this context
                    if (this.playPauseBtn) this.playPauseBtn.addEventListener('click', this.togglePlayPause.bind(this));
                    if (this.prevTrackBtn) this.prevTrackBtn.addEventListener('click', this.previousTrack.bind(this));
                    if (this.nextTrackBtn) this.nextTrackBtn.addEventListener('click', this.nextTrack.bind(this));
                    if (this.shuffleBtn) this.shuffleBtn.addEventListener('click', this.toggleShuffle.bind(this));
                    if (this.repeatBtn) this.repeatBtn.addEventListener('click', this.toggleRepeat.bind(this));
                    // Progress and volume
                    if (this.progressBar) {
                        this.progressBar.addEventListener('input', (e) => this.seekTo(e.target.value));
                        this.progressBar.addEventListener('mousedown', () => this.progressBar.dragging = true;
                        this.progressBar.addEventListener('mouseup', () => this.progressBar.dragging = false);
                    }
                    if (this.volumeSlider) this.volumeSlider.addEventListener('input', (e) => this.setVolume(e.target.value));
                    // Close button
                    if (this.closeMusicPlayer) this.closeMusicPlayer.addEventListener('click', this.hidePlayer.bind(this));
                    // Keyboard shortcut Ctrl+Alt+C to toggle music player
                    document.addEventListener('keydown', (e) => {
                        if (e.ctrlKey && e.altKey && (e.key === 'c' || e.key === 'C')) {
                            e.preventDefault();
                            this.togglePlayer();
                        }
                    });
                    // Keyboard shortcut Ctrl+Alt+F to show/hide Christmas toggle
                    document.addEventListener('keydown', (e) => {
                        if (e.ctrlKey && e.altKey && (e.key === 'f' || e.key === 'F')) {
                            e.preventDefault();
                            this.toggleChristmasToggleVisibility();
                        }
                    });
                }
                // Cache management
                getCachedAudioFiles() {
                    try {
                        const cached = localStorage.getItem(this.CACHE_KEY);
                        const timestamp = localStorage.getItem(this.CACHE_TIMESTAMP_KEY);
                        if (cached && timestamp) {
                            const cacheAge = Date.now() - parseInt(timestamp);
                            if (cacheAge < 3600000) { // 1 hour cache
                                return JSON.parse(cached);
                            }
                        }
                    } catch (error) {
                        console.error('Error reading audio cache:', error);
                    }
                    return null;
                }
                setCachedAudioFiles(audioFiles) {
                    try {
                        localStorage.setItem(this.CACHE_KEY, JSON.stringify(audioFiles));
                        localStorage.setItem(this.CACHE_TIMESTAMP_KEY, Date.now().toString());
                    } catch (error) {
                        console.error('Error caching audio files:', error);
                    }
                }
                // Audio file management
                async loadAudioFiles(forceRefresh = false) {
                    if (!forceRefresh) {
                        const cached = this.getCachedAudioFiles();
                        if (cached) {
                            this.tracks = cached.map(file => ({
                                title: file.title,
                                filename: file.filename,
                                src: file.url
                            }));
                            console.log('Loaded audio tracks from cache:', this.tracks.length);
                            return;
                        }
                    }
                    try {
                        const response = await fetch('/api/audio/files');
                        if (response.ok) {
                            const audioFiles = await response.json();
                            this.tracks = audioFiles.map(file => ({
                                title: file.title,
                                filename: file.filename,
                                src: file.url
                            }));
                            this.setCachedAudioFiles(audioFiles);
                            console.log('Loaded and cached audio tracks:', this.tracks.length);
                        } else {
                            this.loadFallbackTracks();
                        }
                    } catch (error) {
                        console.error('Error loading audio files:', error);
                        this.loadFallbackTracks();
                    }
                }
                loadFallbackTracks() {
                    this.tracks = [
                        { title: 'nekodex - Little Drummer Girl', filename: 'nekodex - Little Drummer Girl (osu! xmas 2020).mp3', src: '/audio/nekodex - Little Drummer Girl (osu! xmas 2020).mp3' },
                        { title: 'Deck the Halls', filename: 'Deck-the-Halls-B-chosic.com_.mp3', src: '/audio/Deck-the-Halls-B-chosic.com_.mp3' }
                    ];
                    console.log('Using fallback tracks');
                }
                async checkForNewFiles() {
                    const now = Date.now();
                    if (now - this.lastAudioCheck > this.AUDIO_CHECK_INTERVAL) {
                        await this.loadAudioFiles(true);
                        this.lastAudioCheck = now;
                    }
                }
                // Track management
                loadTrack(index) {
                    if (index < 0 || index >= this.tracks.length) return;
                    this.currentTrackIndex = index;
                    const track = this.tracks[index];
                    // Stop current audio before loading new track
                    this.audio.pause();
                    this.audio.currentTime = 0;
                    this.audio.src = track.src;
                    this.audio.load();
                    this.updateTrackDisplay();
                    this.resetProgressBar();
                }
                updateTrackDisplay() {
                    if (!this.currentTrackDisplay || !this.tracks[this.currentTrackIndex]) return;
                    const track = this.tracks[this.currentTrackIndex];
                    const displayName = track.filename
                        ? track.filename.replace(/\.[^/.]+$/, "").replace(/_/g, " ")
                        : track.title;
                    this.currentTrackDisplay.textContent = displayName;
                }
                resetProgressBar() {
                    if (this.progressBar) {
                        this.progressBar.value = 0;
                        this.progressBar.max = 100;
                    }
                    if (this.currentTimeDisplay) this.currentTimeDisplay.textContent = '0:00';
                    if (this.durationDisplay) this.durationDisplay.textContent = '0:00';
                }
                // Playback controls
                async play() {
                    try {
                        await this.audio.play();
                        this.isPlaying = true;
                        this.updatePlayPauseButton();
                        this.showMusicToast('▶️ Now Playing', this.tracks[this.currentTrackIndex]?.title || 'Unknown Track');
                    } catch (error) {
                        console.error('Error playing audio:', error);
                        this.showToast('Unable to play audio', 'error');
                    }
                }
                pause() {
                    this.audio.pause();
                    this.isPlaying = false;
                    this.updatePlayPauseButton();
                    this.showMusicToast('⏸️ Paused', this.tracks[this.currentTrackIndex]?.title || 'Unknown Track');
                }
                togglePlayPause() {
                    if (this.isPlaying) {
                        this.pause();
                    } else {
                        this.play();
                    }
                }
                previousTrack() {
                    let newIndex;
                    if (this.isShuffle) {
                        newIndex = Math.floor(Math.random() * this.tracks.length);
                        this.showMusicToast('🔀 Shuffle Previous', this.tracks[newIndex]?.title || 'Unknown Track');
                    } else {
                        newIndex = (this.currentTrackIndex - 1 + this.tracks.length) % this.tracks.length;
                        this.showMusicToast('⏮️ Previous Track', this.tracks[newIndex]?.title || 'Unknown Track');
                    }
                    this.loadTrack(newIndex);
                    this.play(); // Always play when changing tracks
                }
                nextTrack() {
                    let newIndex;
                    if (this.isShuffle) {
                        newIndex = Math.floor(Math.random() * this.tracks.length);
                        this.showMusicToast('🔀 Shuffle Next', this.tracks[newIndex]?.title || 'Unknown Track');
                    } else {
                        newIndex = (this.currentTrackIndex + 1) % this.tracks.length;
                        this.showMusicToast('⏭️ Next Track', this.tracks[newIndex]?.title || 'Unknown Track');
                    }
                    this.loadTrack(newIndex);
                    this.play(); // Always play when changing tracks
                }
                toggleShuffle() {
                    this.isShuffle = !this.isShuffle;
                    if (this.shuffleBtn) {
                        this.shuffleBtn.style.color = this.isShuffle ? 'var(--primary)' : 'var(--text-secondary)';
                        this.shuffleBtn.style.borderColor = this.isShuffle ? 'var(--primary)' : 'var(--border)';
                    }
                    this.showMusicToast(this.isShuffle ? '🔀 Shuffle On' : '🔀 Shuffle Off', 'Shuffle mode ' + (this.isShuffle ? 'enabled' : 'disabled'));
                }
                toggleRepeat() {
                    this.repeatMode = (this.repeatMode + 1) % 3;
                    this.audio.loop = this.repeatMode === 2;
                    let modeText = '';
                    if (this.repeatMode === 0) modeText = 'No Repeat';
                    else if (this.repeatMode === 1) modeText = 'Repeat All';
                    else if (this.repeatMode === 2) modeText = 'Repeat One';
                    if (this.repeatBtn) {
                        const icon = this.repeatBtn.querySelector('i');
                        if (icon) {
                            if (this.repeatMode === 0) {
                                icon.className = 'fas fa-redo';
                                this.repeatBtn.style.color = 'var(--text-secondary)';
                                this.repeatBtn.style.borderColor = 'var(--border)';
                            } else if (this.repeatMode === 1) {
                                icon.className = 'fas fa-redo';
                                this.repeatBtn.style.color = 'var(--primary)';
                                this.repeatBtn.style.borderColor = 'var(--primary)';
                            } else if (this.repeatMode === 2) {
                                icon.className = 'fas fa-redo-alt';
                                this.repeatBtn.style.color = 'var(--primary)';
                                this.repeatBtn.style.borderColor = 'var(--primary)';
                            }
                        }
                    }
                    this.showMusicToast('🔁 ' + modeText, 'Repeat mode changed');
                }
                seekTo(percentage) {
                    const time = (percentage / 100) * this.audio.duration;
                    this.audio.currentTime = time;
                }
                setVolume(volume) {
                    this.audio.volume = volume;
                    this.volume = volume;
                    // Save volume to localStorage
                    localStorage.setItem('christmasPlayerVolume', volume.toString());
                }
                // Event handlers
                onMetadataLoaded() {
                    if (this.durationDisplay) {
                        this.durationDisplay.textContent = this.formatTime(this.audio.duration);
                    }
                    if (this.progressBar) {
                        this.progressBar.max = 100;
                    }
                }
                onTimeUpdate() {
                    if (this.progressBar && !this.progressBar.dragging) {
                        const percentage = (this.audio.currentTime / this.audio.duration) * 100;
                        this.progressBar.value = percentage;
                    }
                    if (this.currentTimeDisplay) {
                        this.currentTimeDisplay.textContent = this.formatTime(this.audio.currentTime);
                    }
                }
                onTrackEnded() {
                    if (this.repeatMode === 2) {
                        // Repeat one - handled by audio.loop
                        this.showMusicToast('🔁 Repeating', this.tracks[this.currentTrackIndex]?.title || 'Unknown Track');
                        return;
                    } else if (this.repeatMode === 1 || !this.isShuffle) {
                        // Repeat all or next track
                        this.nextTrack();
                    } else {
                        // Shuffle mode
                        this.nextTrack();
                    }
                }
                onAudioError(error) {
                    console.error('Audio error:', error);
                    this.showToast('Error playing audio file', 'error');
                    this.nextTrack(); // Skip to next track on error
                }
                // UI updates
                updatePlayPauseButton() {
                    if (this.playPauseBtn) {
                        const icon = this.playPauseBtn.querySelector('i');
                        if (icon) {
                            icon.className = this.isPlaying ? 'fas fa-pause' : 'fas fa-play';
                        }
                    }
                }
                showPlayer() {
                    if (this.musicPlayer) {
                        this.musicPlayer.style.display = 'block';
                    }
                }
                hidePlayer() {
                    if (this.musicPlayer) {
                        this.musicPlayer.style.display = 'none';
                    }
                }
                togglePlayer() {
                    // Only allow toggling if Christmas theme is active
                    if (!document.body.classList.contains('christmas-theme')) {
                        this.showChristmasToast('🎄 Enable Christmas theme first to access the music player!');
                        return;
                    }
                    if (this.musicPlayer) {
                        const isVisible = this.musicPlayer.style.display !== 'none';
                        this.musicPlayer.style.display = isVisible ? 'none' : 'block';
                    }
                }
                toggleChristmasToggleVisibility() {
                    const christmasToggle = document.getElementById('christmasToggle');
                    if (christmasToggle) {
                        const isVisible = christmasToggle.classList.contains('visible');
                        if (isVisible) {
                            christmasToggle.classList.remove('visible');
                        } else {
                            christmasToggle.classList.add('visible');
                            // Show a helpful toast
                            this.showChristmasToast('🎄 Christmas toggle revealed! Press again to hide.');
                        }
                    }
                }
                // Utility functions
                formatTime(seconds) {
                    if (isNaN(seconds)) return '0:00';
                    const mins = Math.floor(seconds / 60);
                    const secs = Math.floor(seconds % 60);
                    return `${mins}:${secs.toString().padStart(2, '0')}`;
                }
                showToast(message, type = 'info') {
                    const toastStack = document.getElementById('toast-stack');
                    if (!toastStack) return;
                    const toast = document.createElement('div');
                    toast.className = `toast-notification toast-${type}`;
                    toast.innerHTML = `
                        <div class="toast-content">
                            <div class="toast-icon">${type === 'error' ? '❌' : type === 'success' ? '✅' : 'ℹ️'}</div>
                            <div class="toast-text">${message}</div>
                            <button class="toast-close" onclick="this.parentElement.parentElement.remove()">×</button>
                        </div>
                    `;
                    toastStack.appendChild(toast);
                    setTimeout(() => toast.classList.add('show'), 100);
                    setTimeout(() => {
                        toast.classList.remove('show');
                        setTimeout(() => toast.remove(), 300);
                    }, 3000);
                }
                showMusicToast(action, trackName) {
                    const toastStack = document.getElementById('toast-stack');
                    if (!toastStack) return;
                    const toast = document.createElement('div');
                    toast.className = 'toast-notification toast-info music-toast';
                    toast.innerHTML = `
                        <div class="toast-content">
                            <div class="toast-icon">🎵</div>
                            <div class="toast-text">
                                <strong>${action}</strong><br>
                                <small style="color: var(--text-muted);">${trackName}</small>
                            </div>
                            <button class="toast-close" onclick="this.parentElement.parentElement.remove()">×</button>
                        </div>
                    `;
                    toastStack.appendChild(toast);
                    setTimeout(() => toast.classList.add('show'), 100);
                    setTimeout(() => {
                        toast.classList.remove('show');
                        setTimeout(() => toast.remove(), 300);
                    }, 2500); // Shorter duration for music toasts
                }
            }
            // Initialize Christmas effects when DOM is ready - ensure single instance
            document.addEventListener('DOMContentLoaded', () => {
                if (!window.christmasEffectsManager) {
                    window.christmasEffectsManager = new ChristmasEffectsManager();
                }
            });
        </script>
    </div>
    <!-- Main Content -->
    <div class="main" id="mainContent">
        <div style="position: relative;">
            <div class="dashboard-title">DASHBOARD</div>
            <!-- Christmas Toast Container (positioned to the right of dashboard title) -->
            <div id="christmasToastContainer" style="position: absolute; top: 0; right: 0; z-index: 1000; pointer-events: none;"></div>
        </div>
        <div class="dashboard-content">
        <!-- Stats Cards -->
        <div class="stats">
            <div class="card" id="booksCard">
                <div class="card-header">
                    <h3 style="font-size: 0.9rem; color: var(--text-muted); margin: 0; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; opacity: 1;"><i class="fas fa-book" style="margin-right: 8px; color: var(--primary);"></i>Books</h3>
                </div>
                <div class="count">{{ $booksCount }}</div>
                <div class="card-actions-bottom">
                    <button class="btn btn-sm btn-primary" onclick="openAddBookModal()" title="Add New Book">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button class="btn btn-sm btn-outline" onclick="openBooksTable()" title="View All Books">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            <div class="card" id="membersCard">
                <div class="card-header">
                    <h3 style="font-size: 0.9rem; color: var(--text-muted); margin: 0; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; opacity: 1;"><i class="fas fa-users" style="margin-right: 8px; color: var(--primary);"></i>Members</h3>
                </div>
                <div class="count">{{ $membersCount }}</div>
                <div class="card-actions-bottom">
                    <button class="btn btn-sm btn-primary" onclick="openJulitaRegisterModal()" title="Add New Member">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button class="btn btn-sm btn-outline" onclick="openMembersTable()" title="View All Members">
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
        <div class="analytics-section" style="margin-top: 2rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: 2rem;">
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
        <!-- Christmas Music Player Overlay -->
        <div id="christmasMusicPlayer" style="
            position: fixed;
            top: auto;
            bottom: 20px;
            right: 20px;
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-xl);
            box-shadow: var(--glass-shadow);
            padding: 1.5rem;
            z-index: 1001;
            display: none;
            min-width: 350px;
            max-width: 400px;
            pointer-events: auto;
        ">
            <div style="text-align: center; margin-bottom: 1rem;">
                <h3 style="color: var(--text-primary); font-size: 1.2rem; margin: 0;">🎵 Christmas Music Player</h3>
            </div>
            <!-- Progress Bar -->
            <div style="margin-bottom: 1rem;">
                <input type="range" id="progressBar" min="0" max="100" value="0" style="width: 100%; height: 6px; border-radius: 3px; background: var(--border); outline: none; -webkit-appearance: none; appearance: none; cursor: pointer;">
                <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;">
                    <span id="currentTime">0:00</span>
                    <span id="duration">0:00</span>
                </div>
            </div>
            <!-- Control Buttons (5 buttons: shuffle, prev, play/pause, next, repeat) -->
            <div style="display: flex; align-items: center; justify-content: center; gap: 0.25rem; margin-bottom: 1rem;">
                <button id="shuffleBtn" class="btn btn-sm" style="background: transparent; color: var(--text-secondary); border: 1px solid var(--border); width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; transition: var(--transition); padding: 0; min-width: 32px;">
                    <i class="fas fa-random" style="font-size: 14px;"></i>
                </button>
                <button id="prevTrack" class="btn btn-sm" style="background: var(--primary); color: white; border: none; width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; transition: var(--transition); padding: 0; min-width: 32px;">
                    <i class="fas fa-step-backward" style="font-size: 14px;"></i>
                </button>
                <button id="playPauseBtn" class="btn btn-sm" style="background: var(--success); color: white; border: none; width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 1rem; transition: var(--transition); padding: 0; min-width: 32px;">
                    <i class="fas fa-play" style="font-size: 14px;"></i>
                </button>
                <button id="nextTrack" class="btn btn-sm" style="background: var(--primary); color: white; border: none; width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; transition: var(--transition); padding: 0; min-width: 32px;">
                    <i class="fas fa-step-forward" style="font-size: 14px;"></i>
                </button>
                <button id="repeatBtn" class="btn btn-sm" style="background: transparent; color: var(--text-secondary); border: 1px solid var(--border); width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; transition: var(--transition); padding: 0; min-width: 32px;">
                    <i class="fas fa-redo" style="font-size: 14px;"></i>
                </button>
            </div>
            <!-- Volume Slider (smaller and shorter) -->
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; justify-content: center;">
                <span style="font-size: 0.8rem; color: var(--text-muted);"><i class="fas fa-volume-down"></i></span>
                <input type="range" id="volumeSlider" min="0" max="1" step="0.1" value="0.3" style="width: 120px; height: 6px; border-radius: 3px; background: var(--border); outline: none; -webkit-appearance: none; appearance: none; cursor: pointer;">
                <span style="font-size: 0.8rem; color: var(--text-muted);"><i class="fas fa-volume-up"></i></span>
            </div>
            <!-- Track Info -->
            <div style="text-align: center; font-size: 0.9rem; color: var(--text-secondary);">
                <span id="currentTrack">nekodex - Little Drummer Girl</span>
            </div>
            <!-- Close Button -->
            <button id="closeMusicPlayer" style="
                position: absolute;
                top: 10px;
                right: 10px;
                background: var(--glass-bg);
                border: 1px solid var(--glass-border);
                border-radius: 50%;
                width: 30px;
                height: 30px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                color: var(--text-muted);
                transition: var(--transition);
            ">
                <i class="fas fa-times"></i>
            </button>
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
              <div class="premium-upload-area" id="cover-preview-area" style="height: 180px;">
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
                  <img id="cover-preview" class="cover-preview" style="display: none; width: 100%; height: 100%; object-fit: cover; border-radius: var(--radius-lg); position: absolute; top: 0; left: 0;">
                  <button class="remove-preview-btn" id="remove-cover-preview" style="display: none; position: absolute; top: 5px; right: 5px; background: rgba(239, 68, 68, 0.8); color: white; border: none; border-radius: 50%; width: 24px; height: 24px; cursor: pointer; z-index: 10;" title="Remove image">×</button>
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
                    <input type="number" id="bookYear" name="published_year" class="premium-input" required min="1900" max="2099" placeholder="e.g., 2023" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
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
                    <input type="number" id="bookAvailability" name="availability" class="premium-input" required min="0" placeholder="Number of copies available" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
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
    <!-- ADD MEMBER MODAL (Julita Residents) -->
    <div class="modal-overlay" id="julitaRegisterModal">
        <div class="modal-container">
            <!-- Enhanced Header with Gradient Background -->
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
                <button class="modal-close" onclick="closeJulitaRegisterModal()" aria-label="Close modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- Scrollable Body -->
            <div class="modal-body">
                <form id="julitaRegisterForm" enctype="multipart/form-data" novalidate>
                    <!-- Personal Information Section -->
                    <div class="form-section">
                        <div class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <span>Personal Information</span>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="julitaFirstName" class="form-label">
                                    <i class="fas fa-signature"></i>
                                    First Name <span class="required">*</span>
                                </label>
                                <input type="text" id="julitaFirstName" name="firstName" class="form-control" required placeholder="Enter first name" autocomplete="given-name">
                            </div>
                            <div class="form-group">
                                <label for="julitaMiddleName" class="form-label">
                                    <i class="fas fa-signature"></i>
                                    Middle Name
                                </label>
                                <input type="text" id="julitaMiddleName" name="middleName" class="form-control" placeholder="Enter middle name (optional)" autocomplete="additional-name">
                            </div>
                            <div class="form-group">
                                <label for="julitaLastName" class="form-label">
                                    <i class="fas fa-signature"></i>
                                    Last Name <span class="required">*</span>
                                </label>
                                <input type="text" id="julitaLastName" name="lastName" class="form-control" required placeholder="Enter last name" autocomplete="family-name">
                            </div>
                            <div class="form-group">
                                <label for="julitaAge" class="form-label">
                                    <i class="fas fa-birthday-cake"></i>
                                    Age <span class="required">*</span>
                                </label>
                                <input type="number" id="julitaAge" name="age" class="form-control" min="1" max="150" required placeholder="Enter age">
                            </div>
                        </div>
                    </div>
                    <!-- Address Information Section -->
                    <div class="form-section">
                        <div class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <span>Address Information</span>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="julitaHouseNumber" class="form-label">
                                    <i class="fas fa-home"></i>
                                    House Number
                                </label>
                                <input type="text" id="julitaHouseNumber" name="houseNumber" class="form-control" placeholder="Enter house number" autocomplete="address-line1">
                            </div>
                            <div class="form-group">
                                <label for="julitaStreet" class="form-label">
                                    <i class="fas fa-road"></i>
                                    Street
                                </label>
                                <input type="text" id="julitaStreet" name="street" class="form-control" placeholder="Enter street name" autocomplete="address-line2">
                            </div>
                            <div class="form-group">
                                <label for="julitaBarangay" class="form-label">
                                    <i class="fas fa-map"></i>
                                    Barangay <span class="required">*</span>
                                </label>
                                <select id="julitaBarangay" name="barangay" class="form-control" required autocomplete="address-level3">
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
                                    Municipality <span class="required">*</span>
                                </label>
                                <input type="text" id="julitaMunicipality" name="municipality" class="form-control" value="Julita" readonly autocomplete="address-level2">
                            </div>
                            <div class="form-group">
                                <label for="julitaProvince" class="form-label">
                                    <i class="fas fa-globe-asia"></i>
                                    Province <span class="required">*</span>
                                </label>
                                <input type="text" id="julitaProvince" name="province" class="form-control" value="Leyte" readonly autocomplete="address-level1">
                            </div>
                        </div>
                    </div>
                    <!-- Contact Information Section -->
                    <div class="form-section">
                        <div class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <span>Contact Information</span>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="julitaContactNumber" class="form-label">
                                    <i class="fas fa-mobile-alt"></i>
                                    Contact Number <span class="required">*</span>
                                </label>
                                <input type="tel" id="julitaContactNumber" name="contactNumber" class="form-control" pattern="[0-9]{11}" maxlength="11" required placeholder="09XXXXXXXXX" autocomplete="tel">
                            </div>
                            <div class="form-group">
                                <label for="julitaSchool" class="form-label">
                                    <i class="fas fa-school"></i>
                                    School/Institution
                                </label>
                                <input type="text" id="julitaSchool" name="school" class="form-control" placeholder="Enter school or institution name" autocomplete="organization">
                            </div>
                        </div>
                    </div>
                    <!-- Photo Upload Section -->
                    <div class="form-section">
                        <div class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-camera"></i>
                            </div>
                            <span>Upload Photo</span>
                        </div>
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
            <!-- Enhanced Footer with Better Button Layout -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeJulitaRegisterModal()">
                    <i class="fas fa-times"></i>
                    <span>Cancel</span>
                </button>
                <button type="button" class="btn btn-primary" onclick="submitJulitaRegister()">
                    <i class="fas fa-save"></i>
                    <span>Register Member</span>
                </button>
            </div>
        </div>
    </div>
    <!-- REGISTER MODAL (Non-Julita Residents) -->
    <div class="modal-overlay" id="registerModal">
        <div class="modal-container">
            <!-- Enhanced Header with Gradient Background -->
            <div class="modal-header">
                <div class="modal-header-content">
                    <div class="modal-icon-wrapper">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="modal-title-section">
                        <h2 class="modal-title">Register New Member</h2>
                        <p class="modal-subtitle">Add a new member from any location</p>
                    </div>
                </div>
                <button class="modal-close" onclick="closeRegisterModal()" aria-label="Close modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- Scrollable Body -->
            <div class="modal-body">
                <form id="registerForm" novalidate>
                    <!-- Personal Information Section -->
                    <div class="form-section">
                        <div class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <span>Personal Information</span>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="firstName" class="form-label">
                                    <i class="fas fa-signature"></i>
                                    First Name <span class="required">*</span>
                                </label>
                                <input type="text" id="firstName" name="firstName" class="form-control" required placeholder="Enter first name" autocomplete="given-name">
                            </div>
                            <div class="form-group">
                                <label for="middleName" class="form-label">
                                    <i class="fas fa-signature"></i>
                                    Middle Name
                                </label>
                                <input type="text" id="middleName" name="middleName" class="form-control" placeholder="Enter middle name (optional)" autocomplete="additional-name">
                            </div>
                            <div class="form-group">
                                <label for="lastName" class="form-label">
                                    <i class="fas fa-signature"></i>
                                    Last Name <span class="required">*</span>
                                </label>
                                <input type="text" id="lastName" name="lastName" class="form-control" required placeholder="Enter last name" autocomplete="family-name">
                            </div>
                            <div class="form-group">
                                <label for="age" class="form-label">
                                    <i class="fas fa-birthday-cake"></i>
                                    Age <span class="required">*</span>
                                </label>
                                <input type="number" id="age" name="age" class="form-control" min="1" max="150" required placeholder="Enter age">
                            </div>
                        </div>
                    </div>
                    <!-- Address Information Section -->
                    <div class="form-section">
                        <div class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <span>Address Information</span>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="houseNumber" class="form-label">
                                    <i class="fas fa-home"></i>
                                    House Number   
                                </label>
                                <input type="text" id="houseNumber" name="houseNumber" class="form-control" placeholder="Enter house number" autocomplete="address-line1">
                            </div>
                            <div class="form-group">
                                <label for="street" class="form-label">
                                    <i class="fas fa-road"></i>
                                    Street
                                </label>
                                <input type="text" id="street" name="street" class="form-control" placeholder="Enter street name" autocomplete="address-line2">
                            </div>
                            <div class="form-group">
                                <label for="barangay" class="form-label">
                                    <i class="fas fa-map"></i>
                                    Barangay <span class="required">*</span>
                                </label>
                                <input type="text" id="barangay" name="barangay" class="form-control" required placeholder="Enter barangay" autocomplete="address-level3">
                            </div>
                            <div class="form-group">
                                <label for="municipality" class="form-label">
                                    <i class="fas fa-city"></i>
                                    Municipality/City <span class="required">*</span>
                                </label>
                                <input type="text" id="municipality" name="municipality" class="form-control" required placeholder="Enter municipality/city" autocomplete="address-level2">
                            </div>
                            <div class="form-group">
                                <label for="province" class="form-label">
                                    <i class="fas fa-globe-asia"></i>
                                    Province <span class="required">*</span>
                                </label>
                                <input type="text" id="province" name="province" class="form-control" required placeholder="Enter province" autocomplete="address-level1">
                            </div>
                        </div>
                    </div>
                    <!-- Contact Information Section -->
                    <div class="form-section">
                        <div class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <span>Contact Information</span>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="contactNumber" class="form-label">
                                    <i class="fas fa-mobile-alt"></i>
                                    Contact Number <span class="required">*</span>
                                </label>
                                <input type="tel" id="contactNumber" name="contactNumber" class="form-control" pattern="[0-9]{11}" maxlength="11" required placeholder="09XXXXXXXXX" autocomplete="tel">
                            </div>
                            <div class="form-group">
                                <label for="school" class="form-label">
                                    <i class="fas fa-school"></i>
                                    School/Institution
                                </label>
                                <input type="text" id="school" name="school" class="form-control" placeholder="Enter school or institution name" autocomplete="organization">
                            </div>
                        </div>
                    </div>
                    <!-- Photo Upload Section -->
                    <div class="form-section">
                        <div class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-camera"></i>
                            </div>
                            <span>Upload Photo</span>
                        </div>
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
                                    <input type="file" id="photo" name="photo" accept="image/*" class="form-input">
                                </div>
                                <img id="photoPreview" class="photo-preview" src="#" alt="Photo Preview" style="display: none;">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Enhanced Footer with Better Button Layout -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeRegisterModal()">
                    <i class="fas fa-times"></i>
                    <span>Cancel</span>
                </button>
                <button type="button" class="btn btn-primary" onclick="submitRegister()">
                    <i class="fas fa-save"></i>
                    <span>Register Member</span>
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
                    imageItem.style.box-shadow = 'var(--shadow-md)';
                });
                imageItem.addEventListener('mouseleave', () => {
                    imageItem.style.borderColor = 'var(--border-light)';
                    imageItem.style.transform = '';
                    imageItem.style.box-shadow = '';
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
            const activeModal = document.querySelector('.modal-overlay.active');
            if (!activeModal) return;
            const fileInput = activeModal.querySelector('#cover-input') || activeModal.querySelector('#photo') || activeModal.querySelector('#julitaPhoto');
            if (fileInput) {
                const dt = new DataTransfer();
                dt.items.add(file);
                fileInput.files = dt.files;
            }
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

    <!-- ✅ FIXED MODAL IMAGE UPLOAD/STACKING ISSUES – FULLY FUNCTIONAL -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize upload handlers for all modals
            initializeUploadHandler('addBookModal', 'cover-input', 'cover-preview');
            initializeUploadHandler('julitaRegisterModal', 'julitaPhoto', 'julitaPhotoPreview');
            initializeUploadHandler('registerModal', 'photo', 'photoPreview');
        });

        function initializeUploadHandler(modalId, inputId, previewId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;

            const uploadArea = modal.querySelector('.photo-upload') || modal.querySelector('.premium-upload-area');
            const fileInput = document.getElementById(inputId);
            const previewImg = document.getElementById(previewId);

            if (!uploadArea || !fileInput || !previewImg) return;

            // Style the upload area
            const isMemberModal = modalId.includes('Register') || modalId === 'registerModal';
            Object.assign(uploadArea.style, {
                border: '3px dashed var(--border)',
                borderRadius: 'var(--radius-lg)',
                padding: 'var(--spacing-lg)',
                textAlign: 'center',
                transition: 'all 0.3s ease',
                cursor: 'pointer',
                background: 'var(--surface)',
                display: 'flex',
                flexDirection: 'column',
                alignItems: 'center',
                justifyContent: 'center',
                height: isMemberModal ? '200px' : '260px',
                width: isMemberModal ? '200px' : 'auto',
                overflow: 'hidden'
            });

            // Function to clear the preview area before showing a new image
            function clearPreviewArea() {
                const uploadZone = modal.querySelector('.upload-zone');
                const uploadAreaElement = modal.querySelector('.premium-upload-area') || modal.querySelector('.photo-upload');

                if (!uploadAreaElement) return;

                // Handle book modal (premium-upload-area with upload-zone)
                if (uploadZone) {
                    // Show the upload zone
                    uploadZone.style.display = 'flex';

                    // Remove existing preview elements
                    if (uploadAreaElement._previewElements) {
                        uploadAreaElement._previewElements.forEach(el => el.remove());
                    }

                    // Reset styles
                    uploadAreaElement.style.position = '';
                    uploadAreaElement.style.padding = uploadAreaElement._originalPadding || 'var(--spacing-lg)';
                    delete uploadAreaElement._blobUrl;
                    delete uploadAreaElement._previewElements;
                }
                // Handle member modals (photo-upload without upload-zone)
                else {
                    // Hide preview elements
                    if (uploadAreaElement._previewElements) {
                        uploadAreaElement._previewElements.forEach(el => el.remove());
                    }

                    // Show original content
                    const iconWrapper = uploadAreaElement.querySelector('.upload-icon-wrapper');
                    const uploadText = uploadAreaElement.querySelector('.upload-text');
                    if (iconWrapper) iconWrapper.style.display = 'flex';
                    if (uploadText) uploadText.style.display = 'flex';

                    // Reset styles
                    uploadAreaElement.style.position = '';
                    uploadAreaElement.style.padding = uploadAreaElement._originalPadding || 'var(--spacing-lg)';
                    delete uploadAreaElement._blobUrl;
                    delete uploadAreaElement._previewElements;
                }
            }

            // Update preview with image
            function updatePreview(file) {
              if (!file) return;
              if (!file.type.match('image/')) {
                showToast('Only image files are allowed.', 'error');
                return;
              }
              if (file.size > 5 * 1024 * 1024) {
                showToast('Image too large! Maximum size is 5MB.', 'error');
                return;
              }

              // Store the file globally for form submission
              window.uploadedMediaFile = file;

              const url = URL.createObjectURL(file);
              const uploadAreaElement = modal.querySelector('.premium-upload-area') || modal.querySelector('.photo-upload');

              if (uploadAreaElement) {
                // Store original padding
                const originalPadding = uploadAreaElement.style.padding || 'var(--spacing-lg)';
                uploadAreaElement._originalPadding = originalPadding;

                // Set position relative for absolute positioning
                uploadAreaElement.style.position = 'relative';
                // Remove padding to fit image perfectly
                uploadAreaElement.style.padding = '0';

                // Clear the area first
                clearPreviewArea();

                // Hide upload zone (for book modal) or original content (for member modals)
                const uploadZone = modal.querySelector('.upload-zone');
                if (uploadZone) {
                    uploadZone.style.display = 'none';
                } else {
                    // For member modals, hide the original content
                    const iconWrapper = uploadAreaElement.querySelector('.upload-icon-wrapper');
                    const uploadText = uploadAreaElement.querySelector('.upload-text');
                    if (iconWrapper) iconWrapper.style.display = 'none';
                    if (uploadText) uploadText.style.display = 'none';
                }

                // Create and append the preview image
                const img = document.createElement('img');
                img.src = url;
                img.alt = 'Photo Preview';
                img.style.cssText = 'width: 100%; height: 100%; object-fit: contain; border-radius: var(--radius-md); cursor: pointer;';
                img.onclick = () => fileInput.click(); // Clicking image reopens file dialog
                uploadAreaElement.appendChild(img);

                // Add filename
                const p = document.createElement('p');
                p.textContent = file.name;
                p.style.cssText = 'color: var(--gray-800); font-weight: 600; margin: 0; position: absolute; bottom: 5px; left: 5px; background: rgba(255,255,255,0.8); padding: 2px 5px; border-radius: 3px; font-size: 0.8rem;';
                uploadAreaElement.appendChild(p);

                // Add change text
                const small = document.createElement('small');
                small.textContent = 'Click to change';
                small.style.cssText = 'color: var(--text-muted); position: absolute; bottom: 5px; left: 5px; background: rgba(255,255,255,0.8); padding: 2px 5px; border-radius: 3px; font-size: 0.7rem;';
                uploadAreaElement.appendChild(small);

                // Add clear button
                const clearBtn = document.createElement('button');
                clearBtn.textContent = '×';
                clearBtn.style.cssText = 'position: absolute; top: 5px; right: 5px; background: rgba(239, 68, 68, 0.8); color: white; border: none; border-radius: 50%; width: 24px; height: 24px; cursor: pointer; font-size: 16px; display: flex; align-items: center; justify-content: center; z-index: 10;';
                clearBtn.title = 'Clear image';
                clearBtn.onclick = (e) => {
                  e.stopPropagation();
                  clearPreviewArea();
                  fileInput.value = '';
                  window.uploadedMediaFile = null; // Clear the stored file
                };
                uploadAreaElement.appendChild(clearBtn);

                // Store for cleanup
                uploadAreaElement._blobUrl = url;
                uploadAreaElement._previewElements = [img, p, small, clearBtn];
              }
            }

            // Click to open file picker
            uploadArea.addEventListener('click', () => {
                fileInput.click();
            });

            // Handle file selection
            fileInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) updatePreview(file);
            });

            // Prevent default drag behaviors
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, preventDefaults, false);
            });

            // Visual feedback
            uploadArea.addEventListener('dragenter', () => {
                uploadArea.style.borderColor = 'var(--primary)';
                uploadArea.style.backgroundColor = 'rgba(47, 185, 235, 0.05)';
            });
            uploadArea.addEventListener('dragover', () => {
                uploadArea.style.borderColor = 'var(--primary)';
                uploadArea.style.backgroundColor = 'rgba(47, 185, 235, 0.1)';
            });
            uploadArea.addEventListener('dragleave', () => {
                uploadArea.style.borderColor = 'var(--border)';
                uploadArea.style.backgroundColor = 'var(--surface)';
            });

            // Handle drop
            uploadArea.addEventListener('drop', (e) => {
                const files = e.dataTransfer.files;
                if (files.length) {
                    const dt = new DataTransfer();
                    dt.items.add(files[0]);
                    fileInput.files = dt.files;
                    updatePreview(files[0]);
                }
                uploadArea.style.borderColor = 'var(--border)';
                uploadArea.style.backgroundColor = 'var(--surface)';
            });

            // Add remove button functionality for Add Book Modal
            if (modalId === 'addBookModal') {
                const removeBtn = document.getElementById('remove-cover-preview');
                if (removeBtn) {
                    removeBtn.addEventListener('click', () => {
                        clearPreviewArea();
                        fileInput.value = '';
                    });
                }
            }

            // Define reset function for this specific modal
            const resetFunctionName = `reset${modalId.charAt(0).toUpperCase() + modalId.slice(1)}Preview`;
            window[resetFunctionName] = function () {
                clearPreviewArea();
                fileInput.value = '';
                window.uploadedMediaFile = null;
            };
        }

        // Toast notification function removed - using consolidated version

        // Custom Christmas toast function positioned near dashboard title
        function showChristmasToast(message) {
            const toastContainer = document.getElementById('christmasToastContainer');
            if (!toastContainer) return;
            const toast = document.createElement('div');
            toast.className = 'toast-notification toast-success christmas-toast';
            toast.style.cssText = 'position: absolute; top: 10px; right: 10px; min-width: 350px; max-width: 450px; height: auto; pointer-events: auto; z-index: 1000;';
            toast.innerHTML = '<div class="toast-content"><div class="toast-icon">🎄</div><div class="toast-text">' + message + '</div><button class="toast-close" onclick="this.parentElement.parentElement.remove()">×</button></div>';
            toastContainer.appendChild(toast);
            setTimeout(() => toast.classList.add('show'), 100);
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 5000); // 5 seconds for Christmas toast
        }

        // Ensure reset functions are called on modal close
        function closeAddBookModal() {
            const modal = document.getElementById('addBookModal');
            if (modal) {
                modal.classList.remove('active');
                modal.style.display = 'none';
                document.body.classList.remove('modal-open');
                // Reset form and preview
                document.getElementById('addBookForm').reset();
                if (typeof resetAddBookModalPreview === 'function') resetAddBookModalPreview();
            }
        }

        function closeJulitaRegisterModal() {
            closeRegisterModal();
            if (typeof resetJulitaRegisterModalPreview === 'function') resetJulitaRegisterModalPreview();
        }

        function closeRegisterModal() {
            const registerModal = document.getElementById("registerModal");
            const julitaModal = document.getElementById("julitaRegisterModal");
            if (registerModal) {
                registerModal.classList.remove("active");
                // Force hide after transition
                setTimeout(() => {
                    registerModal.style.display = 'none';
                }, 300);
            }
            if (julitaModal) {
                julitaModal.classList.remove("active");
                // Force hide after transition
                setTimeout(() => {
                    julitaModal.style.display = 'none';
                }, 300);
            }
            document.body.classList.remove("modal-open");
            if (typeof resetRegisterModalPreview === 'function') resetRegisterModalPreview();
        }

        // Close modal on overlay click
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal-overlay')) {
                e.target.classList.remove('active');
                document.body.classList.remove('modal-open');
                // Auto-reset based on which modal was open
                if (e.target.id === 'addBookModal') closeAddBookModal();
                else if (e.target.id === 'julitaRegisterModal') closeJulitaRegisterModal();
                else if (e.target.id === 'registerModal') closeRegisterModal();
            }
        });
    </script>

</body>
</html>