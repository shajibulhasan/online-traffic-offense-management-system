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
            ['name' => 'Admin',  'role' => 'admin', 'email' => 'admin@gmail.com', 'status' => '1', 'password' => Hash::make('12345678'), 'created_at' => DateTime::now()],
            ['name' => 'Officer1',  'role' => 'officer', 'email' => 'officer1@gmail.com', 'status' => '0', 'password' => Hash::make('12345678'), 'created_at' => DateTime::now()],
            ['name' => 'Officer2',  'role' => 'officer', 'email' => 'officer2@gmail.com', 'status' => '0', 'password' => Hash::make('12345678'), 'created_at' => DateTime::now()],
            ['name' => 'User1',  'role' => 'user', 'email' => 'user1@gmail.com', 'status' => '0', 'password' => Hash::make('12345678'), 'created_at' => DateTime::now()],
        ]);

        DB::table('thana')->insert([
            ['division' => 'Chattogram',  'district' => 'Coxsbazar', 'thana_name' => 'Moheshkhali', 'contact' => '0156865598'],
            ['division' => 'Dhaka',  'district' => 'Dhaka', 'thana_name' => 'Dhanmondi', 'contact' => '0156865599'],
            ['division' => 'Dhaka',  'district' => 'Dhaka', 'thana_name' => 'Mirpur', 'contact' => '0156865590'],

        ]);

        DB::table('area')->insert([
            ['district' => 'Coxsbazar',  'thana_name' => 'Moheshkhali', 'area_name' => 'Hoanak'],
            ['district' => 'Dhaka',  'thana_name' => 'Dhanmondi', 'area_name' => 'Dhanmondi'],
            ['district' => 'Dhaka',  'thana_name' => 'Mirpur', 'area_name' => 'Mirpur'],
        ]);
            

    }
}
