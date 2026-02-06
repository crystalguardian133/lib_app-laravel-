<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>🔐 Active Sessions | Julita Public Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2fb9eb;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --accent: #06b6d4;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
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
            --radius: 12px;
        }
        body {
            font-family: 'Outfit', 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--gray-50), #e0f2fe);
            color: var(--gray-900);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .page-header {
            margin-bottom: 32px;
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
        }
        .page-title i { color: var(--primary); }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            border: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }
        .btn-danger {
            background: var(--danger);
            color: white;
        }
        .btn-outline {
            background: white;
            border: 1px solid var(--gray-300);
            color: var(--gray-700);
        }
        .card {
            background: white;
            border-radius: var(--radius);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-header h3 {
            font-size: 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .card-body { padding: 24px; }
        .alert {
            padding: 16px 20px;
            border-radius: var(--radius);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
        .session-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .session-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: var(--gray-50);
            border-radius: var(--radius);
            border: 1px solid var(--gray-200);
            transition: all 0.3s ease;
        }
        .session-item:hover {
            background: var(--gray-100);
        }
        .session-item.current {
            background: rgba(47, 185, 235, 0.1);
            border-color: var(--primary);
        }
        .session-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .session-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        .session-icon.desktop {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }
        .session-icon.mobile {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }
        .session-icon.unknown {
            background: rgba(107, 114, 128, 0.1);
            color: var(--gray-500);
        }
        .session-details h4 {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .session-meta {
            font-size: 13px;
            color: var(--gray-500);
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }
        .session-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .session-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        .badge-current {
            background: var(--primary);
            color: white;
        }
        .badge-active {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--gray-500);
        }
        .empty-state i {
            font-size: 64px;
            margin-bottom: 16px;
            color: var(--gray-300);
        }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--gray-600);
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 24px;
            transition: color 0.3s ease;
        }
        .back-link:hover { color: var(--primary); }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('dashboard') }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            Back to Dashboard
        </a>

        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-desktop"></i>
                Active Sessions
            </h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-list"></i> Your Active Sessions</h3>
                <span style="font-size: 14px; color: var(--gray-500);">
                    {{ $sessions->count() }} {{ $sessions->count() == 1 ? 'session' : 'sessions' }} active
                </span>
            </div>
            <div class="card-body">
                @if($sessions->count() > 0)
                    <div class="session-list">
                        @foreach($sessions as $session)
                            @php
                                $isCurrentSession = $session->session_id === session()->getId();
                                $userAgent = $session->user_agent ?? '';
                                $isMobile = preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', substr($userAgent, 0, 4));
                            @endphp
                            <div class="session-item {{ $isCurrentSession ? 'current' : '' }}">
                                <div class="session-info">
                                    <div class="session-icon {{ $isMobile ? 'mobile' : 'desktop' }}">
                                        <i class="fas {{ $isMobile ? 'fa-mobile-alt' : 'fa-desktop' }}"></i>
                                    </div>
                                    <div class="session-details">
                                        <h4>
                                            {{ $isCurrentSession ? 'Current Session' : 'Other Device' }}
                                            @if($isCurrentSession)
                                                <span class="session-badge badge-current">
                                                    <i class="fas fa-check"></i> This Browser
                                                </span>
                                            @endif
                                        </h4>
                                        <div class="session-meta">
                                            <span><i class="fas fa-map-marker-alt"></i> {{ $session->ip_address ?? 'Unknown IP' }}</span>
                                            <span><i class="fas fa-clock"></i> Last active: {{ $session->last_activity->diffForHumans() }}</span>
                                            <span><i class="fas fa-calendar"></i> Expires: {{ $session->expires_at->diffForHumans() }}</span>
                                        </div>
                                        @if($userAgent)
                                            <div class="session-meta" style="margin-top: 4px;">
                                                <span style="word-break: break-all;">{{ Str::limit($userAgent, 80) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    @if(!$isCurrentSession)
                                        <form action="{{ route('user.sessions.invalidate', $session->id) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-outline" onclick="return confirm('Are you sure you want to terminate this session?')">
                                                <i class="fas fa-times"></i>
                                                Terminate
                                            </button>
                                        </form>
                                    @else
                                        <span class="session-badge badge-active">
                                            <i class="fas fa-circle"></i> Active Now
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-desktop"></i>
                        <h3>No active sessions</h3>
                        <p>You don't have any active sessions at the moment.</p>
                    </div>
                @endif
            </div>
        </div>

        <div style="margin-top: 24px; padding: 20px; background: rgba(239, 68, 68, 0.05); border-radius: var(--radius); border: 1px solid rgba(239, 68, 68, 0.1);">
            <h4 style="color: var(--danger); margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-exclamation-triangle"></i>
                Security Notice
            </h4>
            <p style="color: var(--gray-600); font-size: 14px; line-height: 1.6;">
                <strong>Single Session Policy:</strong> When you log in from a new device or browser, 
                all other sessions for your account will be automatically terminated. 
                This prevents multiple concurrent sessions on the same account for security purposes.
            </p>
        </div>
    </div>
</body>
</html>
