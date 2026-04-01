<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>👥 User Management | Julita Public Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            /* Legacy Color Palette */
            --primary: #2fb9eb;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --accent: #06b6d4;
            --accent-dark: #0891b2;
            --success: #059669;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
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
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            position: relative;
        }
        body.dark-mode {
            background: linear-gradient(135deg, #121212, #1a1a1a);
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
        /* Sidebar - Keep original sizing */
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
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        body:not(.dark-mode) .sidebar {
            background: linear-gradient(180deg, rgba(30, 64, 175, 0.95), rgba(124, 58, 237, 0.95));
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
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
        body:not(.dark-mode) .sidebar .label {
            color: #1a1a1a;
        }
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
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: var(--spacing-xl);
            min-height: 100vh;
        }
        /* Page Header */
        .page-header {
            margin-bottom: var(--spacing-xl);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .page-title {
            font-size: 28px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-primary);
        }
        .page-title i {
            color: var(--primary);
        }
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            border: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: var(--shadow);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        .btn-outline {
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text-primary);
        }
        .btn-outline:hover {
            background: var(--bg-hover);
            border-color: var(--gray-300);
        }
        /* Cards */
        .card {
            background: var(--surface);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            border: 1px solid var(--border-light);
        }
        .card-header {
            padding: var(--spacing-lg);
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--glass-bg);
        }
        .card-header h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .card-body {
            padding: var(--spacing-lg);
        }
        /* Filters Section */
        .filters-section {
            background: var(--bg-primary);
            border-radius: var(--radius);
            padding: var(--spacing-lg);
            margin-bottom: var(--spacing-lg);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--spacing-md);
        }
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-sm);
        }
        .filter-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .filter-input,
        .filter-select {
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--bg-primary);
            color: var(--text-primary);
            font-size: 14px;
            transition: var(--transition);
        }
        .filter-input:focus,
        .filter-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(47, 185, 235, 0.1);
        }
        .search-input-wrapper {
            position: relative;
        }
        .search-input-wrapper i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 14px;
        }
        .search-input-wrapper input {
            padding-left: 40px;
        }
        /* Search Bar */
        .search-bar {
            display: flex;
            gap: var(--spacing-md);
            margin-bottom: var(--spacing-lg);
            flex-wrap: wrap;
        }
        .search-input {
            flex: 1;
            min-width: 250px;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--bg-primary);
            color: var(--text-primary);
            font-size: 14px;
            transition: var(--transition);
        }
        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(47, 185, 235, 0.1);
        }
        .filter-select {
            min-width: 150px;
        }
        /* Table Container */
        .table-container {
            background: var(--bg-primary);
            border-radius: var(--radius);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .table-wrapper {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border);
        }
        th {
            padding: 14px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }
        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: var(--transition);
        }
        tbody tr:hover {
            background: var(--bg-hover);
        }
        tbody tr:last-child {
            border-bottom: none;
        }
        td {
            padding: 16px;
            font-size: 14px;
            color: var(--text-primary);
            vertical-align: middle;
        }
        /* Role Badge */
        .role-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }
        .role-admin { background: rgba(239, 68, 68, 0.15); color: #ef4444; }
        .role-librarian { background: rgba(59, 130, 246, 0.15); color: #3b82f6; }
        .role-assistant { background: rgba(34, 197, 94, 0.15); color: #22c55e; }
        .role-unknown { background: rgba(107, 114, 128, 0.15); color: var(--gray-500); }
        /* Special Badge */
        .special-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            color: #8b5cf6;
            background: rgba(139, 92, 246, 0.1);
            padding: 4px 8px;
            border-radius: 4px;
            margin: 2px;
        }
        /* Actions */
        .actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            font-size: 14px;
        }
        .action-btn-edit { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
        .action-btn-special { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }
        .action-btn-delete { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
        .action-btn-logout { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
        .action-btn-logout.hidden { display: none !important; }
        .action-btn-logout.visible { display: inline-flex !important; }
        .action-btn-logout.loading { opacity: 0.6; pointer-events: none; }
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }
        /* Footer Pagination */
        .table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            border-top: 1px solid var(--border);
            background: var(--bg-secondary);
        }
        .pagination-info {
            color: var(--text-secondary);
            font-size: 14px;
        }
        .pagination-controls {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .pagination-button {
            padding: 8px 12px;
            border: 1px solid var(--border);
            background: var(--bg-primary);
            color: var(--text-primary);
            border-radius: 6px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
        }
        .pagination-button:hover:not(:disabled) {
            background: var(--bg-hover);
            border-color: var(--gray-300);
        }
        .pagination-button:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }
        .pagination-number {
            min-width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }
        .pagination-number:hover {
            background: var(--bg-hover);
        }
        .pagination-number.active {
            background: var(--primary);
            color: white;
        }
        .pagination-dots {
            padding: 0 4px;
            color: var(--text-secondary);
        }
        /* Dark Mode Overrides */
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
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        .empty-state i {
            font-size: 64px;
            color: var(--gray-300);
            margin-bottom: 16px;
        }
        .empty-state h3 {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }
        .empty-state p {
            color: var(--text-secondary);
            font-size: 14px;
        }
        /* User Avatar */
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .user-name {
            font-weight: 600;
            color: var(--text-primary);
        }
        .user-email {
            font-size: 13px;
            color: var(--text-secondary);
        }
        .user-username {
            font-size: 12px;
            color: var(--text-muted);
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
            <a href="{{ route('timelog.index') }}" data-label="Member Time-in/out">
                <span class="icon"><i class="fas fa-user-clock"></i></span>
                <span class="label">Member Time-in/out</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="active" data-label="User Management">
                <span class="icon"><i class="fas fa-users-cog"></i></span>
                <span class="label">User Management</span>
            </a>
            <a href="{{ route('system-logs.index') }}" data-label="System Logs">
                <span class="icon"><i class="fas fa-clipboard-list"></i></span>
                <span class="label">System Logs</span>
            </a>
        </nav>
    </div>

    <div class="main-content">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-users-cog"></i>
                User Management
            </h1>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Add New User
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-list"></i> All Users</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.index') }}" method="GET" class="search-bar">
                    <div class="search-input-wrapper" style="flex: 1;">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" class="search-input" 
                               placeholder="Search by name, email, or username..." 
                               value="{{ request('search') }}">
                    </div>
                    <select name="role" class="filter-select">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline">
                        <i class="fas fa-refresh"></i> Reset
                    </a>
                </form>

                @if($users->count() > 0)
                <div class="table-container">
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Role</th>
                                    <th>Special Permissions</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="user-name">{{ $user->name }}</div>
                                                <div class="user-email">{{ $user->email }}</div>
                                                <div class="user-username">@ {{ $user->username }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="role-badge role-{{ $user->role ? $user->role->slug : 'unknown' }}">
                                            {{ $user->role ? $user->role->name : 'No Role' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($user->specialPermissions->count() > 0)
                                            @foreach($user->specialPermissions->take(2) as $permission)
                                                <span class="special-badge">
                                                    <i class="fas fa-star"></i> {{ $permission->name }}
                                                </span>
                                            @endforeach
                                            @if($user->specialPermissions->count() > 2)
                                                <span class="special-badge">+{{ $user->specialPermissions->count() - 2 }} more</span>
                                            @endif
                                        @else
                                            <span style="color: var(--text-muted);">None</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="actions">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="action-btn action-btn-edit" title="Edit User">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.users.show', $user->id) }}" class="action-btn action-btn-special" title="Manage Permissions">
                                                <i class="fas fa-shield-alt"></i>
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn action-btn-delete" title="Delete User" onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
@if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.force-logout', $user->id) }}" method="POST" style="display: inline;" class="force-logout-form" data-user-id="{{ $user->id }}">
                                                @csrf
                                                <button type="submit" class="action-btn action-btn-logout" data-user-id="{{ $user->id }}" title="Force Logout" onclick="return confirm('Are you sure you want to force logout this user?')">
                                                    <i class="fas fa-sign-out-alt"></i>
                                                </button>
                                            </form>
@endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="table-footer">
                        <div class="pagination-info">
                            Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users
                        </div>
                        <div class="pagination-controls">
                            {{-- Previous Page Link --}}
                            @if ($users->onFirstPage())
                                <button class="pagination-button" disabled>
                                    <i class="fas fa-chevron-left"></i> Previous
                                </button>
                            @else
                                <a href="{{ $users->previousPageUrl() }}" class="pagination-button">
                                    <i class="fas fa-chevron-left"></i> Previous
                                </a>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                @if ($page == $users->currentPage())
                                    <span class="pagination-number active">{{ $page }}</span>
                                @elseif ($page == 1 || $page == $users->lastPage() || ($page >= $users->currentPage() - 1 && $page <= $users->currentPage() + 1))
                                    <a href="{{ $url }}" class="pagination-number">{{ $page }}</a>
                                @elseif ($page == $users->currentPage() - 2 || $page == $users->currentPage() + 2)
                                    <span class="pagination-dots">...</span>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($users->hasMorePages())
                                <a href="{{ $users->nextPageUrl() }}" class="pagination-button">
                                    Next <i class="fas fa-chevron-right"></i>
                                </a>
                            @else
                                <button class="pagination-button" disabled>
                                    Next <i class="fas fa-chevron-right"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-users"></i>
                        <h3>No users found</h3>
                        <p>Try adjusting your search criteria or add a new user.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Dark mode toggle
        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark-mode');
        }
        
        // Listen for dark mode changes from other tabs
        window.addEventListener('storage', function(e) {
            if (e.key === 'darkMode') {
                if (e.newValue === 'true') {
                    document.body.classList.add('dark-mode');
                } else {
                    document.body.classList.remove('dark-mode');
                }
            }
        });

        // =========================================
        // Force Logout Session Polling (every 5 seconds)
        // =========================================
        function checkForceLogoutStatus(userId, buttonElement) {
            if (!userId || !buttonElement) return;
            
            fetch(`/admin/users/${userId}/force-logout-status`)
                .then(response => response.json())
                .then(data => {
                    if (data.force_logout) {
                        buttonElement.classList.add('hidden');
                        buttonElement.classList.remove('visible');
                    } else {
                        buttonElement.classList.remove('hidden');
                        buttonElement.classList.add('visible');
                    }
                })
                .catch(error => {
                    console.error('Error checking force logout status:', error);
                    // Hide button on error to be safe
                    buttonElement.classList.add('hidden');
                    buttonElement.classList.remove('visible');
                });
        }

        function initForceLogoutPolling() {
            // Get all force logout buttons
            const forceLogoutButtons = document.querySelectorAll('.action-btn-logout[data-user-id]');
            
            if (forceLogoutButtons.length === 0) return;
            
            // Initially hide all buttons - JavaScript will show them if user is not force-logged out
            forceLogoutButtons.forEach(button => {
                button.classList.add('hidden');
                button.classList.remove('visible');
            });
            
            // Check immediately for each user
            forceLogoutButtons.forEach(button => {
                const userId = button.getAttribute('data-user-id');
                checkForceLogoutStatus(userId, button);
            });
            
            // Poll every 5 seconds
            setInterval(() => {
                forceLogoutButtons.forEach(button => {
                    const userId = button.getAttribute('data-user-id');
                    checkForceLogoutStatus(userId, button);
                });
            }, 5000);
        }
        
        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initForceLogoutPolling);
        } else {
            initForceLogoutPolling();
        }
    </script>
</body>
</html>
