<?php

namespace Database\Seeders;

use App\Models\User;
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

        User::factory()->create([
            'name' => 'administrator',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('1234'),
        ]);

        // Run member seeder to create sample member data
        $this->call(MemberSeeder::class);

        // Run book seeder to create sample books
        $this->call(BookSeeder::class);

        // Run transaction seeder to create sample borrowing data
        $this->call(TransactionSeeder::class);
    }
}
