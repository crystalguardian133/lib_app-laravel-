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
            font-size: 14px;
            color: var(--text-secondary);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: var(--bg-primary);
            border-radius: 12px;
            max-width: 600px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .modal-close {
            padding: 8px;
            border: none;
            background: transparent;
            color: var(--text-secondary);
            cursor: pointer;
            border-radius: 6px;
            transition: var(--transition);
        }

        .modal-close:hover {
            background: var(--bg-hover);
        }

        .modal-body {
            padding: 20px;
        }

        .detail-group {
            margin-bottom: 20px;
        }

        .detail-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
        }

        .detail-value {
            font-size: 14px;
            color: var(--text-primary);
            padding: 12px;
            background: var(--bg-secondary);
            border-radius: 8px;
        }

        .detail-code {
            font-family: 'Courier New', monospace;
            font-size: 13px;
            background: var(--gray-900);
            color: var(--gray-100);
            padding: 16px;
            border-radius: 8px;
            overflow-x: auto;
            white-space: pre-wrap;
            word-break: break-word;
        }

        /* Notification */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 16px 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            display: none;
            align-items: center;
            gap: 12px;
            z-index: 2000;
            animation: slideIn 0.3s ease;
        }

        .notification.show {
            display: flex;
        }

        .notification.success {
            border-left: 4px solid var(--success);
        }

        .notification.error {
            border-left: 4px solid var(--danger);
        }

        .notification i {
            font-size: 20px;
        }

        .notification.success i {
            color: var(--success);
        }

        .notification.error i {
            color: var(--danger);
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: var(--spacing-md);
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--spacing-md);
            }

            .header-actions {
                width: 100%;
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .table-wrapper {
                overflow-x: scroll;
            }

            table {
                min-width: 800px;
            }

            .table-footer {
                flex-direction: column;
                gap: var(--spacing-md);
            }

            .filters-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-file-alt"></i>
                System Logs
            </h1>
            <div class="header-actions">
                <a href="{{ route('dashboard') }}" class="btn">
                    <i class="fas fa-arrow-left"></i>
                    Back to Dashboard
                </a>
                <button onclick="clearLogs()" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i>
                    Clear Logs
                </button>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filters-section">
            <div class="filters-grid">
                <div class="filter-group">
                    <label class="filter-label">Filter by Action</label>
                    <select class="filter-select" id="actionFilter">
                        <option value="">All Actions</option>
                        <option value="user_login">User Login</option>
                        <option value="user_logout">User Logout</option>
                        <option value="password_changed">Password Changed</option>
                        <option value="book_created">Book Created</option>
                        <option value="book_updated">Book Updated</option>
                        <option value="book_deleted">Book Deleted</option>
                        <option value="book_borrowed">Book Borrowed</option>
                        <option value="book_returned">Book Returned</option>
                        <option value="member_created">Member Created</option>
                        <option value="member_updated">Member Updated</option>
                        <option value="member_deleted">Member Deleted</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Filter by Year</label>
                    <select class="filter-select" id="yearFilter">
                        <option value="">All Years</option>
                        @php
                            $currentYear = date('Y');
                            $startYear = $logs->min('created_at') ? $logs->min('created_at')->year : $currentYear;
                        @endphp
                        @for($year = $currentYear; $year >= $startYear; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Filter by Month</label>
                    <select class="filter-select" id="monthFilter">
                        <option value="">All Months</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Show Entries</label>
                    <select class="filter-select" id="perPageSelect" onchange="changePerPage(this.value)">
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Search</label>
                    <div class="search-input-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" class="filter-input" placeholder="Search logs..." id="searchInput">
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="table-container">
            <div class="table-wrapper">
                @if($logs->count() > 0)
                <table>
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
                        @php
                            $actionIcon = [
                                'user_login' => 'fa-sign-in-alt',
                                'user_logout' => 'fa-sign-out-alt',
                                'password_changed' => 'fa-key',
                                'password_change_failed' => 'fa-exclamation-triangle',
                                'login_failed' => 'fa-exclamation-circle',
                                'book_created' => 'fa-plus-circle',
                                'book_updated' => 'fa-edit',
                                'book_deleted' => 'fa-trash-alt',
                                'book_borrowed' => 'fa-book-open',
                                'book_returned' => 'fa-undo',
                                'member_created' => 'fa-user-plus',
                                'member_updated' => 'fa-user-edit',
                                'member_deleted' => 'fa-user-times',
                                'member_time_in' => 'fa-clock',
                                'member_time_out' => 'fa-clock',
                                'member_time_in_qr' => 'fa-qrcode',
                                'member_time_out_qr' => 'fa-qrcode'
                            ][strtolower($log->action)] ?? 'fa-circle';
                        @endphp
                        <tr data-action="{{ strtolower($log->action) }}" data-date="{{ $log->created_at->format('Y-m') }}" data-year="{{ $log->created_at->year }}" data-month="{{ $log->created_at->format('m') }}">
                            <td class="log-number">{{ str_pad($logs->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <span class="log-action {{ strtolower($log->action) }}">
                                    <i class="fas {{ $actionIcon }}"></i>
                                    {{ ucwords(str_replace('_', ' ', $log->action)) }}
                                </span>
                            </td>
                            <td>
                                @if($log->user)
                                <span class="log-user-badge">
                                    <i class="fas fa-user"></i>
                                    {{ $log->user->username ?? 'Unknown' }}
                                </span>
                                @else
                                <span style="color: var(--text-secondary); font-size: 13px;">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="log-description">{{ $log->description }}</div>
                            </td>
                            <td>
                                <div class="log-timestamp">
                                    {{ $log->created_at->format('M d, Y H:i:s') }}
                                </div>
                            </td>
                            <td>
                                <div class="actions-cell">
                                    @if($log->metadata)
                                    <button class="action-button" onclick="viewDetails({{ $log->id }})">
                                        <i class="fas fa-eye"></i>
                                        View
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>No Logs Found</h3>
                    <p>The system logs database is empty.</p>
                </div>
                @endif
            </div>

            @if($logs->count() > 0)
            <div class="table-footer">
                <div class="pagination-info">
                    Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }} entries
                </div>
                <div class="pagination-controls">
                    @if($logs->onFirstPage())
                        <button class="pagination-button" disabled>
                            <i class="fas fa-chevron-left"></i>
                            Prev
                        </button>
                    @else
                        <a href="{{ $logs->previousPageUrl() }}" class="pagination-button">
                            <i class="fas fa-chevron-left"></i>
                            Prev
                        </a>
                    @endif

                    @foreach(range(1, $logs->lastPage()) as $page)
                        @if($page == $logs->currentPage())
                            <span class="pagination-number active">{{ $page }}</span>
                        @elseif($page == 1 || $page == $logs->lastPage() || abs($page - $logs->currentPage()) <= 1)
                            <a href="{{ $logs->url($page) }}" class="pagination-number">{{ $page }}</a>
                        @elseif($page == 2 || $page == $logs->lastPage() - 1)
                            <span class="pagination-dots">...</span>
                        @endif
                    @endforeach

                    @if($logs->hasMorePages())
                        <a href="{{ $logs->nextPageUrl() }}" class="pagination-button">
                            Next
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <button class="pagination-button" disabled>
                            Next
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Details Modal -->
    <div class="modal" id="detailsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Log Details</h3>
                <button class="modal-close" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Dynamic content -->
            </div>
        </div>
    </div>

    <!-- Notification -->
    <div id="notification" class="notification">
        <i class="fas fa-check-circle"></i>
        <span id="notificationText"></span>
    </div>

    <script>
        // Log details data
        const logsData = {!! json_encode($logs->map(function($log) {
            return [
                'id' => $log->id,
                'action' => $log->action,
                'description' => $log->description,
                'user' => $log->user ? $log->user->username : null,
                'ip_address' => $log->ip_address,
                'user_agent' => $log->user_agent,
                'metadata' => $log->metadata,
                'created_at' => $log->created_at->format('M d, Y H:i:s')
            ];
        })) !!};

        function viewDetails(logId) {
            const log = logsData.find(l => l.id === logId);
            if (!log) return;

            let metadataHtml = '';
            if (log.metadata) {
                // Check for specific metadata types
                if (log.metadata.borrowed_at || log.metadata.returned_at || log.metadata.due_date || 
                    log.metadata.time_in || log.metadata.time_out) {
                    metadataHtml += '<div class="detail-group"><div class="detail-label">Dates</div><div class="detail-value">';
                    if (log.metadata.time_in) metadataHtml += `<div>Time In: ${log.metadata.time_in}</div>`;
                    if (log.metadata.time_out) metadataHtml += `<div>Time Out: ${log.metadata.time_out}</div>`;
                    if (log.metadata.borrowed_at) metadataHtml += `<div>Borrowed: ${log.metadata.borrowed_at}</div>`;
                    if (log.metadata.due_date) metadataHtml += `<div>Due: ${log.metadata.due_date}</div>`;
                    if (log.metadata.returned_at) metadataHtml += `<div>Returned: ${log.metadata.returned_at}</div>`;
                    metadataHtml += '</div></div>';
                }

                if (log.metadata.old_values && log.metadata.new_values) {
                    metadataHtml += '<div class="detail-group"><div class="detail-label">Changes</div><div class="detail-value">';
                    for (const [field, newValue] of Object.entries(log.metadata.new_values)) {
                        const oldValue = log.metadata.old_values[field] || 'N/A';
                        metadataHtml += `<div><strong>${field}:</strong> ${oldValue} → ${newValue}</div>`;
                    }
                    metadataHtml += '</div></div>';
                }

                metadataHtml += `
                    <div class="detail-group">
                        <div class="detail-label">Raw Metadata</div>
                        <div class="detail-code">${JSON.stringify(log.metadata, null, 2)}</div>
                    </div>
                `;
            }

            const modalContent = `
                <div class="detail-group">
                    <div class="detail-label">Action</div>
                    <div class="detail-value">${log.action.replace(/_/g, ' ').toUpperCase()}</div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">Description</div>
                    <div class="detail-value">${log.description}</div>
                </div>
                ${log.user ? `
                <div class="detail-group">
                    <div class="detail-label">User</div>
                    <div class="detail-value">${log.user}</div>
                </div>
                ` : ''}
                <div class="detail-group">
                    <div class="detail-label">Timestamp</div>
                    <div class="detail-value">${log.created_at}</div>
                </div>
                ${log.ip_address ? `
                <div class="detail-group">
                    <div class="detail-label">IP Address</div>
                    <div class="detail-value">${log.ip_address}</div>
                </div>
                ` : ''}
                ${log.user_agent ? `
                <div class="detail-group">
                    <div class="detail-label">User Agent</div>
                    <div class="detail-value">${log.user_agent}</div>
                </div>
                ` : ''}
                ${metadataHtml}
            `;

            document.getElementById('modalBody').innerHTML = modalContent;
            document.getElementById('detailsModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('detailsModal').classList.remove('active');
        }

        // Close modal on outside click
        document.getElementById('detailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        function showNotification(message, type = 'success') {
            const notification = document.getElementById('notification');
            const icon = notification.querySelector('i');
            icon.className = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
            
            notification.className = `notification ${type} show`;
            document.getElementById('notificationText').textContent = message;
            
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }

        function changePerPage(perPage) {
            const url = new URL(window.location);
            url.searchParams.set('per_page', perPage);
            url.searchParams.delete('page');
            window.location.href = url.toString();
        }

        function clearLogs() {
            if (!confirm('Are you sure you want to clear all logs? This action cannot be undone.')) {
                return;
            }

            fetch('{{ route("system-logs.clear") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Logs cleared successfully', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification(data.message || 'Failed to clear logs', 'error');
                }
            })
            .catch(error => {
                showNotification('Error clearing logs', 'error');
            });
        }

        // Client-side filtering
        document.getElementById('actionFilter').addEventListener('change', function() {
            filterTable();
        });

        document.getElementById('yearFilter').addEventListener('change', function() {
            filterTable();
        });

        document.getElementById('monthFilter').addEventListener('change', function() {
            filterTable();
        });

        document.getElementById('searchInput').addEventListener('input', function() {
            filterTable();
        });

        function filterTable() {
            const actionFilter = document.getElementById('actionFilter').value.toLowerCase();
            const yearFilter = document.getElementById('yearFilter').value;
            const monthFilter = document.getElementById('monthFilter').value;
            const searchText = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            let visibleCount = 0;

            rows.forEach(row => {
                const action = row.dataset.action;
                const year = row.dataset.year;
                const month = row.dataset.month;
                const text = row.textContent.toLowerCase();
                
                const matchesAction = !actionFilter || action === actionFilter;
                const matchesYear = !yearFilter || year === yearFilter;
                const matchesMonth = !monthFilter || month === monthFilter;
                const matchesSearch = !searchText || text.includes(searchText);
                
                const shouldShow = matchesAction && matchesYear && matchesMonth && matchesSearch;
                row.style.display = shouldShow ? '' : 'none';
                
                if (shouldShow) visibleCount++;
            });

            // Update the table footer with filtered count
            updateFilteredCount(visibleCount);
        }

        function updateFilteredCount(count) {
            const paginationInfo = document.querySelector('.pagination-info');
            if (paginationInfo && count > 0) {
                const totalEntries = document.querySelectorAll('tbody tr').length;
                if (count < totalEntries) {
                    paginationInfo.innerHTML = `Showing ${count} of ${totalEntries} entries (filtered)`;
                }
            }
        }
    </script>
</body>
</html>
