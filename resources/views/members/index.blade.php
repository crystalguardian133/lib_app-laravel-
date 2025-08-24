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

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--light) 0%, #f0f9ff 100%);
            color: var(--dark);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
        }

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
            padding: 2rem;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main.collapsed {
            margin-left: 70px;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding: 2rem;
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
            margin-bottom: 2rem;
            align-items: center;
            padding: 1.5rem;
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
            min-width: 300px;
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

        .btn-danger {
            background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 0.875rem;
            min-width: auto;
        }

        .btn-sm .icon {
            font-size: 0.875rem;
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
            color: var(--accent-light);
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

        /* Table Styles */
        .table-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: 1rem;
        }

        body.dark-mode .table-container {
            background: rgba(30, 41, 59, 0.9);
            border-color: rgba(51, 65, 85, 0.3);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }

        th {
            padding: 1.2rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
            position: relative;
        }

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
            width: 50px;
            text-align: center;
        }

        td {
            padding: 1.2rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        td:first-child {
            text-align: center;
            width: 50px;
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
            color: var(--text-dark);
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
            color: var(--accent-light);
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
            color: var(--accent-light);
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
            color: var(--text-dark);
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
            background: var(--bg-dark);
            color: var(--text-dark);
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
            color: var(--text-dark);
            border-color: rgba(51, 65, 85, 0.3);
        }

        .qr-content h3 {
            margin-bottom: 1.5rem;
            color: var(--primary);
            font-size: 1.5rem;
        }

        body.dark-mode .qr-content h3 {
            color: var(--accent-light);
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
            }

            .search-box {
                min-width: auto;
            }

            .page-title {
                font-size: 2rem;
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
  z-index: 1000;
  left: 100; top: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.6);
  justify-content: center;
  align-items: center;
}

.card-modal-content {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  width: 420px;
  position: relative;
  box-shadow: 0 6px 18px rgba(0,0,0,0.3);
}

.card-modal-content h2 {
  text-align: center;
  margin-bottom: 20px;
}

.card-modal-content .close {
  position: absolute;
  top: 10px; right: 15px;
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
  width: 340px;  /* driver’s license size */
  height: 216px;
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


/* Name above the "Member" text in template */
/* Name: slightly above the middle of the card */
.overlay.name {
  position: absolute;
  top: 100px;      /* adjust for your template height */
  left: 37px;
  right: 25px;
  text-align: left;
  font-weight: bold;
  font-size: 10px;
  text-transform: uppercase;
  color: #fff;
}

/* Date: positioned beside "Membership Date :" text in template */
.overlay.date {
  position: absolute;
  bottom: 43px;   /* near the bottom, adjust to match template */
  left: 127px;    /* aligns next to pre-printed label */
  font-size: 13px;
  font-weight: bold;
  text-transform: uppercase;
  font-size: 12px;
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
  object-fit: cover;   /* ensures it fills and stays centered */
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
        @keyframes successFlash {
            0% { background: rgba(16, 185, 129, 0.2); }
            100% { background: transparent; }
        }
    </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <img src="/images/logo.png" alt="Logo" class="logo">
      <h3 class="label">Julita Public Library</h3>
    </div>
    
    <button class="toggle-btn" id="toggleSidebar" disabled>
      <i class="fas fa-bars"></i>
    </button>
    
    <nav>
      <a href="/dashboard">
        <span class="icon">🏠</span>
        <span class="label">Dashboard</span>
      </a>
      <a href="/books">
        <span class="icon">📘</span>
        <span class="label">Manage Books</span>
      </a>
      <a href="/members" class="active">
        <span class="icon">👥</span>
        <span class="label">Manage Members</span>
      </a>
      <a href="/transactions">
        <span class="icon">📃</span>
        <span class="label">Transactions</span>
      </a>
    </nav>
    
    <div class="dark-toggle">
      <label class="switch">
        <input type="checkbox" id="darkModeToggle">
        <span class="slider"></span>
      </label>
      <a href="/logout" class="logout-link">
        <span>🚪</span>
        <span class="label">Logout</span>
      </a>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main" id="mainContent">
    <div class="page-header">
      <h1 class="page-title">
        <span>👥</span>
        Registered Members
      </h1>
    </div>

    <div class="top-controls">
      <div class="search-box">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="searchInput" placeholder="Search members by name, address, or contact...">
      </div>
      <button class="btn btn-primary" onclick="openRegisterModal()">
        <i class="fas fa-user-plus"></i>
        Register Member
      </button>

   <!-- Members Table -->
<div class="table-container">
  <table id="membersTable">
    <thead>
      <tr>
        <th>Name</th>
        <th>Age</th>
        <th>Address</th>
        <th>Contact Number</th>
        <th>School</th>
        <th>Member Since</th>
        <th>Computer Time</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="membersTableBody">
      @if(isset($members) && $members->count())
        @foreach ($members as $member)
          <tr>
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

            {{-- Computer Time --}}
            <td>{{ (!empty($member->member_time) && $member->member_time !== 'null') ? $member->member_time . ' min' : '' }}</td>

            {{-- Actions - Individual Edit and Download Buttons --}}
            <td>
              <div style="display: flex; gap: 8px; align-items: center;">
                  <button 
                class="btn btn-sm btn-primary editBtn" 
                data-id="{{ $member->id }}">
                Edit
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
          <td colspan="8" style="text-align: center;">No members found.</td>
        </tr>
      @endif
    </tbody>
  </table>
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
// Dark mode functionality
const darkToggle = document.getElementById('darkModeToggle');

// Initialize dark mode on page load
document.addEventListener('DOMContentLoaded', function() {
  const darkMode = localStorage.getItem('darkMode') === 'true';
  if (darkMode) {
    document.body.classList.add('dark-mode');
    darkToggle.checked = true;
  }
});

// Dark mode toggle event listener
darkToggle.addEventListener('change', function() {
  document.body.classList.toggle('dark-mode');
  localStorage.setItem('darkMode', this.checked);
});

// Sidebar toggle functionality
const sidebar = document.getElementById('sidebar');
const mainContent = document.getElementById('mainContent');
const toggleBtn = document.getElementById('toggleSidebar');

toggleBtn.addEventListener('click', function() {
  sidebar.classList.toggle('collapsed');
  mainContent.classList.toggle('collapsed');
});

// Card preview function
function showCardPreviewModal(cardUrl) {
  document.getElementById("cardPreviewFrame").src = cardUrl;
  document.getElementById("downloadCardBtn").href = cardUrl;
  document.getElementById("cardPreviewModal").style.display = "block";
}

function closeCardPreviewModal() {
  document.getElementById("cardPreviewModal").style.display = "none";
  document.getElementById("cardPreviewFrame").src = "";
}
</script>

<!-- External Scripts - ONLY INCLUDE EACH ONCE -->
<script src="{{ asset('js/overdue.js') }}"></script>
<script src="{{ asset('js/photoprev.js') }}"></script>
<script src="{{ asset('js/membersearch.js') }}"></script>
<script src="{{ asset('js/memberscript.js') }}"></script>
<script src="{{ asset('js/memberedit.js') }}"></script>
<script src="{{ asset('js/sidebarcollapse.js') }}"></script>
<script src="{{ asset('js/showqr.js') }}"></script>
<script src="{{ asset('js/card_gen.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>


</body>
</html>