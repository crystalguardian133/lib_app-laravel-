<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Run role and permission seeder first
        $this->call(RolePermissionSeeder::class);

        // Create admin user and assign admin role
        $adminRole = Role::where('slug', 'admin')->first();
        User::factory()->create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'role_id' => $adminRole->id,
        ]);

        // Create librarian user
        $librarianRole = Role::where('slug', 'librarian')->first();
        User::factory()->create([
            'name' => 'Librarian',
            'username' => 'librarian',
            'email' => 'librarian@example.com',
            'password' => bcrypt('librarian123'),
            'role_id' => $librarianRole->id,
        ]);

        // Create assistant user
        $assistantRole = Role::where('slug', 'assistant')->first();
        User::factory()->create([
            'name' => 'Assistant',
            'username' => 'assistant',
            'email' => 'assistant@example.com',
            'password' => bcrypt('assistant123'),
            'role_id' => $assistantRole->id,
        ]);

        // Run member seeder to create sample member data
        $this->call(MemberSeeder::class);

        // Run book seeder to create sample books
        $this->call(BookSeeder::class);
    }
}
