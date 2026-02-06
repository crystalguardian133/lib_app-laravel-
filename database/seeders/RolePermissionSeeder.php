<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks for truncating
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Clear existing data in correct order
        \DB::table('permission_role')->truncate();
        Permission::truncate();
        Role::truncate();
        
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $permissions = [
            // Admin permissions (full access)
            'admin' => [
                'name' => 'Admin Access',
                'slug' => 'admin',
                'description' => 'Full admin access to everything',
            ],
            'view_system_logs' => [
                'name' => 'View System Logs',
                'slug' => 'view_system_logs',
                'description' => 'Access to view system logs',
            ],

            // Librarian permissions
            'manage_members' => [
                'name' => 'Manage Members',
                'slug' => 'manage-members',
                'description' => 'Create, edit, and delete members',
            ],
            'manage_books' => [
                'name' => 'Manage Books',
                'slug' => 'manage-books',
                'description' => 'Create, edit, and delete books',
            ],
            'time_in_out' => [
                'name' => 'Time In/Out',
                'slug' => 'time-in-out',
                'description' => 'Access to time-in and time-out pages',
            ],
            'scan_qr' => [
                'name' => 'Scan QR',
                'slug' => 'scan-qr',
                'description' => 'Access to QR scanner for time-in/time-out',
            ],
            'borrow_books' => [
                'name' => 'Borrow Books',
                'slug' => 'borrow-books',
                'description' => 'Borrow books for members',
            ],
            'return_books' => [
                'name' => 'Return Books',
                'slug' => 'return-books',
                'description' => 'Process book returns',
            ],
            'view_transactions' => [
                'name' => 'View Transactions',
                'slug' => 'view-transactions',
                'description' => 'View borrow and return transactions',
            ],
            'view_overdue' => [
                'name' => 'View Overdue',
                'slug' => 'view-overdue',
                'description' => 'View overdue books and due soon',
            ],
            'edit_own_credentials' => [
                'name' => 'Edit Own Credentials',
                'slug' => 'edit-own-credentials',
                'description' => 'Edit own username, password, and email',
            ],

            // Assistant permissions
            'assistant_time_access' => [
                'name' => 'Assistant Time Access',
                'slug' => 'assistant-time-access',
                'description' => 'Access to time-in and time-out pages only',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Create roles
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Full access to everything, can manage users with lower permissions',
        ]);

        $librarianRole = Role::create([
            'name' => 'Librarian',
            'slug' => 'librarian',
            'description' => 'Can manage members, books, and time-in/out. Can borrow and return books.',
        ]);

        $assistantRole = Role::create([
            'name' => 'Assistant',
            'slug' => 'assistant',
            'description' => 'Only access to time-in and time-out pages. Can only change own credentials.',
        ]);

        // Assign permissions to Admin role (all permissions including admin)
        $adminPermissions = Permission::all();
        $adminRole->permissions()->attach($adminPermissions);

        // Assign permissions to Librarian role
        $librarianPermissions = Permission::whereIn('slug', [
            'manage-members',
            'manage-books',
            'time-in-out',
            'scan-qr',
            'borrow-books',
            'return-books',
            'view-transactions',
            'view-overdue',
            'edit-own-credentials',
        ])->get();
        $librarianRole->permissions()->attach($librarianPermissions);

        // Assign permissions to Assistant role
        $assistantPermissions = Permission::where('slug', 'assistant-time-access')->get();
        $assistantRole->permissions()->attach($assistantPermissions);
    }
}
