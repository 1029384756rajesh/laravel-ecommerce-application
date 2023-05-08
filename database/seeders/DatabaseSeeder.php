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
            'about' => 'This is a ecommerce company',
            'email' => 'admin@admin.com',
            'mobile' => '1234567890',
            'gst' => 5,
            'shipping_cost' => 349
        ]);

        DB::table('categories')->insert([
            'name' => 'Men'
        ]);

        DB::table('categories')->insert([
            'name' => 'Tshirt',
            'parent_id' => 1
        ]);

        DB::table('categories')->insert([
            'name' => 'Shirt',
            'parent_id' => 1
        ]);

        DB::table('categories')->insert([
            'name' => 'Gadgets',
            'parent_id' => null
        ]);

        DB::table('categories')->insert([
            'name' => 'Mobile',
            'parent_id' => 4
        ]);

        DB::table('categories')->insert([
            'name' => 'Headphone',
            'parent_id' => 4
        ]);
    }
}
