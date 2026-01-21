<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>📋 System Logs | Julita Public Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            /* Shared Color Palette */
            --primary: #2fb9eb;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --accent: #06b6d4;
            --accent-dark: #0891b2;
            --success: #10b981;
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
            --shadow-glow: 0 0 25px rgba(99, 102, 241, 0.25);
        }

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
        }

        body.dark-mode {
            background: linear-gradient(135deg, #121212, #1a1a1a);
        }

        .header {
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border-bottom: 1px solid var(--glass-border);
            box-shadow: var(--glass-shadow);
            padding: var(--spacing-lg) var(--spacing-xl);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-primary);
        }

        .header h1 i {
            color: var(--primary);
            font-size: 28px;
        }

        .header-actions {
            display: flex;
            gap: var(--spacing-sm);
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: var(--radius);
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-family: 'Outfit', sans-serif;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
            box-shadow: var(--shadow);
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            background: var(--surface);
            color: var(--text-primary);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        .btn-secondary:hover {
            background: var(--surface-elevated);
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .container {
            max-width: 1400px;
            margin: var(--spacing-xl) auto;
            padding: 0 var(--spacing-lg);
        }

        .logs-container {
            background: var(--surface);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--glass-shadow);
            overflow: hidden;
        }

        .logs-header {
            padding: var(--spacing-lg) var(--spacing-xl);
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--surface-elevated);
        }

        .logs-header h2 {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logs-header h2 i {
            color: var(--accent);
        }

        .logs-count {
            color: var(--text-secondary);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .logs-count i {
            color: var(--text-muted);
        }

        .logs-content {
            max-height: calc(100vh - 280px);
            overflow-y: auto;
            padding: var(--spacing-lg);
        }

        .logs-content::-webkit-scrollbar {
            width: 8px;
        }

        .logs-content::-webkit-scrollbar-track {
            background: var(--background);
            border-radius: var(--radius);
        }

        .logs-content::-webkit-scrollbar-thumb {
            background: var(--gray-400);
            border-radius: var(--radius);
        }

        .logs-content::-webkit-scrollbar-thumb:hover {
            background: var(--gray-500);
        }

        .log-entry {
            padding: var(--spacing-md);
            margin-bottom: var(--spacing-md);
            border-left: 4px solid var(--primary);
            background: var(--surface);
            border-radius: var(--radius);
            transition: var(--transition);
            border: 1px solid var(--border-light);
        }

        .log-entry:hover {
            background: var(--surface-elevated);
            box-shadow: var(--shadow);
            transform: translateX(4px);
        }

        .log-entry.error {
            border-left-color: var(--danger);
            background: rgba(239, 68, 68, 0.05);
        }

        body.dark-mode .log-entry.error {
            background: rgba(239, 68, 68, 0.1);
        }

        .log-entry.warning {
            border-left-color: var(--warning);
            background: rgba(245, 158, 11, 0.05);
        }

        body.dark-mode .log-entry.warning {
            background: rgba(245, 158, 11, 0.1);
        }

        .log-entry.info {
            border-left-color: var(--info);
            background: rgba(59, 130, 246, 0.05);
        }

        body.dark-mode .log-entry.info {
            background: rgba(59, 130, 246, 0.1);
        }

        .log-entry.debug {
            border-left-color: var(--gray-500);
            background: rgba(100, 116, 139, 0.05);
        }

        .log-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-sm);
        }

        .log-timestamp {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .log-timestamp i {
            color: var(--text-muted);
            font-size: 11px;
        }

        .log-level {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .log-level i {
            font-size: 10px;
        }

        .log-level.error {
            background: rgba(239, 68, 68, 0.15);
            color: var(--danger);
        }

        .log-level.warning {
            background: rgba(245, 158, 11, 0.15);
            color: var(--warning);
        }

        .log-level.info {
            background: rgba(59, 130, 246, 0.15);
            color: var(--info);
        }

        .log-level.debug {
            background: rgba(100, 116, 139, 0.15);
            color: var(--gray-600);
        }

        .log-message {
            color: var(--text-primary);
            font-size: 14px;
            margin-top: var(--spacing-sm);
            word-break: break-word;
            line-height: 1.6;
        }

        .log-stack {
            margin-top: var(--spacing-md);
            padding: var(--spacing-md);
            background: var(--gray-900);
            color: var(--gray-100);
            border-radius: var(--radius);
            font-family: 'Courier New', monospace;
            font-size: 12px;
            max-height: 200px;
            overflow-y: auto;
            display: none;
            border: 1px solid var(--gray-700);
        }

        body.dark-mode .log-stack {
            background: var(--gray-800);
            border-color: var(--gray-700);
        }

        .log-entry.expanded .log-stack {
            display: block;
        }

        .toggle-stack {
            margin-top: var(--spacing-sm);
            color: var(--primary);
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: var(--transition);
        }

        .toggle-stack:hover {
            color: var(--primary-dark);
        }

        .toggle-stack i {
            font-size: 10px;
            transition: var(--transition);
        }

        .log-entry.expanded .toggle-stack i {
            transform: rotate(180deg);
        }

        .empty-state {
            text-align: center;
            padding: var(--spacing-2xl) var(--spacing-lg);
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: var(--spacing-lg);
            color: var(--gray-400);
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: var(--spacing-sm);
            color: var(--text-secondary);
        }

        .empty-state p {
            font-size: 14px;
            color: var(--text-muted);
        }

        .log-user {
            background: var(--primary);
            color: white;
            padding: 4px 8px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .pagination-container {
            margin-top: var(--spacing-lg);
            display: flex;
            justify-content: center;
        }

        .pagination-container .pagination {
            display: flex;
            gap: 4px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .pagination-container .page-link {
            padding: 8px 12px;
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text-primary);
            text-decoration: none;
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }

        .pagination-container .page-link:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .pagination-container .active .page-link {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            z-index: 1000;
            display: none;
            animation: slideIn 0.3s ease;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .notification.show {
            display: inline-flex;
        }

        .notification.success {
            background: var(--success);
            color: white;
        }

        .notification.error {
            background: var(--danger);
            color: white;
        }

        .notification i {
            font-size: 18px;
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
            .header {
                flex-direction: column;
                gap: var(--spacing-md);
                align-items: flex-start;
            }

            .header-actions {
                width: 100%;
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .logs-header {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--spacing-sm);
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>
            <i class="fas fa-file-alt"></i>
            System Logs
        </h1>
        <div class="header-actions">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            <button onclick="clearLogs()" class="btn btn-danger">
                <i class="fas fa-trash-alt"></i> Clear Logs
            </button>
        </div>
    </div>

    <div class="container">
        <div class="logs-container">
            <div class="logs-header">
                <h2>
                    <i class="fas fa-list-ul"></i>
                    Application Logs
                </h2>
                <span class="logs-count">
                    <i class="fas fa-hashtag"></i>
                    {{ count($logs) }} entries
                </span>
            </div>
            <div class="logs-content">
                @if($logs->count() > 0)
                    @foreach($logs as $log)
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
                                'member_created' => 'fa-user-plus',
                                'member_updated' => 'fa-user-edit',
                                'member_deleted' => 'fa-user-times',
                                'member_time_in' => 'fa-clock',
                                'member_time_out' => 'fa-clock',
                                'member_time_in_qr' => 'fa-qrcode',
                                'member_time_out_qr' => 'fa-qrcode'
                            ][strtolower($log->action)] ?? 'fa-circle';
                        @endphp
                        <div class="log-entry {{ strtolower($log->action) }} {{ $log->metadata ? 'has-stack' : '' }}">
                            <div class="log-header">
                                <span class="log-timestamp">
                                    <i class="fas fa-clock"></i>
                                    {{ $log->created_at->format('Y-m-d H:i:s') }}
                                </span>
                                <span class="log-level {{ strtolower($log->action) }}">
                                    <i class="fas {{ $actionIcon }}"></i>
                                    {{ ucwords(str_replace('_', ' ', $log->action)) }}
                                </span>
                                @if($log->user)
                                    <span class="log-user">
                                        <i class="fas fa-user"></i>
                                        {{ $log->user->username ?? 'Unknown' }}
                                    </span>
                                @endif
                            </div>
                            <div class="log-message">
                                <i class="fas fa-message" style="color: var(--text-muted); margin-right: 8px; font-size: 12px;"></i>
                                {{ $log->description }}
                            </div>
                            @if($log->metadata)
                                <div class="toggle-stack" onclick="toggleStack(this)">
                                    <i class="fas fa-chevron-down"></i>
                                    <span>Show Details</span>
                                </div>
                                <div class="log-stack">
                                    <pre>{{ json_encode($log->metadata, JSON_PRETTY_PRINT) }}</pre>
                                    @if($log->ip_address)
                                        <div><strong>IP Address:</strong> {{ $log->ip_address }}</div>
                                    @endif
                                    @if($log->user_agent)
                                        <div><strong>User Agent:</strong> {{ $log->user_agent }}</div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                    <div class="pagination-container">
                        {{ $logs->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3>No Logs Found</h3>
                        <p>The system logs database is empty.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="notification" class="notification"></div>

    <script>
        function toggleStack(element) {
            const entry = element.closest('.log-entry');
            const icon = element.querySelector('i');
            const span = element.querySelector('span');
            entry.classList.toggle('expanded');
            
            if (entry.classList.contains('expanded')) {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
                span.textContent = 'Hide Stack Trace';
            } else {
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
                span.textContent = 'Show Stack Trace';
            }
        }

        function showNotification(message, type = 'success') {
            const notification = document.getElementById('notification');
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
            notification.innerHTML = `<i class="fas ${icon}"></i> ${message}`;
            notification.className = `notification ${type} show`;
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
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
    </script>
</body>
</html>
