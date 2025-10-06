<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>👥 Members | Julita Public Library</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
<style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --accent: #06b6d4;
            --accent-light: #67e8f9;
            --light: #f8fafc;
            --dark: #1e293b;
            --white: #ffffff;
            --gray: #64748b;
            --gray-light: #f1f5f9;
            --bg-dark: #0f172a;
            --text-dark: #e2e8f0;
            --hover-dark: #1e293b;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --highlight: #e0e7ff;
            --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --border-radius: 16px;
            --border-radius-sm: 8px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

<<<<<<< Updated upstream
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--light) 0%, #f0f9ff 100%);
            color: var(--dark);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
        }
=======
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
>>>>>>> Stashed changes

        body.dark-mode {
            background: linear-gradient(135deg, var(--bg-dark) 0%, #0c1426 100%);
            color: var(--text-dark);
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

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            height: 100vh;
            padding: 1.5rem 1rem;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
            z-index: 2000;
            backdrop-filter: blur(10px);
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header .logo {
            width: 40px;
            height: 40px;
            background: var(--accent);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 12px rgba(6, 182, 212, 0.3);
        }

        .sidebar-header h3 {
            font-size: 1.1rem;
            font-weight: 600;
            opacity: 1;
            transition: opacity 0.3s;
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

        .sidebar nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .sidebar nav a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 0;
            height: 100%;
            background: linear-gradient(90deg, rgba(255,255,255,0.1), transparent);
            transition: width 0.3s ease;
        }

        .sidebar nav a:hover::before {
            width: 100%;
        }

        .sidebar nav a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(6px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .sidebar nav a.active {
            background: var(--accent);
            color: white;
            box-shadow: 0 4px 15px rgba(6, 182, 212, 0.4);
        }

        .sidebar nav a .icon {
            font-size: 1.2rem;
            width: 20px;
            text-align: center;
        }

        .dark-toggle {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 52px;
            height: 28px;
            margin-bottom: 1rem;
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
            background-color: rgba(255,255,255,0.2);
            transition: 0.4s;
            border-radius: 34px;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        }

        .slider:before {
            position: absolute;
            content: "🌞";
            height: 24px;
            width: 24px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 24px;
            font-size: 12px;
            transition: 0.4s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        input:checked + .slider {
            background-color: var(--accent);
        }

        input:checked + .slider:before {
            transform: translateX(24px);
            content: "🌙";
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
            margin-left: 260px;
            padding: 1.5rem;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
            overflow-x: hidden;
            max-width: calc(100vw - 260px);
        }

<<<<<<< Updated upstream
        .main.collapsed {
            margin-left: 70px;
            max-width: calc(100vw - 70px);
        }
=======
  body {
    overflow: hidden;
  }

  .dashboard-content {
    display: flex;
    flex-direction: column;
    flex: 1;
    min-height: 0;
    height: 100%;
    overflow: hidden;
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
>>>>>>> Stashed changes

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        body.dark-mode .page-header {
            background: rgba(30, 41, 59, 0.8);
            border-color: rgba(51, 65, 85, 0.3);
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        body.dark-mode .page-title {
            color: var(--accent-light);
        }

        .top-controls {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
            align-items: center;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        body.dark-mode .top-controls {
            background: rgba(30, 41, 59, 0.8);
            border-color: rgba(51, 65, 85, 0.3);
        }

        .search-box {
            position: relative;
            flex: 1;
            min-width: 250px;
            max-width: 400px;
        }

        .search-box input {
            width: 100%;
            padding: 14px 18px 14px 50px;
            font-size: 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            background: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(6, 182, 212, 0.1);
            transform: translateY(-1px);
        }

        .search-box .search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 1.1rem;
        }

        body.dark-mode .search-box input {
            background: var(--bg-dark);
            border-color: #475569;
            color: var(--text-dark);
        }

        .btn {
            padding: 14px 28px;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent) 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(6, 182, 212, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(6, 182, 212, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, var(--gray) 0%, #6b7280 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(100, 116, 139, 0.3);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(100, 116, 139, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
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
            color: var(--accent);
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

<<<<<<< Updated upstream
        /* Table Styles */
        .table-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            overflow-x: auto;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: 1rem;
            position: relative;
        }
=======
  /* Table Styles */
  .table-container {
    background: var(--glass-bg);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-lg);
    overflow: auto;
    box-shadow: var(--glass-shadow);
    margin-top: var(--spacing);
    display: flex;
    justify-content: center;
    align-items: flex-start;
    flex: 1;
    height: calc(100vh - 220px);
    max-height: calc(100vh - 200px);
  }
>>>>>>> Stashed changes

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

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

<<<<<<< Updated upstream
        thead {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }

        th {
            padding: 1rem 0.75rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            position: relative;
            white-space: nowrap;
        }
=======
  .data-table th {
    background: var(--glass-bg);
    color: var(--text-primary);
    font-weight: 600;
    padding: 8px 6px;
    text-align: center;
    border-bottom: 2px solid var(--border);
    position: sticky;
    top: 0;
    z-index: 10;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
  }
>>>>>>> Stashed changes

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
            width: 180px;
            min-width: 160px;
        }

        th:nth-child(2) {
            width: 70px;
            min-width: 50px;
        }

        th:nth-child(3) {
            width: 220px;
            min-width: 180px;
        }

        th:nth-child(4) {
            width: 130px;
            min-width: 110px;
        }

        th:nth-child(5) {
            width: 180px;
            min-width: 140px;
        }

        th:nth-child(6) {
            width: 90px;
            min-width: 70px;
        }

        th:nth-child(7) {
            width: 90px;
            min-width: 70px;
        }

<<<<<<< Updated upstream
        td {
            padding: 1rem 0.75rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            vertical-align: top;
            word-wrap: break-word;
        }
=======
  .data-table td {
    padding: 6px 4px;
    border-bottom: 1px solid var(--border-light);
    color: var(--text-secondary);
    font-size: 0.8rem;
    vertical-align: middle;
    text-align: center;
    max-width: 120px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
>>>>>>> Stashed changes

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
            width: 100px;
            min-width: 80px;
        }

        td:nth-child(7) {
            width: 100px;
            min-width: 80px;
        }

        body.dark-mode td {
            border-bottom-color: rgba(255,255,255,0.1);
            color: var(--text-dark);
        }

        tbody tr {
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(6, 182, 212, 0.05));
            transform: translateX(2px);
        }

        tbody tr.selected {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(6, 182, 212, 0.1));
        }

        body.dark-mode tbody tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        body.dark-mode tbody tr.selected {
            background: rgba(6, 182, 212, 0.1);
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
            z-index: 2000;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            box-sizing: border-box;
        }

        .modal.show {
            display: flex !important;
            animation: fadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 2.5rem;
            width: 100%;
            max-width: 900px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--shadow-lg);
            animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.2);
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
            color: var(--text-primary);
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
            color: var(--accent);
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
            color: var(--accent);
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
            color: var(--text-primary);
        }

        .form-group input,
        .form-group select {
            padding: 14px 18px;
            font-size: 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            background: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(6, 182, 212, 0.1);
            transform: translateY(-1px);
        }

        body.dark-mode .form-group input,
        body.dark-mode .form-group select {
            background: var(--bg-dark);
            border-color: #475569;
            color: var(--text-dark);
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
            background: var(--surface);
            color: var(--text-primary);
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
            color: var(--text-primary);
            border-color: rgba(51, 65, 85, 0.3);
        }

        .qr-content h3 {
            margin-bottom: 1.5rem;
            color: var(--primary);
            font-size: 1.5rem;
        }

        body.dark-mode .qr-content h3 {
            color: var(--accent);
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
                align-items: center;
            }

            .btn-sm {
                padding: 4px 8px;
                font-size: 0.75rem;
            }

            .page-title {
                font-size: 2rem;
                background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
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
  z-index: 3000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.8);
  justify-content: center;
  align-items: center;
}

