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
        DB::table('division')->insert([
            ['id' => 1, 'email' => 'admin.chittagong@gmail.com', 'password' => Hash::make('12345678')],
            ['id' => 2, 'email' => 'admin.dhaka@gmail.com', 'password' => Hash::make('12345678')],
            ['id' => 3, 'email' => 'admin.comilla@gmail.com', 'password' => Hash::make('12345678')],
            ['id' => 4, 'email' => 'admin.barishal@gmail.com', 'password' => Hash::make('12345678')],
            ['id' => 5, 'email' => 'admin.khulna@gmail.com', 'password' => Hash::make('12345678')],
            ['id' => 6, 'email' => 'admin.mymensingh@gmail.com', 'password' => Hash::make('12345678')],
            ['id' => 7, 'email' => 'admin.rajshahi@gmail.com', 'password' => Hash::make('12345678')],
            ['id' => 8, 'email' => 'admin.rangpur@gmail.com', 'password' => Hash::make('12345678')],
        ]);
    }
}
