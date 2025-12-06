<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Julita Public Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600&display=swap" rel="stylesheet">
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

        /* 🌙 DARK MODE - With Dark Gray Background */
        body.dark-mode {
            --background: #121212;          /* Sleek dark gray */
            --surface: rgba(30, 30, 30, 0.8);
            --surface-elevated: rgba(40, 40, 40, 0.85);
            --text-primary: var(--gray-100);
            --text-secondary: var(--gray-300);
            --text-muted: var(--gray-400);
            --border: rgba(255, 255, 255, 0.1);
            --border-light: rgba(255, 255, 255, 0.05);
            /* Glassmorphism for dark gray */
            --glass-bg: rgba(40, 40, 40, 0.4);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.6);
            --glass-blur: blur(10px);
            /* Stronger glow to pop on neutral dark */
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

        .login-card {
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--glass-shadow);
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 1.5rem;
            box-shadow: var(--shadow);
            transition: var(--transition-spring);
        }

        .logo:hover {
            transform: scale(1.05) rotate(2deg);
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: 600;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--glass-border);
            border-radius: var(--radius);
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            color: var(--text-primary);
            font-size: 1rem;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(47, 185, 235, 0.1), var(--shadow);
            background: var(--surface-elevated);
            transform: translateY(-1px);
        }

        .form-input:hover {
            border-color: var(--primary);
            transform: translateY(-1px);
        }

        .form-input::placeholder {
            color: var(--text-muted);
        }

        .password-group {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0.25rem;
            border-radius: var(--radius);
            transition: var(--transition);
        }

        .password-toggle:hover {
            color: var(--text-primary);
            background: rgba(0, 0, 0, 0.05);
        }

        .remember-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .remember-group input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
            accent-color: var(--primary);
        }

        .remember-group label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: 0.75rem 1rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: var(--radius);
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--shadow);
        }

        .btn-login:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--secondary));
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
        }

        .login-footer a {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .login-footer a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: var(--danger);
            padding: 0.75rem;
            border-radius: var(--radius);
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }

        .success-message {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: var(--success);
            padding: 0.75rem;
            border-radius: var(--radius);
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }

        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .loading-spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s linear infinite;
            margin-right: 0.5rem;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Dark Mode Toggle */
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

        @media (max-width: 480px) {
            .login-card {
                padding: 1.5rem;
                margin: 1rem;
            }

            .login-title {
                font-size: 1.25rem;
            }

            .theme-toggle {
                top: 10px;
                right: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Theme Toggle -->
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

    <div class="login-card">
        <div class="login-header">
            <div class="logo">
                <i class="fas fa-book"></i>
            </div>
            <h1 class="login-title">Welcome Back</h1>
            <p class="login-subtitle">Sign in to your library account</p>
        </div>

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            @if(session('errors') && session('errors')->has('username'))
                <div class="error-message">
                    {{ session('errors')->first('username') }}
                </div>
            @endif

            @if(session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <div class="form-group">
                <label for="username" class="form-label">
                    <i class="fas fa-user" style="margin-right: 0.5rem;"></i>
                    Username
                </label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    class="form-input"
                    placeholder="Enter your username"
                    value="{{ old('username') }}"
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password" class="form-label">
                    <i class="fas fa-lock" style="margin-right: 0.5rem;"></i>
                    Password
                </label>
                <div class="password-group">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input"
                        placeholder="Enter your password"
                        required
                    >
                    <button type="button" class="password-toggle" id="passwordToggle" title="Toggle password visibility">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="remember-group">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>

            <button type="submit" class="btn-login" id="loginBtn">
                <i class="fas fa-sign-in-alt" style="margin-right: 0.5rem;"></i>
                Sign In
            </button>
        </form>

        <div class="login-footer">
            <a href="#">
                <i class="fas fa-key" style="margin-right: 0.25rem;"></i>
                Forgot your password?
            </a>
        </div>
    </div>

    <script>
        // Theme toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');
            const body = document.body;

            // Load saved theme preference
            const savedTheme = localStorage.getItem('theme');
            const label = document.getElementById('themeLabel');
            if (savedTheme === 'dark') {
                body.classList.add('dark-mode');
                themeToggle.checked = true;
                label.textContent = 'Dark Mode';
            } else {
                label.textContent = 'Light Mode';
            }

            // Theme toggle event listener
            themeToggle.addEventListener('change', function() {
                body.classList.add('dark-mode-transition');

                const label = document.getElementById('themeLabel');

                if (this.checked) {
                    body.classList.add('dark-mode');
                    localStorage.setItem('theme', 'dark');
                    label.textContent = 'Dark Mode';
                } else {
                    body.classList.remove('dark-mode');
                    localStorage.setItem('theme', 'light');
                    label.textContent = 'Light Mode';
                }

                // Remove transition class after animation
                setTimeout(() => {
                    body.classList.remove('dark-mode-transition');
                }, 600);
            });
        });

        // Password toggle functionality
        document.getElementById('passwordToggle').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
                this.title = 'Hide password';
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
                this.title = 'Show password';
            }
        });

        // Form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('loginBtn');
            const originalText = btn.innerHTML;

            // Add loading state
            btn.disabled = true;
            btn.innerHTML = '<span class="loading-spinner"></span>Signing In...';
            btn.classList.add('loading');

            // Remove loading state after 3 seconds (fallback)
            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                btn.classList.remove('loading');
            }, 3000);
        });

        // Auto-focus username field if no errors
        @if(!$errors->has('username'))
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('username').focus();
            });
        @endif
    </script>
</body>
</html>