.card-modal-content {
  background: white;
  padding: 20px;
  border-radius: 12px;
  width: 420px;
  position: relative;
  box-shadow: 0 6px 18px rgba(0,0,0,0.3);
}

.card-modal-content h3 {
  text-align: center;
  margin-bottom: 20px;
}

.card-modal-content .close {
  position: absolute;
  top: 10px;
  right: 15px;
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
  width: 337.5px;  /* Philippine driver's license width */
  height: 212.5px; /* Philippine driver's license height */
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

/* Name overlay */
.overlay.name {
  position: absolute;
  top: 100px;
  left: 37px;
  right: 25px;
  text-align: left;
  font-weight: bold;
  font-size: 10px;
  text-transform: uppercase;
  color: #fff;
}

/* Date overlay */
.overlay.date {
  position: absolute;
  bottom: 43px;
  left: 127px;
  font-size: 12px;
  font-weight: bold;
  text-transform: uppercase;
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
  object-fit: cover;
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
<<<<<<< Updated upstream
        @keyframes successFlash {
            0% { background: rgba(16, 185, 129, 0.2); }
            100% { background: transparent; }
        }
=======
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

  /* Tooltip Styles */
  .member-tooltip {
    position: absolute;
    background: var(--surface-elevated);
    backdrop-filter: var(--glass-blur);
    -webkit-backdrop-filter: var(--glass-blur);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius);
    padding: 1rem;
    color: var(--text-primary);
    font-size: 0.85rem;
    line-height: 1.6;
    white-space: nowrap;
    z-index: 9999;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
    box-shadow: var(--shadow-lg);
    max-width: 400px;
    min-width: 300px;
    word-wrap: break-word;
    white-space: normal;
  }

  body.dark-mode .member-tooltip {
    background: rgba(15, 23, 42, 0.95);
    border-color: rgba(51, 65, 85, 0.3);
  }

  .member-tooltip.show {
    opacity: 1;
  }

  .member-tooltip::before {
    content: '';
    position: absolute;
    top: -8px;
    left: 20px;
    width: 0;
    height: 0;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    border-bottom: 8px solid var(--glass-border);
  }

  body.dark-mode .member-tooltip::before {
    border-bottom-color: rgba(51, 65, 85, 0.3);
  }
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
      <a href="/transactions">
        <span class="icon">📃</span>
        <span class="label">Transactions</span>
=======
      <a href="{{ route('timelog.index') }}" data-label="Member Time-in/out">
        <span class="icon"><i class="fas fa-user-clock"></i></span>
        <span class="label">Member Time-in/out</span>
>>>>>>> Stashed changes
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
    <div class="dashboard-content">
      <div class="page-header">
        <div class="page-header-content">
          <div class="page-header-left">
            <div class="dashboard-title" style="position: sticky; top: 0; z-index: 100; background: transparent; padding: 1rem 0; margin: -1rem 0 1rem 0;">
              REGISTERED MEMBERS
            </div>
          </div>
        </div>
      </div>

      <!-- Table Controls -->
      <div class="table-controls" style="display: flex; flex-direction: row; gap: 1rem; align-items: center; margin-bottom: 1rem; padding: 1rem; background: var(--glass-bg); backdrop-filter: var(--glass-blur); -webkit-backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border); border-radius: var(--radius-lg); box-shadow: var(--glass-shadow);">
        <div class="search-container" style="flex: 1; max-width: 100%;">
          <input type="text" id="searchInput" class="search-bar" placeholder="Search members by name, address, or contact..." style="width: 100%; min-width: 400px;">
        </div>
        <div class="register-button-container">
          <button class="btn btn-primary" onclick="openRegisterModal()">
            <i class="fas fa-user-plus"></i>
            Register Member
          </button>
        </div>
      </div>

      <!-- Members Table -->
      <div class="table-container">
      <table id="membersTable" class="data-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Age</th>
            <th>Address</th>
            <th>Contact Number</th>
            <th>School</th>
            <th>Member Since</th>
            <th>Actions</th>
          </tr>
        </thead>
    <tbody id="membersTableBody">
      @if(isset($members) && $members->count())
        @foreach ($members as $member)
          <tr data-member-info="Name: {{ (!empty($member->last_name) && $member->last_name !== 'null') ? $member->last_name : '' }}{{ (!empty($member->first_name) && $member->first_name !== 'null') ? ((!empty($member->last_name) && $member->last_name !== 'null') ? ', ' : '') . $member->first_name : '' }}{{ (!empty($member->middle_name) && $member->middle_name !== 'null') ? ' ' . $member->middle_name : '' }} | Age: {{ $member->age ?? '' }} | Address: {{ collect([(!empty($member->house_number) && $member->house_number !== 'null') ? $member->house_number : null, (!empty($member->street) && $member->street !== 'null') ? $member->street : null, (!empty($member->barangay) && $member->barangay !== 'null') ? $member->barangay : null, (!empty($member->municipality) && $member->municipality !== 'null') ? $member->municipality : null, (!empty($member->province) && $member->province !== 'null') ? $member->province : null])->filter()->implode(', ') }} | Contact: {{ (!empty($member->contactnumber) && $member->contactnumber !== 'null') ? $member->contactnumber : '' }} | School: {{ (!empty($member->school) && $member->school !== 'null') ? $member->school : '' }} | Member Since: {{ (!empty($member->memberdate) && $member->memberdate !== 'null') ? \Carbon\Carbon::parse($member->memberdate)->format('F j, Y') : '' }}">
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
          <td colspan="7" style="text-align: center;">No members found.</td>
        </tr>
      @endif
      </tbody>
    </table>
  </div>
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
// Initialize page functionality
document.addEventListener('DOMContentLoaded', function() {
  console.log('Members page loaded successfully');

  // Initialize dark mode toggle
  initializeDarkModeToggle();

  // Initialize search functionality
  initializeSearch();

  // Initialize modal functions
  initializeModals();

  // Initialize tooltip functionality
  initializeTooltips();

  // Test if edit buttons are working
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

// Dark mode toggle functionality
function initializeDarkModeToggle() {
  const darkModeToggle = document.getElementById('darkModeToggle');
  const darkModeLabel = document.getElementById('darkModeLabel');

  if (!darkModeToggle) {
    console.error('Dark mode toggle not found');
    return;
  }

  // Apply saved preference on load
  const savedDarkMode = localStorage.getItem('darkMode') === 'true';
  const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
  const isDark = savedDarkMode !== null ? savedDarkMode : prefersDarkMode;

  document.body.classList.toggle('dark-mode', isDark);
  darkModeToggle.checked = isDark;
  if (darkModeLabel) {
    darkModeLabel.textContent = isDark ? 'Dark Mode' : 'Light Mode';
  }

  // Toggle dark mode
  darkModeToggle.addEventListener('change', function() {
    const isChecked = this.checked;
    document.body.classList.toggle('dark-mode', isChecked);
    localStorage.setItem('darkMode', isChecked);
    if (darkModeLabel) {
      darkModeLabel.textContent = isChecked ? 'Dark Mode' : 'Light Mode';
    }
  });

  console.log('Dark mode toggle initialized');
}

// Search functionality
function initializeSearch() {
  const searchInput = document.getElementById('searchInput');
  if (searchInput) {
    searchInput.addEventListener('input', function() {
      const searchTerm = this.value.toLowerCase();
      const tableBody = document.getElementById('membersTableBody');
      const rows = tableBody.querySelectorAll('tr');

      rows.forEach(row => {
        if (row.cells.length > 1) { // Skip "No members found" row
          const name = row.cells[0].textContent.toLowerCase();
          const address = row.cells[2].textContent.toLowerCase();
          const contact = row.cells[3].textContent.toLowerCase();

          const matches = name.includes(searchTerm) ||
                         address.includes(searchTerm) ||
                         contact.includes(searchTerm);

          row.style.display = matches ? '' : 'none';
        }
      });
    });
  }
}

// Modal functions
function initializeModals() {
  // These functions should be handled by external JS files
  // but we'll add basic functionality as backup
  window.openRegisterModal = window.openRegisterModal || function() {
    console.log('Opening register modal');
    const modal = document.getElementById('registerModal');
    if (modal) {
      modal.classList.add('show');
      modal.style.display = 'flex';
      document.body.classList.add('modal-open');
    }
  };

  window.closeRegisterModal = window.closeRegisterModal || function() {
    console.log('Closing register modal');
    const modal = document.getElementById('registerModal');
    if (modal) {
      modal.classList.remove('show');
      modal.style.display = 'none';
      document.body.classList.remove('modal-open');
    }
  };

  window.openCardModal = window.openCardModal || function(memberId) {
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
          <button onclick="this.closest('div').parentNode.remove()" style="
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

    document.body.appendChild(modal);

    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
      if (e.target === modal) {
        modal.remove();
      }
    });
  };

  window.generateCard = window.generateCard || function(memberId) {
    // This would typically generate and download the card
    alert(`Card generated for member ID: ${memberId}`);
    document.querySelector('div[style*="z-index: 3000"]').remove();
  };
}

// Tooltip functionality with 3-second delay
function initializeTooltips() {
  const tableBody = document.getElementById('membersTableBody');
  const tooltip = document.createElement('div');
  tooltip.className = 'member-tooltip';
  document.body.appendChild(tooltip);

  let hoverTimer = null;
  let currentRow = null;

  if (tableBody) {
    tableBody.addEventListener('mouseover', function(e) {
      const row = e.target.closest('tr');
      if (row && row.hasAttribute('data-member-info')) {
        currentRow = row;
        hoverTimer = setTimeout(() => {
          showTooltip(row, e);
        }, 3000); // 3-second delay
      }
    });

    tableBody.addEventListener('mouseout', function(e) {
      const row = e.target.closest('tr');
      if (row && row.hasAttribute('data-member-info')) {
        clearTimeout(hoverTimer);
        hideTooltip();
        currentRow = null;
      }
    });

    // Hide tooltip when mouse moves
    document.addEventListener('mousemove', function(e) {
      if (currentRow && !currentRow.contains(e.target) && !tooltip.contains(e.target)) {
        clearTimeout(hoverTimer);
        hideTooltip();
        currentRow = null;
      }
    });
  }

  function showTooltip(row, event) {
    const memberInfo = row.getAttribute('data-member-info');

    // Format as vertical list
    const formattedInfo = memberInfo
      .split(' | ')
      .map(item => `<div style="margin-bottom: 4px; padding: 2px 0;">${item}</div>`)
      .join('');

    tooltip.innerHTML = formattedInfo;
    tooltip.classList.add('show');

    // Position tooltip
    const rect = row.getBoundingClientRect();
    tooltip.style.left = event.pageX + 10 + 'px';
    tooltip.style.top = event.pageY - 10 + 'px';
  }

  function hideTooltip() {
    tooltip.classList.remove('show');
  }
}

// Global function to close all modals
function closeAllModals() {
  const modals = document.querySelectorAll('.modal');
  modals.forEach(modal => {
    modal.classList.remove('show');
    modal.style.display = 'none';
  });
  document.body.classList.remove('modal-open');
}

// Function to open register modal with Julita resident confirmation
function openJulitaRegisterModal() {
  console.log('openJulitaRegisterModal called');
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

// Function to close register modal
function closeRegisterModal() {
  const registerModal = document.getElementById("registerModal");
  const julitaModal = document.getElementById("julitaRegisterModal");
  if (registerModal) {
    registerModal.classList.remove("show");
    registerModal.style.display = "none";
  }
  if (julitaModal) {
    julitaModal.classList.remove("show");
    julitaModal.style.display = "none";
  }
  document.body.classList.remove("modal-open");
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('modal')) {
    e.target.classList.remove('show');
    e.target.style.display = 'none';
    document.body.classList.remove('modal-open');
  }
});

console.log('Members page JavaScript initialized');
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