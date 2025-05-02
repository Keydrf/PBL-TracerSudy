<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user')->insert([
            [
                'level_id' => 1,
                'username' => 'superadmin',
                'nama' => 'Super Administrator',
                'password' => Hash::make('12345678'), // Gunakan Hash::make untuk mengenkripsi password
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'level_id' => 2,
                'username' => 'admin',
                'nama' => 'Administrator',
                'password' => Hash::make('12345678'), // Gunakan Hash::make untuk mengenkripsi password
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}
