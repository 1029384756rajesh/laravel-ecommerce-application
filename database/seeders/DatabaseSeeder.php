<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
            'is_admin' => true
        ]);

        DB::table('settings')->insert([
            'about' => 'lorem',
            'email' => 'admin@admin.com',
            'mobile' => '1234567890',
            'gst' => 5,
            'shipping_cost' => 349,
            'return_address' => 'Odisha',
        ]);
    }
}
