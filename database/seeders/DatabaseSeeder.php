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

        DB::table('categories')->insert([
            'name' => 'Fasion'
        ]);

        DB::table('categories')->insert([
            'name' => 'Men',
            'parent_id' => 1
        ]);

        DB::table('categories')->insert([
            'name' => 'Tshirt',
            'parent_id' => 2
        ]);

        DB::table('categories')->insert([
            'name' => 'Shoes',
            'parent_id' => 2
        ]);

        DB::table('categories')->insert([
            'name' => 'Gadgets'
        ]);

        DB::table('categories')->insert([
            'name' => 'Mobile',
            'parent_id' => 5
        ]);

        DB::table('categories')->insert([
            'name' => 'Headphones',
            'parent_id' => 5
        ]);

        DB::table('products')->insertMany(
            [
                'name' => "Levis Mens Rounded Neck Cotton Tshirt",
                'short_description' => 'This easy to maintain and breathable Tshirt in a cotton rich blend is an ideal choice for warmer days',
                'description' => "This mens Tshirt is designed to give you an effortlessly casual or sporty look for the ultimate fashion statement. The soft fabric keeps you at ease and allows you to go about your day comfortably. The traditional crew neckline and short sleeves make this Tshirt a minimalistic classic.",
                'price' => 500,
                'stock' => 100,
                'image_url' => 'http://localhost:8000/uploads/photos/1/products/tshirt/ts-1.1.png',
                'category_id' => 3
            ],
            [
                'name' => "Levis Mens Regular Fit Tshirt",
                'short_description' => 'This easy to maintain and breathable Tshirt in a cotton rich blend is an ideal choice for warmer days',
                'description' => "This mens Tshirt is designed to give you an effortlessly casual or sporty look for the ultimate fashion statement. The soft fabric keeps you at ease and allows you to go about your day comfortably. The traditional crew neckline and short sleeves make this Tshirt a minimalistic classic.",
                'price' => 400,
                'stock' => 100,
                'image_url' => 'http://localhost:8000/uploads/photos/1/products/tshirt/ts-2.1.png',
                'category_id' => 3
            ],
            [
                'name' => "Levis Mens Slim Fit Tshirt",
                'short_description' => 'This easy to maintain and breathable Tshirt in a cotton rich blend is an ideal choice for warmer days',
                'description' => "This mens Tshirt is designed to give you an effortlessly casual or sporty look for the ultimate fashion statement. The soft fabric keeps you at ease and allows you to go about your day comfortably. The traditional crew neckline and short sleeves make this Tshirt a minimalistic classic.",
                'price' => 650,
                'stock' => 100,
                'image_url' => 'http://localhost:8000/uploads/photos/1/products/tshirt/ts-3.1.png',
                'category_id' => 3
            ],
            [
                'name' => "Roadster Mens Slim Fit Tshirt",
                'short_description' => 'This easy to maintain and breathable Tshirt in a cotton rich blend is an ideal choice for warmer days',
                'description' => "This mens Tshirt is designed to give you an effortlessly casual or sporty look for the ultimate fashion statement. The soft fabric keeps you at ease and allows you to go about your day comfortably. The traditional crew neckline and short sleeves make this Tshirt a minimalistic classic.",
                'price' => 750,
                'stock' => 100,
                'image_url' => 'http://localhost:8000/uploads/photos/1/products/tshirt/ts-4.1.png',
                'category_id' => 3
            ],
            [
                'name' => "Roadster Mens Regular Fit Tshirt",
                'short_description' => 'This easy to maintain and breathable Tshirt in a cotton rich blend is an ideal choice for warmer days',
                'description' => "This mens Tshirt is designed to give you an effortlessly casual or sporty look for the ultimate fashion statement. The soft fabric keeps you at ease and allows you to go about your day comfortably. The traditional crew neckline and short sleeves make this Tshirt a minimalistic classic.",
                'price' => 750,
                'stock' => 100,
                'image_url' => 'http://localhost:8000/uploads/photos/1/products/tshirt/ts-4.1.png',
                'category_id' => 3
            ],
            [
                'name' => "Nike Mens Cotton Fit Tshirt",
                'short_description' => 'This easy to maintain and breathable Tshirt in a cotton rich blend is an ideal choice for warmer days',
                'description' => "This mens Tshirt is designed to give you an effortlessly casual or sporty look for the ultimate fashion statement. The soft fabric keeps you at ease and allows you to go about your day comfortably. The traditional crew neckline and short sleeves make this Tshirt a minimalistic classic.",
                'price' => 850,
                'stock' => 100,
                'image_url' => 'http://localhost:8000/uploads/photos/1/products/tshirt/ts-5.1.png',
                'category_id' => 3
            ],
            [
                'name' => "Nike Mens Rounded Neck Tshirt",
                'short_description' => 'This easy to maintain and breathable Tshirt in a cotton rich blend is an ideal choice for warmer days',
                'description' => "This mens Tshirt is designed to give you an effortlessly casual or sporty look for the ultimate fashion statement. The soft fabric keeps you at ease and allows you to go about your day comfortably. The traditional crew neckline and short sleeves make this Tshirt a minimalistic classic.",
                'price' => 800,
                'stock' => 100,
                'image_url' => 'http://localhost:8000/uploads/photos/1/products/tshirt/ts-6.1.png',
                'category_id' => 3
            ],
            [
                'name' => "Nike Mens Printed Regular Fit Tshirt",
                'short_description' => 'This easy to maintain and breathable Tshirt in a cotton rich blend is an ideal choice for warmer days',
                'description' => "This mens Tshirt is designed to give you an effortlessly casual or sporty look for the ultimate fashion statement. The soft fabric keeps you at ease and allows you to go about your day comfortably. The traditional crew neckline and short sleeves make this Tshirt a minimalistic classic.",
                'price' => 670,
                'stock' => 100,
                'image_url' => 'http://localhost:8000/uploads/photos/1/products/tshirt/ts-7.1.png',
                'category_id' => 3
            ],
            [
                'name' => "Louis Mens Regular Fit Tshirt",
                'short_description' => 'This easy to maintain and breathable Tshirt in a cotton rich blend is an ideal choice for warmer days',
                'description' => "This mens Tshirt is designed to give you an effortlessly casual or sporty look for the ultimate fashion statement. The soft fabric keeps you at ease and allows you to go about your day comfortably. The traditional crew neckline and short sleeves make this Tshirt a minimalistic classic.",
                'price' => 450,
                'stock' => 100,
                'image_url' => 'http://localhost:8000/uploads/photos/1/products/tshirt/ts-8.1.png',
                'category_id' => 3
            ],
            [
                'name' => "Adidas Mens Regular Fit Tshirt",
                'short_description' => 'This easy to maintain and breathable Tshirt in a cotton rich blend is an ideal choice for warmer days',
                'description' => "This mens Tshirt is designed to give you an effortlessly casual or sporty look for the ultimate fashion statement. The soft fabric keeps you at ease and allows you to go about your day comfortably. The traditional crew neckline and short sleeves make this Tshirt a minimalistic classic.",
                'price' => 450,
                'stock' => 100,
                'image_url' => 'http://localhost:8000/uploads/photos/1/products/tshirt/ts-9.1.png',
                'category_id' => 3
            ],
            [
                'name' => "London Hills Mens Regular Fit Tshirt",
                'short_description' => 'This easy to maintain and breathable Tshirt in a cotton rich blend is an ideal choice for warmer days',
                'description' => "This mens Tshirt is designed to give you an effortlessly casual or sporty look for the ultimate fashion statement. The soft fabric keeps you at ease and allows you to go about your day comfortably. The traditional crew neckline and short sleeves make this Tshirt a minimalistic classic.",
                'price' => 650,
                'stock' => 100,
                'image_url' => 'http://localhost:8000/uploads/photos/1/products/tshirt/ts-10.1.png',
                'category_id' => 3
            ]
        );
    }
}
