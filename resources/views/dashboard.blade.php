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
    --primary-dark:Resume #4f46e5;
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
    width: 8px;
  }
  .dashboard-content::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.2);
  }
  .dashboard-content::-webkit-scrollbar-track {
    background: var(--border-light);
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
  body.dark-mode .table-container {
    border-color: rgba(99, 102, 241, 0.4);
    box-shadow: var(--shadow-lg), 0 0 30px rgba(99, 102, 241, 0.15);
  }
  body.dark-mode .table-container::-webkit-scrollbar-track {
    background: rgba(99, 102, 241, 0.2);
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
  .card:hover {
    transform: scale(1) !important;
    box-shadow: var(--shadow-xl), var(--shadow-glow) !important;
    border-color: rgba(99, 102, 241, 0.3) !important;
    z-index: 10 !important;
  }
  .card:hover::before {
    opacity: 1;
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
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
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
  /* Bottom positioned action buttons */
  .card-actions-bottom {
    display: flex;
    gap: 8px;
    justify-content: flex-end;
    align-items: center;
    margin-top: auto;
    padding-top: var(--spacing-sm);
    position: relative;
    z-index: 3;
  }
  .card-actions-bottom .btn {
    position: relative;
    z-index: 4;
    pointer-events: auto;
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
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
  }
  .btn-outline:hover {
    background: var(--glass-bg);
    color: var(--primary);
    border-color: var(--primary);
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
    z-index: 2000;
    justify-content: center;
    align-items: center;
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
    background: rgba(255, 255, 255, 0.95);
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
  .modal-content {
    background: rgba(255, 255, 255, 0.98) !important;
    backdrop-filter: blur(25px) !important;
    border-radius: 24px;
    padding: 3rem;
    width: 100%;
    max-width: 900px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: var(--shadow-xl), 0 0 40px rgba(99, 102, 241, 0.15) !important;
    animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid rgba(99, 102, 241, 0.1) !important;
    position: relative;
    z-index: 10;
  }
  body.dark-mode .modal-content {
    background: rgba(15, 23, 42, 0.98);
    color: var(--text-primary);
    border-color: rgba(99, 102, 241, 0.3);
    box-shadow: var(--shadow-xl), 0 0 50px rgba(99, 102, 241, 0.2);
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
    margin-bottom: 2.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 4px solid rgba(99, 102, 241, 0.3);
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(6, 182, 212, 0.05));
    border-radius: 16px 16px 0 0;
    padding: 2.5rem 3rem 2rem 3rem;
    margin: -3rem -3rem 2.5rem -3rem;
    position: relative;
    overflow: hidden;
    z-index: 5;
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
  .modal-close, .close-modal {
    background: rgba(99, 102, 241, 0.1);
    border: 2px solid rgba(99, 102, 241, 0.2);
    font-size: 1.8rem;
    color: var(--primary);
    cursor: pointer;
    padding: 12px;
    border-radius: 50%;
    transition: var(--transition);
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.2);
    position: relative;
    z-index: 15;
  }
  .modal-close:hover, .close-modal:hover {
    background: var(--primary);
    color: #ffffff;
    transform: scale(1.15) rotate(90deg);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
    border-color: var(--primary);
  }
  body.dark-mode .modal-close, body.dark-mode .close-modal {
    background: rgba(99, 102, 241, 0.2);
    border-color: rgba(99, 102, 241, 0.4);
    color: var(--accent);
  }
  body.dark-mode .modal-close:hover, body.dark-mode .close-modal:hover {
    background: var(--accent);
    color: #ffffff;
    border-color: var(--accent);
    box-shadow: 0 4px 16px rgba(6, 182, 212, 0.5);
  }
  .modal-body {
    padding: 0;
  }
  .modal-footer, .modal-actions {
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
    animation: slideInFromLeft 0.5s ease-out;
  }
  .modal-actions .btn:nth-child(2) {
    animation: slideInFromRight 0.5s ease-out;
  }
  .form-section {
    margin-bottom: 2.5rem;
    animation: slideInFromLeft 0.6s ease-out;
  }
  .form-section:nth-child(even) {
    animation: slideInFromRight 0.6s ease-out;
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
    border-color: #d1d5db;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
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
  #cover-preview-area {
    border: 2px dashed #d1d5db;
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    background: rgba(249, 250, 251, 0.5);
    backdrop-filter: blur(10px);
    animation: bounceIn 0.8s ease-out;
  }
  #cover-preview-area:hover {
    border-color: var(--primary);
    background: rgba(99, 102, 241, 0.05);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.15);
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
    transition: all 0.3s ease;
  }
  #cover-preview-area:hover #cover-upload-icon {
    color: var(--primary);
    transform: scale(1.1);
  }
  #cover-preview-text {
    color: var(--text-muted);
    margin: 0;
    font-weight: 500;
    font-size: 1.1rem;
  }
  .cover-input {
    display: none;
  }
  body.dark-mode #cover-preview-area {
    background: rgba(30, 41, 59, 0.3);
    border-color: rgba(71, 85, 105, 0.5);
  }
  body.dark-mode #cover-preview-area:hover {
    background: rgba(6, 182, 212, 0.1);
    border-color: var(--accent);
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
  /* ✨ Glassmorphism Enforcement & Modal Exclusion */
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
  /* Ensure modal elements are never affected by glassmorphism */
  .modal *,
  .modal-content,
  .modal-card,
  .modal-title,
  .modal-header,
  .modal-body,
  .modal-footer,
  .modal-close,
  .close-modal {
    background: unset !important;
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
    border: unset !important;
    box-shadow: unset !important;
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
  .toast-notification,
  .toast-notification * {
    background: unset !important;
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
    border: unset !important;
    box-shadow: unset !important;
  }
  /* Restore intended modal styles */
  .modal-content,
  .modal-card {
    background: rgba(255, 255, 255, 0.98) !important;
    backdrop-filter: blur(25px) !important;
    -webkit-backdrop-filter: blur(25px) !important;
    box-shadow: var(--shadow-xl), 0 0 40px rgba(99, 102, 241, 0.15) !important;
    border-radius: 24px !important;
    border: 2px solid rgba(99, 102, 241, 0.1) !important;
  }
  body.dark-mode .modal-content,
  body.dark-mode .modal-card {
    background: rgba(15, 23, 42, 0.98) !important;
    box-shadow: var(--shadow-xl), 0 0 50px rgba(99, 102, 241, 0.2) !important;
    border-color: rgba(99, 102, 241, 0.3) !important;
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
    .chart-grid {
      grid-template-columns: 1fr;
    }
    .stats {
      grid-template-columns: 1fr;
    }
    .heading {
      font-size: 1.75rem;
    }
    /* Improved mobile card responsiveness */
    .card {
      min-height: 120px;
    }
    .card-actions-bottom {
      justify-content: center;
      margin-top: var(--spacing-sm);
    }
    .card-actions-bottom .btn {
      flex: 1;
      max-width: 120px;
    }
    .card .count {
      text-align: center;
      margin-top: 8px;
    }
    .stats-subcard {
      min-height: 80px;
    }
  }
  @media (max-width: 480px) {
    .main {
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
    </div>
    <!-- Main Content -->
    <div class="main" id="mainContent">
        <div class="dashboard-title" style="position: sticky; top: 0; z-index: 100; background: transparent; padding: 1rem 0; margin: -1rem 0 1rem 0;">DASHBOARD</div>
        <div class="dashboard-content">
        <!-- Stats Cards -->
        <div class="stats">
            <div class="card" id="booksCard">
                <div class="card-header">
                    <h3>Books</h3>
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
                    <h3>Members</h3>
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
                <h3>📚 Borrower List</h3>
                <div class="card-actions">
                    <select id="borrowersFilter" class="form-control" style="width: auto; padding: 6px 12px; font-size: 0.85rem;" onchange="filterBorrowers(this.value)">
                        <option value="all">All Borrowers</option>
                        <option value="today">Today</option>
                        <option value="weekly">This Week</option>
                    </select>
            </div>
        </div>
            <!-- Borrowers Table -->
            <div style="flex: 1; display: flex; flex-direction: column;">
                <!-- Search Bar -->
                <div style="padding: 0.75rem; background: var(--glass-bg); border-radius: var(--radius) var(--radius) 0 0; border: 1px solid var(--border); border-bottom: none;">
                    <div style="position: relative;">
                        <input type="text" id="borrowerSearch" placeholder="Search borrowers..." style="width: 100%; padding: 0.5rem 0.75rem 0.5rem 2rem; border: 1px solid var(--border); border-radius: var(--radius); background: var(--surface-elevated); color: var(--text-primary); font-size: 0.85rem; transition: var(--transition);" onkeyup="searchBorrowers(this.value)">
                        <i class="fas fa-search" style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.8rem;"></i>
            </div>
        </div>
                <!-- Table Container -->
                <div style="overflow-y: auto; max-height: 250px; border: 1px solid var(--border); border-top: none; border-radius: 0 0 var(--radius) var(--radius);">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Borrowed Date</th>
                                <th>Due Date</th>
                                <th>Returned At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="borrowersTableBody">
                            <tr>
                                <td colspan="7" class="loading">Loading borrowers...</td>
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
        <!-- Consolidated Statistics with Line Graph -->
        <div class="card stats-overview-card" style="margin-top: 2rem; display: flex; flex-direction: column;">
            <div class="card-header">
                <h3>📊 Statistics Overview</h3>
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
                    <div class="count" id="mainCount" style="font-size: 2.5rem; margin-bottom: 0.25rem;">{{ $lifetimeCount }}</div>
                    <p id="mainLabel" style="font-size: 1rem; margin-bottom: 1rem; color: var(--text-secondary);">Total Transactions</p>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="stats-subcard" style="text-align: center; padding: 0.75rem; background: var(--glass-bg); border-radius: var(--radius); border: 1px solid var(--border);">
                            <div class="count" style="font-size: 1.5rem; margin-bottom: 0.25rem;" id="booksCount">{{ $booksCount }}</div>
                            <p style="margin: 0; color: var(--text-muted); font-weight: 600; font-size: 0.9rem;">Books</p>
                        </div>
                        <div class="stats-subcard" style="text-align: center; padding: 0.75rem; background: var(--glass-bg); border-radius: var(--radius); border: 1px solid var(--border);">
                            <div class="count" style="font-size: 1.5rem; margin-bottom: 0.25rem;" id="membersCount">{{ $membersCount }}</div>
                            <p style="margin: 0; color: var(--text-muted); font-weight: 600; font-size: 0.9rem;">Members</p>
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
        <footer style="margin-top: 3rem; text-align: center; color: var(--gray); font-size: 0.9rem;">
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
    <!-- ADD BOOK MODAL -->
    <div class="modal" id="addBookModal" style="display: none;">
        <div class="modal-content" style="max-width: 600px;">
            <div class="modal-header">
                <h2 class="modal-title">
                    <i class="fas fa-plus"></i>
                    Add New Book
                </h2>
                <button class="close-modal" onclick="closeAddBookModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="addBookForm" enctype="multipart/form-data">
                    @csrf
                    <!-- Cover Image Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-image"></i>
                            Book Cover
                        </h3>
                        <div id="cover-preview-area">
                            <div id="cover-preview-content">
                                <i id="cover-upload-icon" class="fas fa-cloud-upload-alt"></i>
                                <p id="cover-preview-text">Click or drag image here...</p>
                                <small style="color: var(--text-muted); margin-top: 8px; display: block;">
                                    Supports JPG, PNG, GIF (max 5MB)
                                </small>
                                <input type="file" id="cover-input" class="cover-input" accept="image/*">
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
                                <label for="bookTitle">Title *</label>
                                <input type="text" id="bookTitle" name="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="bookAuthor">Author *</label>
                                <input type="text" id="bookAuthor" name="author" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="bookGenre">Genre</label>
                                <input type="text" id="bookGenre" name="genre" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="bookYear">Published Year *</label>
                                <input type="number" id="bookYear" name="published_year" class="form-control" required min="1000" max="2099">
                            </div>
                            <div class="form-group">
                                <label for="bookAvailability">Availability *</label>
                                <input type="number" id="bookAvailability" name="availability" class="form-control" required min="0">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeAddBookModal()">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <button type="submit" form="addBookForm" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Add Book
                </button>
            </div>
        </div>
    </div>
    <!-- ADD MEMBER MODAL -->
    <div class="modal" id="julitaRegisterModal" style="display: none;">
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
            <form id="julitaRegisterForm" enctype="multipart/form-data">
                <!-- Personal Information Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-user"></i>
                        Personal Information
                    </h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="julitaFirstName">First Name *</label>
                            <input type="text" id="julitaFirstName" name="firstName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="julitaMiddleName">Middle Name</label>
                            <input type="text" id="julitaMiddleName" name="middleName" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="julitaLastName">Last Name *</label>
                            <input type="text" id="julitaLastName" name="lastName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="julitaAge">Age *</label>
                            <input type="number" id="julitaAge" name="age" class="form-control" min="1" max="150" required>
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
                            <input type="text" id="julitaHouseNumber" name="houseNumber" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="julitaStreet">Street</label>
                            <input type="text" id="julitaStreet" name="street" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="julitaBarangay">Barangay *</label>
                            <select id="julitaBarangay" name="barangay" class="form-control" required>
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
                            <input type="text" id="julitaMunicipality" name="municipality" class="form-control" value="Julita" readonly>
                        </div>
                        <div class="form-group">
                            <label for="julitaProvince">Province *</label>
                            <input type="text" id="julitaProvince" name="province" class="form-control" value="Leyte" readonly>
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
                            <input type="tel" id="julitaContactNumber" name="contactNumber" class="form-control" pattern="[0-9]{11}" maxlength="11" required>
                        </div>
                        <div class="form-group">
                            <label for="julitaSchool">School/Institution</label>
                            <input type="text" id="julitaSchool" name="school" class="form-control">
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
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Register Member
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- REGISTER MODAL (Non-Julita Residents) -->
    <div class="modal" id="registerModal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">
                    <i class="fas fa-user-plus"></i>
                    Register Member
                </h2>
                <button class="close-modal" onclick="closeRegisterModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
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
                            <input type="text" id="firstName" name="firstName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="middleName">Middle Name</label>
                            <input type="text" id="middleName" name="middleName" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name *</label>
                            <input type="text" id="lastName" name="lastName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="age">Age *</label>
                            <input type="number" id="age" name="age" class="form-control" min="1" max="150" required>
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
                            <input type="text" id="houseNumber" name="houseNumber" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="street">Street</label>
                            <input type="text" id="street" name="street" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="barangay">Barangay *</label>
                            <input type="text" id="barangay" name="barangay" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="municipality">Municipality *</label>
                            <input type="text" id="municipality" name="municipality" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="province">Province *</label>
                            <input type="text" id="province" name="province" class="form-control" required>
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
                            <input type="tel" id="contactNumber" name="contactNumber" class="form-control" pattern="[0-9]{11}" maxlength="11" required>
                        </div>
                        <div class="form-group">
                            <label for="school">School/Institution</label>
                            <input type="text" id="school" name="school" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-camera"></i>
                        Upload Photo
                    </h3>
                    <div class="form-group">
                        <label for="photo">Upload Photo</label>
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
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Register Member
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- BOOKS TABLE MODAL -->
    <div class="modal" id="booksTableModal" style="display: none;">
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
                <div class="table-container">
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
    <div class="modal" id="borrowModal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Borrow Books</h3>
                <button class="close-modal" onclick="closeBorrowModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Member Name</label>
                    <input type="text" id="memberName" class="form-control" placeholder="Scan QR code to fill" readonly>
                    <input type="hidden" id="memberId">
                </div>
                <div class="form-group">
                    <label>Due Date</label>
                    <input type="date" id="dueDate" class="form-control">
                </div>
                <div class="form-group">
                    <label>Due Time</label>
                    <input type="time" id="dueTime" class="form-control">
                    <small style="display:block; margin-top:5px; color:var(--text-secondary); font-size:0.85rem;">
                        Default time set to end of day (11:59 PM)
                    </small>
                </div>
                <div class="form-group">
                    <label>Selected Books</label>
                    <ul id="selectedBooksList" style="list-style: none; padding: 0;"></ul>
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
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeBorrowModal()">Cancel</button>
                <button class="btn btn-primary" onclick="confirmBorrow()">Confirm</button>
            </div>
        </div>
    </div>
    <!-- MEMBERS TABLE MODAL -->
    <div class="modal" id="membersTableModal" style="display: none;">
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
                <div class="table-container">
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
        const weeklyData = @json($weeklyData);
        const visitsData = @json($visitsData);
        const borrowersData = @json($borrowers);
    </script>
    <script src="{{ asset('js/dashb.js') }}"></script>
    <script src="{{ asset('js/chatbot.js') }}"></script>
    <script src="{{ asset('js/overdue.js') }}" defer></script>
    <script src="{{ asset('js/bookadd.js') }}"></script>
    <script src="{{ asset('js/memberscript.js') }}"></script>
    <script>
        // Member date and time are automatically filled by the backend
        // Member form submission is now handled by memberscript.js
        // Function to open register modal with Julita resident confirmation
        function openJulitaRegisterModal() {
            console.log('openJulitaRegisterModal called');
            // Close any other open modals first
            closeAllModals();
            const confirmJulita = confirm("Are you a Julita resident?\nClick OK for Yes, Cancel for No.");
            if (confirmJulita) {
                const modal = document.getElementById("julitaRegisterModal");
                if (modal) {
                    modal.classList.add("show");
                    modal.style.display = "flex";
                    document.body.classList.add("modal-open");
                    console.log('Julita modal opened');
                } else {
                    console.error('julitaRegisterModal element not found');
                }
            } else {
                const modal = document.getElementById("registerModal");
                if (modal) {
                    modal.classList.add("show");
                    modal.style.display = "flex";
                    document.body.classList.add("modal-open");
                    console.log('Register modal opened');
                } else {
                    console.error('registerModal element not found');
                }
            }
        }
        // Function to close all modals
        function closeAllModals() {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.classList.remove("show");
                modal.style.display = "none";
            });
            document.body.classList.remove("modal-open");
        }
        // Function to close register modal
        function closeRegisterModal() {
            const registerModal = document.getElementById("registerModal");
            const julitaModal = document.getElementById("julitaRegisterModal");
            registerModal.classList.remove("show");
            registerModal.style.display = "none";
            julitaModal.classList.remove("show");
            julitaModal.style.display = "none";
            document.body.classList.remove("modal-open");
        }
    </script>
<script>
    // Dark mode toggle initialization will be moved to DOMContentLoaded
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
    // Modal functions are now handled by imported bookadd.js and memberscript.js
    // Popup table functions
    function openBooksTable() {
        document.getElementById('booksTableModal').style.display = 'flex';
        loadBooksData();
    }
    function closeBooksTable() {
        document.getElementById('booksTableModal').style.display = 'none';
    }
    function openMembersTable() {
        console.log('openMembersTable called');
        const modal = document.getElementById('membersTableModal');
        if (modal) {
            modal.style.display = 'flex';
            loadMembersData();
            console.log('Members table modal opened');
        } else {
            console.error('membersTableModal element not found');
        }
    }
    function closeMembersTable() {
        document.getElementById('membersTableModal').style.display = 'none';
    }
    async function loadBooksData() {
        try {
            const response = await fetch('{{ route("dashboard.books-data") }}');
            const books = await response.json();
            const tbody = document.getElementById('booksTableBody');
            tbody.innerHTML = '';
            if (books.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" class="loading">No books found</td></tr>';
                return;
            }
            books.forEach((book, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td style="font-weight: 600; color: var(--primary);">${index + 1}</td>
                    <td>${book.title}</td>
                    <td>${book.author}</td>
                    <td>${book.genre || '-'}</td>
                    <td>${book.published_year}</td>
                    <td>${book.availability}</td>
                    <td>${new Date(book.created_at).toLocaleDateString()}</td>
                `;
                tbody.appendChild(row);
            });
        } catch (error) {
            console.error('Error loading books:', error);
            document.getElementById('booksTableBody').innerHTML = '<tr><td colspan="7" class="loading">Error loading books</td></tr>';
        }
    }
    async function loadMembersData() {
        try {
            const response = await fetch('{{ route("dashboard.members-data") }}');
            const members = await response.json();
            const tbody = document.getElementById('membersTableBody');
            tbody.innerHTML = '';
            if (members.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="loading">No members found</td></tr>';
                return;
            }
            members.forEach((member, index) => {
                const fullName = [member.first_name, member.middle_name, member.last_name]
                    .filter(name => name && name !== 'null')
                    .join(' ');
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td style="font-weight: 600; color: var(--primary);">${index + 1}</td>
                    <td>${fullName}</td>
                    <td>${member.age}</td>
                    <td>${member.barangay}</td>
                    <td>${member.contactnumber}</td>
                    <td>${new Date(member.created_at).toLocaleDateString()}</td>
                `;
                tbody.appendChild(row);
            });
        } catch (error) {
            console.error('Error loading members:', error);
            document.getElementById('membersTableBody').innerHTML = '<tr><td colspan="6" class="loading">Error loading members</td></tr>';
        }
    }
    // Store original borrowers data for search
    let originalBorrowersData = [];
    // Load borrowers data on page load
    function loadBorrowersData() {
        const tbody = document.getElementById('borrowersTableBody');
        tbody.innerHTML = '';
        if (borrowersData.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="loading">No borrowers found</td></tr>';
            return;
        }
        // Store original data for search
        originalBorrowersData = [...borrowersData];
        displayBorrowersData(borrowersData);
    }
    // Display borrowers data in table
    function displayBorrowersData(data) {
        const tbody = document.getElementById('borrowersTableBody');
        tbody.innerHTML = '';
        if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="loading">No borrowers found</td></tr>';
            return;
        }
        data.forEach(borrower => {
            const fullName = [borrower.member.first_name, borrower.member.middle_name, borrower.member.last_name]
                .filter(name => name && name !== 'null')
                .join(' ');
            const borrowedDate = new Date(borrower.borrowed_at).toLocaleDateString();
            const dueDate = new Date(borrower.due_date).toLocaleDateString();
            const returnedAt = borrower.returned_at ? new Date(borrower.returned_at).toLocaleDateString() : '-';
            const statusBadge = borrower.returned_at ? 
                '<span style="color: #10b981; font-weight: 600;">Returned</span>' : 
                '<span style="color: #f59e0b; font-weight: 600;">Active</span>';
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${borrower.id}</td>
                <td>${fullName}</td>
                <td>${borrower.book.title}</td>
                <td>${borrowedDate}</td>
                <td>${dueDate}</td>
                <td>${returnedAt}</td>
                <td>${statusBadge}</td>
            `;
            tbody.appendChild(row);
        });
    }
    // Search borrowers function
    function searchBorrowers(searchTerm) {
        if (!searchTerm.trim()) {
            displayBorrowersData(originalBorrowersData);
            return;
        }
        const filteredData = originalBorrowersData.filter(borrower => {
            const fullName = [borrower.member.first_name, borrower.member.middle_name, borrower.member.last_name]
                .filter(name => name && name !== 'null')
                .join(' ')
                .toLowerCase();
            const bookTitle = borrower.book.title.toLowerCase();
            const searchLower = searchTerm.toLowerCase();
            return fullName.includes(searchLower) || 
                   bookTitle.includes(searchLower) ||
                   borrower.id.toString().includes(searchLower);
        });
        displayBorrowersData(filteredData);
    }
    // Filter borrowers by date range
    async function filterBorrowers(filter) {
        try {
            const response = await fetch(`{{ route("dashboard.borrowers-data") }}?filter=${filter}`);
            const borrowers = await response.json();
            // Update original data for search
            originalBorrowersData = [...borrowers];
            // Clear search input
            document.getElementById('borrowerSearch').value = '';
            // Display filtered data
            displayBorrowersData(borrowers);
        } catch (error) {
            console.error('Error loading borrowers:', error);
            document.getElementById('borrowersTableBody').innerHTML = '<tr><td colspan="7" class="loading">Error loading borrowers</td></tr>';
        }
    }
    // Update weekly chart based on month/year selection
    async function updateWeeklyChart() {
        const month = document.getElementById('monthFilter').value;
        const year = document.getElementById('yearFilter').value;
        try {
            const response = await fetch(`{{ route("dashboard.weekly-data") }}?month=${month}&year=${year}`);
            const data = await response.json();
            // Update the chart with new data
            if (window.weeklyChart) {
                window.weeklyChart.data.labels = data.map(item => item.week);
                window.weeklyChart.data.datasets[0].data = data.map(item => item.count);
                window.weeklyChart.update();
            }
        } catch (error) {
            console.error('Error updating weekly chart:', error);
        }
    }
    // Stats data for different time periods
    const statsData = {
        lifetime: {
            mainCount: {{ $lifetimeCount }},
            mainLabel: 'Total Transactions',
            booksCount: {{ $booksCount }},
            membersCount: {{ $membersCount }},
            chartData: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                books: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, {{ $booksCount }}],
                members: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, {{ $membersCount }}]
            }
        },
        today: {
            mainCount: {{ $dailyCount }},
            mainLabel: 'Today\'s Transactions',
            booksCount: {{ $booksToday }},
            membersCount: {{ $membersToday }},
            chartData: {
                labels: ['6AM', '9AM', '12PM', '3PM', '6PM', '9PM'],
                books: [0, {{ $booksToday }}, 0, 0, 0, 0],
                members: [0, {{ $membersToday }}, 0, 0, 0, 0]
            }
        },
        weekly: {
            mainCount: {{ $weeklyCount }},
            mainLabel: 'This Week\'s Transactions',
            booksCount: {{ $booksThisWeek }},
            membersCount: {{ $membersThisWeek }},
            chartData: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                books: [0, 0, 0, 0, 0, 0, {{ $booksThisWeek }}],
                members: [0, 0, 0, 0, 0, 0, {{ $membersThisWeek }}]
            }
        }
    };
    // Filter stats by time period
    function filterStats(period) {
        const data = statsData[period];
        // Update main count and label
        document.getElementById('mainCount').textContent = data.mainCount;
        document.getElementById('mainLabel').textContent = data.mainLabel;
        document.getElementById('booksCount').textContent = data.booksCount;
        document.getElementById('membersCount').textContent = data.membersCount;
        // Update chart
        if (window.statsChart) {
            window.statsChart.data.labels = data.chartData.labels;
            window.statsChart.data.datasets[0].data = data.chartData.books;
            window.statsChart.data.datasets[1].data = data.chartData.members;
            window.statsChart.update();
        }
    }
    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Dashboard page loaded');
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
        });
        // Initialize dark mode toggle
        function initializeDarkModeToggle() {
            const darkModeToggle = document.getElementById('darkModeToggle');
            if (darkModeToggle) {
                console.log('Dark mode toggle found and initialized');
                // Apply saved preference on load
                const savedDarkMode = localStorage.getItem('darkMode') === 'true';
                if (savedDarkMode) {
                    document.body.classList.add('dark-mode');
                    darkModeToggle.classList.add('dark-mode');
                    console.log('Applied dark mode on load');
                } else {
                    console.log('Applied light mode on load');
                }
                // Update label text on load
                const label = document.getElementById('darkModeLabel');
                if (label) {
                    label.textContent = savedDarkMode ? 'Dark Mode' : 'Light Mode';
                    console.log('Label initialized to:', label.textContent);
                }
                console.log('Initial state: dark mode =', savedDarkMode);
                return true;
            } else {
                console.log('Dark mode toggle not found, retrying...');
                return false;
            }
        }
        // Try to initialize immediately
        if (!initializeDarkModeToggle()) {
            // If not found, try again after a short delay
            setTimeout(() => {
                if (!initializeDarkModeToggle()) {
                    // Final attempt after DOM is fully loaded
                    setTimeout(initializeDarkModeToggle, 100);
                }
            }, 50);
        }
        // Make dark mode toggle function globally available for testing
        window.testDarkModeToggle = function() {
            const toggle = document.getElementById('darkModeToggle');
            const label = document.getElementById('darkModeLabel');
            console.log('Testing dark mode toggle:');
            console.log('Toggle element:', toggle);
            console.log('Toggle has dark-mode class:', toggle ? toggle.classList.contains('dark-mode') : 'N/A');
            console.log('Label element:', label);
            console.log('Label text:', label ? label.textContent : 'N/A');
            console.log('Body classes:', document.body.classList.toString());
            if (toggle) {
                // Manually trigger the toggle
                toggle.click();
                console.log('Manual toggle completed');
            }
        };
        // Load all borrowers data by default
        loadBorrowersData();
        // Set current month as default
        const currentMonth = new Date().getMonth() + 1;
        document.getElementById('monthFilter').value = currentMonth;
        // Set current year as default
        const currentYear = new Date().getFullYear();
        document.getElementById('yearFilter').value = currentYear;
        // Initialize stats with lifetime data (default)
        filterStats('lifetime');
        // Set borrowers filter to show all by default
        document.getElementById('borrowersFilter').value = 'all';
        // Test if member card buttons are working
        const memberCardButtons = document.querySelectorAll('.card .btn');
        console.log('Found member card buttons:', memberCardButtons.length);
        // Add click event listeners as backup
        memberCardButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                console.log('Button clicked:', this.onclick?.toString());
            });
        });
    });
</script>
</body>
</html>