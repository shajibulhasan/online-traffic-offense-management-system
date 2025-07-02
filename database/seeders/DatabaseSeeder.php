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
            ['name' => 'Chattogram Leader',  'division_lead' => 'chattogram', 'email' => 'admin.chattogram@gmail.com', 'password' => Hash::make('12345678')],
            ['name' => 'Dhaka Leader', 'division_lead' => 'dhaka', 'email' => 'admin.dhaka@gmail.com', 'password' => Hash::make('12345678')],
            ['name' => 'Sylhet', 'division_lead' => 'sylhet', 'email' => 'admin.Sylhet@gmail.com', 'password' => Hash::make('12345678')],
            ['name' => 'Barishal Leader', 'division_lead' => 'barishal', 'email' => 'admin.barishal@gmail.com', 'password' => Hash::make('12345678')],
            ['name' => 'Khulna Leader', 'division_lead' => 'khulna', 'email' => 'admin.khulna@gmail.com', 'password' => Hash::make('12345678')],
            ['name' => 'Mymensingh Leader', 'division_lead' => 'mymensingh', 'email' => 'admin.mymensingh@gmail.com', 'password' => Hash::make('12345678')],
            ['name' => 'Rajshahi Leader', 'division_lead' => 'rajshahi', 'email' => 'admin.rajshahi@gmail.com', 'password' => Hash::make('12345678')],
            ['name' => 'Rangpur Leader', 'division_lead' => 'rangpur', 'email' => 'admin.rangpur@gmail.com', 'password' => Hash::make('12345678')],
        ]);
    }
}
