<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('users')->insert([
            ['name' => 'Admin',  'role' => 'admin', 'email' => 'admin@gmail.com', 'status' => '1', 'password' => Hash::make('12345678')],
            ['name' => 'Officer1',  'role' => 'officer', 'email' => 'officer1@gmail.com', 'status' => '0', 'password' => Hash::make('12345678')],
            ['name' => 'Officer2',  'role' => 'officer', 'email' => 'officer2@gmail.com', 'status' => '0', 'password' => Hash::make('12345678')],
            ['name' => 'User1',  'role' => 'user', 'email' => 'user1@gmail.com', 'status' => '0', 'password' => Hash::make('12345678')],
        ]);

    }
}
