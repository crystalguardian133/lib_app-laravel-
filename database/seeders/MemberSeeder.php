<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample Julita members
        $julitaMembers = [
            [
                'first_name' => 'Juan',
                'middle_name' => 'Dela',
                'last_name' => 'Cruz',
                'age' => 25,
                'house_number' => '123',
                'street' => 'Main St',
                'barangay' => 'Poblacion District I',
                'municipality' => 'Julita',
                'province' => 'Leyte',
                'contactnumber' => '09123456789',
                'email' => 'juan@example.com',
                'school' => 'Julita Elementary School',
                'memberdate' => Carbon::now()->subDays(30),
                'member_time' => 1,
            ],
            [
                'first_name' => 'Maria',
                'middle_name' => 'Santos',
                'last_name' => 'Garcia',
                'age' => 32,
                'house_number' => '456',
                'street' => 'Oak St',
                'barangay' => 'Alegria',
                'municipality' => 'Julita',
                'province' => 'Leyte',
                'contactnumber' => '09123456790',
                'email' => 'maria@example.com',
                'school' => 'Julita High School',
                'memberdate' => Carbon::now()->subDays(20),
                'member_time' => 2,
            ],
            [
                'first_name' => 'Pedro',
                'middle_name' => 'Reyes',
                'last_name' => 'Martinez',
                'age' => 45,
                'house_number' => '789',
                'street' => 'Pine St',
                'barangay' => 'Anibong',
                'municipality' => 'Julita',
                'province' => 'Leyte',
                'contactnumber' => '09123456791',
                'email' => 'pedro@example.com',
                'school' => 'Julita Central School',
                'memberdate' => Carbon::now()->subDays(10),
                'member_time' => 3,
            ],
            [
                'first_name' => 'Ana',
                'middle_name' => 'Lopez',
                'last_name' => 'Rodriguez',
                'age' => 28,
                'house_number' => '321',
                'street' => 'Cedar St',
                'barangay' => 'Poblacion District II',
                'municipality' => 'Julita',
                'province' => 'Leyte',
                'contactnumber' => '09123456792',
                'email' => 'ana@example.com',
                'school' => 'Julita Elementary School',
                'memberdate' => Carbon::now()->subDays(5),
                'member_time' => 4,
            ],
            [
                'first_name' => 'Carlos',
                'middle_name' => 'Fernandez',
                'last_name' => 'Gonzalez',
                'age' => 55,
                'house_number' => '654',
                'street' => 'Maple St',
                'barangay' => 'Balante',
                'municipality' => 'Julita',
                'province' => 'Leyte',
                'contactnumber' => '09123456793',
                'email' => 'carlos@example.com',
                'school' => 'Julita Senior High School',
                'memberdate' => Carbon::now()->subDays(1),
                'member_time' => 5,
            ],
        ];

        // Sample non-Julita members
        $nonJulitaMembers = [
            [
                'first_name' => 'Elena',
                'middle_name' => 'Torres',
                'last_name' => 'Hernandez',
                'age' => 30,
                'house_number' => '111',
                'street' => 'Elm St',
                'barangay' => 'Centro',
                'municipality' => 'Tacloban',
                'province' => 'Leyte',
                'contactnumber' => '09123456794',
                'email' => 'elena@example.com',
                'school' => 'Tacloban University',
                'memberdate' => Carbon::now()->subDays(15),
                'member_time' => 6,
            ],
            [
                'first_name' => 'Miguel',
                'middle_name' => 'Ramirez',
                'last_name' => 'Perez',
                'age' => 40,
                'house_number' => '222',
                'street' => 'Birch St',
                'barangay' => 'Poblacion',
                'municipality' => 'Ormoc',
                'province' => 'Leyte',
                'contactnumber' => '09123456795',
                'email' => 'miguel@example.com',
                'school' => 'Ormoc City College',
                'memberdate' => Carbon::now()->subDays(8),
                'member_time' => 7,
            ],
            [
                'first_name' => 'Sofia',
                'middle_name' => 'Morales',
                'last_name' => 'Sanchez',
                'age' => 22,
                'house_number' => '333',
                'street' => 'Willow St',
                'barangay' => 'San Jose',
                'municipality' => 'Baybay',
                'province' => 'Leyte',
                'contactnumber' => '09123456796',
                'email' => 'sofia@example.com',
                'school' => 'Baybay National High School',
                'memberdate' => Carbon::now()->subDays(3),
                'member_time' => 8,
            ],
        ];

        // Insert all members
        foreach (array_merge($julitaMembers, $nonJulitaMembers) as $memberData) {
            Member::create($memberData);
        }
    }
}