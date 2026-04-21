<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password - Julita Public Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #2fb9eb;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --accent: #06b6d4;
            --accent-dark: #0891b2;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
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
            --background: #f8fafc;
            --surface: rgba(255, 255, 255, 0.85);
            --surface-elevated: rgba(255, 255, 255, 0.95);
            --text-primary: var(--gray-900);
            --text-secondary: var(--gray-600);
            --text-muted: var(--gray-500);
            --border: rgba(226, 232, 240, 0.7);
            --glass-bg: rgba(255, 255, 255, 0.35);
            --glass-border: rgba(255, 255, 255, 0.25);
            --glass-shadow: 0 8px 32px rgba(31, 38, 135, 0.18);
            --glass-blur: blur(10px);
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.04);
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 10px 15px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 20px 25px rgba(0, 0, 0, 0.1);
            --shadow-glow: 0 0 20px rgba(99, 102, 241, 0.12);
            --radius-sm: 8px;
            --radius: 12px;
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body.dark-mode {
            --background: #121212;
            --surface: rgba(30, 30, 30, 0.8);
            --surface-elevated: rgba(40, 40, 40, 0.85);
            --text-primary: var(--gray-100);
            --text-secondary: var(--gray-300);
            --text-muted: var(--gray-400);
            --border: rgba(255, 255, 255, 0.1);
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
            background: linear-gradient(135deg, var(--background), #f1f5f9);
            color: var(--text-primary);
            line-height: 1.6;
            transition: background 0.4s cubic-bezier(0.4, 0, 0.2, 1), color 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            overflow: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

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

        body.dark-mode {
            background: linear-gradient(135deg, #121212, #1a1a1a);
        }

        .reset-card {
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--glass-shadow);
            max-width: 450px;
            width: 90%;
            animation: slideIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .reset-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .reset-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 0 30px rgba(47, 185, 235, 0.3);
        }

        .reset-icon i {
            color: white;
            font-size: 28px;
        }

        .reset-header h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .reset-header p {
            color: var(--text-secondary);
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-primary);
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            background: var(--surface-elevated);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text-primary);
            font-size: 14px;
            transition: var(--transition);
            font-family: inherit;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(47, 185, 235, 0.1);
        }

        .form-group input::placeholder {
            color: var(--text-muted);
        }

        .btn-submit {
            width: 100%;
            padding: 12px 16px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(47, 185, 235, 0.3);
            margin-top: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(47, 185, 235, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: var(--transition);
        }

        .back-link a:hover {
            color: var(--accent);
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            animation: slideIn 0.3s ease-out;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: var(--success);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: var(--danger);
        }

        .error-message {
            color: var(--danger);
            font-size: 12px;
            margin-top: 6px;
        }

        .info-box {
            background: rgba(47, 185, 235, 0.1);
            border-left: 3px solid var(--primary);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        #themeLabel {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            color: rgba(0, 0, 0, 0.8);
            font-size: 14px;
        }

        body.dark-mode #themeLabel {
            color: rgba(255, 255, 255, 0.8);
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

        .slider-thumb .icon-moon {
            display: none;
        }

        .switch input:checked + .slider .slider-thumb {
            transform: translateX(26px);
        }

        .switch input:checked + .slider .icon-sun {
            display: none;
        }

        .switch input:checked + .slider .icon-moon {
            display: inline;
        }
    </style>
</head>
<body>
    <div class="theme-toggle">
        <span id="themeLabel">Light Mode</span>
        <label class="switch" title="Toggle Dark Mode">
            <input type="checkbox" id="themeToggle">
            <span class="slider">
                <span class="slider-thumb">
                    <span class="icon-sun">🌞</span>
                    <span class="icon-moon">🌙</span>
                </span>
            </span>
        </label>
    </div>

    <div class="reset-card">
        <div class="reset-header">
            <div class="reset-icon">
                <i class="fas fa-key"></i>
            </div>
            <h1>Forgot Your Password?</h1>
            <p>Enter your username and email so we can verify your account before resetting your password.</p>
        </div>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ $error }}
                </div>
            @endforeach
        @endif

        @if (session('status'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.send-reset-email') }}">
            @csrf

            <div class="info-box">
                <i class="fas fa-info-circle"></i> We will verify your username and email, then send a secure verification link to continue the password reset.
            </div>

            <div class="form-group">
                <label for="username">
                    <i class="fas fa-user" style="color: var(--primary); margin-right: 8px;"></i> Username
                </label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Enter your username"
                    value="{{ old('username') }}"
                    required
                >
                @error('username')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">
                    <i class="fas fa-envelope" style="color: var(--primary); margin-right: 8px;"></i> Email Address
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="Enter your email address"
                    value="{{ old('email') }}"
                    required
                >
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane" style="margin-right: 8px;"></i> Send Verification Email
            </button>
        </form>

        <div class="back-link">
            <a href="{{ route('login') }}">
                <i class="fas fa-arrow-left" style="margin-right: 6px;"></i> Back to Login
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');
            const body = document.body;
            const label = document.getElementById('themeLabel');

            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                body.classList.add('dark-mode');
                themeToggle.checked = true;
                label.textContent = 'Dark Mode';
            } else {
                label.textContent = 'Light Mode';
            }

            themeToggle.addEventListener('change', function() {
                if (this.checked) {
                    body.classList.add('dark-mode');
                    localStorage.setItem('theme', 'dark');
                    label.textContent = 'Dark Mode';
                } else {
                    body.classList.remove('dark-mode');
                    localStorage.setItem('theme', 'light');
                    label.textContent = 'Light Mode';
                }
            });
        });
    </script>
</body>
</html>
