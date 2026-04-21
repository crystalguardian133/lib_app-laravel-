<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>📋 System Logs | Julita Public Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            /* Colors */
            --primary: #2fb9eb;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            
            /* Neutrals */
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            
            /* Theme */
            --bg-primary: #ffffff;
            --bg-secondary: #f9fafb;
            --bg-hover: #f3f4f6;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --border: #e5e7eb;
            
            /* Spacing */
            --spacing-xs: 0.25rem;
            --spacing-sm: 0.5rem;
            --spacing-md: 1rem;
            --spacing-lg: 1.5rem;
            --spacing-xl: 2rem;
            
            /* Transitions */
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--gray-50);
            color: var(--text-primary);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: var(--spacing-xl);
        }

        /* Header */
        .page-header {
            margin-bottom: var(--spacing-xl);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-title i {
            color: var(--primary);
        }

        .header-actions {
            display: flex;
            gap: var(--spacing-md);
        }

        .btn {
            padding: 10px 20px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--bg-primary);
            color: var(--text-primary);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn:hover {
            background: var(--bg-hover);
            border-color: var(--gray-300);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
            border-color: var(--danger);
        }

        .btn-danger:hover {
            background: #dc2626;
            border-color: #dc2626;
        }

        /* Filters Section */
        .filters-section {
            background: var(--bg-primary);
            border-radius: 12px;
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
            border-radius: 8px;
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

        /* Table Container */
        .table-container {
            background: var(--bg-primary);
            border-radius: 12px;
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

        .log-number {
            font-weight: 600;
            color: var(--text-secondary);
        }

        .log-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }

        .log-action.user_login,
        .log-action.user_logout {
            background: rgba(59, 130, 246, 0.1);
            color: var(--info);
        }

        .log-action.login_blocked {
            background: rgba(239, 68, 68, 0.15);
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .log-action.user_session_terminated {
            background: rgba(245, 158, 11, 0.15);
            color: #d97706;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .log-action.password_changed {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .log-action.login_failed,
        .log-action.password_change_failed {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .log-action.book_created,
        .log-action.book_updated,
        .log-action.member_created,
        .log-action.member_updated {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .log-action.book_deleted,
        .log-action.member_deleted {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .log-action.book_borrowed,
        .log-action.book_returned,
        .log-action.member_time_in,
        .log-action.member_time_out,
        .log-action.member_time_in_qr,
        .log-action.member_time_out_qr {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        /* User Management Actions */
        .log-action.user_created,
        .log-action.user_updated,
        .log-action.user_role_changed {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .log-action.user_deleted {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .log-action.permission_granted {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .log-action.permission_revoked,
        .log-action.role_permission_revoked {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .log-action.permission_restored {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .log-action i {
            font-size: 12px;
        }

        .log-user-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            background: var(--primary);
            color: white;
            border-radius: 16px;
            font-size: 12px;
            font-weight: 600;
        }

        .log-user-badge i {
            font-size: 10px;
        }

        .log-timestamp {
            color: var(--text-secondary);
            font-size: 13px;
            white-space: nowrap;
        }

        .log-description {
            max-width: 400px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .action-button {
            padding: 6px 12px;
            border: none;
            background: transparent;
            color: var(--primary);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border-radius: 6px;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .action-button:hover {
            background: rgba(47, 185, 235, 0.1);
        }

        .actions-cell {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .more-actions {
            position: relative;
        }

        .more-button {
            padding: 6px 10px;
            border: none;
            background: transparent;
            color: var(--text-secondary);
            cursor: pointer;
            border-radius: 6px;
            transition: var(--transition);
        }

        .more-button:hover {
            background: var(--bg-hover);
        }

        /* Footer Pagination */
        .table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            border-top: 1px solid var(--border);
            background: var(--bg-secondary);
            flex-wrap: wrap;
            gap: 12px;
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

        /* Entries Control */
        .entries-control {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .entries-label {
            color: var(--text-secondary);
            font-size: 14px;
        }

        .entries-select {
            padding: 6px 10px;
            border: 1px solid var(--border);
            border-radius: 6px;
            background: var(--bg-primary);
            color: var(--text-primary);
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition);
        }

        .entries-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(47, 185, 235, 0.1);
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

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, rgba(30, 64, 175, 0.95), rgba(124, 58, 237, 0.95));
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            padding: 24px;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 1000;
        }

        .sidebar-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 32px;
        }

        .sidebar-header .logo {
            width: 120px;
            height: 120px;
            border-radius: 16px;
            object-fit: cover;
            margin-bottom: 12px;
        }

        .sidebar-header .label {
            font-weight: 700;
            font-size: 1.1rem;
            color: #ffffff;
        }

        .sidebar nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .sidebar nav a:hover,
        .sidebar nav a.active {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        .sidebar nav a.active {
            border-left: 3px solid var(--accent);
        }

        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 32px;
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
            <a href="{{ route('admin.users.index') }}" data-label="User Management">
                <span class="icon"><i class="fas fa-users-cog"></i></span>
                <span class="label">User Management</span>
            </a>
            <a href="{{ route('system-logs.index') }}" class="active" data-label="System Logs">
                <span class="icon"><i class="fas fa-clipboard-list"></i></span>
                <span class="label">System Logs</span>
            </a>
        </nav>
    </div>

    <div class="main-content">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-clipboard-list"></i>
                System Logs
            </h1>
            <form action="{{ route('system-logs.clear') }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to clear all logs? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i>
                    Clear Logs
                </button>
            </form>
        </div>

        <div class="filters-section">
            <form action="{{ route('system-logs.index') }}" method="GET" class="filters-grid">
                <div class="filter-group">
                    <label class="filter-label">Search</label>
                    <div class="search-input-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" class="filter-input" placeholder="Search logs..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Action Type</label>
                    <select name="action" class="filter-select">
                        <option value="">All Actions</option>
                        <option value="user_login" {{ request('action') === 'user_login' ? 'selected' : '' }}>User Login</option>
                        <option value="user_logout" {{ request('action') === 'user_logout' ? 'selected' : '' }}>User Logout</option>
                        <option value="login_blocked" {{ request('action') === 'login_blocked' ? 'selected' : '' }}>Login Blocked</option>
                        <option value="user_session_terminated" {{ request('action') === 'user_session_terminated' ? 'selected' : '' }}>Session Terminated</option>
                        <option value="login_failed" {{ request('action') === 'login_failed' ? 'selected' : '' }}>Login Failed</option>
                        <option value="password_changed" {{ request('action') === 'password_changed' ? 'selected' : '' }}>Password Changed</option>
                        <option value="book_created" {{ request('action') === 'book_created' ? 'selected' : '' }}>Book Created</option>
                        <option value="book_updated" {{ request('action') === 'book_updated' ? 'selected' : '' }}>Book Updated</option>
                        <option value="book_deleted" {{ request('action') === 'book_deleted' ? 'selected' : '' }}>Book Deleted</option>
                        <option value="book_borrowed" {{ request('action') === 'book_borrowed' ? 'selected' : '' }}>Book Borrowed</option>
                        <option value="book_returned" {{ request('action') === 'book_returned' ? 'selected' : '' }}>Book Returned</option>
                        <option value="member_created" {{ request('action') === 'member_created' ? 'selected' : '' }}>Member Created</option>
                        <option value="member_updated" {{ request('action') === 'member_updated' ? 'selected' : '' }}>Member Updated</option>
                        <option value="member_deleted" {{ request('action') === 'member_deleted' ? 'selected' : '' }}>Member Deleted</option>
                        <option value="user_created" {{ request('action') === 'user_created' ? 'selected' : '' }}>User Created</option>
                        <option value="user_updated" {{ request('action') === 'user_updated' ? 'selected' : '' }}>User Updated</option>
                        <option value="user_deleted" {{ request('action') === 'user_deleted' ? 'selected' : '' }}>User Deleted</option>
                        <option value="permission_granted" {{ request('action') === 'permission_granted' ? 'selected' : '' }}>Permission Granted</option>
                        <option value="permission_revoked" {{ request('action') === 'permission_revoked' ? 'selected' : '' }}>Permission Revoked</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Date From</label>
                    <input type="date" name="date_from" class="filter-input" value="{{ request('date_from') }}">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Date To</label>
                    <input type="date" name="date_to" class="filter-input" value="{{ request('date_to') }}">
                </div>
                <div class="filter-group" style="justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i>
                        Apply Filters
                    </button>
                    <a href="{{ route('system-logs.index') }}" class="btn btn-outline">
                        <i class="fas fa-refresh"></i>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        @if($logs->count() > 0)
        <div class="table-container">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Action</th>
                            <th>User</th>
                            <th>Description</th>
                            <th>Timestamp</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $index => $log)
                        <tr>
                            <td class="log-number">{{ $loop->iteration + ($logs->currentPage() - 1) * $logs->perPage() }}</td>
                            <td>
                                <span class="log-action {{ $log->action }}">
                                    @switch($log->action)
                                        @case('user_login')
                                            <i class="fas fa-sign-in-alt"></i>
                                            @break
                                        @case('user_logout')
                                            <i class="fas fa-sign-out-alt"></i>
                                            @break
                                        @case('login_blocked')
                                            <i class="fas fa-ban"></i>
                                            @break
                                        @case('user_session_terminated')
                                            <i class="fas fa-times-circle"></i>
                                            @break
                                        @case('login_failed')
                                            <i class="fas fa-exclamation-triangle"></i>
                                            @break
                                        @case('password_changed')
                                            <i class="fas fa-key"></i>
                                            @break
                                        @case('book_created')
                                            <i class="fas fa-plus-circle"></i>
                                            @break
                                        @case('book_updated')
                                            <i class="fas fa-edit"></i>
                                            @break
                                        @case('book_deleted')
                                            <i class="fas fa-trash"></i>
                                            @break
                                        @case('book_borrowed')
                                            <i class="fas fa-book-reader"></i>
                                            @break
                                        @case('book_returned')
                                            <i class="fas fa-book-return"></i>
                                            @break
                                        @case('member_created')
                                            <i class="fas fa-user-plus"></i>
                                            @break
                                        @case('member_updated')
                                            <i class="fas fa-user-edit"></i>
                                            @break
                                        @case('member_deleted')
                                            <i class="fas fa-user-times"></i>
                                            @break
                                        @case('user_created')
                                            <i class="fas fa-user-plus"></i>
                                            @break
                                        @case('user_updated')
                                            <i class="fas fa-user-cog"></i>
                                            @break
                                        @case('user_deleted')
                                            <i class="fas fa-user-minus"></i>
                                            @break
                                        @case('permission_granted')
                                            <i class="fas fa-check-circle"></i>
                                            @break
                                        @case('permission_revoked')
                                            <i class="fas fa-times-circle"></i>
                                            @break
                                        @case('role_permission_revoked')
                                            <i class="fas fa-ban"></i>
                                            @break
                                        @case('user_role_changed')
                                            <i class="fas fa-users-cog"></i>
                                            @break
                                        @case('member_time_in')
                                            <i class="fas fa-clock"></i>
                                            @break
                                        @case('member_time_out')
                                            <i class="fas fa-clock"></i>
                                            @break
                                        @case('member_time_in_qr')
                                            <i class="fas fa-qrcode"></i>
                                            @break
                                        @case('member_time_out_qr')
                                            <i class="fas fa-qrcode"></i>
                                            @break
                                        @case('password_change_failed')
                                            <i class="fas fa-lock"></i>
                                            @break
                                        @default
                                            <i class="fas fa-info-circle"></i>
                                    @endswitch
                                    {{ ucwords(str_replace('_', ' ', $log->action)) }}
                                </span>
                            </td>
                            <td>
                                @if($log->user)
                                    <span class="log-user-badge">
                                        <i class="fas fa-user"></i>
                                        {{ $log->user->name }}
                                    </span>
                                @else
                                    <span style="color: var(--text-secondary);">System</span>
                                @endif
                            </td>
                            <td class="log-description">{{ $log->description }}</td>
                            <td class="log-timestamp">{{ $log->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <div class="actions-cell">
                                    <button class="action-button" onclick="viewLogDetails({{ $log->id }})" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="table-footer">
                <div class="entries-control">
                    <span class="entries-label">Show</span>
                    <select class="entries-select" onchange="window.location.href = this.value">
                        <option value="{{ route('system-logs.index', array_merge(request()->except('page'), ['per_page' => 10])) }}" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="{{ route('system-logs.index', array_merge(request()->except('page'), ['per_page' => 25])) }}" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="{{ route('system-logs.index', array_merge(request()->except('page'), ['per_page' => 50])) }}" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="{{ route('system-logs.index', array_merge(request()->except('page'), ['per_page' => 100])) }}" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span class="entries-label">entries</span>
                </div>
                <div class="pagination-info">
                    Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} logs
                </div>
                <div class="pagination-controls">
                    {{-- Previous Page Link --}}
                    @if ($logs->onFirstPage())
                        <button class="pagination-button" disabled>
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>
                    @else
                        <a href="{{ $logs->previousPageUrl() }}" class="pagination-button">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                        @if ($page == $logs->currentPage())
                            <span class="pagination-number active">{{ $page }}</span>
                        @elseif ($page == 1 || $page == $logs->lastPage() || ($page >= $logs->currentPage() - 1 && $page <= $logs->currentPage() + 1))
                            <a href="{{ $url }}" class="pagination-number">{{ $page }}</a>
                        @elseif ($page == $logs->currentPage() - 2 || $page == $logs->currentPage() + 2)
                            <span class="pagination-dots">...</span>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($logs->hasMorePages())
                        <a href="{{ $logs->nextPageUrl() }}" class="pagination-button">
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
                <i class="fas fa-clipboard-list"></i>
                <h3>No logs found</h3>
                <p>Try adjusting your search criteria or check back later.</p>
            </div>
        @endif
    </div>

    <script>
        function viewLogDetails(logId) {
            // View log details functionality
        }
    </script>
</body>
</html>
