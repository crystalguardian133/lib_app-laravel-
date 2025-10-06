<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>📘 Julita Library | Bookshelf</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
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

    /* 🌙 DARK MODE */
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
      --glass-blur: blur(10px);

      --shadow-glow: 0 0 25px rgba(99, 102, 241, 0.25);
    }

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
      transition: var(--transition-slow);
      min-height: 100vh;
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    body.dark-mode {
      background: linear-gradient(135deg, #121212, #1a1a1a);
    }

    /* Layout */
    .app-container {
      display: grid;
      grid-template-columns: 280px 1fr;
      min-height: 100vh;
    }

    @media (max-width: 768px) {
      .app-container {
        grid-template-columns: 1fr;
      }
    }

    /* Sidebar */
    .sidebar {
      background: var(--surface);
      backdrop-filter: var(--glass-blur);
      -webkit-backdrop-filter: var(--glass-blur);
      border-right: 1px solid var(--glass-border);
      padding: var(--spacing-lg);
      position: sticky;
      top: 0;
      height: 100vh;
      overflow-y: auto;
      transition: var(--transition);
      box-shadow: var(--glass-shadow);
      z-index: 100;
    }

    .logo {
      font-size: 1.5rem;
      font-weight: 700;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      background-clip: text;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: var(--spacing-xl);
      animation: fadeInDown 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .nav-menu {
      display: flex;
      flex-direction: column;
      gap: var(--spacing-sm);
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 14px 18px;
      border-radius: var(--radius-md);
      color: var(--text-secondary);
      text-decoration: none;
      font-weight: 500;
      transition: var(--transition-spring);
      position: relative;
      overflow: hidden;
    }

    .nav-item::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.1), transparent);
      transition: var(--transition);
    }

    .nav-item:hover::before {
      left: 100%;
    }

    .nav-item.active {
      background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(139, 92, 246, 0.1));
      color: var(--primary);
      font-weight: 600;
      border-left: 3px solid var(--primary);
      box-shadow: var(--shadow-glow);
    }

    .nav-item:hover {
      background: var(--glass-bg);
      backdrop-filter: var(--glass-blur);
      -webkit-backdrop-filter: var(--glass-blur);
      color: var(--primary);
      transform: translateX(6px) scale(1.02);
      box-shadow: var(--shadow-md);
    }

    /* Dark Mode Toggle */
    .dark-mode-toggle {
      margin-top: auto;
      padding: var(--spacing) 0;
      display: flex;
      align-items: center;
      gap: 14px;
      font-weight: 500;
      border-top: 1px solid var(--border);
      padding-top: var(--spacing-lg);
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

    #modeLabel {
      font-weight: 500;
      color: var(--text-secondary);
      transition: var(--transition);
    }

    /* Main */
    main {
      padding: var(--spacing-xl);
      max-width: 1400px;
      margin: 0 auto;
      width: 100%;
      animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Sticky Header Controls */
    .page-controls {
      position: sticky;
      top: 0;
      background: var(--surface);
      backdrop-filter: var(--glass-blur);
      -webkit-backdrop-filter: var(--glass-blur);
      border: 1px solid var(--glass-border);
      z-index: 100;
      padding: var(--spacing-lg);
      margin-bottom: var(--spacing-xl);
      border-radius: var(--radius-lg);
      box-shadow: var(--glass-shadow);
      transition: var(--transition);
    }

    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: var(--spacing);
    }

    .page-title {
      font-size: 2rem;
      font-weight: 800;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      background-clip: text;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .actions {
      display: flex;
      gap: var(--spacing-sm);
    }

    .btn {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 20px;
      border-radius: var(--radius);
      font-weight: 600;
      cursor: pointer;
      border: none;
      transition: var(--transition-spring);
      position: relative;
      overflow: hidden;
      font-size: 0.95rem;
    }

    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: var(--transition);
    }

    .btn:hover::before {
      left: 100%;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      box-shadow: var(--shadow);
    }

    .btn-outline {
      background: transparent;
      color: var(--primary);
      border: 1px solid var(--primary);
      backdrop-filter: var(--glass-blur);
      -webkit-backdrop-filter: var(--glass-blur);
    }

    .btn:hover {
      transform: translateY(-3px) scale(1.02);
      box-shadow: var(--shadow-lg);
    }

    .btn:active {
      transform: translateY(-1px) scale(1.01);
    }

    /* Search */
    .search-bar {
      width: 100%;
      padding: 16px 20px;
      border: 1px solid var(--border);
      border-radius: var(--radius-md);
      font-size: 1rem;
      background: var(--surface-elevated);
      backdrop-filter: var(--glass-blur);
      -webkit-backdrop-filter: var(--glass-blur);
      margin-top: var(--spacing);
      transition: var(--transition);
      color: var(--text-primary);
    }

    .search-bar:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15), var(--shadow-md);
      transform: translateY(-2px);
    }

    /* Book Grid */
    .book-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: var(--spacing-xl);
      margin-bottom: var(--spacing-xl);
    }

    .book-card {
      background: var(--surface);
      backdrop-filter: var(--glass-blur);
      -webkit-backdrop-filter: var(--glass-blur);
      border: 1px solid var(--glass-border);
      border-radius: var(--radius-lg);
      overflow: hidden;
      box-shadow: var(--glass-shadow);
      transition: var(--transition-spring);
      position: relative;
    }

    .book-card::before {
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

    .book-card:hover::before {
      opacity: 1;
    }

    .book-card:hover {
      transform: translateY(-10px) scale(1.02);
      box-shadow: var(--shadow-xl), var(--shadow-glow);
      border-color: rgba(99, 102, 241, 0.3);
    }

    .book-cover {
      width: 100%;
      height: 320px;
      object-fit: cover;
      transition: var(--transition);
    }

    .book-card:hover .book-cover {
      transform: scale(1.05);
    }

    .book-info {
      padding: var(--spacing-lg);
    }

    .book-title {
      font-weight: 700;
      font-size: 1.2rem;
      margin: 0 0 var(--spacing-sm) 0;
      color: var(--text-primary);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .book-meta {
      font-size: 0.9rem;
      color: var(--text-secondary);
      margin-bottom: var(--spacing);
      line-height: 1.5;
    }

    .book-actions {
      display: flex;
      gap: var(--spacing-sm);
    }

    .btn-qr, .btn-borrow {
      flex: 1;
      padding: 10px 16px;
      border: none;
      border-radius: var(--radius);
      font-size: 0.9rem;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition-spring);
      position: relative;
      overflow: hidden;
    }

    .btn-qr {
      background: linear-gradient(135deg, #f3e8ff, #e9d5ff);
      color: var(--primary);
      border: 1px solid rgba(99, 102, 241, 0.2);
    }

    .btn-borrow {
      background: linear-gradient(135deg, #dcfce7, #bbf7d0);
      color: var(--success);
      border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .btn-qr:hover, .btn-borrow:hover {
      transform: translateY(-2px) scale(1.05);
      box-shadow: var(--shadow-md);
    }

    /* MODALS */
    .modal {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
      align-items: center;
      justify-content: center;
      z-index: 2000;
      animation: modalFadeIn 0.3s ease-out;
    }

    @keyframes modalFadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .modal-card {
      background: var(--surface-elevated);
      backdrop-filter: var(--glass-blur);
      -webkit-backdrop-filter: var(--glass-blur);
      border: 1px solid var(--glass-border);
      border-radius: var(--radius-lg);
      overflow: hidden;
      box-shadow: var(--shadow-xl);
      width: 90%;
      max-width: 500px;
      max-height: 90vh;
      display: flex;
      flex-direction: column;
      animation: modalSlideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes modalSlideIn {
      from { transform: translateY(30px) scale(0.9); opacity: 0; }
      to { transform: translateY(0) scale(1); opacity: 1; }
    }

    .modal-header {
      padding: var(--spacing-lg);
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: var(--shadow);
    }

    .modal-title {
      font-size: 1.3rem;
      font-weight: 700;
    }

    .modal-close {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      color: white;
      width: 36px;
      height: 36px;
      border-radius: 50%;
      font-size: 1.5rem;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: var(--transition);
    }

    .modal-close:hover {
      background: rgba(255, 255, 255, 0.25);
      transform: scale(1.1) rotate(90deg);
    }

    .modal-body {
      padding: var(--spacing-xl);
      overflow-y: auto;
      flex: 1;
    }

    .form-group {
      margin-bottom: var(--spacing-lg);
    }

    .form-group label {
      display: block;
      margin-bottom: var(--spacing-sm);
      font-weight: 600;
      color: var(--text-primary);
    }

    .form-control {
      width: 100%;
      padding: 12px 16px;
      border: 1px solid var(--border);
      border-radius: var(--radius);
      font-size: 1rem;
      background: var(--surface-elevated);
      color: var(--text-primary);
      transition: var(--transition);
    }

    .form-control:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15), var(--shadow-md);
      transform: translateY(-1px);
    }

    .modal-footer {
      padding: var(--spacing-lg);
      display: flex;
      gap: var(--spacing);
      border-top: 1px solid var(--border);
      background: var(--surface);
    }

    /* Cover Preview Area */
    .cover-preview-area {
      width: 100%;
      height: 400px;
      border-radius: var(--radius-md);
      overflow: hidden;
      margin-bottom: var(--spacing-lg);
      position: relative;
      cursor: pointer;
      transition: var(--transition-spring);
      border: 2px dashed var(--border);
      background: var(--surface);
    }

    .cover-preview-area.drag-over {
      border-color: var(--accent);
      background-color: rgba(6, 182, 212, 0.1);
      transform: scale(1.02);
      box-shadow: var(--shadow-glow);
    }

    #cover-preview-content {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100%;
      color: var(--text-secondary);
      font-size: 1rem;
      text-align: center;
      background-color: var(--surface);
      background-size: cover;
      background-position: center;
      transition: var(--transition);
      font-weight: 500;
    }

    .cover-input {
      position: absolute;
      width: 100%;
      height: 100%;
      opacity: 0;
      cursor: pointer;
      z-index: 2;
    }

    #cover-upload-icon {
      font-size: 4rem;
      margin-bottom: 12px;
      transition: var(--transition-spring);
      color: var(--accent);
    }

    #cover-preview-text {
      font-size: 1.1rem;
      font-weight: 600;
      transition: var(--transition);
      color: var(--text-secondary);
    }

    #cover-preview-text small {
      display: block;
      font-size: 0.9rem;
      opacity: 0.7;
      margin-top: 10px;
    }

    #cover-preview-content:hover #cover-upload-icon {
      color: var(--primary);
      transform: scale(1.1);
    }

    /* Selection Mode Bar */
    .selection-mode {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background: linear-gradient(135deg, var(--accent), var(--accent-dark));
      color: white;
      padding: var(--spacing-lg) var(--spacing-xl);
      z-index: 1000;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: 600;
      box-shadow: var(--shadow-lg);
      backdrop-filter: var(--glass-blur);
      -webkit-backdrop-filter: var(--glass-blur);
    }

    .book-card.selected {
      outline: 4px solid var(--accent);
      outline-offset: -4px;
      transform: translateY(-5px) scale(1.02);
      box-shadow: var(--shadow-xl), 0 0 30px rgba(6, 182, 212, 0.4);
    }

    /* Toast Notifications */
    .toast {
      padding: 16px 24px;
      margin-bottom: 12px;
      border-radius: var(--radius-md);
      color: white;
      font-weight: 600;
      box-shadow: var(--shadow-lg);
      animation: toastSlideIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1), 
                 fadeOut 0.3s 2.7s forwards;
      max-width: 360px;
      backdrop-filter: var(--glass-blur);
      -webkit-backdrop-filter: var(--glass-blur);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    @keyframes toastSlideIn {
      0% { opacity: 0; transform: translateY(-30px) scale(0.8) rotate(-2deg); }
      50% { transform: translateY(5px) scale(1.05) rotate(1deg); }
      100% { opacity: 1; transform: translateY(0) scale(1) rotate(0deg); }
    }

    @keyframes fadeOut {
      from { opacity: 1; transform: translateY(0); }
      to { opacity: 0; transform: translateY(-20px); }
    }

    .toast-info { 
      background: linear-gradient(135deg, var(--accent), var(--accent-dark)); 
    }
    .toast-success { 
      background: linear-gradient(135deg, var(--success), #059669); 
    }
    .toast-warning { 
      background: linear-gradient(135deg, var(--warning), #d97706); 
    }
    .toast-error { 
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
      .app-container {
        grid-template-columns: 1fr;
      }
      
      .sidebar {
        position: relative;
        height: auto;
      }
      
      main {
        padding: var(--spacing-lg);
      }
      
      .book-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: var(--spacing-lg);
      }
      
      .page-title {
        font-size: 1.5rem;
      }
      
      .actions {
        flex-direction: column;
        width: 100%;
      }
      
      .btn {
        justify-content: center;
      }
    }

    @media (max-width: 480px) {
      main {
        padding: var(--spacing);
      }
      
      .book-grid {
        grid-template-columns: 1fr;
      }
      
      .page-controls {
        padding: var(--spacing);
        margin-bottom: var(--spacing-lg);
      }
    }
    
    .sidebar-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: var(--spacing-xl);
    transition: var(--transition);
}

