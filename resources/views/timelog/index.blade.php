<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <title>🕒 Member Time Logs | Julita Leyte</title>
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

  /* Sidebar */
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
  /* Light mode sidebar */
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

  .sidebar.collapsed {
    width: 80px;
  }

  .sidebar.collapsed .label {
    display: none !important;
  }

  .sidebar.collapsed .sidebar-header {
    justify-content: center;
  }

  .sidebar:not(.collapsed) .label {
    display: inline !important;
    opacity: 1 !important;
    visibility: visible !important;
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
  /* Light mode navigation */
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

  #darkModeLabel {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    font-weight: 500;
    color: rgba(255, 255, 255, 0.8);
    font-size: 14px;
  }

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
    transition: var(--transition);
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

  /* Logout Button */
  .logout-section {
    margin-top: auto;
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
    background: linear-gradient(135deg, #dc2626, var(--danger));
    color: white !important;
    border-color: var(--danger) !important;
    box-shadow: var(--shadow) !important;
    transform: translateY(-2px);
  }
  .logout-text{

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

  .hero-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: var(--spacing);
  }

  .stat-card {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    padding: var(--spacing-lg);
    border-radius: var(--radius-lg);
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: var(--transition);
  }

  .stat-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-xl);
  }

  .stat-number {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: var(--spacing-xs);
  }

  .stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  /* Quick Actions */
  .quick-actions {
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-lg);
    padding: var(--spacing-lg);
    margin-bottom: var(--spacing-xl);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: var(--spacing);
  }

  .search-wrapper {
    flex: 1;
    max-width: 500px;
    position: relative;
  }

  .search-icon {
    position: absolute;
    left: var(--spacing);
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
  }

  .search-input {
    width: 100%;
    padding: var(--spacing) var(--spacing) var(--spacing) 3rem;
    border: 2px solid var(--border);
    border-radius: var(--radius);
    background: var(--surface);
    color: var(--text-primary);
    font-size: 1rem;
    transition: var(--transition);
  }

  .search-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(47, 185, 235, 0.1);
  }

  .action-buttons {
    display: flex;
    gap: var(--spacing);
  }

  .action-btn {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    padding: var(--spacing) var(--spacing-lg);
    border: none;
    border-radius: var(--radius);
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    color: white;
  }

  .action-btn.primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
  }

  .action-btn.secondary {
    background: linear-gradient(135deg, var(--gray-600), var(--gray-700));
  }

  .action-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
  }

  /* Dashboard Grid */
  .dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: var(--spacing-xl);
  }

  .dashboard-card {
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    transition: var(--transition);
  }

  .dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-xl);
  }

  .card-header {
    padding: var(--spacing-lg);
    border-bottom: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--primary);
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
  }

  .card-content {
    padding: var(--spacing-lg);
    max-height: 500px;
    overflow-y: auto;
  }

  .card-content::-webkit-scrollbar {
    width: 6px;
  }

  .card-content::-webkit-scrollbar-thumb {
    background: var(--text-muted);
    border-radius: 8px;
  }

  /* Active Members List */
  .active-member-item {
    display: flex;
    align-items: center;
    gap: var(--spacing);
    padding: var(--spacing);
    background: var(--surface);
    border-radius: var(--radius);
    margin-bottom: var(--spacing);
    transition: var(--transition);
  }

  .active-member-item:hover {
    background: rgba(47, 185, 235, 0.1);
  }

  .member-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.25rem;
  }

  .member-details {
    flex: 1;
  }

  .member-name {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
  }

  .member-school {
    font-size: 0.875rem;
    color: var(--text-muted);
  }

  .empty-state {
    text-align: center;
    padding: var(--spacing-2xl);
    color: var(--text-muted);
  }

  .empty-icon {
    font-size: 3rem;
    margin-bottom: var(--spacing);
    opacity: 0.5;
  }

  /* IMPROVED MODAL */
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(8px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 2000;
    padding: var(--spacing-xl);
    animation: fadeIn 0.3s ease-out;
  }

  .modal-overlay.active {
    display: flex;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
    }
    to {
      opacity: 1;
    }
  }

  .modal-container {
    background: var(--surface);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-xl);
    width: 90vw;
    max-width: 1400px;
    max-height: 85vh;
    display: flex;
    flex-direction: column;
    animation: slideUp 0.3s ease-out;
    overflow: hidden;
  }


  @keyframes slideUp {
    from {
      transform: translateY(50px);
      opacity: 0;
    }
    to {
      transform: translateY(0);
      opacity: 1;
    }
  }

  .modal-header {
    padding: var(--spacing-xl);
    border-bottom: 2px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--surface-elevated);
  }

  .modal-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--primary);
    display: flex;
    align-items: center;
    gap: var(--spacing);
  }

  .modal-close {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    background: var(--border-light);
    color: var(--text-secondary);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    transition: var(--transition);
  }

  .modal-close:hover {
    background: var(--danger);
    color: white;
    transform: rotate(90deg);
  }

  .modal-body {
    padding: var(--spacing-xl);
    overflow-y: auto;
    flex: 1;
  }

  .modal-body::-webkit-scrollbar {
    width: 8px;
  }

  .modal-body::-webkit-scrollbar-thumb {
    background: var(--text-muted);
    border-radius: 8px;
  }

  /* Enhanced Table */
  .table-wrapper {
    overflow-x: auto;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border);
  }

  .data-table {
    width: 100%;
    border-collapse: collapse;
    background: var(--surface);
  }

  .data-table th {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    padding: var(--spacing) var(--spacing-lg);
    text-align: left;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.875rem;
    letter-spacing: 0.5px;
    position: sticky;
    top: 0;
    z-index: 10;
  }

  .data-table td {
    padding: var(--spacing) var(--spacing-lg);
    border-bottom: 1px solid var(--border-light);
    color: var(--text-secondary);
  }

  .data-table tr:hover {
    background: rgba(47, 185, 235, 0.05);
  }

  .data-table tr:last-child td {
    border-bottom: none;
  }

  .duration-badge {
    display: inline-block;
    padding: 0.375rem 0.75rem;
    background: linear-gradient(135deg, var(--success), #059669);
    color: white;
    border-radius: var(--radius);
    font-size: 0.875rem;
    font-weight: 600;
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

    .modal-container {
      width: 95vw;
      max-height: 90vh;
    }
  }

  @media (max-width: 768px) {
    .hero-title {
      font-size: 1.75rem;
    }

    .quick-actions {
      flex-direction: column;
    }

    .search-wrapper {
      max-width: none;
    }

    .dashboard-grid {
      grid-template-columns: 1fr;
    }

    .modal-container {
      width: 100vw;
      max-height: 100vh;
      border-radius: 0;
    }

    .modal-header,
    .modal-body {
      padding: var(--spacing);
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
      <a href="{{ route('members.index') }}" data-label="Members">
        <span class="icon"><i class="fas fa-users"></i></span>
        <span class="label">Members</span>
      </a>
      <a href="{{ route('timelog.index') }}" class="active" data-label="Member Time-in/out">
        <span class="icon"><i class="fas fa-user-clock"></i></span>
        <span class="label">Member Time-in/out</span>
      </a>
      <a href="{{ route('timelog.qrScanner') }}" data-label="QR Scanner">
        <span class="icon"><i class="fas fa-qrcode"></i></span>
        <span class="label">QR Scanner</span>
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
  </div>

  <!-- Main Content -->
  <div class="main">
    <div class="main-content-wrapper">
    <!-- Hero Section -->
    <div class="hero-section">
      <div class="hero-content">
        <h1 class="hero-title">
          <i class="fas fa-clock"></i>
          Member Time Logs
        </h1>
        <p class="hero-subtitle"></p>
        
        <div class="hero-stats">
          <div class="stat-card">
            <i class="fas fa-user-check" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
            <div class="stat-number">{{ $logs->count() }}</div>
            <div class="stat-label">Active Now</div>
          </div>
          <div class="stat-card">
            <i class="fas fa-calendar-day" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
            <div class="stat-number">{{ ($historyLogs ?? collect())->where('time_in', '>=', now()->startOfDay())->count() }}</div>
            <div class="stat-label">Sessions Today</div>
          </div>
          <div class="stat-card">
            <i class="fas fa-clock" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
            <div class="stat-number" id="currentTime">{{ now()->format('H:i:s') }}</div>
            <div class="stat-label">Current Time</div>
          </div>
          <div class="stat-card">
            <i class="fas fa-history" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
            <div class="stat-number">{{ ($historyLogs ?? collect())->count() }}</div>
            <div class="stat-label">Total Sessions</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Dashboard Grid -->
    <div class="dashboard-grid">
      <!-- Active Sessions -->
      <div class="dashboard-card">
        <div class="card-header">
          <div class="card-title">
            <i class="fas fa-user-check"></i>
            Active Sessions
          </div>
          <button style="background: none; border: none; cursor: pointer; color: var(--text-muted);">
            <i class="fas fa-sync-alt"></i>
          </button>
        </div>
        <div class="card-content">
          <!-- Quick Actions -->
          <div class="quick-actions" style="margin-bottom: var(--spacing-lg);">
            <div class="search-wrapper">
              <i class="fas fa-search search-icon"></i>
              <input type="text" class="search-input" placeholder="Search member by name..." id="activeSearch">
            </div>
          </div>
          <!-- Table -->
          <div class="table-wrapper">
            <table class="data-table" id="activeTable">
              <thead>
                <tr>
                  <th>Full Name</th>
                  <th>Time In</th>
                  <th>Time Out</th>
                </tr>
              </thead>
              <tbody>
                @if($logs->count() > 0)
                  @foreach($logs as $log)
                  <tr>
                    <td style="font-weight: 600; color: var(--text-primary);">{{ $log->member->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($log->time_in)->format('h:i A') }}</td>
                    <td>-</td>
                  </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="3" style="text-align: center; padding: var(--spacing-2xl); color: var(--text-muted);">
                      <div class="empty-icon">👥</div>
                      <h3>No Active Sessions</h3>
                      <p>No members are currently logged in.</p>
                    </td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Recent Activity -->
      <div class="dashboard-card">
        <div class="card-header">
          <div class="card-title">
            <i class="fas fa-history"></i>
            Recent Activity
          </div>
          <button onclick="openHistoryModal()" style="background: none; border: none; cursor: pointer; color: var(--primary);">
            <i class="fas fa-external-link-alt"></i> View All
          </button>
        </div>
        <div class="card-content">
          @if($historyLogs->count() > 0)
            @foreach($historyLogs->take(5) as $log)
              <div style="padding: var(--spacing); background: var(--surface); border-radius: var(--radius); margin-bottom: var(--spacing); border-left: 3px solid var(--success);">
                <div style="font-weight: 600; margin-bottom: 0.25rem;">{{ $log->member->name ?? '' }} completed session</div>
                <div style="font-size: 0.875rem; color: var(--text-muted);">
                  {{ \Carbon\Carbon::parse($log->time_in)->format('g:i A') }} - {{ \Carbon\Carbon::parse($log->time_out)->format('g:i A') }} • <span style="color: var(--success);">{{ \Carbon\Carbon::parse($log->time_in)->diff(\Carbon\Carbon::parse($log->time_out))->format('%Hh %Im') }}</span>
                </div>
              </div>
            @endforeach
          @else
            <div class="empty-state">
              <div class="empty-icon">📋</div>
              <h3>No Recent Activity</h3>
              <p>No completed sessions yet.</p>
            </div>
          @endif
        </div>
      </div>

      <!-- QR Scanner -->
      <div class="dashboard-card">
        <div class="card-header">
          <div class="card-title">
            <i class="fas fa-qrcode"></i>
            QR Scanner
          </div>
        </div>
        <div class="card-content">
          <div style="margin-bottom: 24px;">
            <div id="qr-reader" style="width: 100%; height: 320px; border: 2px solid var(--border); border-radius: var(--radius-lg); background: var(--glass-bg); display: flex; align-items: center; justify-content: center; margin: 0 auto;"></div>
          </div>
          <p id="qr-instruction" style="margin: 16px 0 24px 0; color: var(--text-secondary); font-size: 0.95rem; text-align: center; line-height: 1.5;">
            Point your camera at a QR code to scan
          </p>
          <div id="qr-buttons" style="display: flex; justify-content: center; gap: var(--spacing);">
            <button type="button" class="action-btn primary" id="startScannerBtn">
              <i class="fas fa-play"></i>
              <span>Start Scanner</span>
            </button>
            <button type="button" class="action-btn secondary" id="stopScannerBtn" style="display: none;">
              <i class="fas fa-stop"></i>
              <span>Stop Scanner</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- History Modal -->
  <div id="historyModal" class="modal-overlay">
    <div class="modal-container">
      <div class="modal-header">
        <h3 class="modal-title">
          <i class="fas fa-history"></i>
          Complete Session History
        </h3>
        <button class="modal-close" onclick="closeHistoryModal()">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="modal-body">
        @if(($historyLogs ?? collect())->count() > 0)
          <div class="table-wrapper">
            <table class="data-table">
              <thead>
                <tr>
                  <th>Member</th>
                  <th>School</th>
                  <th>Time In</th>
                  <th>Time Out</th>
                  <th>Duration</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                @foreach($historyLogs ?? [] as $log)
                <tr>
                  <td>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                      <div class="member-avatar" style="width: 40px; height: 40px; font-size: 1rem;">{{ strtoupper(substr($log->member->name, 0, 1)) }}</div>
                      <div>
                        <div style="font-weight: 600;">{{ $log->member->name }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">ID: {{ $log->member->id }}</div>
                      </div>
                    </div>
                  </td>
                  <td>{{ $log->member->school }}</td>
                  <td>{{ \Carbon\Carbon::parse($log->time_in)->format('h:i A') }}</td>
                  <td>{{ $log->time_out ? \Carbon\Carbon::parse($log->time_out)->format('h:i A') : '-' }}</td>
                  <td>
                    @if($log->time_out)
                      <span class="duration-badge">{{ \Carbon\Carbon::parse($log->time_in)->diff(\Carbon\Carbon::parse($log->time_out))->format('%Hh %Im') }}</span>
                    @else
                      <span>-</span>
                    @endif
                  </td>
                  <td>{{ \Carbon\Carbon::parse($log->time_in)->format('M d, Y') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="empty-state">
            <div class="empty-icon">📊</div>
            <h3>No History Available</h3>
            <p>No completed sessions found.</p>
          </div>
        @endif
      </div>
    </div>
  </div>

  <script>
    // Dark Mode Toggle
    const darkModeToggle = document.getElementById('darkModeToggle');
    const darkModeLabel = document.getElementById('darkModeLabel');
    const body = document.body;

    // Detect system preference
    const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const savedMode = localStorage.getItem('darkMode');
    const isDark = savedMode ? savedMode === 'true' : prefersDarkMode;

    // Apply mode
    body.classList.toggle('dark-mode', isDark);
    darkModeToggle.checked = isDark;
    darkModeLabel.textContent = isDark ? 'Dark Mode' : 'Light Mode';

    // Toggle dark mode
    darkModeToggle.addEventListener('change', () => {
      const isChecked = darkModeToggle.checked;
      body.classList.toggle('dark-mode', isChecked);
      localStorage.setItem('darkMode', isChecked);
      darkModeLabel.textContent = isChecked ? 'Dark Mode' : 'Light Mode';

      // Add transition class for smooth animation
      body.classList.add('dark-mode-transition');
      setTimeout(() => {
        body.classList.remove('dark-mode-transition');
      }, 600);
    });

    // Update Clock
    function updateClock() {
      const now = new Date();
      const hours = now.getHours();
      const minutes = now.getMinutes();
      const seconds = now.getSeconds();
      const timeString = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
      document.getElementById('currentTime').textContent = timeString;
    }

    updateClock();
    setInterval(updateClock, 1000);

    // Modal Functions
    function openHistoryModal() {
      const modal = document.getElementById('historyModal');
      modal.classList.add('active');
      document.body.style.overflow = 'hidden';
    }

    function closeHistoryModal() {
      const modal = document.getElementById('historyModal');
      modal.classList.remove('active');
      document.body.style.overflow = 'auto';
    }


    // Export function
    function exportData() {
      alert('Export functionality will be implemented with backend');
    }

    // Close modal on overlay click
    const historyModal = document.getElementById('historyModal');

    if (historyModal) {
      historyModal.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal') || e.target.id === 'historyModal') {
          closeHistoryModal();
        }
      });
    }

    // Close modal on Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        closeHistoryModal();
        closeScanQRModal();
      }
    });

    // Search functionality for active table
    document.getElementById('activeSearch').addEventListener('input', function() {
      const searchTerm = this.value.toLowerCase();
      const rows = document.querySelectorAll('#activeTable tbody tr');
      rows.forEach(row => {
        const memberName = row.cells[0].textContent.toLowerCase();
        if (memberName.includes(searchTerm)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    });
  </script>
  
  
  <script src="{{ asset('js/timelog.js') }}"></script>
  <script src="{{ asset('js/memberscript.js') }}"></script>
  <script src="{{ asset('js/sidebarcollapse.js')}}"></script>
  <script src="{{ asset('js/overdue.js') }}"></script>
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
  <script src="{{ asset('js/scanqr.js')}}"></script>

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

                  <!-- Logs and History Tab -->
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
                          <a href="{{ route('system-logs.index') }}" class="btn btn-primary" style="text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; flex: 1;">
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
              const form = document.getElementById('changePasswordForm');
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

      function changePassword() {
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

          const submitBtn = document.querySelector('#changePasswordForm button[type="submit"]');
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

      document.addEventListener('DOMContentLoaded', function() {
          const passwordForm = document.getElementById('changePasswordForm');
          if (passwordForm) {
              passwordForm.addEventListener('submit', function(e) {
                  e.preventDefault();
                  changePassword();
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
</body>
</html>