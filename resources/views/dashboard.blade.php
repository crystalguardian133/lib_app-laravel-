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
        /* Fix for chart container expansion */
        .chart-container-fixed {
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
        }
        .chart-container-fixed canvas {
            max-width: 100%;
            max-height: 300px;--shadow-xl: 0 25px 50px rgba(0, 0, 0, 0.15);
            width: 100%;
            height: 300px;
        }
    </style>
    <style>
:root {
    /* Legacy Color Palette */
    --primary: #2fb9eb;           /* Indigo */
    --primary-dark: #4f46e5;
    --secondary: #8b5cf6;        /* Vibrant Purple */
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
    opacity: 1 !important;
    color: var(--text-primary) !important;
  }
  body.dark-mode .data-table td {
    border-bottom-color: rgba(255, 255, 255, 0.05);
    opacity: 1 !important;
    color: var(--text-primary) !important;
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
  /* Ensure table data is always fully visible - exclude modals and toasts */
  .data-table:not(.modal .data-table):not(.toast .data-table):not(.toast-notification .data-table) td,
  .data-table:not(.modal .data-table):not(.toast .data-table):not(.toast-notification .data-table) th,
  .data-table:not(.modal .data-table):not(.toast .data-table):not(.toast-notification .data-table) tr,
  .data-table:not(.modal .data-table):not(.toast .data-table):not(.toast-notification .data-table) td *,
  .data-table:not(.modal .data-table):not(.toast .data-table):not(.toast-notification .data-table) th * {
    opacity: 1 !important;
  }
  /* Exception for disabled buttons and loading states */
  .btn:disabled {
    opacity: 0.6 !important;
  }
  .loading-shimmer {
    opacity: inherit !important;
  }
  /* Ensure modals, overlays, and toasts can control their own opacity and visibility */
  .modal,
  .modal-overlay,
  .modal-container,
  .toast,
  .toast-notification,
  .modal *,
  .modal-overlay *,
  .modal-container *,
  .toast *,
  .toast-notification * {
    opacity: inherit !important;
  }
  /* Specific fix for register modals - respect display property */
  #registerModal:not(.active),
  #julitaRegisterModal:not(.active),
  #addBookModal:not(.active) {
    display: none !important;
  }
  #registerModal.active,
  #julitaRegisterModal.active,
  #addBookModal.active {
    display: flex !important;
  }
  /* Ensure modal content inside respects parent visibility */
  #registerModal:not(.active) *,
  #julitaRegisterModal:not(.active) *,
  #addBookModal:not(.active) * {
    opacity: inherit !important;
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
  
  /* Dark mode for System Settings Modal */
  body.dark-mode #settingsModal .modal-header {
    background: rgba(30, 30, 30, 0.95);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }
  
  body.dark-mode #settingsModal .modal-title span {
    color: var(--text-primary);
  }
  
  body.dark-mode #settingsModal .modal-close {
    background: rgba(30, 41, 59, 0.9);
    border-color: rgba(71, 85, 105, 0.5);
    color: var(--text-muted);
  }
  
  body.dark-mode #settingsModal .modal-close:hover {
    background: var(--danger);
    border-color: var(--danger);
    color: white;
  }
  
  body.dark-mode #settingsModal .settings-tab {
    background: rgba(30, 30, 30, 0.8);
    color: var(--text-secondary);
  }
  
  body.dark-mode #settingsModal .settings-tab.active {
    background: rgba(99, 102, 241, 0.15);
    color: var(--primary);
  }
  
  body.dark-mode #settingsModal .settings-tab:hover:not(.active) {
    background: rgba(255, 255, 255, 0.05);
    color: var(--text-primary);
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
    opacity: 1 !important;
  }
  .data-table td {
    padding: 14px 12px;
    border-bottom: 1px solid var(--border-light);
    color: var(--text-primary);
    font-size: 0.95rem;
    font-weight: 500;
    transition: var(--transition);
    opacity: 1 !important;
  }
  .data-table tr:hover {
   background: rgba(99, 102, 241, 0.08);
   transform: translateX(2px);
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
    display: none; /* Hidden by default */
    align-items: center;
    font-size: 0.95rem;
    cursor: pointer;
    margin-bottom: 12px;
    border-left: 4px solid transparent;
    position: relative;
    overflow: hidden;
    visibility: hidden;
  }
  .toast-notification.show {
    display: flex !important;
    opacity: 1 !important;
    visibility: visible !important;
    transform: translateY(0) scale(1);
    animation: toastSlideIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1),
               toastGlow 2s ease-in-out infinite alternate;
  }
  .toast-notification.toast-hidden {
    display: none !important;
    opacity: 0 !important;
    visibility: hidden !important;
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
    opacity: 1 !important;
  }
  .data-table th *,
  .data-table td * {
    opacity: 1 !important;
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
    /* Compact book display on mobile */
    .books-cell {
      max-width: 120px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
  }
  /* Enhanced table row hover effects for grouped data */
  .data-table tr {
    transition: all 0.3s ease;
  }
  .data-table tr td,
  .data-table tr th {
    opacity: 1 !important;
  }
  .data-table tr:not(:hover) td,
  .data-table tr:not(:hover) th {
    opacity: 1 !important;
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
  /* Notification Styles */
  .notification {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 10000;
    padding: 16px 20px;
    border-radius: var(--radius-lg);
    color: white;
    font-weight: 500;
    font-size: 14px;
    box-shadow: var(--shadow-xl);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    max-width: 400px;
    transform: translateX(100%);
    opacity: 0;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .notification.show {
    transform: translateX(0);
    opacity: 1;
  }
  .notification-content {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .notification-close {
    background: none;
    border: none;
    color: white;
    font-size: 18px;
    cursor: pointer;
    padding: 0;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background 0.2s ease;
  }
  .notification-close:hover {
    background: rgba(255, 255, 255, 0.2);
  }
  .notification-success {
    background: linear-gradient(135deg, var(--success), #059669);
  }
  .notification-error {
    background: linear-gradient(135deg, var(--danger), #dc2626);
  }
  .notification-info {
    background: linear-gradient(135deg, var(--info), #2563eb);
  }
  .notification-warning {
    background: linear-gradient(135deg, var(--warning), #d97706);
  }
</style>
<body data-user-role="{{ Auth::user() && Auth::user()->isAdmin() ? 'admin' : 'user' }}">
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
            <div class="admin-only-links">
            <a href="{{ route('admin.users.index') }}" data-label="User Management">
                <span class="icon"><i class="fas fa-users-cog"></i></span>
                <span class="label">User Management</span>
            </a>
            <a href="{{ route('system-logs.index') }}" data-label="System Logs">
                <span class="icon"><i class="fas fa-clipboard-list"></i></span>
                <span class="label">System Logs</span>
            </a>
            </div>
        </nav>
        <!-- Settings and Logout Buttons -->
        <div style="margin-top: auto; margin-bottom: var(--spacing-lg); display: flex; align-items: center; justify-content: center; gap: 8px;">
            <a href="{{ route('user.sessions') }}" class="settings-btn admin-only-btn" style="display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; padding: 0; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); color: var(--text-secondary); cursor: pointer; transition: var(--transition); font-size: 16px; box-shadow: var(--shadow-sm); flex-shrink: 0; text-decoration: none;" title="Active Sessions">
                <i class="fas fa-desktop"></i>
            </a>
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
                                init() {
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
                // Initialize new charts first
                createMonthlyBooksChart();
                createActiveAreasChart();

                if (!window.christmasEffectsManager) {
                    window.christmasEffectsManager = new ChristmasEffectsManager();
                }
            });
        </script>
    </div>
    <!-- Main Content -->
    <div class="main" id="mainContent">
        <!-- Dashboard Header -->
        <div class="dashboard-title" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <i style="margin-right: 0.5rem;"></i>
                DASHBOARD
            </div>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div id="realTimeClock" style="font-size: 1.2rem; font-weight: 600; color: var(--primary); background: var(--glass-bg); backdrop-filter: var(--glass-blur); -webkit-backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border); border-radius: var(--radius); padding: 0.5rem 1rem; box-shadow: var(--glass-shadow);">
                    Loading...
                </div>
            </div>
        </div>
        <!-- Christmas Toast Container -->
        <div id="christmasToastContainer" style="position: fixed; top: 100px; right: 24px; z-index: 1000; pointer-events: none;"></div>
        <div class="dashboard-content">
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
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary); cursor: pointer;" onclick="sortTable(0)" data-sort="text" class="sortable-header">
                                    <div style="display: flex; align-items: center; gap: 4px;">
                                        Name
                                        <span class="sort-indicator" style="opacity: 0.3; font-size: 0.8rem;">↕</span>
                                    </div>
                                </th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary); cursor: pointer;" onclick="sortTable(1)" data-sort="text" class="sortable-header">
                                    <div style="display: flex; align-items: center; gap: 4px;">
                                        Title
                                        <span class="sort-indicator" style="opacity: 0.3; font-size: 0.8rem;">↕</span>
                                    </div>
                                </th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary); cursor: pointer;" onclick="sortTable(2)" data-sort="date" class="sortable-header">
                                    <div style="display: flex; align-items: center; gap: 4px;">
                                        Borrow Date
                                        <span class="sort-indicator" style="opacity: 0.3; font-size: 0.8rem;">↕</span>
                                    </div>
                                </th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary); cursor: pointer;" onclick="sortTable(3)" data-sort="time" class="sortable-header">
                                    <div style="display: flex; align-items: center; gap: 4px;">
                                        Borrow Time
                                        <span class="sort-indicator" style="opacity: 0.3; font-size: 0.8rem;">↕</span>
                                    </div>
                                </th>
                                <th style="font-size: 1rem; font-weight: 700; color: var(--primary);">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="borrowersTableBody">
                            <tr>
                                <td colspan="5" class="loading">Loading borrowers...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        <!-- Enhanced Member Demographics (Full Width) -->
        <div class="card" style="margin-top: 2rem;">
            <div class="card-header">
                <h3 style="opacity: 1; color: var(--text-muted);">👥 Member Demographics & Stratification</h3>
                <div class="card-actions">
                    <button class="btn btn-sm btn-outline" onclick="refreshDemographicsData()" title="Refresh Data" style="margin-right: 8px;">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <select id="demographicsFilter" class="form-control" style="width: auto; padding: 4px 8px; font-size: 0.8rem;" onchange="switchDemographicsView(this.value)">
                        <option value="julita" selected>Julita Residents (by Barangay)</option>
                        <option value="non-julita">Other Municipalities</option>
                        <option value="overview">Demographics Overview</option>
                    </select>
                </div>
            </div>
            <div style="padding: 1rem;">
                <!-- Overview Statistics -->
                <div id="demographicsOverview" style="display: none;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
                        <div class="stats-subcard" style="text-align: center; padding: 1rem; background: var(--glass-bg); border-radius: var(--radius); border: 1px solid var(--border);">
                            <div class="count" style="font-size: 2rem; margin-bottom: 0.5rem; color: var(--primary);" id="julitaTotalCount">-</div>
                            <p style="margin: 0; color: var(--text-muted); font-weight: 600;">Julita Residents</p>
                            <small style="color: var(--text-secondary);" id="julitaPercentage">-</small>
                        </div>
                        <div class="stats-subcard" style="text-align: center; padding: 1rem; background: var(--glass-bg); border-radius: var(--radius); border: 1px solid var(--border);">
                            <div class="count" style="font-size: 2rem; margin-bottom: 0.5rem; color: var(--secondary);" id="nonJulitaTotalCount">-</div>
                            <p style="margin: 0; color: var(--text-muted); font-weight: 600;">Other Municipalities</p>
                            <small style="color: var(--text-secondary);" id="nonJulitaPercentage">-</small>
                        </div>
                        <div class="stats-subcard" style="text-align: center; padding: 1rem; background: var(--glass-bg); border-radius: var(--radius); border: 1px solid var(--border);">
                            <div class="count" style="font-size: 2rem; margin-bottom: 0.5rem; color: var(--accent);" id="totalMembersCount">-</div>
                            <p style="margin: 0; color: var(--text-muted); font-weight: 600;">Total Members</p>
                            <small style="color: var(--text-secondary);">100%</small>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
                        <div>
                            <h4 style="text-align: center; margin-bottom: 1rem; color: var(--text-primary);">Geographic Distribution</h4>
                            <canvas id="overviewChart" style="max-height: 350px;"></canvas>
                        </div>
                        <div>
                            <h4 style="text-align: center; margin-bottom: 1rem; color: var(--text-primary);">Top 5 Areas</h4>
                            <div id="topAreasList" style="max-height: 350px; overflow-y: auto; padding: 0.5rem; background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border);">
                                <!-- Top areas will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Julita Detailed Breakdown -->
                <div id="julitaDemographics" style="display: block;">
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                        <div>
                            <h4 style="text-align: center; margin-bottom: 1rem; color: var(--text-primary);">Julita Barangay Distribution</h4>
                            <canvas id="barangayChart" style="max-height: 400px;"></canvas>
                        </div>
                        <div>
                            <h4 style="text-align: center; margin-bottom: 1rem; color: var(--text-primary);">Barangay Statistics</h4>
                            <div id="barangayStats" style="max-height: 400px; overflow-y: auto; padding: 0.5rem; background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border);">
                                <!-- Barangay stats will be loaded here -->
                            </div>
                        </div>
                    </div>

                    <!-- Integrated Map Container - DISABLED -->
                    <div style="margin-bottom: 2rem; display: none;">
                        <h4 style="text-align: center; margin-bottom: 1rem; color: var(--text-primary);">Julita Geographic Distribution Map</h4>
                        <div class="map-container-wrapper" style="position: relative;">
                            <div id="julitaMapContainer" class="demographic-map" style="height: 400px; width: 100%; border-radius: var(--radius); border: 1px solid var(--border); background: var(--surface); position: relative; overflow: hidden;">
                                <!-- Map will be loaded here -->
                                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: var(--text-muted);">
                                    <i class="fas fa-map-marked-alt" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                                    <p>Interactive map loading...</p>
                                    <small>Barangay boundaries and member density visualization</small>
                                </div>
                            </div>
                            <!-- Map Controls -->
                            <div class="map-controls" style="position: absolute; top: 10px; right: 10px; display: flex; gap: 5px; z-index: 100;">
                                <button class="btn btn-sm btn-outline" onclick="toggleMapView('julita')" title="Toggle Map View" style="padding: 5px 8px; font-size: 0.8rem;">
                                    <i class="fas fa-map"></i>
                                </button>
                                <button class="btn btn-sm btn-outline" onclick="refreshJulitaMap()" title="Refresh Map" style="padding: 5px 8px; font-size: 0.8rem;">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Barangay Table -->
                    <div style="margin-top: 1rem;">
                        <h4 style="text-align: center; margin-bottom: 1rem; color: var(--text-primary);">Complete Barangay Breakdown</h4>
                        <div style="overflow-x: auto; border-radius: var(--radius); border: 1px solid var(--border);">
                            <table class="data-table" style="min-width: 600px;">
                                <thead>
                                    <tr>
                                        <th>Barangay</th>
                                        <th>Members</th>
                                        <th>Percentage</th>
                                        <th>Age Distribution</th>
                                        <th>Most Active Age Group</th>
                                    </tr>
                                </thead>
                                <tbody id="barangayTableBody">
                                    <tr>
                                        <td colspan="5" class="loading">Loading barangay data...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Non-Julita Municipalities -->
                <div id="nonJulitaDemographics" style="display: none;">
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                        <div>
                            <h4 style="text-align: center; margin-bottom: 1rem; color: var(--text-primary);">Other Municipalities Distribution</h4>
                            <canvas id="municipalityChart" style="max-height: 400px;"></canvas>
                        </div>
                        <div>
                            <h4 style="text-align: center; margin-bottom: 1rem; color: var(--text-primary);">Municipality Statistics</h4>
                            <div id="municipalityStats" style="max-height: 400px; overflow-y: auto; padding: 0.5rem; background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border);">
                                <!-- Municipality stats will be loaded here -->
                            </div>
                        </div>
                    </div>

                    <!-- Integrated Map Container for Non-Julita Areas - DISABLED -->
                    <div style="margin-bottom: 2rem; display: none;">
                        <h4 style="text-align: center; margin-bottom: 1rem; color: var(--text-primary);">Geographic Distribution Map (Outside Julita)</h4>
                        <div class="map-container-wrapper" style="position: relative;">
                            <div id="nonJulitaMapContainer" class="demographic-map" style="height: 400px; width: 100%; border-radius: var(--radius); border: 1px solid var(--border); background: var(--surface); position: relative; overflow: hidden;">
                                <!-- Map will be loaded here -->
                                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: var(--text-muted);">
                                    <i class="fas fa-map-marked-alt" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                                    <p>Interactive map loading...</p>
                                    <small>Municipality locations and member density visualization</small>
                                </div>
                            </div>
                            <!-- Map Controls -->
                            <div class="map-controls" style="position: absolute; top: 10px; right: 10px; display: flex; gap: 5px; z-index: 100;">
                                <button class="btn btn-sm btn-outline" onclick="toggleMapView('non-julita')" title="Toggle Map View" style="padding: 5px 8px; font-size: 0.8rem;">
                                    <i class="fas fa-map"></i>
                                </button>
                                <button class="btn btn-sm btn-outline" onclick="refreshNonJulitaMap()" title="Refresh Map" style="padding: 5px 8px; font-size: 0.8rem;">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Municipality Table -->
                    <div style="margin-top: 1rem;">
                        <h4 style="text-align: center; margin-bottom: 1rem; color: var(--text-primary);">Complete Municipality Breakdown</h4>
                        <div style="overflow-x: auto; border-radius: var(--radius); border: 1px solid var(--border);">
                            <table class="data-table" style="min-width: 600px;">
                                <thead>
                                    <tr>
                                        <th>Municipality/City</th>
                                        <th>Province</th>
                                        <th>Members</th>
                                        <th>Percentage</th>
                                        <th>Age Distribution</th>
                                    </tr>
                                </thead>
                                <tbody id="municipalityTableBody">
                                    <tr>
                                        <td colspan="5" class="loading">Loading municipality data...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Activity Analytics Charts Side by Side -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 2rem;">
            <!-- Comparative Book Borrowing Analytics Chart -->
            <div class="card">
                <div class="card-header">
                    <h3 style="opacity: 1; color: var(--text-muted);">📊 Book Borrowing Frequency Comparison</h3>
                    <div class="card-actions">
                        <select id="monthlyChartMonthFilter" class="form-control" style="width: auto; padding: 6px 12px; font-size: 0.85rem;" onchange="updateMonthlyChart()">
                            <option value="current" selected>Current Month</option>
                            <option value="last">Last Month</option>
                        </select>
                    </div>
                </div>
                <div style="padding: 1rem;">
                    <div class="chart-container-fixed" style="height: 310px;">
                        <canvas id="monthlyBooksChart"></canvas>
                    </div>
                </div>
            </div>
            <!-- Most Active Barangay & Municipality Chart -->
            <div class="card">
                <div class="card-header">
                    <h3 style="opacity: 1; color: var(--text-muted);">📊 Most Active Barangay & Municipality</h3>
                    <div class="card-actions">
                        <select id="activeAreasFilter" class="form-control" style="width: auto; padding: 6px 12px; font-size: 0.85rem;" onchange="filterActiveAreas(this.value)">
                            <option value="all">All Areas</option>
                            <option value="julita">Julita Only</option>
                            <option value="non-julita">Non-Julita Only</option>
                        </select>
                    </div>
                </div>
                <div style="padding: 1rem;">
                    <div class="chart-container-fixed" style="height: 310px;">
                        <canvas id="activeAreasChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Member Activity & Retention Analytics -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 2rem;">
            <!-- Peak Hours Activity Chart -->
            <div class="card">
                <div class="card-header">
                    <h3 style="opacity: 1; color: var(--text-muted);">🕐 Peak Hours Activity</h3>
                    <div class="card-actions">
                        <select id="peakHoursFilter" class="form-control" style="width: auto; padding: 6px 12px; font-size: 0.85rem;" onchange="updatePeakHoursChart()">
                            <option value="today">Today</option>
                            <option value="week" selected>This Week</option>
                            <option value="month">This Month</option>
                        </select>
                    </div>
                </div>
                <div style="padding: 1rem;">
                    <div class="chart-container-fixed" style="height: 310px;">
                        <canvas id="peakHoursChart"></canvas>
                    </div>
                </div>
            </div>
            <!-- Age Group Activity Chart -->
            <div class="card">
                <div class="card-header">
                    <h3 style="opacity: 1; color: var(--text-muted);">👥 Age Group Visit Frequency</h3>
                    <div class="card-actions">
                        <select id="ageActivityFilter" class="form-control" style="width: auto; padding: 6px 12px; font-size: 0.85rem;" onchange="updateAgeActivityChart()">
                            <option value="week" selected>This Week</option>
                            <option value="month">This Month</option>
                            <option value="quarter">Last 3 Months</option>
                        </select>
                    </div>
                </div>
                <div style="padding: 1rem;">
                    <div class="chart-container-fixed" style="height: 310px;">
                        <canvas id="ageActivityChart"></canvas>
                    </div>
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
        const monthlyBorrowsData = @json($monthlyBorrows);
        const activeAreasData = @json($activeAreas);
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
        // Enhanced demographics data structure
        const demographicsData = {
            julitaBarangays: {
                'Poblacion District I': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Poblacion District II': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Poblacion District III': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Poblacion District IV': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Alegria': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Anibong': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Aslum': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Balante': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Bongdo': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Bonifacio': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Bugho': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Calbasag': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Caridad': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Cuya-e': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Dita': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Gitabla': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Hindang': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Inawangan': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Jurao': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'San Andres': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'San Pablo': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Santa Cruz': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Santo Niño': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Tagkip': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Tolosahay': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } },
                'Villa Hermosa': { count: 0, ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 } }
            },
            municipalities: {}
        };

        // Load demographics data immediately when the script runs
        loadDemographicsData();

        // Function to switch between demographics views
        function switchDemographicsView(viewType) {
            const overviewView = document.getElementById('demographicsOverview');
            const julitaView = document.getElementById('julitaDemographics');
            const nonJulitaView = document.getElementById('nonJulitaDemographics');
            
            // Hide all views first
            if (overviewView) overviewView.style.display = 'none';
            if (julitaView) julitaView.style.display = 'none';
            if (nonJulitaView) nonJulitaView.style.display = 'none';
            
            if (viewType === 'overview') {
                if (overviewView) overviewView.style.display = 'block';
                loadDemographicsOverview();
            } else if (viewType === 'julita') {
                if (julitaView) julitaView.style.display = 'block';
                loadJulitaDemographics();
            } else if (viewType === 'non-julita') {
                if (nonJulitaView) nonJulitaView.style.display = 'block';
                // Ensure data is loaded before displaying
                if (Object.keys(demographicsData.municipalities).length === 0) {
                    // If no data, try to reload
                    loadDemographicsData().then(() => {
                        loadNonJulitaDemographics();
                    });
                } else {
                    loadNonJulitaDemographics();
                }
            }
        }

        // Load demographics overview
        function loadDemographicsOverview() {
            // Sample data - replace with actual API call
            const julitaTotal = Object.values(demographicsData.julitaBarangays).reduce((sum, brgy) => sum + brgy.count, 0);
            const nonJulitaTotal = Object.values(demographicsData.municipalities).reduce((sum, muni) => sum + muni.count, 0);
            const totalMembers = julitaTotal + nonJulitaTotal;
            
            document.getElementById('julitaTotalCount').textContent = julitaTotal || '0';
            document.getElementById('nonJulitaTotalCount').textContent = nonJulitaTotal || '0';
            document.getElementById('totalMembersCount').textContent = totalMembers || '0';
            
            const julitaPercent = totalMembers > 0 ? ((julitaTotal / totalMembers) * 100).toFixed(1) : '0';
            const nonJulitaPercent = totalMembers > 0 ? ((nonJulitaTotal / totalMembers) * 100).toFixed(1) : '0';
            
            document.getElementById('julitaPercentage').textContent = `${julitaPercent}% of total`;
            document.getElementById('nonJulitaPercentage').textContent = `${nonJulitaPercent}% of total`;
            
            // Create overview chart
            createOverviewChart(julitaTotal, nonJulitaTotal);
            loadTopAreas();
        }

        // Load Julita demographics by barangay
        function loadJulitaDemographics() {
            const barangays = Object.entries(demographicsData.julitaBarangays)
                .filter(([name, data]) => data.count > 0)
                .sort((a, b) => b[1].count - a[1].count);

            // Create barangay chart with delay to ensure DOM is ready
            setTimeout(() => {
                createBarangayChart(barangays);
            }, 100);

            // Maps are disabled - skip initialization

            // Populate barangay statistics
            const statsContainer = document.getElementById('barangayStats');
            statsContainer.innerHTML = barangays.map(([name, data]) => {
                const total = Object.values(demographicsData.julitaBarangays).reduce((sum, brgy) => sum + brgy.count, 0);
                const percentage = total > 0 ? ((data.count / total) * 100).toFixed(1) : '0';
                const topAgeGroup = Object.entries(data.ageGroups).reduce((a, b) => a[1] > b[1] ? a : b)[0];

                return `
                    <div style="padding: 8px 12px; margin-bottom: 8px; background: var(--glass-bg); border-radius: var(--radius); border: 1px solid var(--border);">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 600; color: var(--text-primary);">${name}</span>
                            <span style="background: var(--primary); color: white; padding: 2px 8px; border-radius: 12px; font-size: 0.8rem;">${data.count}</span>
                        </div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;">
                            ${percentage}% of Julita residents • Top age: ${topAgeGroup}
                        </div>
                    </div>
                `;
            }).join('') || '<p style="color: var(--text-muted); text-align: center;">No Julita residents data available</p>';

            // Populate barangay table
            const tableBody = document.getElementById('barangayTableBody');
            tableBody.innerHTML = barangays.map(([name, data]) => {
                const total = Object.values(demographicsData.julitaBarangays).reduce((sum, brgy) => sum + brgy.count, 0);
                const percentage = total > 0 ? ((data.count / total) * 100).toFixed(1) : '0';
                const ageDistribution = Object.entries(data.ageGroups)
                    .filter(([age, count]) => count > 0)
                    .map(([age, count]) => `${age}: ${count}`)
                    .join(', ') || 'No data';
                const topAgeGroup = Object.entries(data.ageGroups).reduce((a, b) => a[1] > b[1] ? a : b)[0];

                return `
                    <tr>
                        <td style="font-weight: 600;">${name}</td>
                        <td>${data.count}</td>
                        <td>${percentage}%</td>
                        <td style="font-size: 0.9rem;">${ageDistribution}</td>
                        <td>${topAgeGroup}</td>
                    </tr>
                `;
            }).join('') || '<tr><td colspan="5" style="text-align: center; color: var(--text-muted);">No barangay data available</td></tr>';
        }

        // Load non-Julita demographics
        function loadNonJulitaDemographics() {
            console.log('Loading non-Julita demographics...');
            console.log('Full demographicsData:', demographicsData);
            console.log('Municipalities object:', demographicsData.municipalities);
            console.log('Municipalities keys:', Object.keys(demographicsData.municipalities || {}));
            
            const municipalities = Object.entries(demographicsData.municipalities || {})
                .filter(([name, data]) => data && data.count > 0)
                .sort((a, b) => b[1].count - a[1].count);
            
            console.log('Filtered municipalities data:', municipalities);
            console.log('Municipalities count:', municipalities.length);
            
            // Create municipality chart
            createMunicipalityChart(municipalities);
            
            // Maps are disabled - skip initialization
            
            // Populate municipality statistics
            const statsContainer = document.getElementById('municipalityStats');
            if (!statsContainer) {
                console.error('municipalityStats container not found');
                return;
            }
            
            if (municipalities.length === 0) {
                statsContainer.innerHTML = '<p style="color: var(--text-muted); text-align: center; padding: 2rem;">No non-Julita members data available</p>';
            } else {
                const total = Object.values(demographicsData.municipalities).reduce((sum, muni) => sum + (muni.count || 0), 0);
                statsContainer.innerHTML = municipalities.map(([name, data]) => {
                    const percentage = total > 0 ? ((data.count / total) * 100).toFixed(1) : '0';
                    
                    return `
                        <div style="padding: 8px 12px; margin-bottom: 8px; background: var(--glass-bg); border-radius: var(--radius); border: 1px solid var(--border);">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <span style="font-weight: 600; color: var(--text-primary);">${name}</span>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);">${data.province || 'Unknown Province'}</div>
                                </div>
                                <span style="background: var(--secondary); color: white; padding: 2px 8px; border-radius: 12px; font-size: 0.8rem;">${data.count}</span>
                            </div>
                            <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;">
                                ${percentage}% of non-Julita members
                            </div>
                        </div>
                    `;
                }).join('');
            }
            
            // Populate municipality table
            const tableBody = document.getElementById('municipalityTableBody');
            if (!tableBody) {
                console.error('municipalityTableBody container not found');
                return;
            }
            
            if (municipalities.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="5" style="text-align: center; color: var(--text-muted); padding: 2rem;">No municipality data available</td></tr>';
            } else {
                const total = Object.values(demographicsData.municipalities).reduce((sum, muni) => sum + (muni.count || 0), 0);
                tableBody.innerHTML = municipalities.map(([name, data]) => {
                    const percentage = total > 0 ? ((data.count / total) * 100).toFixed(1) : '0';
                    const ageDistribution = Object.entries(data.ageGroups || {})
                        .filter(([age, count]) => count > 0)
                        .map(([age, count]) => `${age}: ${count}`)
                        .join(', ') || 'No data';
                    
                    return `
                        <tr>
                            <td style="font-weight: 600;">${name}</td>
                            <td>${data.province || 'Unknown'}</td>
                            <td>${data.count}</td>
                            <td>${percentage}%</td>
                            <td style="font-size: 0.9rem;">${ageDistribution}</td>
                        </tr>
                    `;
                }).join('');
            }
        }

        // Create overview pie chart
        function createOverviewChart(julitaTotal, nonJulitaTotal) {
            const ctx = document.getElementById('overviewChart');
            if (!ctx) {
                console.error('Overview chart canvas not found');
                return;
            }

            try {
                // Destroy existing chart if any
                if (window.overviewChartInstance) {
                    window.overviewChartInstance.destroy();
                }

                window.overviewChartInstance = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Julita Residents', 'Other Municipalities'],
                        datasets: [{
                            data: [julitaTotal, nonJulitaTotal],
                            backgroundColor: [
                                'rgba(99, 102, 241, 0.8)',
                                'rgba(139, 92, 246, 0.8)'
                            ],
                            borderColor: [
                                'rgba(99, 102, 241, 1)',
                                'rgba(139, 92, 246, 1)'
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    color: document.body.classList.contains('dark-mode') ? '#FFFFFF' : undefined
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const total = julitaTotal + nonJulitaTotal;
                                        const percentage = total > 0 ? ((context.raw / total) * 100).toFixed(1) : '0';
                                        return `${context.label}: ${context.raw} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating overview chart:', error);
            }
        }

        // Create barangay chart
        function createBarangayChart(barangays) {
            const ctx = document.getElementById('barangayChart');
            if (!ctx) {
                console.error('Barangay chart canvas not found');
                return;
            }

            // Check if Chart.js is loaded
            if (typeof Chart === 'undefined') {
                console.error('Chart.js not loaded');
                return;
            }

            // Check if canvas is visible
            if (ctx.offsetParent === null) {
                console.warn('Barangay chart canvas not visible');
                return;
            }

            try {
                // Destroy existing chart if any
                if (window.barangayChartInstance) {
                    window.barangayChartInstance.destroy();
                }

                const labels = barangays.map(([name]) => name);
                const data = barangays.map(([, data]) => data.count);

                window.barangayChartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Members',
                            data: data,
                            backgroundColor: 'rgba(99, 102, 241, 0.7)',
                            borderColor: 'rgba(99, 102, 241, 1)',
                            borderWidth: 1,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        indexAxis: 'x', // Vertical bars
                        responsive: true,
                        maintainAspectRatio: false,
                        maxBarThickness: 15, // More narrow bar width
                        categoryPercentage: 0.8, // Moderate category width
                        barPercentage: 0.35, // More narrow bar width within category
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    color: document.body.classList.contains('dark-mode') ? '#FFFFFF' : undefined
                                },
                                title: {
                                    display: true,
                                    text: 'Members',
                                    color: document.body.classList.contains('dark-mode') ? '#FFFFFF' : undefined,
                                    font: {
                                        weight: 'bold',
                                        size: 14
                                    },
                                    padding: { bottom: 10 }
                                }
                            },
                            x: {
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 45,
                                    color: document.body.classList.contains('dark-mode') ? '#FFFFFF' : undefined
                                },
                                title: {
                                    display: true,
                                    text: 'Barangay',
                                    color: document.body.classList.contains('dark-mode') ? '#FFFFFF' : undefined,
                                    font: {
                                        weight: 'bold',
                                        size: 14
                                    },
                                    padding: { top: 10 }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    title: function(context) {
                                        return context[0].label;
                                    },
                                    label: function(context) {
                                        const total = data.reduce((sum, val) => sum + val, 0);
                                        const percentage = total > 0 ? ((context.raw / total) * 100).toFixed(1) : '0';
                                        return `Members: ${context.raw} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating barangay chart:', error);
            }
        }

        // Create barangay chart
        function createBarangayChart(barangays) {
            const ctx = document.getElementById('barangayChart');
            if (!ctx) {
                console.error('Barangay chart canvas not found');
                return;
            }

            try {
                // Destroy existing chart if any
                if (window.barangayChartInstance) {
                    window.barangayChartInstance.destroy();
                }

                const labels = barangays.map(([name]) => name);
                const data = barangays.map(([, data]) => data.count);

                window.barangayChartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Members',
                            data: data,
                            backgroundColor: 'rgba(99, 102, 241, 0.7)',
                            borderColor: 'rgba(99, 102, 241, 1)',
                            borderWidth: 1,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        indexAxis: 'x', // Vertical bars
                        responsive: true,
                        maintainAspectRatio: false,
                        maxBarThickness: 45, // Moderate bar width
                        categoryPercentage: 0.75, // Moderate category width
                        barPercentage: 0.85, // Moderate bar width within category
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            },
                            x: {
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 45
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    title: function(context) {
                                        return context[0].label;
                                    },
                                    label: function(context) {
                                        const total = data.reduce((sum, val) => sum + val, 0);
                                        const percentage = total > 0 ? ((context.raw / total) * 100).toFixed(1) : '0';
                                        return `Members: ${context.raw} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating barangay chart:', error);
            }
        }

        // Create municipality chart
        function createMunicipalityChart(municipalities) {
            const ctx = document.getElementById('municipalityChart');
            if (!ctx) return;
            
            // Destroy existing chart if any - check both window instance and canvas chart property
            if (window.municipalityChartInstance) {
                window.municipalityChartInstance.destroy();
                window.municipalityChartInstance = null;
            }
            
            // Also check if Chart.js has attached a chart instance to the canvas
            if (ctx.chart) {
                ctx.chart.destroy();
                ctx.chart = null;
            }
            
            // Use Chart.getChart to find any existing chart on this canvas
            const existingChart = Chart.getChart(ctx);
            if (existingChart) {
                existingChart.destroy();
            }
            
            const labels = municipalities.map(([name]) => name);
            const data = municipalities.map(([, data]) => data.count);
            
            window.municipalityChartInstance = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: [
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(34, 197, 94, 0.8)',
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(168, 85, 247, 0.8)',
                            'rgba(236, 72, 153, 0.8)',
                            'rgba(20, 184, 166, 0.8)',
                            'rgba(251, 146, 60, 0.8)'
                        ],
                        borderColor: 'rgba(255, 255, 255, 0.2)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                padding: 15,
                                usePointStyle: true,
                                font: {
                                    size: 11
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = data.reduce((sum, val) => sum + val, 0);
                                    const percentage = total > 0 ? ((context.raw / total) * 100).toFixed(1) : '0';
                                    return `${context.label}: ${context.raw} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // ===== UNIFIED DATA SOURCE =====
        // Enhanced caching system for analytics data
        class AnalyticsCache {
            constructor() {
                this.cache = new Map();
                this.cacheTimeout = 5 * 60 * 1000; // 5 minutes
            }

            set(key, data) {
                this.cache.set(key, {
                    data,
                    timestamp: Date.now()
                });
            }

            get(key) {
                const cached = this.cache.get(key);
                if (cached && (Date.now() - cached.timestamp) < this.cacheTimeout) {
                    return cached.data;
                }
                this.cache.delete(key);
                return null;
            }

            clear() {
                this.cache.clear();
            }
        }

        const analyticsCache = new AnalyticsCache();

        // ===== ENHANCED API FUNCTIONS =====
        // Fetch Monthly Books Data from Backend with improved error handling
        async function fetchMonthlyBorrowsData(forceRefresh = false) {
            const cacheKey = 'monthlyBorrows';

            if (!forceRefresh) {
                const cached = analyticsCache.get(cacheKey);
                if (cached) {
                    console.log('📊 Using cached monthly borrows data');
                    return cached;
                }
            }

            try {
                console.log('🔄 Fetching fresh monthly borrows data...');
                const response = await fetch('/api/analytics/monthly-borrows', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Cache-Control': 'no-cache'
                    },
                    credentials: 'same-origin'
                });

                if (response.ok) {
                    const data = await response.json();
                    console.log('✅ Fetched monthly borrows data:', data);

                    // Validate data structure
                    if (this.validateMonthlyData(data)) {
                        analyticsCache.set(cacheKey, data);
                        return data;
                    } else {
                        console.warn('⚠️ Invalid data structure, using fallback');
                        return getFallbackMonthlyData();
                    }
                } else {
                    console.warn(`⚠️ API returned ${response.status}, using fallback`);
                    return getFallbackMonthlyData();
                }
            } catch (error) {
                console.error('❌ Error fetching monthly borrows data:', error);
                return getFallbackMonthlyData();
            }
        }

        // Validate monthly data structure
        function validateMonthlyData(data) {
            return data &&
                   Array.isArray(data.labels) &&
                   Array.isArray(data.data) &&
                   data.labels.length === data.data.length &&
                   data.labels.length > 0;
        }

        // Enhanced fallback data for monthly borrows
        function getFallbackMonthlyData() {
            const currentDate = new Date();
            const currentYear = currentDate.getFullYear();
            const labels = [];
            const data = [];

            // Generate last 12 months
            for (let i = 11; i >= 0; i--) {
                const date = new Date(currentYear, currentDate.getMonth() - i, 1);
                const monthName = date.toLocaleDateString('en-US', { month: 'short', year: '2-digit' });
                labels.push(monthName);
                data.push(0); // Default to 0 for fallback
            }

            return { labels, data };
        }

        // Fetch Active Areas Data from Backend with enhanced caching
        async function fetchActiveAreasData(forceRefresh = false) {
            const cacheKey = 'activeAreas';

            if (!forceRefresh) {
                const cached = analyticsCache.get(cacheKey);
                if (cached) {
                    console.log('📊 Using cached active areas data');
                    return cached;
                }
            }

            try {
                console.log('🔄 Fetching fresh active areas data...');
                const response = await fetch('/api/analytics/active-areas', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Cache-Control': 'no-cache'
                    },
                    credentials: 'same-origin'
                });

                if (response.ok) {
                    const data = await response.json();
                    console.log('✅ Fetched active areas data:', data);

                    // Validate and structure data
                    if (this.validateActiveAreasData(data)) {
                        analyticsCache.set(cacheKey, data);
                        return data;
                    } else {
                        console.warn('⚠️ Invalid active areas data structure, using fallback');
                        return getFallbackActiveAreasData();
                    }
                } else {
                    console.warn(`⚠️ API returned ${response.status}, using fallback`);
                    return getFallbackActiveAreasData();
                }
            } catch (error) {
                console.error('❌ Error fetching active areas data:', error);
                return getFallbackActiveAreasData();
            }
        }

        // Validate active areas data structure
        function validateActiveAreasData(data) {
            return data &&
                   Array.isArray(data.labels) &&
                   Array.isArray(data.data) &&
                   data.labels.length === data.data.length &&
                   data.labels.length > 0;
        }

        // Enhanced fallback data for active areas
        function getFallbackActiveAreasData() {
            return {
                labels: ['No Activity Data'],
                data: [0]
            };
        }

        // ===== CHART LOADING & ERROR HANDLING =====
        // Show loading state on chart canvas
        function showChartLoading(canvas, message = 'Loading...') {
            const ctx = canvas.getContext('2d');
            const centerX = canvas.width / 2;
            const centerY = canvas.height / 2;

            // Clear canvas
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Set background
            ctx.fillStyle = 'var(--surface, #ffffff)';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Draw loading text
            ctx.fillStyle = 'var(--text-muted, #64748b)';
            ctx.font = '14px Outfit, Inter, sans-serif';
            ctx.textAlign = 'center';
            ctx.fillText(message, centerX, centerY);

            // Draw spinner
            ctx.save();
            ctx.translate(centerX, centerY - 30);
            ctx.beginPath();
            ctx.arc(0, 0, 10, 0, 2 * Math.PI);
            ctx.strokeStyle = 'var(--primary, #6366f1)';
            ctx.lineWidth = 2;
            ctx.stroke();

            // Animated arc
            const time = Date.now() * 0.005;
            ctx.beginPath();
            ctx.arc(0, 0, 10, time, time + Math.PI);
            ctx.strokeStyle = 'var(--accent, #06b6d4)';
            ctx.stroke();
            ctx.restore();
        }

        // Clear loading state
        function clearChartLoading(canvas) {
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }

        // Show error state on chart canvas
        function showChartError(canvas, message = 'Error loading chart') {
            const ctx = canvas.getContext('2d');
            const centerX = canvas.width / 2;
            const centerY = canvas.height / 2;

            // Clear canvas
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Set background
            ctx.fillStyle = 'var(--surface, #ffffff)';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Draw error icon
            ctx.fillStyle = 'var(--danger, #ef4444)';
            ctx.font = '24px Arial';
            ctx.textAlign = 'center';
            ctx.fillText('⚠️', centerX, centerY - 20);

            // Draw error text
            ctx.fillStyle = 'var(--text-primary, #1e293b)';
            ctx.font = '14px Outfit, Inter, sans-serif';
            ctx.fillText(message, centerX, centerY + 10);

            // Draw retry hint
            ctx.fillStyle = 'var(--text-muted, #64748b)';
            ctx.font = '12px Outfit, Inter, sans-serif';
            ctx.fillText('Please refresh the page', centerX, centerY + 30);
        }

        // ===== THEME-AWARE CHART COLORS =====
        function getChartThemeColors() {
            const isDark = document.body.classList.contains('dark-mode');
            return {
                primary: isDark ? 'rgba(139, 92, 246, 1)' : 'rgba(99, 102, 241, 1)',
                primaryLight: isDark ? 'rgba(139, 92, 246, 0.2)' : 'rgba(99, 102, 241, 0.1)',
                text: isDark ? 'rgba(255, 255, 255, 0.8)' : 'rgba(0, 0, 0, 0.8)',
                grid: isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)',
                tooltipBg: 'rgba(0, 0, 0, 0.9)',
                tooltipText: '#ffffff'
            };
        }

        // Generate bell curve data for time distribution visualization
        function generateBellCurve(data) {
            const n = data.length;
            if (n === 0) return [];

            // Find the peak hour and its value
            const maxValue = Math.max(...data);
            const peakIndex = data.indexOf(maxValue);

            // Create a bell curve centered around the peak hour
            const bellCurve = [];
            const stdDev = 3; // Controls the width of the bell curve

            for (let i = 0; i < n; i++) {
                // Calculate distance from peak (in hours)
                const distance = Math.abs(i - peakIndex);
                // Normalize distance
                const normalizedDistance = distance / stdDev;

                // Bell curve formula: e^(-0.5 * x^2)
                const bellValue = Math.exp(-0.5 * normalizedDistance * normalizedDistance);

                // Scale by the actual data value at this point, but ensure minimum visibility
                const actualValue = data[i] || 0.1; // Minimum value to show something
                const scaledValue = bellValue * actualValue * 1.5; // Boost for better visualization

                bellCurve.push(scaledValue);
            }

            // Apply additional smoothing for a more natural curve
            const smoothed = [];
            for (let i = 0; i < n; i++) {
                let sum = 0;
                let count = 0;
                const smoothingRadius = 1; // Smooth with neighboring points

                for (let j = Math.max(0, i - smoothingRadius); j <= Math.min(n - 1, i + smoothingRadius); j++) {
                    sum += bellCurve[j];
                    count++;
                }

                smoothed.push(sum / count);
            }

            return smoothed;
        }

        // ===== PEAK HOURS ACTIVITY CHART =====
        async function createPeakHoursChart(filterValue = 'week', forceRefresh = false) {
            const ctx = document.getElementById('peakHoursChart');
            if (!ctx) {
                console.error('❌ Peak hours chart canvas not found');
                return;
            }

            if (typeof Chart === 'undefined') {
                console.error('❌ Chart.js not loaded');
                return;
            }

            // Destroy existing chart
            if (window.peakHoursChartInstance) {
                window.peakHoursChartInstance.destroy();
                window.peakHoursChartInstance = null;
            }

            showChartLoading(ctx, 'Loading peak hours data...');

            try {
                const peakHoursData = await fetchPeakHoursData(filterValue);
                clearChartLoading(ctx);

                if (!peakHoursData || !peakHoursData.labels || !peakHoursData.data) {
                    console.error('❌ Invalid peak hours data:', peakHoursData);
                    showChartError(ctx, 'No peak hours data available');
                    return;
                }

                const totalVisits = peakHoursData.data.reduce((sum, val) => sum + val, 0);
                console.log('📊 Creating peak hours chart with:', {
                    hours: peakHoursData.labels.length,
                    totalVisits
                });

                const colors = getChartThemeColors();
                const isDarkMode = document.body.classList.contains('dark-mode');

                const chartData = {
                    labels: peakHoursData.labels,
                    datasets: [{
                        label: `Visits (${filterValue === 'today' ? 'Today' : filterValue === 'week' ? 'This Week' : 'This Month'})`,
                        data: peakHoursData.data,
                        backgroundColor: peakHoursData.data.map((value, index) => {
                            // Color intensity based on visit count
                            const maxValue = Math.max(...peakHoursData.data);
                            const intensity = maxValue > 0 ? (value / maxValue) : 0;
                            const baseColor = isDarkMode ? [139, 92, 246] : [99, 102, 241]; // Purple/Blue
                            const r = Math.round(baseColor[0] + (intensity * 50));
                            const g = Math.round(baseColor[1] + (intensity * 50));
                            const b = Math.round(baseColor[2] + (intensity * 50));
                            return `rgba(${r}, ${g}, ${b}, 0.8)`;
                        }),
                        borderColor: peakHoursData.data.map((value, index) => {
                            const maxValue = Math.max(...peakHoursData.data);
                            const intensity = maxValue > 0 ? (value / maxValue) : 0;
                            const baseColor = isDarkMode ? [139, 92, 246] : [99, 102, 241];
                            const r = Math.round(baseColor[0] + (intensity * 50));
                            const g = Math.round(baseColor[1] + (intensity * 50));
                            const b = Math.round(baseColor[2] + (intensity * 50));
                            return `rgba(${r}, ${g}, ${b}, 1)`;
                        }),
                        borderWidth: 2,
                        borderRadius: 6,
                        borderSkipped: false
                    }]
                };

                // Generate bell curve data from the actual data
                const bellCurveData = generateBellCurve(peakHoursData.data);

                const bellCurveChartData = {
                    labels: peakHoursData.labels,
                    datasets: [{
                        label: `Visit Distribution (${filterValue === 'today' ? 'Today' : filterValue === 'week' ? 'This Week' : 'This Month'})`,
                        data: bellCurveData,
                        borderColor: 'rgba(99, 102, 241, 1)',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 2,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: 'rgba(99, 102, 241, 1)',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 2
                    }]
                };

                window.peakHoursChartInstance = new Chart(ctx, {
                    type: 'line',
                    data: bellCurveChartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.9)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                borderColor: 'rgba(99, 102, 241, 0.5)',
                                borderWidth: 1,
                                cornerRadius: 8,
                                padding: 12,
                                callbacks: {
                                    title: function(context) {
                                        return `🕐 ${context[0].label}`;
                                    },
                                    label: function(context) {
                                        const bellValue = context.raw;
                                        const actualValue = peakHoursData.data[context.dataIndex];
                                        return `📊 Distribution: ${bellValue.toFixed(1)} • Actual: ${actualValue} visits`;
                                    },
                                    footer: function(context) {
                                        const maxBell = Math.max(...bellCurveData);
                                        const maxIndex = bellCurveData.indexOf(maxBell);
                                        const peakHour = peakHoursData.labels[maxIndex];
                                        const actualPeak = Math.max(...peakHoursData.data);
                                        return `🔥 Peak: ${peakHour} (${actualPeak} visits)`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value.toFixed(1);
                                    },
                                    color: isDarkMode ? '#FFFFFF' : 'var(--text-secondary)',
                                    font: { size: 12 }
                                },
                                title: {
                                    display: true,
                                    text: 'Visit Distribution',
                                    color: isDarkMode ? '#FFFFFF' : 'var(--text-primary)',
                                    font: {
                                        weight: 'bold',
                                        size: 14
                                    },
                                    padding: { bottom: 10 }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                    drawBorder: false
                                }
                            },
                            x: {
                                ticks: {
                                    color: isDarkMode ? '#FFFFFF' : 'var(--text-secondary)',
                                    font: { size: 11 }
                                },
                                title: {
                                    display: true,
                                    text: 'Hour of Day',
                                    color: isDarkMode ? '#FFFFFF' : 'var(--text-primary)',
                                    font: {
                                        weight: 'bold',
                                        size: 14
                                    },
                                    padding: { top: 10 }
                                },
                                grid: { display: false }
                            }
                        },
                        animation: {
                            duration: 1500,
                            easing: 'easeInOutQuart'
                        },
                        onHover: function(event, elements) {
                            event.native.target.style.cursor = elements.length > 0 ? 'pointer' : 'default';
                        }
                    }
                });

                console.log('✅ Peak hours chart created successfully');

            } catch (error) {
                console.error('❌ Error creating peak hours chart:', error);
                clearChartLoading(ctx);
                showChartError(ctx, 'Failed to load peak hours data');
            }
        }

        // ===== AGE GROUP ACTIVITY CHART =====
        async function createAgeActivityChart(filterValue = 'week', forceRefresh = false) {
            const ctx = document.getElementById('ageActivityChart');
            if (!ctx) {
                console.error('❌ Age activity chart canvas not found');
                return;
            }

            if (typeof Chart === 'undefined') {
                console.error('❌ Chart.js not loaded');
                return;
            }

            // Destroy existing chart
            if (window.ageActivityChartInstance) {
                window.ageActivityChartInstance.destroy();
                window.ageActivityChartInstance = null;
            }

            showChartLoading(ctx, 'Loading age activity data...');

            try {
                const ageActivityData = await fetchAgeActivityData(filterValue);
                clearChartLoading(ctx);

                if (!ageActivityData || !ageActivityData.labels || !ageActivityData.datasets) {
                    console.error('❌ Invalid age activity data:', ageActivityData);
                    showChartError(ctx, 'No age activity data available');
                    return;
                }

                console.log('📊 Creating age activity chart with:', {
                    ageGroups: ageActivityData.labels.length,
                    datasets: ageActivityData.datasets.length
                });

                const colors = getChartThemeColors();
                const isDarkMode = document.body.classList.contains('dark-mode');

                // Enhanced color palette for age groups
                const ageGroupColors = [
                    'rgba(239, 68, 68, 0.8)',   // Red - 18-25
                    'rgba(245, 158, 11, 0.8)',  // Orange - 26-35
                    'rgba(34, 197, 94, 0.8)',   // Green - 36-50
                    'rgba(99, 102, 241, 0.8)'   // Blue - 50+
                ];

                const borderColors = [
                    'rgba(239, 68, 68, 1)',
                    'rgba(245, 158, 11, 1)',
                    'rgba(34, 197, 94, 1)',
                    'rgba(99, 102, 241, 1)'
                ];

                window.ageActivityChartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ageActivityData.labels,
                        datasets: ageActivityData.datasets.map((dataset, index) => ({
                            ...dataset,
                            backgroundColor: ageGroupColors[index % ageGroupColors.length],
                            borderColor: borderColors[index % borderColors.length],
                            borderWidth: 2,
                            borderRadius: 6,
                            borderSkipped: false
                        }))
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'x',
                        maxBarThickness: 50,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20,
                                    color: isDarkMode ? '#FFFFFF' : 'var(--text-primary)',
                                    font: { size: 12 }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.9)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                borderColor: 'rgba(99, 102, 241, 0.5)',
                                borderWidth: 1,
                                cornerRadius: 8,
                                padding: 12,
                                callbacks: {
                                    title: function(context) {
                                        return `👥 ${context[0].label}`;
                                    },
                                    label: function(context) {
                                        const dataset = context.dataset;
                                        const value = context.raw;
                                        const total = ageActivityData.datasets.reduce((sum, ds) =>
                                            sum + (ds.data[context.dataIndex] || 0), 0);
                                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : '0';
                                        return `${dataset.label}: ${value} (${percentage}%)`;
                                    },
                                    footer: function(context) {
                                        const ageGroup = context[0].label;
                                        const totalVisits = ageActivityData.datasets[0].data[context[0].dataIndex] || 0;
                                        const avgDuration = ageActivityData.datasets[1]?.data[context[0].dataIndex] || 0;
                                        return `📊 Total: ${totalVisits} visits • Avg: ${avgDuration}min`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    callback: function(value) {
                                        return Number.isInteger(value) ? value : '';
                                    },
                                    color: isDarkMode ? '#FFFFFF' : 'var(--text-secondary)',
                                    font: { size: 12 }
                                },
                                title: {
                                    display: true,
                                    text: 'Activity Level',
                                    color: isDarkMode ? '#FFFFFF' : 'var(--text-primary)',
                                    font: {
                                        weight: 'bold',
                                        size: 14
                                    },
                                    padding: { bottom: 10 }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                    drawBorder: false
                                }
                            },
                            x: {
                                ticks: {
                                    color: isDarkMode ? '#FFFFFF' : 'var(--text-secondary)',
                                    font: { size: 11 }
                                },
                                title: {
                                    display: true,
                                    text: 'Age Groups',
                                    color: isDarkMode ? '#FFFFFF' : 'var(--text-primary)',
                                    font: {
                                        weight: 'bold',
                                        size: 14
                                    },
                                    padding: { top: 10 }
                                },
                                grid: { display: false }
                            }
                        },
                        animation: {
                            duration: 1200,
                            easing: 'easeInOutQuart',
                            delay: function(context) {
                                return context.dataIndex * 100;
                            }
                        },
                        onHover: function(event, elements) {
                            event.native.target.style.cursor = elements.length > 0 ? 'pointer' : 'default';
                        }
                    }
                });

                console.log('✅ Age activity chart created successfully');

            } catch (error) {
                console.error('❌ Error creating age activity chart:', error);
                clearChartLoading(ctx);
                showChartError(ctx, 'Failed to load age activity data');
            }
        }

        // ===== ENHANCED CHART CREATION =====
        // Create Monthly Books Chart (Comparative Analytics for Book Borrowing Frequency)
        async function createMonthlyBooksChart(filterValue = 'current', forceRefresh = false) {
            const ctx = document.getElementById('monthlyBooksChart');
            if (!ctx) {
                console.error('❌ Monthly books chart canvas not found');
                return;
            }

            if (typeof Chart === 'undefined') {
                console.error('❌ Chart.js not loaded');
                return;
            }

            // Destroy existing chart
            if (window.monthlyBooksChartInstance) {
                window.monthlyBooksChartInstance.destroy();
                window.monthlyBooksChartInstance = null;
            }

            try {
                // Fetch comparative book borrowing data
                const comparativeData = await fetchComparativeBookData(filterValue);

                if (!comparativeData || !comparativeData.books || comparativeData.books.length === 0) {
                    console.error('❌ No comparative book data available');
                    showChartError(ctx, 'No book borrowing data available');
                    return;
                }

                const colors = getChartThemeColors();
                const isDarkMode = document.body.classList.contains('dark-mode');

                // Get month name for display
                const now = new Date();
                let monthName = '';
                if (filterValue === 'current') {
                    monthName = now.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
                } else if (filterValue === 'last') {
                    const lastMonthDate = new Date(now.getFullYear(), now.getMonth() - 1, 1);
                    monthName = lastMonthDate.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
                }

                console.log('📊 Creating comparative book borrowing chart with:', {
                    books: comparativeData.books.length,
                    totalBorrows: comparativeData.totalBorrows,
                    filter: filterValue,
                    month: monthName
                });

                // Generate gradient colors for each book
                const backgroundColors = comparativeData.books.map((book, index) => {
                    const hue = Math.floor(360 * (index / comparativeData.books.length));
                    return `hsla(${hue}, 75%, 60%, 0.7)`;
                });

                const borderColors = comparativeData.books.map((book, index) => {
                    const hue = Math.floor(360 * (index / comparativeData.books.length));
                    return `hsla(${hue}, 75%, 50%, 1)`;
                });

                const chartData = {
                    labels: comparativeData.books.map(book => book.title),
                    datasets: [{
                        label: `Borrowing Frequency${monthName ? ` (${monthName})` : ''}`,
                        data: comparativeData.books.map(book => book.borrow_count),
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 2,
                        borderRadius: 6,
                        borderSkipped: false
                    }]
                };

                window.monthlyBooksChartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'x',
                        maxBarThickness: 50, // Limit bar width
                        categoryPercentage: 0.6, // Reduce category width (space allocated to each bar group)
                        barPercentage: 0.7, // Reduce bar width within category // Vertical bars - quantity on vertical axis, book titles on horizontal
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.9)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                borderColor: 'rgba(99, 102, 241, 0.5)',
                                borderWidth: 1,
                                cornerRadius: 8,
                                padding: 9,
                                callbacks: {
                                    title: function(context) {
                                        return `📚 ${context[0].label}`;
                                    },
                                    label: function(context) {
                                        const book = comparativeData.books[context.dataIndex];
                                        const percentage = comparativeData.totalBorrows > 0
                                            ? ((book.borrow_count / comparativeData.totalBorrows) * 100).toFixed(1)
                                            : '0';
                                        return `📖 ${book.borrow_count} borrows (${percentage}% of total)`;
                                    },
                                    footer: function(context) {
                                        const book = comparativeData.books[context[0].dataIndex];
                                        return `📝 Author: ${book.author || 'Unknown'}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    callback: function(value) {
                                        return Number.isInteger(value) ? value : '';
                                    },
                                    color: isDarkMode ? '#FFFFFF' : 'var(--text-secondary)',
                                    font: { size: 12 }
                                },
                                title: {
                                    display: true,
                                    text: 'Number of Borrows',
                                    color: isDarkMode ? '#FFFFFF' : 'var(--text-primary)',
                                    font: {
                                        weight: 'bold',
                                        size: 14
                                    },
                                    padding: { bottom: 10 }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                    drawBorder: false
                                }
                            },
                            x: {
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 45,
                                    autoSkip: false,
                                    color: isDarkMode ? '#FFFFFF' : 'var(--text-secondary)',
                                    font: { size: 11 }
                                },
                                title: {
                                    display: true,
                                    text: 'Book Titles',
                                    color: isDarkMode ? '#FFFFFF' : 'var(--text-primary)',
                                    font: {
                                        weight: 'bold',
                                        size: 14
                                    },
                                    padding: { top: 10 }
                                },
                                grid: { display: false }
                            }
                        },
                        animation: {
                            duration: 1200,
                            easing: 'easeInOutQuart',
                            delay: function(context) {
                                return context.dataIndex * 50;
                            }
                        },
                        onHover: function(event, elements) {
                            event.native.target.style.cursor = elements.length > 0 ? 'pointer' : 'default';
                        }
                    }
                });

                console.log('✅ Comparative book borrowing chart created successfully');

            } catch (error) {
                console.error('❌ Error creating comparative book chart:', error);
                showChartError(ctx, 'Failed to load book data');
            }
        }

        // Fetch comparative book borrowing data
        async function fetchComparativeBookData(filterValue = 'current') {
            try {
                // Calculate the month based on filter
                const now = new Date();
                let month = null;
                if (filterValue === 'current') {
                    month = now.getMonth() + 1; // 1-12
                } else if (filterValue === 'last') {
                    month = now.getMonth() === 0 ? 12 : now.getMonth(); // If Jan, last is Dec (12), else current-1
                }

                // Build URL with month parameter if specified
                let url = '/api/analytics/book-borrowing-frequency';
                if (month) {
                    url += `?month=${month}`;
                }

                // Call the new API endpoint to get real data from the database
                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Cache-Control': 'no-cache'
                    },
                    credentials: 'same-origin'
                });

                if (response.ok) {
                    const data = await response.json();
                    console.log('✅ Fetched book borrowing frequency data:', data);

                    // Validate data structure
                    if (data && data.books && data.totalBorrows !== undefined) {
                        return data;
                    } else {
                        console.warn('⚠️ Invalid data structure from API, using fallback');
                        return getSampleComparativeData();
                    }
                } else {
                    console.warn(`⚠️ API returned ${response.status}, using fallback`);
                    return getSampleComparativeData();
                }
            } catch (error) {
                console.error('❌ Error fetching comparative book data:', error);
                return getSampleComparativeData();
            }
        }

        // Get sample comparative data
        function getSampleComparativeData() {
            return {
                books: [
                    { title: 'Sample Book 1', author: 'Author A', borrow_count: 15 },
                    { title: 'Sample Book 2', author: 'Author B', borrow_count: 12 },
                    { title: 'Sample Book 3', author: 'Author C', borrow_count: 9 },
                    { title: 'Sample Book 4', author: 'Author D', borrow_count: 7 },
                    { title: 'Sample Book 5', author: 'Author E', borrow_count: 5 }
                ],
                totalBorrows: 48
            };
        }

        // Update monthly chart when filter changes
        function updateMonthlyChart() {
            const monthFilter = document.getElementById('monthlyChartMonthFilter');
            if (monthFilter) {
                const selectedMonth = monthFilter.value;
                createMonthlyBooksChart(selectedMonth, true);
            }
        }

        // Create Active Areas Chart (Vertical Bar Graph) with enhanced features
        async function createActiveAreasChart(forceRefresh = false) {
            const ctx = document.getElementById('activeAreasChart');
            if (!ctx) {
                console.error('❌ Active areas chart canvas not found');
                return;
            }

            // Destroy existing chart
            if (window.activeAreasChartInstance) {
                window.activeAreasChartInstance.destroy();
                window.activeAreasChartInstance = null;
            }

            showChartLoading(ctx, 'Loading active areas data...');

            try {
                const activeAreasData = await fetchActiveAreasData(forceRefresh);
                clearChartLoading(ctx);

                if (!activeAreasData || !activeAreasData.labels || !activeAreasData.data) {
                    console.error('❌ Invalid active areas data:', activeAreasData);
                    showChartError(ctx, 'Invalid areas data');
                    return;
                }

                const totalActivities = activeAreasData.data.reduce((sum, val) => sum + val, 0);
                console.log('📊 Creating active areas chart with:', {
                    areas: activeAreasData.labels.length,
                    totalActivities
                });

                // Check for dark mode
                const isDarkMode = document.body.classList.contains('dark-mode');

                // Generate enhanced colors based on activity level and dark mode
                const colors = generateActivityColors(activeAreasData.data, isDarkMode);

                const areasData = {
                    labels: activeAreasData.labels,
                    datasets: [{
                        label: 'Activity Count',
                        data: activeAreasData.data,
                        backgroundColor: colors.background,
                        borderColor: colors.border,
                        borderWidth: 2,
                        borderRadius: 6,
                        borderSkipped: false,
                        hoverBorderWidth: 3,
                        hoverBorderColor: colors.hover
                    }]
                };

                window.activeAreasChartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: areasData,
                    options: {
                        indexAxis: 'x',
                        responsive: true,
                        maintainAspectRatio: false,
                        maxBarThickness: 60,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.9)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                borderColor: 'rgba(139, 92, 246, 0.5)',
                                borderWidth: 1,
                                cornerRadius: 8,
                                padding: 12,
                                callbacks: {
                                    title: function(context) {
                                        return `📍 ${context[0].label}`;
                                    },
                                    label: function(context) {
                                        const value = context.raw;
                                        const percentage = totalActivities > 0 ? ((value / totalActivities) * 100).toFixed(1) : '0';
                                        return `🎯 ${value} activities (${percentage}% of total)`;
                                    },
                                    footer: function(context) {
                                        const value = context[0].raw;
                                        const max = Math.max(...activeAreasData.data);
                                        const rank = activeAreasData.data.indexOf(value) + 1;
                                        return `🏆 Rank #${rank} • Peak: ${max} activities`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    callback: function(value) {
                                        return Number.isInteger(value) ? value : '';
                                    },
                                    color: isDarkMode ? '#FFFFFF' : 'var(--text-secondary)',
                                    font: { size: 12 }
                                },
                                title: {
                                    display: true,
                                    text: 'Activity Count',
                                    color: isDarkMode ? '#FFFFFF' : 'var(--text-primary)',
                                    font: {
                                        weight: 'bold',
                                        size: 14
                                    },
                                    padding: { bottom: 10 }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                    drawBorder: false
                                }
                            },
                            x: {
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 0,
                                    autoSkip: false,
                                    color: isDarkMode ? '#FFFFFF' : 'var(--text-secondary)',
                                    font: { size: 11 }
                                },
                                title: {
                                    display: true,
                                    text: 'Barangay/Municipality',
                                    color: isDarkMode ? '#FFFFFF' : 'var(--text-primary)',
                                    font: {
                                        weight: 'bold',
                                        size: 14
                                    },
                                    padding: { top: 10 }
                                },
                                grid: { display: false }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        animation: {
                            duration: 1200,
                            easing: 'easeInOutQuart',
                            delay: function(context) {
                                return context.dataIndex * 100;
                            }
                        },
                        onHover: function(event, elements) {
                            event.native.target.style.cursor = elements.length > 0 ? 'pointer' : 'default';
                        }
                    }
                });

                console.log('✅ Active areas chart created successfully');

                // Apply current filter after chart creation
                const filterSelect = document.getElementById('activeAreasFilter');
                if (filterSelect) {
                    filterActiveAreas(filterSelect.value);
                }

            } catch (error) {
                console.error('❌ Error creating active areas chart:', error);
                clearChartLoading(ctx);
                showChartError(ctx, 'Failed to load active areas');
            }
        }

        // Enhanced color generation based on activity levels and dark mode
        function generateActivityColors(data, isDarkMode = false) {
            const maxValue = Math.max(...data);
            const minValue = Math.min(...data);
            const backgroundColors = [];
            const borderColors = [];
            const hoverColors = [];

            data.forEach(value => {
                let intensity = 0;
                if (maxValue > minValue) {
                    intensity = (value - minValue) / (maxValue - minValue);
                }

                if (isDarkMode) {
                    // Dark mode: lighter, more vibrant colors
                    const r = Math.round(168 + (intensity * 87));  // 168 to 255 (lighter purple to bright)
                    const g = Math.round(85 + (intensity * 170));   // 85 to 255
                    const b = Math.round(247 + (intensity * 8));    // 247 to 255 (almost white to purple)

                    backgroundColors.push(`rgba(${r}, ${g}, ${b}, 0.9)`);
                    borderColors.push(`rgba(${r}, ${g}, ${b}, 1)`);
                    hoverColors.push(`rgba(${Math.min(r + 30, 255)}, ${Math.min(g + 30, 255)}, ${Math.min(b + 30, 255)}, 1)`);
                } else {
                    // Light mode: original colors
                    const r = Math.round(147 + (intensity * 108)); // 147 to 255
                    const g = Math.round(51 + (intensity * 204));   // 51 to 255
                    const b = Math.round(234 + (intensity * 21));   // 234 to 255

                    backgroundColors.push(`rgba(${r}, ${g}, ${b}, 0.8)`);
                    borderColors.push(`rgba(${r}, ${g}, ${b}, 1)`);
                    hoverColors.push(`rgba(${Math.min(r + 20, 255)}, ${Math.min(g + 20, 255)}, ${Math.min(b + 20, 255)}, 1)`);
                }
            });

            return {
                background: backgroundColors,
                border: borderColors,
                hover: hoverColors
            };
        }

        // Load top areas
        function loadTopAreas() {
            const allAreas = [];
            
            // Add Julita barangays
            Object.entries(demographicsData.julitaBarangays).forEach(([name, data]) => {
                if (data.count > 0) {
                    allAreas.push({ name: name, count: data.count, type: 'Barangay', location: 'Julita' });
                }
            });
            
            // Add municipalities
            Object.entries(demographicsData.municipalities).forEach(([name, data]) => {
                if (data.count > 0) {
                    allAreas.push({ name: name, count: data.count, type: 'Municipality', location: data.province || 'Unknown' });
                }
            });
            
            // Sort by count and take top 5
            const topAreas = allAreas.sort((a, b) => b.count - a.count).slice(0, 5);
            
            const container = document.getElementById('topAreasList');
            container.innerHTML = topAreas.map((area, index) => `
                <div style="display: flex; align-items: center; gap: 12px; padding: 8px 12px; background: var(--glass-bg); border-radius: var(--radius); border: 1px solid var(--border); margin-bottom: 8px;">
                    <div style="width: 24px; height: 24px; background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 600;">
                        ${index + 1}
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 600; color: var(--text-primary); font-size: 0.9rem;">${area.name}</div>
                        <div style="color: var(--text-muted); font-size: 0.8rem;">${area.type} • ${area.location}</div>
                    </div>
                    <div style="background: var(--success); color: white; padding: 2px 8px; border-radius: 12px; font-size: 0.8rem; font-weight: 600;">
                        ${area.count}
                    </div>
                </div>
            `).join('') || '<p style="color: var(--text-muted); text-align: center; margin: 2rem 0;">No area data available</p>';
        }

        // Function to load real data from API
        async function loadDemographicsData() {
            console.log('Loading demographics data from API...');
            try {
                const response = await fetch('/api/members/demographics', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                });
                console.log('API Response status:', response.status);

                if (response.ok) {
                    const data = await response.json();
                    console.log('API Response data:', data);
                    processDemographicsData(data);
                } else {
                    console.warn('Failed to load demographics data (HTTP ' + response.status + ')');
                }
            } catch (error) {
                console.error('Error loading demographics data:', error);
            }

            // Always refresh the current view after loading data
            const currentView = document.getElementById('demographicsFilter')?.value || 'julita';
            switchDemographicsView(currentView);

            // Maps are disabled - skip initialization
        }

        // Process demographics data from API
        function processDemographicsData(data) {
            console.log('Processing demographics data:', data);

            // Reset data
            Object.keys(demographicsData.julitaBarangays).forEach(barangay => {
                demographicsData.julitaBarangays[barangay].count = 0;
                Object.keys(demographicsData.julitaBarangays[barangay].ageGroups).forEach(ageGroup => {
                    demographicsData.julitaBarangays[barangay].ageGroups[ageGroup] = 0;
                });
            });

            demographicsData.municipalities = {};

            // Process Julita members
            if (data.julitaMembers && Array.isArray(data.julitaMembers)) {
                data.julitaMembers.forEach(member => {
                    // Normalize barangay name (remove extra spaces, case insensitive)
                    const normalizedBarangay = member.barangay ? member.barangay.trim() : '';

                    if (demographicsData.julitaBarangays[normalizedBarangay]) {
                        demographicsData.julitaBarangays[normalizedBarangay].count++;

                        const ageGroup = getAgeGroup(parseInt(member.age));
                        if (demographicsData.julitaBarangays[normalizedBarangay].ageGroups[ageGroup] !== undefined) {
                            demographicsData.julitaBarangays[normalizedBarangay].ageGroups[ageGroup]++;
                        }
                    } else {
                        // If barangay is not in our predefined list, add it dynamically
                        console.log('Unknown barangay found:', normalizedBarangay);
                        demographicsData.julitaBarangays[normalizedBarangay] = {
                            count: 1,
                            ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 }
                        };

                        const ageGroup = getAgeGroup(parseInt(member.age));
                        if (demographicsData.julitaBarangays[normalizedBarangay].ageGroups[ageGroup] !== undefined) {
                            demographicsData.julitaBarangays[normalizedBarangay].ageGroups[ageGroup]++;
                        }
                    }
                });
            }

            // Process non-Julita members
            if (data.nonJulitaMembers && Array.isArray(data.nonJulitaMembers)) {
                console.log('Processing non-Julita members:', data.nonJulitaMembers.length);
                data.nonJulitaMembers.forEach(member => {
                    const municipalityKey = member.municipality && member.province
                        ? `${member.municipality.trim()}, ${member.province.trim()}`
                        : member.municipality
                            ? member.municipality.trim()
                            : 'Unknown Location';

                    if (!demographicsData.municipalities[municipalityKey]) {
                        demographicsData.municipalities[municipalityKey] = {
                            count: 0,
                            province: member.province ? member.province.trim() : 'Unknown',
                            ageGroups: { '18-25': 0, '26-35': 0, '36-50': 0, '50+': 0 }
                        };
                    }

                    demographicsData.municipalities[municipalityKey].count++;

                    const ageGroup = getAgeGroup(parseInt(member.age));
                    if (demographicsData.municipalities[municipalityKey].ageGroups[ageGroup] !== undefined) {
                        demographicsData.municipalities[municipalityKey].ageGroups[ageGroup]++;
                    }
                });
            } else {
                console.warn('No nonJulitaMembers data found or not an array:', data.nonJulitaMembers);
            }

            console.log('Processed demographics data:', demographicsData);
            console.log('Municipalities count:', Object.keys(demographicsData.municipalities).length);
            console.log('Municipalities data:', demographicsData.municipalities);

            // Reload the current view to refresh data display
            const currentView = document.getElementById('demographicsFilter')?.value || 'julita';
            if (currentView === 'non-julita') {
                // Small delay to ensure DOM is ready
                setTimeout(() => {
                    loadNonJulitaDemographics();
                }, 100);
            }
        }

        // Helper function to categorize age groups
        function getAgeGroup(age) {
            if (age >= 18 && age <= 25) return '18-25';
            if (age >= 26 && age <= 35) return '26-35';
            if (age >= 36 && age <= 50) return '36-50';
            return '50+';
        }

        // Function to refresh demographics data
        async function refreshDemographicsData() {
            const refreshBtn = document.querySelector('[onclick="refreshDemographicsData()"]');
            const originalIcon = refreshBtn.innerHTML;
            
            // Show loading state
            refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            refreshBtn.disabled = true;
            
            try {
                await loadDemographicsData();
                // Maps are disabled - skip refresh
                showToast('Demographics data refreshed successfully', 'success');
            } catch (error) {
                showToast('Error refreshing data', 'error');
            } finally {
                // Restore button state
                refreshBtn.innerHTML = originalIcon;
                refreshBtn.disabled = false;
            }
        }

        // Map Management Functions - DISABLED
        let mapInitializationObserver = null;
        
        function initializeMapContainers() {
            // Maps are disabled - do nothing
            return;
        }

        function initializeDemographicMap(type, container) {
            console.log(`Initializing ${type} map container:`, container);
            
            // Clear any existing content
            container.innerHTML = '';
            
            // Create map instance
            const map = L.map(container, {
                center: type === 'julita' ? [11.0258, 124.9725] : [11.0, 125.0], // Center on Julita/Leyte
                zoom: type === 'julita' ? 13 : 10,
                zoomControl: false
            });
            
            // Store map instance for later use
            container._mapInstance = map;
            
            // Add tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            
            // Add zoom controls
            L.control.zoom({
                position: 'topright'
            }).addTo(map);
            
            // Add member data to map
            addMemberDataToMap(map, type);
        }

        function addMemberDataToMap(map, type) {
            const locationData = type === 'julita' ? demographicsData.julitaBarangays : demographicsData.municipalities;
            const totalMembers = Object.values(locationData).reduce((sum, loc) => sum + loc.count, 0);
            
            if (totalMembers === 0) {
                // Show no data message
                const noDataDiv = document.createElement('div');
                noDataDiv.style.cssText = `
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    background: var(--surface);
                    padding: 2rem;
                    border-radius: var(--radius);
                    text-align: center;
                    box-shadow: var(--shadow-lg);
                    z-index: 1000;
                `;
                noDataDiv.innerHTML = `
                    <i class="fas fa-info-circle" style="font-size: 2rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
                    <h4 style="color: var(--text-primary); margin-bottom: 0.5rem;">No ${type === 'julita' ? 'Barangay' : 'Municipality'} Data</h4>
                    <p style="color: var(--text-muted);">Member data will appear here once available</p>
                `;
                map.getContainer().appendChild(noDataDiv);
                return;
            }
            
            // Define approximate coordinates for Julita barangays and nearby municipalities
            const locationCoordinates = {
                // Julita Barangays (approximate coordinates)
                'Poblacion District I': [11.0258, 124.9725],
                'Poblacion District II': [11.0265, 124.9730],
                'Poblacion District III': [11.0250, 124.9720],
                'Poblacion District IV': [11.0260, 124.9715],
                'Alegria': [11.0350, 124.9800],
                'Anibong': [11.0200, 124.9650],
                'Aslum': [11.0400, 124.9750],
                'Balante': [11.0150, 124.9700],
                'Bongdo': [11.0300, 124.9850],
                'Bonifacio': [11.0180, 124.9680],
                'Bugho': [11.0320, 124.9780],
                'Calbasag': [11.0220, 124.9760],
                'Caridad': [11.0280, 124.9720],
                'Cuya-e': [11.0380, 124.9820],
                'Dita': [11.0160, 124.9640],
                'Gitabla': [11.0420, 124.9880],
                'Hindang': [11.0240, 124.9800],
                'Inawangan': [11.0360, 124.9760],
                'Jurao': [11.0140, 124.9660],
                'San Andres': [11.0330, 124.9840],
                'San Pablo': [11.0190, 124.9720],
                'Santa Cruz': [11.0370, 124.9700],
                'Santo Niño': [11.0310, 124.9680],
                'Tagkip': [11.0270, 124.9860],
                'Tolosahay': [11.0210, 124.9780],
                'Villa Hermosa': [11.0290, 124.9740],
                
                // Nearby Municipalities (approximate coordinates)
                'Tacloban City, Leyte': [11.2470, 125.0045],
                'Ormoc City, Leyte': [11.0069, 124.6111],
                'Abuyog, Leyte': [10.7500, 125.0333],
                'Tanauan, Leyte': [11.0667, 125.0667],
                'Catbalogan, Samar': [11.7750, 124.8861],
                'Calbayog, Samar': [12.0667, 124.6000]
            };
            
            // Optimized: Batch marker creation and use requestAnimationFrame for smooth rendering
            const locationsWithData = Object.entries(locationData)
                .filter(([name, data]) => data.count > 0)
                .map(([name, data]) => {
                    const coords = locationCoordinates[name] || locationCoordinates[`${name}, Leyte`];
                    return coords ? { name, data, coords } : null;
                })
                .filter(Boolean);
            
            if (locationsWithData.length === 0) return;
            
            // Calculate total once
            const total = Object.values(locationData).reduce((sum, loc) => sum + loc.count, 0);
            const color = type === 'julita' ? '#6366f1' : '#8b5cf6';
            
            // Batch marker creation for better performance
            const markers = [];
            locationsWithData.forEach(({ name, data, coords }) => {
                const percentage = ((data.count / total) * 100).toFixed(1);
                const iconSize = Math.max(20, Math.min(50, 15 + (data.count * 2)));
                
                const customIcon = L.divIcon({
                    html: `
                        <div style="
                            background: ${color};
                            color: white;
                            border-radius: 50%;
                            width: ${iconSize}px;
                            height: ${iconSize}px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-weight: bold;
                            font-size: ${Math.max(8, iconSize * 0.3)}px;
                            border: 2px solid white;
                            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
                        ">
                            ${data.count}
                        </div>
                    `,
                    className: 'custom-div-icon',
                    iconSize: [iconSize, iconSize],
                    iconAnchor: [iconSize / 2, iconSize / 2]
                });
                
                const marker = L.marker(coords, { icon: customIcon });
                
                // Create popup content
                const popupContent = `
                    <div style="min-width: 200px;">
                        <h4 style="margin: 0 0 8px 0; color: var(--text-primary);">${name}</h4>
                        <div style="margin-bottom: 8px;">
                            <strong>Members:</strong> ${data.count} (${percentage}%)
                        </div>
                        <div style="margin-bottom: 8px;">
                            <strong>Age Groups:</strong><br>
                            ${Object.entries(data.ageGroups).map(([age, count]) => 
                                count > 0 ? `${age}: ${count}` : null
                            ).filter(Boolean).join('<br>') || 'No data'}
                        </div>
                        ${type === 'julita' ? `<small style="color: var(--text-muted);">Julita Municipality</small>` : 
                          `<small style="color: var(--text-muted);">${data.province || 'Leyte Province'}</small>`}
                    </div>
                `;
                
                marker.bindPopup(popupContent);
                markers.push(marker);
            });
            
            // Add all markers at once using a marker group for better performance
            const markerGroup = L.layerGroup(markers).addTo(map);
            map._markerGroup = markerGroup; // Store for easy removal later
            
            // Add a legend
            addMapLegend(map, type, totalMembers);
        }

        function addMapLegend(map, type, totalMembers) {
            const legend = L.control({ position: 'bottomright' });
            
            legend.onAdd = function() {
                const div = L.DomUtil.create('div', 'info legend');
                div.style.cssText = `
                    background: var(--surface);
                    padding: 10px;
                    border-radius: 5px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                    font-size: 12px;
                    color: var(--text-primary);
                `;
                
                const title = type === 'julita' ? 'Julita Barangays' : 'External Municipalities';
                const icon = type === 'julita' ? 'fas fa-map-marker-alt' : 'fas fa-city';
                
                div.innerHTML = `
                    <div style="font-weight: bold; margin-bottom: 8px;">
                        <i class="${icon}"></i> ${title}
                    </div>
                    <div style="margin-bottom: 8px;">
                        <strong>Total Members:</strong> ${totalMembers}
                    </div>
                    <div style="margin-bottom: 8px;">
                        <div style="display: inline-block; width: 12px; height: 12px; background: ${type === 'julita' ? '#6366f1' : '#8b5cf6'}; border-radius: 50%; margin-right: 5px;"></div>
                        Member Count
                    </div>
                    <small style="color: var(--text-muted);">Circle size = member count</small>
                `;
                
                return div;
            };
            
            legend.addTo(map);
        }

        function resizeMaps() {
            // Resize all maps when container size changes
            const containers = document.querySelectorAll('.demographic-map');
            containers.forEach(container => {
                if (container._mapInstance) {
                    container._mapInstance.invalidateSize();
                }
            });
        }

        // Add window resize handler
        window.addEventListener('resize', debounce(resizeMaps, 250));

        // Debounce function to limit resize calls
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        function refreshJulitaMap() {
            // Maps are disabled
            return;
        }

        function refreshNonJulitaMap() {
            // Maps are disabled
            return;
        }

        function toggleMapView(type) {
            // Maps are disabled
            return;
        }

        function updateMapMode(container, mode, type) {
            const locationData = type === 'julita' ? demographicsData.julitaBarangays : demographicsData.municipalities;
            
            switch (mode) {
                case 'satellite':
                    container.style.background = 'linear-gradient(45deg, #2c3e50, #34495e)';
                    break;
                case 'heatmap':
                    container.style.background = 'linear-gradient(45deg, #e74c3c, #f39c12, #f1c40f)';
                    break;
                default:
                    container.style.background = 'var(--surface)';
            }
            
            // Show mode indicator
            showMapModeIndicator(container, mode, type, locationData);
        }

        function showMapModeIndicator(container, mode, type, locationData) {
            const totalMembers = Object.values(locationData).reduce((sum, loc) => sum + loc.count, 0);
            const modeLabels = {
                'default': 'Standard View',
                'satellite': 'Satellite View', 
                'heatmap': 'Density Heatmap'
            };
            
            const existingIndicator = container.querySelector('.map-mode-indicator');
            if (existingIndicator) {
                existingIndicator.remove();
            }
            
            const indicator = document.createElement('div');
            indicator.className = 'map-mode-indicator';
            indicator.style.cssText = `
                position: absolute;
                bottom: 10px;
                left: 10px;
                background: rgba(0,0,0,0.7);
                color: white;
                padding: 5px 10px;
                border-radius: 15px;
                font-size: 0.8rem;
                z-index: 1000;
            `;
            indicator.innerHTML = `
                <i class="fas ${mode === 'heatmap' ? 'fa-fire' : mode === 'satellite' ? 'fas fa-satellite' : 'fa-map'}"></i>
                ${modeLabels[mode]} • ${totalMembers} members
            `;
            
            container.appendChild(indicator);
        }

        // External Data Integration Functions
        function loadExternalMapData(dataSource, callback) {
            // Function to load external data for map integration
            console.log('Loading external data from:', dataSource);
            
            // Placeholder for external API calls
            // This can be integrated with:
            // - Google Maps API
            // - OpenStreetMap
            // - Government geographic databases
            // - Census data
            // - etc.
            
            if (typeof callback === 'function') {
                callback(null); // Simulate successful data load
            }
        }

        function integrateExternalMapData(container, externalData, type) {
            // Function to integrate external data with the map containers
            console.log('Integrating external data:', externalData, 'for type:', type);
            
            // Placeholder for external data integration
            // This can handle:
            // - Geographic boundaries
            // - Population data
            // - Administrative divisions
            // - Census information
            // - etc.
            
            if (externalData && container) {
                // Update map with external data
                updateMapWithExternalData(container, externalData, type);
            }
        }

        function updateMapWithExternalData(container, externalData, type) {
            // Function to update map display with external data
            const dataCount = externalData.length || Object.keys(externalData).length;
            
            // Show integration status
            const statusDiv = document.createElement('div');
            statusDiv.style.cssText = `
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(0,0,0,0.8);
                color: white;
                padding: 1rem;
                border-radius: var(--radius);
                text-align: center;
                z-index: 1000;
            `;
            statusDiv.innerHTML = `
                <i class="fas fa-check-circle" style="color: var(--success); font-size: 2rem; margin-bottom: 0.5rem;"></i>
                <h4>External Data Integrated</h4>
                <p>Loaded ${dataCount} records for ${type} mapping</p>
            `;
            
            container.appendChild(statusDiv);
            
            // Remove status after 3 seconds
            setTimeout(() => {
                if (statusDiv.parentNode) {
                    statusDiv.remove();
                }
            }, 3000);
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
        // Create Most Borrowed Book Line Chart
        async function createMostBorrowedBookLineChart(months = 12, forceRefresh = false) {
            const ctx = document.getElementById('mostBorrowedBookChart');
            if (!ctx) {
                console.error('❌ Most borrowed book chart canvas not found');
                return;
            }

            if (typeof Chart === 'undefined') {
                console.error('❌ Chart.js not loaded');
                return;
            }

            // Destroy existing chart
            if (window.mostBorrowedBookChartInstance) {
                window.mostBorrowedBookChartInstance.destroy();
                window.mostBorrowedBookChartInstance = null;
            }

            showChartLoading(ctx, 'Loading book borrowing trend...');

            try {
                const data = await fetchMostBorrowedBookTrendData(months);
                clearChartLoading(ctx);

                if (!data || !data.labels || !data.data) {
                    console.error('❌ Invalid book trend data:', data);
                    showChartError(ctx, 'No trend data available');
                    return;
                }

                const totalBorrows = data.data.reduce((a, b) => a + b, 0);
                const colors = getChartThemeColors();

                console.log('📊 Creating most borrowed book line chart with:', {
                    book: data.bookTitle,
                    months: data.labels.length,
                    totalBorrows
                });

                const trendData = {
                    labels: data.labels,
                    datasets: [{
                        label: `${data.bookTitle} - Borrowing Trend`,
                        data: data.data,
                        borderColor: 'rgba(99, 102, 241, 1)',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: 'rgba(99, 102, 241, 1)',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 3
                    }]
                };

                window.mostBorrowedBookChartInstance = new Chart(ctx, {
                    type: 'line',
                    data: trendData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.9)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                borderColor: 'rgba(99, 102, 241, 0.5)',
                                borderWidth: 1,
                                cornerRadius: 8,
                                padding: 12,
                                callbacks: {
                                    title: function(context) {
                                        return `📅 ${context[0].label}`;
                                    },
                                    label: function(context) {
                                        const value = context.raw;
                                        const percentage = totalBorrows > 0 ? ((value / totalBorrows) * 100).toFixed(1) : '0';
                                        return `📚 ${value} borrows (${percentage}% of total)`;
                                    },
                                    footer: function(context) {
                                        const value = context[0].raw;
                                        const max = Math.max(...data.data);
                                        const rank = data.data.indexOf(value) + 1;
                                        return `🏆 Peak month: ${max} borrows`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    callback: function(value) {
                                        return Number.isInteger(value) ? value : '';
                                    },
                                    color: 'var(--text-secondary)',
                                    font: { size: 12 }
                                },
                                title: {
                                    display: true,
                                    text: 'Number of Borrows',
                                    color: 'var(--text-primary)',
                                    font: {
                                        weight: 'bold',
                                        size: 14
                                    },
                                    padding: { bottom: 10 }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)',
                                    drawBorder: false
                                }
                            },
                            x: {
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 0,
                                    autoSkip: false,
                                    color: 'var(--text-secondary)',
                                    font: { size: 11 }
                                },
                                title: {
                                    display: true,
                                    text: 'Month',
                                    color: 'var(--text-primary)',
                                    font: {
                                        weight: 'bold',
                                        size: 14
                                    },
                                    padding: { top: 10 }
                                },
                                grid: { display: false }
                            }
                        },
                        animation: {
                            duration: 1500,
                            easing: 'easeInOutQuart',
                            delay: function(context) {
                                return context.dataIndex * 50;
                            }
                        },
                        onHover: function(event, elements) {
                            event.native.target.style.cursor = elements.length > 0 ? 'pointer' : 'default';
                        }
                    }
                });

                console.log('✅ Most borrowed book line chart created successfully');

            } catch (error) {
                console.error('❌ Error creating most borrowed book chart:', error);
                clearChartLoading(ctx);
                showChartError(ctx, 'Failed to load book trend data');
            }
        }

        // Fetch Peak Hours Data
        async function fetchPeakHoursData(filterValue = 'week', forceRefresh = false) {
            const cacheKey = `peakHours_${filterValue}`;
        
            if (!forceRefresh) {
                const cached = analyticsCache.get(cacheKey);
                if (cached) {
                    console.log('📊 Using cached peak hours data');
                    return cached;
                }
            }

            try {
                console.log('🔄 Fetching fresh peak hours data for:', filterValue);
                const response = await fetch(`/api/analytics/peak-hours?period=${filterValue}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Cache-Control': 'no-cache'
                    },
                    credentials: 'same-origin'
                });

                if (response.ok) {
                    const data = await response.json();
                    console.log('✅ Fetched peak hours data:', data);

                    // Validate data structure
                    if (validatePeakHoursData(data)) {
                        analyticsCache.set(cacheKey, data);
                        return data;
                    } else {
                        console.warn('⚠️ Invalid data structure, using fallback');
                        return getFallbackPeakHoursData(filterValue);
                    }
                } else {
                    console.warn(`⚠️ API returned ${response.status}, using fallback`);
                    return getFallbackPeakHoursData(filterValue);
                }
            } catch (error) {
                console.error('❌ Error fetching peak hours data:', error);
                return getFallbackPeakHoursData(filterValue);
            }
        }

        // Validate peak hours data structure
        function validatePeakHoursData(data) {
            return data &&
                   Array.isArray(data.labels) &&
                   Array.isArray(data.data) &&
                   data.labels.length === data.data.length &&
                   data.labels.length > 0;
        }

        // Enhanced fallback data for peak hours
        function getFallbackPeakHoursData(filterValue) {
            // Sample data based on typical library patterns
            const baseData = {
                today: {
                    labels: ['8AM', '9AM', '10AM', '11AM', '12PM', '1PM', '2PM', '3PM', '4PM', '5PM', '6PM'],
                    data: [2, 5, 8, 12, 15, 18, 22, 25, 20, 15, 8]
                },
                week: {
                    labels: ['8AM', '10AM', '12PM', '2PM', '4PM', '6PM'],
                    data: [15, 45, 65, 85, 75, 35]
                },
                month: {
                    labels: ['8AM', '10AM', '12PM', '2PM', '4PM', '6PM'],
                    data: [120, 340, 480, 520, 450, 180]
                }
            };

            return baseData[filterValue] || baseData.week;
        }

        // Fetch Age Activity Data
        async function fetchAgeActivityData(filterValue = 'week', forceRefresh = false) {
            const cacheKey = `ageActivity_${filterValue}`;
        
            if (!forceRefresh) {
                const cached = analyticsCache.get(cacheKey);
                if (cached) {
                    console.log('📊 Using cached age activity data');
                    return cached;
                }
            }

            try {
                console.log('🔄 Fetching fresh age activity data for:', filterValue);
                const response = await fetch(`/api/analytics/age-activity?period=${filterValue}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Cache-Control': 'no-cache'
                    },
                    credentials: 'same-origin'
                });

                if (response.ok) {
                    const data = await response.json();
                    console.log('✅ Fetched age activity data:', data);

                    // Validate data structure
                    if (validateAgeActivityData(data)) {
                        analyticsCache.set(cacheKey, data);
                        return data;
                    } else {
                        console.warn('⚠️ Invalid data structure, using fallback');
                        return getFallbackAgeActivityData(filterValue);
                    }
                } else {
                    console.warn(`⚠️ API returned ${response.status}, using fallback`);
                    return getFallbackAgeActivityData(filterValue);
                }
            } catch (error) {
                console.error('❌ Error fetching age activity data:', error);
                return getFallbackAgeActivityData(filterValue);
            }
        }

        // Validate age activity data structure
        function validateAgeActivityData(data) {
            return data &&
                   Array.isArray(data.labels) &&
                   Array.isArray(data.datasets) &&
                   data.labels.length > 0 &&
                   data.datasets.length > 0;
        }

        // Enhanced fallback data for age activity
        function getFallbackAgeActivityData(filterValue) {
            const baseMultiplier = filterValue === 'week' ? 1 : filterValue === 'month' ? 4 : 12;

            return {
                labels: ['18-25', '26-35', '36-50', '50+'],
                datasets: [
                    {
                        label: 'Avg Visits',
                        data: [8.5 * baseMultiplier, 12.2 * baseMultiplier, 6.8 * baseMultiplier, 4.1 * baseMultiplier]
                    },
                    {
                        label: 'Avg Duration (min)',
                        data: [45, 62, 38, 55]
                    }
                ]
            };
        }

        // Update peak hours chart when filter changes
        function updatePeakHoursChart() {
            const filterSelect = document.getElementById('peakHoursFilter');
            if (filterSelect) {
                const selectedPeriod = filterSelect.value;
                createPeakHoursChart(selectedPeriod, true);
            }
        }

        // Update age activity chart when filter changes
        function updateAgeActivityChart() {
            const filterSelect = document.getElementById('ageActivityFilter');
            if (filterSelect) {
                const selectedPeriod = filterSelect.value;
                createAgeActivityChart(selectedPeriod, true);
            }
        }

        // Fetch Most Borrowed Book Trend Data
        async function fetchMostBorrowedBookTrendData(months) {
            const cacheKey = `mostBorrowedBookTrend_${months}`;

            if (!forceRefresh) {
                const cached = analyticsCache.get(cacheKey);
                if (cached) {
                    console.log('📊 Using cached most borrowed book trend data');
                    return cached;
                }
            }

            try {
                console.log('🔄 Fetching fresh most borrowed book trend data for:', months, 'months');
                const response = await fetch(`/api/analytics/most-borrowed-book-trend?months=${months}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Cache-Control': 'no-cache'
                    },
                    credentials: 'same-origin'
                });

                if (response.ok) {
                    const data = await response.json();
                    console.log('✅ Fetched most borrowed book trend data:', data);

                    // Validate data structure
                    if (validateBookTrendData(data)) {
                        analyticsCache.set(cacheKey, data);
                        return data;
                    } else {
                        console.warn('⚠️ Invalid data structure, using fallback');
                        return getFallbackBookTrendData(months);
                    }
                } else {
                    console.warn(`⚠️ API returned ${response.status}, using fallback`);
                    return getFallbackBookTrendData(months);
                }
            } catch (error) {
                console.error('❌ Error fetching most borrowed book trend data:', error);
                return getFallbackBookTrendData(months);
            }
        }

        // Validate book trend data structure
        function validateBookTrendData(data) {
            return data &&
                   typeof data.bookTitle === 'string' &&
                   Array.isArray(data.labels) &&
                   Array.isArray(data.data) &&
                   data.labels.length === data.data.length &&
                   data.labels.length > 0;
        }

        // Enhanced fallback data for most borrowed book trend
        function getFallbackBookTrendData(months) {
            const currentDate = new Date();
            const labels = [];
            const data = [];

            // Generate last N months
            for (let i = months - 1; i >= 0; i--) {
                const date = new Date(currentDate.getFullYear(), currentDate.getMonth() - i, 1);
                const monthName = date.toLocaleDateString('en-US', { month: 'short', year: '2-digit' });
                labels.push(monthName);
                // Sample data with some variation
                data.push(Math.floor(Math.random() * 20) + 5);
            }

            return {
                bookTitle: 'Sample Most Borrowed Book',
                labels,
                data
            };
        }

        // Update book trend chart when filter changes
        function updateBookTrendChart() {
            const monthsFilter = document.getElementById('bookTrendFilter');
            if (monthsFilter) {
                const selectedMonths = parseInt(monthsFilter.value);
                createMostBorrowedBookLineChart(selectedMonths, true);
            }
        }

        // Filter active areas chart by Julita/Non-Julita
        function filterActiveAreas(filterValue) {
            if (!window.activeAreasChartInstance || !activeAreasData) return;

            let filteredLabels = [];
            let filteredData = [];

            if (filterValue === 'all') {
                filteredLabels = activeAreasData.labels;
                filteredData = activeAreasData.data;
            } else if (filterValue === 'julita') {
                // Filter to only Julita barangays
                activeAreasData.labels.forEach((area, index) => {
                    if (demographicsData.julitaBarangays[area]) {
                        filteredLabels.push(area);
                        filteredData.push(activeAreasData.data[index]);
                    }
                });
            } else if (filterValue === 'non-julita') {
                // Filter to only non-Julita municipalities
                activeAreasData.labels.forEach((area, index) => {
                    if (!demographicsData.julitaBarangays[area]) {
                        filteredLabels.push(area);
                        filteredData.push(activeAreasData.data[index]);
                    }
                });
            }

            // Update chart with filtered data
            window.activeAreasChartInstance.data.labels = filteredLabels;
            window.activeAreasChartInstance.data.datasets[0].data = filteredData;
            window.activeAreasChartInstance.update();
        }

        // Function to update monthly chart filter labels with current month names
        function updateMonthlyChartLabels() {
            const now = new Date();
            const currentMonth = now.getMonth() + 1; // 1-12
            const lastMonth = currentMonth === 1 ? 12 : currentMonth - 1;
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            const currentOption = document.querySelector('#monthlyChartMonthFilter option[value="current"]');
            const lastOption = document.querySelector('#monthlyChartMonthFilter option[value="last"]');

            if (currentOption) currentOption.textContent = `Current Month (${monthNames[currentMonth - 1]})`;
            if (lastOption) lastOption.textContent = `Last Month (${monthNames[lastMonth - 1]})`;
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Update filter labels first
            updateMonthlyChartLabels();
    
            // Initialize new charts first
            createMonthlyBooksChart('current');
            createActiveAreasChart();
            createMostBorrowedBookLineChart(12);
    
            // Initialize peak hours and age activity charts
            createPeakHoursChart('week');
            createAgeActivityChart('week');
    
            // Initialize real-time clock
            initializeRealTimeClock();
    
            // Then the rest
            // loadTopBooks(); // Commented out as div not present
            // loadActiveMembers('borrowing'); // Commented out as div not present
    
            // Check for Christmas effects preference on load
            const christmasPreference = localStorage.getItem('christmasEffects');
            if (christmasPreference === 'true') {
                document.body.classList.add('christmas-theme');
            }
        });
    
        // Real-time clock function
        function initializeRealTimeClock() {
            const clockElement = document.getElementById('realTimeClock');
            if (!clockElement) return;
    
            function updateClock() {
                const now = new Date();
                const options = {
                    weekday: 'short',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                };
                const timeString = now.toLocaleDateString('en-US', options);
                clockElement.textContent = timeString;
            }
    
            // Update immediately
            updateClock();
    
            // Update every second
            setInterval(updateClock, 1000);
        }
    </script>
    <script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
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
                else if (e.target.id === 'settingsModal') closeSettingsModal();
            }
        });

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
                // Reset form
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

        function updateProfile() {
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

        // Setup password change form
        document.addEventListener('DOMContentLoaded', function() {
            const passwordForm = document.getElementById('profileForm');
            if (passwordForm) {
                passwordForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    updateProfile();
                });
            }
        });

    </script>

    <!-- System Settings Modal -->Settings
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

    <!-- QR Scanner Modal -->
    <div class="modal-overlay" id="qrScannerModal" style="z-index: 3000; display: none;">
        <div class="modal-container" style="max-width: 500px;">
            <div class="modal-header">
                <div class="modal-title" style="display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-qrcode" style="color: var(--primary); font-size: 20px;"></i>
                    <span>QR Scanner</span>
                </div>
                <button class="modal-close" onclick="stopQRScan()">&times;</button>
            </div>
            <div class="modal-body" style="text-align: center;">
                <div id="qr-reader" style="width: 100%; max-width: 400px; margin: 0 auto;"></div>
                <p style="margin-top: 1rem; color: var(--text-muted); font-size: 0.9rem;">
                    Position the QR code within the camera view
                </p>
            </div>
        </div>
    </div>

    <!-- Overdue Details Modal -->
    <div class="modal-overlay" id="overdueModal" style="z-index: 2700; display: none;">
        <div class="modal-container" style="max-width: 500px;">
            <div class="modal-header">
                <div class="modal-title" style="display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-exclamation-triangle" style="color: var(--danger); font-size: 20px;"></i>
                    <span>Overdue Notice</span>
                </div>
                <button class="modal-close" onclick="closeOverdueModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div id="overdueModalDetails" style="text-align: center;">
                    <!-- Content will be populated by JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <div class="footer-actions">
                    <button type="button" class="btn-cancel-premium" onclick="closeOverdueModal()">
                        <i class="fas fa-times"></i>
                        <span>Close</span>
                    </button>
                    <button type="button" class="btn-submit-premium" onclick="proceedWithReturn()">
                        <i class="fas fa-check"></i>
                        <span>Proceed with Return</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Return All Modal -->
    <div class="modal-overlay" id="returnAllModal" style="z-index: 2600; display: none;">
        <div class="modal-container" style="max-width: 800px; max-height: 80vh;">
            <div class="modal-header">
                <div class="modal-title" style="display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-undo" style="color: var(--success); font-size: 20px;"></i>
                    <span>Return All Books</span>
                </div>
                <button class="modal-close" onclick="closeReturnAllModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; height: 100%;">
                    <!-- Left Side: QR Scanner -->
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <div style="text-align: center;">
                            <h4 style="color: var(--text-primary); margin-bottom: 1rem;">📱 Scan Book QR Codes</h4>
                            <div style="background: var(--surface); border: 2px dashed var(--border); border-radius: var(--radius); padding: 2rem; margin-bottom: 1rem;">
                                <div id="qr-reader-return-all" style="width: 100%; max-width: 300px; height: 200px; margin: 0 auto; border-radius: var(--radius); overflow: hidden;"></div>
                                <p style="margin-top: 1rem; color: var(--text-muted); font-size: 0.9rem;">
                                    Scan each book's QR code to verify return
                                </p>
                            </div>
                            <p style="margin-top: 1rem; color: var(--text-muted); font-size: 0.9rem; font-style: italic;">
                                Scanner starting automatically...
                            </p>
                        </div>
                        <div style="background: var(--surface); border-radius: var(--radius); padding: 1rem; border: 1px solid var(--border);">
                            <h5 style="color: var(--text-primary); margin-bottom: 0.5rem;">📋 Instructions</h5>
                            <ol style="color: var(--text-secondary); font-size: 0.85rem; line-height: 1.4; margin: 0; padding-left: 1rem;">
                                <li>Books to return are pre-filled below</li>
                                <li>Scan each book's QR code to verify return</li>
                                <li>Counter shows progress (scanned/total)</li>
                                <li>Return processes automatically when all books are scanned</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Right Side: Books List -->
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <!-- Member Info -->
                        <div style="background: var(--surface); border-radius: var(--radius); padding: 1rem; border: 1px solid var(--border);">
                            <h5 style="color: var(--text-primary); margin-bottom: 0.5rem;">👤 Member Information</h5>
                            <div id="returnAllMemberInfo" style="color: var(--text-secondary);">
                                <p>Loading...</p>
                            </div>
                        </div>

                        <!-- Books to Return -->
                        <div style="background: var(--surface); border-radius: var(--radius); padding: 1rem; border: 1px solid var(--border); flex: 1; display: flex; flex-direction: column;">
                            <h5 style="color: var(--text-primary); margin-bottom: 0.5rem;">📚 Books to Return <span id="returnAllCounter" style="font-size: 0.8rem; color: var(--text-secondary);">(0/?)</span></h5>
                            <div id="returnAllBooksList" style="flex: 1; overflow-y: auto; max-height: 300px;">
                                <p style="color: var(--text-muted); font-style: italic;">Loading books...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="footer-actions">
                    <button type="button" class="btn-cancel-premium" onclick="closeReturnAllModal()">
                        <i class="fas fa-times"></i>
                        <span>Cancel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

</body>
    <!-- Toast Notifications -->
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
    
    <script>
    // Hide admin-only elements for non-admin users
    document.addEventListener('DOMContentLoaded', function() {
        const userRole = document.body.getAttribute('data-user-role');
        
        if (userRole !== 'admin') {
            // Hide admin-only links in sidebar
            const adminLinks = document.querySelectorAll('.admin-only-links');
            adminLinks.forEach(function(el) {
                el.style.display = 'none';
            });
            
            // Hide admin-only buttons
            const adminButtons = document.querySelectorAll('.admin-only-btn');
            adminButtons.forEach(function(el) {
                el.style.display = 'none';
            });
        }
    });
    </script>
    
    <div id="toast-container" class="toast-container"></div>
    <script src="{{ asset('js/toast.js') }}"></script>
    
    <script>
    // Check system logs access for non-admin users
    function checkSystemLogsAccess(event) {
        const hasPermission = {{ auth()->check() && auth()->user()->hasPermission('view_system_logs') ? 'true' : 'false' }};
        
        if (!hasPermission) {
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

<script>
// =========================================
// Force Logout Detection for Current User
// Polls periodically to check if user has been force-logged out
// =========================================
(function() {
    'use strict';

    const isAdmin = {{ auth()->check() && auth()->user()->isAdmin() ? 'true' : 'false' }};
    if (!isAdmin) return;
    
    const POLL_INTERVAL = 30000; // 30 seconds
    const FORCE_LOGOUT_POPUP_KEY = 'force_logout_popup_shown';
    const FORCE_LOGOUT_MESSAGE_KEY = 'force_logout_message';
    let isRefreshing = false;
    let isChecking = false;
    let pollTimer = null;
    
    function checkCurrentUserForceLogout() {
        // Only run if user is authenticated, visible, and not already redirecting/checking
        const userId = {{ auth()->check() ? auth()->id() : 'null' }};
        if (!userId || isRefreshing || isChecking || document.hidden) return;

        isChecking = true;
        
        fetch('/auth/force-logout-status', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            // If redirected or unauthorized, user is logged out
            if (response.redirected || response.status === 401) {
                handleForceLogout();
                return null;
            }
            return response.json();
        })
        .then(data => {
            if (data && data.force_logout) {
                handleForceLogout();
            }
        })
        .catch(error => {
            // Network error might mean user is logged out
            console.log('Force logout check failed:', error.message);
        })
        .finally(() => {
            isChecking = false;
        });
    }

    function startPolling() {
        if (pollTimer) return;
        checkCurrentUserForceLogout();
        pollTimer = setInterval(checkCurrentUserForceLogout, POLL_INTERVAL);
    }

    function stopPolling() {
        if (!pollTimer) return;
        clearInterval(pollTimer);
        pollTimer = null;
    }
    
    function handleForceLogout() {
        if (isRefreshing) return;
        isRefreshing = true;

        const popupAlreadyShown = sessionStorage.getItem(FORCE_LOGOUT_POPUP_KEY) === '1';
        
        // Store message in session storage for login page
        if (!popupAlreadyShown) {
            sessionStorage.setItem(FORCE_LOGOUT_MESSAGE_KEY, 'Your session has ended. Please log in again.');
            sessionStorage.setItem(FORCE_LOGOUT_POPUP_KEY, '1');
        }
        
        // Show alert only once per browser session, then redirect silently.
        setTimeout(function() {
            if (!popupAlreadyShown) {
                alert('Your session has ended. Please log in again.');
            }
            window.location.href = '/login';
        }, 100);
    }
    
    // Start polling when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            startPolling();
        });
    } else {
        startPolling();
    }

    // Avoid polling while tab is hidden.
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            stopPolling();
        } else {
            startPolling();
        }
    });
})();
</script>
