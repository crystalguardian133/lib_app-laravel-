<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🛡️ User Permissions | Admin</title>
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
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
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
        .page-title { font-size: 1.8rem; font-weight: 700; }
        
        .user-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: var(--radius);
            padding: 32px;
            color: white;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .user-info { display: flex; align-items: center; gap: 20px; }
        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 700;
        }
        .user-details h2 { font-size: 1.5rem; margin-bottom: 4px; }
        .user-details p { opacity: 0.9; }
        .role-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }
        .role-admin { background: rgba(239, 68, 68, 0.9); color: white; }
        .role-librarian { background: rgba(59, 130, 246, 0.9); color: white; }
        .role-assistant { background: rgba(34, 197, 94, 0.9); color: white; }
        
        .grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; }
        .card {
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-header h3 { display: flex; align-items: center; gap: 10px; font-size: 1.1rem; }
        .card-body { padding: 24px; }
        
        .permission-list { list-style: none; }
        .permission-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 16px;
            border-radius: var(--radius);
            margin-bottom: 8px;
            background: rgba(0,0,0,0.02);
            transition: all 0.3s ease;
        }
        .permission-item:hover { background: rgba(0,0,0,0.04); }
        .permission-info { display: flex; align-items: center; gap: 12px; }
        .permission-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }
        .permission-icon.active { background: rgba(16, 185, 129, 0.15); color: #10b981; }
        .permission-icon.inactive { background: rgba(0,0,0,0.05); color: var(--text-secondary); }
        .permission-icon.revoked { background: rgba(239, 68, 68, 0.15); color: #ef4444; }
        .permission-icon.special { background: rgba(139, 92, 246, 0.15); color: #8b5cf6; }
        .permission-name { font-weight: 500; }
        .permission-desc { font-size: 12px; color: var(--text-secondary); }
        
        .special-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }
        .tag-role { background: rgba(16, 185, 129, 0.15); color: #10b981; }
        .tag-special { background: rgba(139, 92, 246, 0.15); color: #8b5cf6; }
        .tag-revoked { background: rgba(239, 68, 68, 0.15); color: #ef4444; }
        
        .expiry-info {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 4px;
        }
        .expiry-soon { color: #f59e0b; }
        .expired { color: #ef4444; }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: var(--radius);
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
        }
        .btn-sm { padding: 6px 12px; font-size: 13px; }
        .btn-danger { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
        .btn-danger:hover { background: #ef4444; color: white; }
        .btn-success { background: rgba(16, 185, 129, 0.1); color: #10b981; }
        .btn-success:hover { background: #10b981; color: white; }
        
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .modal-overlay.active { opacity: 1; visibility: visible; }
        .modal {
            background: var(--surface);
            border-radius: var(--radius);
            width: 100%;
            max-width: 500px;
            transform: translateY(20px);
            transition: all 0.3s ease;
        }
        .modal-overlay.active .modal { transform: translateY(0); }
        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-close {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            background: rgba(0,0,0,0.05);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-body { padding: 24px; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-secondary); }
        .form-select, .form-input, .form-textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid rgba(0,0,0,0.1);
            border-radius: var(--radius);
            background: var(--surface);
            color: var(--text-primary);
            font-size: 14px;
        }
        .form-select:focus, .form-input:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
        }
        .form-textarea { min-height: 80px; resize: vertical; }
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
            <h1 class="page-title">🛡️ Manage Permissions</h1>
        </div>

        <div class="user-header">
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <div class="user-details">
                    <h2>{{ $user->name }}</h2>
                    <p>{{ $user->email }} • @ {{ $user->username }}</p>
                </div>
            </div>
            <span class="role-badge role-{{ $user->role ? $user->role->slug : 'unknown' }}">
                {{ $user->role ? $user->role->name : 'No Role' }}
            </span>
        </div>

        @php($userIdentifier = $user->uuid ?: $user->id)

        <div class="grid">
            <!-- Role Permissions -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-users-cog"></i> Role Permissions</h3>
                    <span style="font-size: 13px; color: var(--text-secondary);">
                        Based on {{ $user->role ? $user->role->name : 'No Role' }}
                    </span>
                </div>
                <div class="card-body">
                    <ul class="permission-list">
                        @forelse($rolePermissions as $permission)
                        @php($isRevoked = $user->revokedPermissions->contains($permission->id))
                        <li class="permission-item" style="{{ $isRevoked ? 'opacity: 0.6;' : '' }}">
                            <div class="permission-info">
                                <div class="permission-icon {{ $isRevoked ? 'revoked' : 'active' }}">
                                    <i class="fas fa-{{ $isRevoked ? 'times' : 'check' }}"></i>
                                </div>
                                <div>
                                    <div class="permission-name">{{ $permission->name }}</div>
                                    <div class="permission-desc">{{ $permission->description }}</div>
                                    @if($isRevoked)
                                        <div style="margin-top: 4px;">
                                            <span class="special-tag tag-revoked">
                                                <i class="fas fa-ban"></i> Revoked
                                            </span>
                                        </div>
                                    @else
                                        <div style="margin-top: 4px;">
                                            <span class="special-tag tag-role">
                                                <i class="fas fa-shield-alt"></i> Role
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @if($isRevoked)
                                <form action="{{ route('admin.users.restore-permission', [$userIdentifier, $permission->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Restore this permission?')">
                                        <i class="fas fa-undo"></i> Restore
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-danger btn-sm" onclick="openRevokeModal('{{ $permission->id }}', '{{ $permission->name }}')">
                                    <i class="fas fa-ban"></i> Revoke
                                </button>
                            @endif
                        </li>
                        @empty
                        <li class="permission-item">
                            <div class="permission-info">
                                <div class="permission-icon inactive">
                                    <i class="fas fa-times"></i>
                                </div>
                                <div>
                                    <div class="permission-name">No Permissions</div>
                                    <div class="permission-desc">This role has no permissions</div>
                                </div>
                            </div>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Special Permissions -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-star" style="color: #8b5cf6;"></i> Special Permissions</h3>
                    <button class="btn btn-primary btn-sm" onclick="openGrantModal()">
                        <i class="fas fa-plus"></i> Add
                    </button>
                </div>
                <div class="card-body">
                    @if($user->specialPermissions->count() > 0)
                        <ul class="permission-list">
                            @foreach($user->specialPermissions as $permission)
                            <li class="permission-item">
                                <div class="permission-info">
                                    <div class="permission-icon special">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div>
                                        <div class="permission-name">{{ $permission->name }}</div>
                                        <div class="permission-desc">{{ $permission->description }}</div>
                                        @if($permission->pivot->expires_at)
                                            @php($expiresAt = \Carbon\Carbon::parse($permission->pivot->expires_at))
                                            @php($isExpired = $expiresAt->isPast())
                                            @php($isSoon = $expiresAt->isFuture() && $expiresAt->diffInDays() <= 7)
                                            <div class="expiry-info {{ $isExpired ? 'expired' : ($isSoon ? 'expiry-soon' : '') }}">
                                                <i class="fas fa-clock"></i>
                                                {{ $isExpired ? 'Expired' : 'Expires' }}: {{ $expiresAt->format('M d, Y') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <form action="{{ route('admin.users.revoke-special-permission', [$userIdentifier, $permission->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Revoke this special permission?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <div style="text-align: center; padding: 40px 20px; color: var(--text-secondary);">
                            <i class="fas fa-star" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
                            <p>No special permissions</p>
                            <p style="font-size: 13px;">Grant additional permissions beyond the role</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- All Available Permissions -->
        <div class="card" style="margin-top: 24px;">
            <div class="card-header">
                <h3><i class="fas fa-list-ul"></i> All Permissions Overview</h3>
            </div>
            <div class="card-body">
                <ul class="permission-list">
                    @foreach($allPermissions as $permission)
                    @php($hasRolePermission = $user->role && $user->role->permissions->contains($permission->id))
                    @php($hasSpecialPermission = $user->specialPermissions->contains($permission->id))
                    @php($isRevoked = $user->revokedPermissions->contains($permission->id))
                    <li class="permission-item" style="{{ $isRevoked ? 'opacity: 0.6;' : '' }}">
                        <div class="permission-info">
                            <div class="permission-icon {{ $hasRolePermission || $hasSpecialPermission ? ($isRevoked ? 'revoked' : 'active') : 'inactive' }}">
                                <i class="fas fa-{{ $hasRolePermission || $hasSpecialPermission ? ($isRevoked ? 'times' : 'check') : 'minus' }}"></i>
                            </div>
                            <div>
                                <div class="permission-name">{{ $permission->name }}</div>
                                <div class="permission-desc">{{ $permission->description }}</div>
                                <div style="margin-top: 4px; display: flex; gap: 4px; flex-wrap: wrap;">
                                    @if($hasRolePermission)
                                        @if($isRevoked)
                                            <span class="special-tag tag-revoked"><i class="fas fa-ban"></i> Revoked</span>
                                        @else
                                            <span class="special-tag tag-role"><i class="fas fa-shield-alt"></i> Role</span>
                                        @endif
                                    @endif
                                    @if($hasSpecialPermission)
                                        <span class="special-tag tag-special"><i class="fas fa-star"></i> Special</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div>
                            @if($hasRolePermission && !$isRevoked)
                                <button class="btn btn-danger btn-sm" onclick="openRevokeModal('{{ $permission->id }}', '{{ $permission->name }}')">
                                    <i class="fas fa-ban"></i> Revoke
                                </button>
                            @elseif($isRevoked)
                                <form action="{{ route('admin.users.restore-permission', [$userIdentifier, $permission->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-undo"></i> Restore
                                    </button>
                                </form>
                            @elseif(!$hasSpecialPermission)
                                <form action="{{ route('admin.users.grant-special-permission', $userIdentifier) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="permission_id" value="{{ $permission->id }}">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Grant
                                    </button>
                                </form>
                            @else
                                <span style="color: var(--text-secondary); font-size: 13px;">
                                    <i class="fas fa-check-circle" style="color: #10b981;"></i> Active
                                </span>
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Grant Special Permission Modal -->
    <div class="modal-overlay" id="grantModal">
        <div class="modal">
            <div class="modal-header">
                <h3><i class="fas fa-star" style="color: #8b5cf6;"></i> Grant Special Permission</h3>
                <button class="modal-close" onclick="closeGrantModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.users.grant-special-permission', $userIdentifier) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Select Permission</label>
                        <select name="permission_id" class="form-select" required>
                            <option value="">Choose a permission...</option>
                            @foreach($allPermissions as $permission)
                                @if(!$user->role || !$user->role->permissions->contains($permission->id))
                                    @if(!$user->specialPermissions->contains($permission->id))
                                        <option value="{{ $permission->id }}">{{ $permission->name }} - {{ $permission->description }}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Expiration (Optional)</label>
                        <input type="date" name="expires_at" class="form-input" min="{{ date('Y-m-d') }}">
                        <small style="color: var(--text-secondary);">Leave blank for permanent access</small>
                    </div>
                </div>
                <div style="padding: 0 24px 24px; display: flex; gap: 12px;">
                    <button type="button" class="btn btn-secondary" style="flex: 1;" onclick="closeGrantModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="flex: 1;">
                        <i class="fas fa-star"></i> Grant
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Revoke Role Permission Modal -->
    <div class="modal-overlay" id="revokeModal">
        <div class="modal">
            <div class="modal-header">
                <h3><i class="fas fa-ban" style="color: #ef4444;"></i> Revoke Permission</h3>
                <button class="modal-close" onclick="closeRevokeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.users.revoke-role-permission', $userIdentifier) }}" method="POST">
                @csrf
                <input type="hidden" name="permission_id" id="revokePermissionId">
                <div class="modal-body">
                    <p style="margin-bottom: 16px;">You are about to revoke the permission: <strong id="revokePermissionName"></strong></p>
                    <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 16px;">
                        This will prevent the user from using this permission even though their role grants it.
                    </p>
                    <div class="form-group">
                        <label class="form-label">Reason (Optional)</label>
                        <textarea name="reason" class="form-textarea" placeholder="Why are you revoking this permission?"></textarea>
                    </div>
                </div>
                <div style="padding: 0 24px 24px; display: flex; gap: 12px;">
                    <button type="button" class="btn btn-secondary" style="flex: 1;" onclick="closeRevokeModal()">Cancel</button>
                    <button type="submit" class="btn btn-danger" style="flex: 1;">
                        <i class="fas fa-ban"></i> Revoke Permission
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openGrantModal() {
            document.getElementById('grantModal').classList.add('active');
        }
        function closeGrantModal() {
            document.getElementById('grantModal').classList.remove('active');
        }
        
        function openRevokeModal(permissionId, permissionName) {
            document.getElementById('revokePermissionId').value = permissionId;
            document.getElementById('revokePermissionName').textContent = permissionName;
            document.getElementById('revokeModal').classList.add('active');
        }
        function closeRevokeModal() {
            document.getElementById('revokeModal').classList.remove('active');
        }
        
        document.getElementById('grantModal').addEventListener('click', function(e) {
            if (e.target === this) closeGrantModal();
        });
        document.getElementById('revokeModal').addEventListener('click', function(e) {
            if (e.target === this) closeRevokeModal();
        });

        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark-mode');
        }
    </script>
</body>
</html>
