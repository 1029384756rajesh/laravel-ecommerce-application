<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    private $categories = [
        [
            'id' => 1,
            'name' => 'Men',
            'parent_id' => null
        ],
        [
            'id' => 2,
            'name' => 'Tshirt',
            'parent_id' => 1
        ],
        [
            'id' => 3,
            'name' => 'Shirt',
            'parent_id' => 1
        ],
        [
            'id' => 4,
            'name' => 'Gadgets',
            'parent_id' => null
        ],
        [
            'id' => 5,
            'name' => 'Mobile',
            'parent_id' => 4
        ],
        [
            'id' => 6,
            'name' => 'Headphone',
            'parent_id' => 4
        ]
    ];

    public function run()
    {

        DB::table('categories')->insert($this->categories);
    }
}