.sidebar.collapsed .sidebar-header {
    justify-content: center;
    opacity: 0.8;
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

.sidebar.collapsed .label {
    display: none;
}
.logo-icon {
    font-size: 2rem;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    transition: var(--transition-spring);
    filter: drop-shadow(0 2px 4px rgba(99, 102, 241, 0.2));
}

.logo-icon:hover {
    transform: scale(1.05) rotate(2deg);
}
.sidebar-header.animated {
    animation: fadeInDown 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes fadeInDown {
    from { 
        opacity: 0; 
        transform: translateY(-30px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}
@media (max-width: 768px) {
    .sidebar-header .label {
        display: none !important;
    }
    
    .sidebar-header {
        justify-content: center;
    }
    
    .sidebar-header .logo {
        width: 36px;
        height: 36px;
    }
}
  </style>
</head>
<body>

  <div class="app-container">
    <!-- Sidebar -->
    <aside class="sidebar">
    <div class="sidebar-header animated">
    <img src="/images/logo.png" alt="Library Logo" class="logo">
    <span class="label">Julita Public Library</span>
</div>
      <nav class="nav-menu">
        <a href="{{ route('dashboard') }}" class="nav-item"><i class="fas fa-th"></i> Dashboard</a>
        <a href="{{ route('books.index') }}" class="nav-item active"><i class="fas fa-book"></i> Books</a>
        <a href="{{ route('members.index') }}" class="nav-item"><i class="fas fa-users"></i> Members</a>
        <a href="{{ route('transactions.index') }}" class="nav-item"><i class="fas fa-file-alt"></i> Transactions</a>
      </nav>
      <div class="dark-mode-toggle">
        <label class="switch" title="Toggle Dark Mode">
          <input type="checkbox" id="darkModeToggle">
          <span class="slider">
            <span class="slider-thumb">
              <span class="icon-sun">🌞</span>
              <span class="icon-moon">🌙</span>
            </span>
          </span>
        </label>
        <span id="modeLabel">Light Mode</span>
      </div>
    </aside>

    <!-- Main -->
    <main>
      <div class="page-controls">
        <div class="page-header">
          <h1 class="page-title">📚 Your Collection</h1>
          <div class="actions">
            <button class="btn btn-outline" onclick="enterSelectionMode()">
              <i class="fas fa-check-square"></i> Select
            </button>
            <button class="btn btn-primary" onclick="openAddBookModal()">
              <i class="fas fa-plus"></i> Add
            </button>
          </div>
        </div>
        <input
          type="text"
          class="search-bar"
          placeholder="🔍 Search by title, author, or genre..."
          id="searchInput"
        />
      </div>

<div class="book-grid" id="bookGrid">
  @foreach($books as $book)
    <div class="book-card"
         data-id="{{ $book->id }}"
         data-title="{{ $book->title }}"
         data-author="{{ $book->author }}"
         data-genre="{{ $book->genre }}"
         data-published-year="{{ $book->published_year }}"
         data-availability="{{ $book->availability }}"
         data-cover-image="{{ $book->cover_image ?? '' }}">
      <img src="{{ $book->cover_image ?? '/images/no-cover.png' }}" alt="Cover" class="book-cover">
      <div class="book-info">
        <h3 class="book-title">{{ $book->title }}</h3>
        <div class="book-meta">
          <div>by {{ $book->author }}</div>
          <div>{{ $book->genre }} • {{ $book->published_year }}</div>
          <div><strong>Available:</strong> {{ $book->availability > 0 ? 'Yes' : 'No' }}</div>
        </div>
        <div class="book-actions">
          @if(!empty($book->qr_url))
            <button class="btn-qr" onclick="showQRModal('{{ $book->title }}', '{{ $book->qr_url }}')">QR</button>
          @else
            <button class="btn-qr" onclick="generateQr({{ $book->id }})">Gen</button>
          @endif
          <button class="btn-borrow" onclick="borrowOne({{ $book->id }})">Borrow</button>
        </div>
      </div>
    </div>
  @endforeach
</div>

  <!-- Selection Mode Bar -->
  <div class="selection-mode" id="selectionBar" style="display:none;">
    <span id="selectedCount">0 books selected</span>
    <div>
      <button class="btn btn-outline" style="color:white;" onclick="exitSelectionMode()">Cancel</button>
      <button class="btn btn-light" style="background:white; color:var(--accent);" onclick="openBorrowModal()">Borrow</button>
      <button class="btn btn-light" id="editButton" style="background:white; color:#7e22ce; display:none;" onclick="openEditModal()">
        <i class="fas fa-edit"></i> Edit
      </button>
    </div>
  </div>

  <!-- ADD BOOK MODAL -->
  <div class="modal" id="addBookModal">
    <div class="modal-card">
      <div class="modal-header">
        <h3 class="modal-title">➕ Add New Book</h3>
        <button class="modal-close" onclick="closeAddBookModal()">&times;</button>
      </div>
      <div class="modal-body">
        <form id="addBookForm" enctype="multipart/form-data">
          @csrf
<div id="cover-preview-area" class="cover-preview-area">
  <div id="cover-preview-content">
    <i id="cover-upload-icon" class="fas fa-cloud-upload-alt"></i>
    <p id="cover-preview-text">Click or drag image here...</p>
    <input type="file" id="cover-input" class="cover-input">
  </div>
</div>          <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Author</label>
            <input type="text" name="author" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Genre</label>
            <input type="text" name="genre" class="form-control">
          </div>
          <div class="form-group">
            <label>Published Year</label>
            <input type="number" name="published_year" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Availability</label>
            <input type="number" name="availability" class="form-control" required min="0">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline" onclick="closeAddBookModal()">Cancel</button>
        <button class="btn btn-primary" form="addBookForm" type="submit">Add Book</button>
      </div>
    </div>
  </div>

  <!-- EDIT MODAL -->
  <div class="modal" id="manage-modal">
    <div class="modal-card">
      <div class="modal-header">
        <h3 class="modal-title">✏️ Edit Book</h3>
        <button class="modal-close" onclick="closeModal()">&times;</button>
      </div>
      <div class="modal-body">
        <div class="cover-preview-area" id="cover-preview-area">
          <div class="cover-preview-content" id="cover-preview-content">
            <i class="fas fa-cloud-upload-alt" id="cover-upload-icon"></i>
            <p id="cover-preview-text">Click or drag image here<br><small>Supports JPG, PNG (max 5MB)</small></p>
            <input type="file" id="cover-input" accept="image/*" class="cover-input">
          </div>
        </div>
        <div class="form-group">
          <label>Title</label>
          <input type="text" id="edit-title" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Author</label>
          <input type="text" id="edit-author" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Genre</label>
          <input type="text" id="edit-genre" class="form-control">
        </div>[]][][]1121
        <div class="form-group">
          <label>Published Year</label>
          <input type="number" id="edit-published-year" class="form-control" min="1000" max="2099" required>
        </div>
        <div class="form-group">
          <label>Availability</label>
          <input type="number" id="edit-availability" class="form-control" required min="0">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline" onclick="closeModal()">Cancel</button>
        <button class="btn btn-danger" id="delete-button">Delete</button>
        <button class="btn btn-primary" onclick="saveChanges()" id="save-button">
          <i class="fas fa-save"></i> Save Changes
        </button>
      </div>
    </div>
  </div>

  <!-- BORROW MODAL -->
  <div class="modal" id="borrowModal">
    <div class="modal-card">
      <div class="modal-header">
        <h3 class="modal-title">📦 Borrow Books</h3>
        <button class="modal-close" onclick="closeBorrowModal()">&times;</button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>👤 Member Name</label>
          <input type="text" id="memberName" class="form-control" placeholder="Scan QR code to fill" readonly>
          <input type="hidden" id="memberId">
        </div>
        <div class="form-group">
          <label>📅 Due Date</label>
          <input type="date" id="dueDate" class="form-control">
        </div>
        <div class="form-group">
          <label>⏰ Due Time</label>
          <input type="time" id="dueTime" class="form-control" value="<?= date('H:i') ?>">
          <small class="time-hint" style="display:block; margin-top:5px; color:var(--text-secondary); font-size:0.85rem;">
            Default time set to end of day (11:59 PM)
          </small>
        </div>
        <div class="form-group">
          <label>📚 Selected Books</label>
          <ul id="selectedBooksList"></ul>
        </div>
        <div style="display: flex; gap: 10px; margin-top: 1rem;">
          <button type="button" class="btn btn-outline" onclick="startQRScan('member')">
            <i class="fas fa-person"></i> Scan Member
          </button>
        </div>
<<<<<<< Updated upstream
        <div style="display: flex; gap: 10px; margin-top: 1rem;">
          <button type="button" class="btn btn-outline" onclick="startQRScan('book')">
            <i class="fas fa-book"></i> Scan Books
          </button>
=======
    </div>

    <!-- BORROW MODAL -->
    <div class="modal" id="borrowModal" style="z-index: 999999900 !important;">
        <div class="modal-content" style="max-width: 900px !important;">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-hand-holding"></i>
                    Borrow Books
                </h3>
                <button class="close-modal" onclick="closeBorrowModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- Member Information Section -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-user"></i>
                        Member Information
                    </h4>
                    <div class="form-group">
                        <label for="memberName">Member Name</label>
                        <div style="display: flex; gap: 8px;">
                            <input type="text" id="memberName" class="form-control" placeholder="Scan QR code to fill member information" readonly style="background-color: var(--surface-elevated); cursor: not-allowed; flex: 1;" onchange="if (typeof window.updateConfirmButtonState === 'function') { window.updateConfirmButtonState(); }">
                            <button type="button" class="btn btn-outline btn-sm" onclick="clearMemberInfo()" title="Clear member information">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <input type="hidden" id="memberId">
                        <small style="display:block; margin-top:5px; color:var(--text-muted); font-size:0.8rem;">
                            <i class="fas fa-info-circle"></i> This field is automatically filled when you scan a member QR code
                        </small>
                    </div>
                </div>

                <!-- Borrow Details Section -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-calendar-alt"></i>
                        Borrow Details
                    </h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="dueDate">Due Date</label>
                            <input type="date" id="dueDate" class="form-control">
                            <small style="display:block; margin-top:5px; color:var(--text-secondary); font-size:0.85rem;">
                                Only working days (Mon-Fri, excluding holidays) are available, including today if it's a working day
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="dueTime">Due Time</label>
                            <!-- Custom Precise Time Picker -->
                            <div id="customTimePicker" class="custom-time-picker" style="display: flex; align-items: center; gap: 8px; margin-top: 8px;">
                                <select id="dueHour" class="form-control" style="flex: 1; max-width: 80px;">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                                <span style="color: var(--text-secondary);">:</span>
                                <select id="dueMinute" class="form-control" style="flex: 1; max-width: 80px;">
                                    <option value="00">00</option>
                                    <option value="15">15</option>
                                    <option value="30">30</option>
                                    <option value="45">45</option>
                                </select>
                                <select id="dueAmPm" class="form-control" style="flex: 1; max-width: 80px;">
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                </select>
                            </div>
                            <!-- Hidden input to store the actual time value -->
                            <input type="hidden" id="dueTime" name="dueTime">
                            <small style="display:block; margin-top:5px; color:var(--text-secondary); font-size:0.85rem;">
                                Select hour, minute, and AM/PM precisely
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Selected Books Section -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-book"></i>
                        Selected Books
                    </h4>
                    <div class="form-group">
                        <ul id="selectedBooksList" style="list-style: none; padding: 0; max-height: 150px; overflow-y: auto; border: 1px solid var(--border-light); border-radius: var(--radius-sm); padding: 10px; background: var(--glass-bg); min-height: 50px;"></ul>
                        <small style="display:block; margin-top:5px; color:var(--text-muted); font-size:0.8rem;">
                            <i class="fas fa-info-circle"></i> Books will appear here when selected
                        </small>
                    </div>
                </div>

                <!-- Action Buttons Section -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-qrcode"></i>
                        Quick Actions
                    </h4>
                    <div style="display: flex; gap: 10px; margin-top: 1rem;">
                        <button type="button" class="btn btn-primary" onclick="showQRScannerModal('member')" style="flex: 1;">
                            <i class="fas fa-qrcode"></i> Scan Member QR
                        </button>
                        <button type="button" class="btn btn-outline" onclick="showQRScannerModal('book')" style="flex: 1;">
                            <i class="fas fa-qrcode"></i> Scan Books
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" onclick="closeBorrowModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button class="btn btn-primary" id="confirmBorrowBtn" disabled>
                    <i class="fas fa-qrcode"></i> Scan Member
                </button>
            </div>
>>>>>>> Stashed changes
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline" onclick="closeBorrowModal()">Cancel</button>
        <button class="btn btn-primary" onclick="confirmBorrow()">Confirm</button>
      </div>
    </div>
  </div>

  <!-- QR SCANNER MODAL -->
  <div class="modal" id="qrScannerModal">
    <div class="modal-card" style="max-width: 400px;">
      <div class="modal-header">
        <h3 class="modal-title">📷 Scan QR Code</h3>
        <button class="modal-close" onclick="stopQRScan()">&times;</button>
      </div>
      <div class="modal-body scanner-body">
        <div id="qr-reader" style="width: 100%; min-height: 250px;"></div>
        <div id="qr-scanner-error" class="error-message hidden"></div>
        <p class="scanner-instructions">
          Point your camera at the QR code
        </p>
      </div>
    </div>
  </div>

  <!-- QR MODAL -->
  <div class="modal" id="qrModal">
    <div class="modal-card" style="max-width: 400px;">
      <div class="modal-header">
        <h3 id="qrModalTitle" class="modal-title">QR Code</h3>
        <button class="modal-close" onclick="closeQRModal()">&times;</button>
      </div>
      <div class="modal-body" style="text-align: center;">
        <img id="qrImage" class="qr-image" src="" alt="QR">
        <a id="downloadLink" class="btn-download" download>📥 Download QR</a>
      </div>
    </div>
  </div>

  <!-- Toast Notifications -->
  <div id="toast-container" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;"></div>

  <!-- SCRIPTS -->
  <script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
  <script src="{{ asset('js/bookadd.js') }}"></script>
  <script src="{{ asset('js/bookmanage.js') }}"></script>
  <script src="{{ asset('js/borrow.js') }}"></script>
  <script src="{{ asset('js/qrgen.js') }}"></script>
  <script src="{{ asset('js/showqr.js') }}"></script>
  <script src="{{ asset('js/overdue.js') }}"></script>
<<<<<<< Updated upstream
  <script src="{{ asset('js/qrscanner-borrow.js') }}"></script>

  <!-- Internal Modal Controls -->
  <script>
    let selectedBooks = [];
    const darkModeToggle = document.getElementById('darkModeToggle');
    const modeLabel = document.getElementById('modeLabel');

    // Detect system preference
    const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const savedMode = localStorage.getItem('darkMode');
    const isDark = savedMode ? savedMode === 'true' : prefersDarkMode;

    // Apply mode
    document.body.classList.toggle('dark-mode', isDark);
    darkModeToggle.checked = isDark;
    modeLabel.textContent = isDark ? 'Dark Mode' : 'Light Mode';

    // Toggle dark mode
    darkModeToggle.addEventListener('change', () => {
      const isChecked = darkModeToggle.checked;
      document.body.classList.toggle('dark-mode', isChecked);
      localStorage.setItem('darkMode', isChecked);
      modeLabel.textContent = isChecked ? 'Dark Mode' : 'Light Mode';
    });

    // --- Selection Mode ---
    function enterSelectionMode() {
      document.getElementById('selectionBar').style.display = 'flex';
      document.querySelectorAll('.book-card').forEach(card => {
        card.onclick = () => toggleSelection(card);
      });
    }

    function exitSelectionMode() {
      document.getElementById('selectionBar').style.display = 'none';
      document.querySelectorAll('.book-card').forEach(card => {
        card.onclick = null;
      });
      document.querySelectorAll('.book-card.selected').forEach(c => c.classList.remove('selected'));
      selectedBooks = [];
      updateSelectionUI();
    }

    function toggleSelection(card) {
      const id = card.dataset.id;
      const title = card.dataset.title;
      const index = selectedBooks.findIndex(b => b.id == id);

      if (index === -1) {
        selectedBooks.push({ id, title });
        card.classList.add('selected');
      } else {
        selectedBooks.splice(index, 1);
        card.classList.remove('selected');
      }
      updateSelectionUI();
    }

    function updateSelectionUI() {
      const count = selectedBooks.length;
      document.getElementById('selectedCount').textContent = `${count} book(s) selected`;
      document.getElementById('editButton').style.display = count === 1 ? 'inline-flex' : 'none';
    }

    // --- Modals ---
    function openAddBookModal() {
      document.getElementById('addBookModal').style.display = 'flex';
    }

    function closeAddBookModal() {
      document.getElementById('addBookModal').style.display = 'none';
    }

    function openEditModal() {
      const book = selectedBooks[0];
      document.getElementById('edit-title').value = book.title;
      document.getElementById('edit-author').value = book.author;
      document.getElementById('manage-modal').style.display = 'flex';
    }

    function closeModal() {
      document.getElementById('manage-modal').style.display = 'none';
    }

    function openBorrowModal() {
      const list = document.getElementById('selectedBooksList');
      list.innerHTML = '';
      selectedBooks.forEach(book => {
        const li = document.createElement('li');
        li.textContent = book.title;
        list.appendChild(li);
      });
      document.getElementById('borrowModal').style.display = 'flex';
    }

    function closeBorrowModal() {
      document.getElementById('borrowModal').style.display = 'none';
    }

    function showQRModal(title, url) {
      document.getElementById('qrModalTitle').textContent = title;
      document.getElementById('qrImage').src = url;
      document.getElementById('downloadLink').href = url;
      document.getElementById('qrModal').style.display = 'flex';
    }

    function closeQRModal() {
      document.getElementById('qrModal').style.display = 'none';
    }

    // --- Cover Preview ---
    function previewCover(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = e => {
          const cover = document.querySelector('.edit-modal-cover');
          cover.style.backgroundImage = `url(${e.target.result})`;
          cover.style.backgroundSize = 'cover';
          cover.style.backgroundPosition = 'center';
          cover.style.color = 'transparent';
        };
        reader.readAsDataURL(file);
      }
    }

    // --- Search ---
    document.getElementById('searchInput').addEventListener('input', (e) => {
      const term = e.target.value.toLowerCase();
      document.querySelectorAll('.book-card').forEach(card => {
        const title = card.dataset.title.toLowerCase();
        const author = card.dataset.author.toLowerCase();
        card.style.display = (title.includes(term) || author.includes(term)) ? 'block' : 'none';
      });
    });
  </script>
=======

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

            // Set default due date and time using Philippine timezone and business days
            function calculatePhilippineBusinessDueDate() {
                // Use Philippine timezone directly (this is more reliable)
                const now = new Date();
                const philippineTime = new Date(now.toLocaleString("en-US", {timeZone: "Asia/Manila"}));

                // Start from current date for due date calculation (including today)
                const startDate = new Date(philippineTime);

                // Calculate 10 working days (Monday to Friday, excluding weekends)
                // Include today if it's a working day
                let workingDaysCount = 0;
                let currentDate = new Date(startDate);

                while (workingDaysCount < 10) {
                    // Check if it's a weekday (Monday = 1, Friday = 5)
                    const dayOfWeek = currentDate.getDay();
                    if (dayOfWeek >= 1 && dayOfWeek <= 5) {
                        workingDaysCount++;
                    }

                    // Move to next day
                    currentDate.setDate(currentDate.getDate() + 1);
                }

                return {
                    date: currentDate.toISOString().split('T')[0],
                    time: '23:59' // End of day
                };
            }

            // Set current date as default (user can change it)
            const today = new Date(philippineTime);
            const currentDate = today.toISOString().split('T')[0];
            document.getElementById('dueDate').value = currentDate;

            // Set current time as default
            const currentHour = today.getHours();
            const currentMinute = Math.floor(today.getMinutes() / 15) * 15; // Round to nearest 15 minutes
            const hour12 = currentHour === 0 ? 12 : currentHour > 12 ? currentHour - 12 : currentHour;
            const ampm = currentHour >= 12 ? 'PM' : 'AM';
            const minuteStr = currentMinute.toString().padStart(2, '0');

            // Set time picker values
            document.getElementById('dueHour').value = hour12.toString();
            document.getElementById('dueMinute').value = minuteStr;
            document.getElementById('dueAmPm').value = ampm;
            document.getElementById('dueTime').value = `${currentHour.toString().padStart(2, '0')}:${minuteStr}`;

            // Initialize search functionality
            initializeSearch();

            // Initialize confirm button state - use the one from borrow.js
            if (typeof window.updateConfirmButtonState === 'function') {
                window.updateConfirmButtonState();
            }

            // Add event listeners for selected books list changes
            const selectedBooksList = document.getElementById('selectedBooksList');
            if (selectedBooksList) {
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (typeof window.updateConfirmButtonState === 'function') {
                            window.updateConfirmButtonState();
                        }
                    });
                });
                observer.observe(selectedBooksList, { childList: true });
            }
        });

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

        // Modal functions
        function openAddBookModal() {
            const modal = document.getElementById('addBookModal');
            modal.classList.add('show');
            modal.style.display = 'flex';
        }

        function closeAddBookModal() {
            const modal = document.getElementById('addBookModal');
            modal.classList.remove('show');
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
            // Handle QR scanner modal click outside
            if (e.target.id === 'qrScannerModal') {
                if (typeof window.closeQRScanner === 'function') {
                    window.closeQRScanner();
                }
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
>>>>>>> Stashed changes
</body>
</html>