<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('level')->insert([
            [
                'level_kode' => 'superadmin',
                'level_nama' => 'Super Administrator',
            ],
            [
                'level_kode' => 'admin',
                'level_nama' => 'Administrator',
            ],
            
        ]);
    }
}
