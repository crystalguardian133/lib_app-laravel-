<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>➕ Create New User | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2fb9eb;
            --primary-dark: #1a9bcf;
            --secondary: #8b5cf6;
            --background: #f8fafc;
            --surface: rgba(255, 255, 255, 0.9);
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --danger: #ef4444;
            --radius: 12px;
        }
        body.dark-mode {
            --background: #0a0a0a;
            --surface: rgba(30, 30, 30, 0.9);
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Outfit', 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--background), #e0f2fe);
            color: var(--text-primary);
            min-height: 100vh;
        }
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, rgba(30, 64, 175, 0.95), rgba(124, 58, 237, 0.95));
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
        .logo {
            width: 120px;
            height: 120px;
            border-radius: 16px;
            object-fit: cover;
            margin-bottom: 12px;
        }
        .sidebar-header .label {
            font-weight: 700;
            font-size: 1.1rem;
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
            margin-bottom: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .sidebar nav a:hover, .sidebar nav a.active {
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
        .page-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }
        .page-title { font-size: 1.8rem; font-weight: 700; }
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: var(--radius);
            text-decoration: none;
            color: var(--text-secondary);
            background: var(--surface);
            border: 1px solid rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .back-btn:hover { background: rgba(0,0,0,0.05); }
        .card {
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            max-width: 800px;
        }
        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid rgba(0,0,0,0.1);
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }
        .card-body { padding: 32px; }
        .form-group { margin-bottom: 24px; }
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-secondary);
        }
        .form-input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid rgba(0,0,0,0.1);
            border-radius: var(--radius);
            background: var(--surface);
            color: var(--text-primary);
            font-size: 15px;
            transition: all 0.3s ease;
        }
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(47, 185, 235, 0.1);
        }
        .role-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 8px;
        }
        .role-option {
            padding: 20px;
            border: 2px solid rgba(0,0,0,0.1);
            border-radius: var(--radius);
            cursor: pointer;
            text-align: center;
            transition: all 0.3s ease;
        }
        .role-option:hover { border-color: var(--primary); }
        .role-option input { display: none; }
        .role-option:has(input:checked) {
            border-color: var(--primary);
            background: rgba(47, 185, 235, 0.1);
        }
        .role-content i {
            font-size: 24px;
            margin-bottom: 8px;
        }
        .role-content div { font-weight: 600; }
        .role-content small { color: var(--text-secondary); font-size: 12px; }
        .btn-group {
            display: flex;
            gap: 16px;
            margin-top: 32px;
        }
        .btn {
            flex: 1;
            padding: 16px 24px;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
        }
        .btn-secondary {
            background: rgba(0,0,0,0.05);
            color: var(--text-secondary);
        }
        .error-message { color: var(--danger); font-size: 13px; margin-top: 6px; }
    </style>
</head>
<body>
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
        </nav>
    </div>

    <div class="main-content">
        <div class="page-header">
            <a href="{{ route('admin.users.index') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Back to Users
            </a>
            <h1 class="page-title">➕ Create New User</h1>
        </div>

        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-user-plus"></i> User Information</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="name" class="form-input" 
                               placeholder="Enter full name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address *</label>
                        <input type="email" name="email" class="form-input" 
                               placeholder="Enter email address" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Username *</label>
                        <input type="text" name="username" class="form-input" 
                               placeholder="Enter username" value="{{ old('username') }}" required>
                        @error('username')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password *</label>
                        <input type="password" name="password" class="form-input" 
                               placeholder="Enter password" required>
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Confirm Password *</label>
                        <input type="password" name="password_confirmation" class="form-input" 
                               placeholder="Confirm password" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Role *</label>
                        <div class="role-options">
                            @foreach($roles as $role)
                                <label class="role-option">
                                    <input type="radio" name="role_id" value="{{ $role->id }}" 
                                           {{ old('role_id') == $role->id ? 'checked' : '' }}>
                                    <div class="role-content">
                                        <i class="fas fa-{{ $role->slug == 'admin' ? 'crown' : ($role->slug == 'librarian' ? 'book-reader' : 'user') }}"></i>
                                        <div>{{ $role->name }}</div>
                                        <small>{{ $role->description }}</small>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('role_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="btn-group">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark-mode');
        }
    </script>
</body>
</html>
