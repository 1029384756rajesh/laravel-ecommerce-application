<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeOption;
use App\Models\ProductVariation;
use App\Models\ProductVariationImage;
use App\Models\ProductVariationOption;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    protected $permissions = [
        [
            'id' => 1,
            'name' => 'Create Brand',
            'label' => 'create_brand'
        ],
        [
            'id' => 2,
            'name' => 'Edit Brand',
            'label' => 'edit_brand'
        ],
        [
            'id' => 3,
            'name' => 'Delete Brand',
            'label' => 'delete_brand'
        ],
        [
            'id' => 4,
            'name' => 'View Brands',
            'label' => 'view_brands'
        ],
        [
            'id' => 5,
            'name' => 'Create Category',
            'label' => 'create_category'
        ],
        [
            'id' => 6,
            'name' => 'Edit Category',
            'label' => 'edit_category'
        ],
        [
            'id' => 7,
            'name' => 'Delete Category',
            'label' => 'delete_category'
        ],
        [
            'id' => 8,
            'name' => 'View Categories',
            'label' => 'view_categories'
        ],
        [
            'id' => 9,
            'name' => 'Create Product',
            'label' => 'create_product'
        ],
        [
            'id' => 10,
            'name' => 'Edit Product',
            'label' => 'edit_product'
        ],
        [
            'id' => 11,
            'name' => 'Delete Product',
            'label' => 'delete_product'
        ],
        [
            'id' => 12,
            'name' => 'View Products',
            'label' => 'view_products'
        ],
        [
            'id' => 13,
            'name' => 'Create Shipping Zone',
            'label' => 'create_shipping_zone'
        ],
        [
            'id' => 14,
            'name' => 'Edit Shipping Zone',
            'label' => 'edit_shipping_zone'
        ],
        [
            'id' => 15,
            'name' => 'Delete Shipping Zone',
            'label' => 'delete_shipping_zone'
        ],
        [
            'id' => 16,
            'name' => 'View Shipping Zones',
            'label' => 'view_shipping_zones'
        ],
        [
            'id' => 17,
            'name' => 'Create Shipping Location',
            'label' => 'create_shipping_location'
        ],
        [
            'id' => 18,
            'name' => 'Edit Shipping Location',
            'label' => 'edit_shipping_location'
        ],
        [
            'id' => 19,
            'name' => 'Delete Shipping Location',
            'label' => 'delete_shipping_location'
        ],
        [
            'id' => 20,
            'name' => 'View Shipping Locations',
            'label' => 'view_shipping_locations'
        ],
        [
            'id' => 21,
            'name' => 'Create Shipping Method',
            'label' => 'create_shipping_method'
        ],
        [
            'id' => 22,
            'name' => 'Edit Shipping Method',
            'label' => 'edit_shipping_method'
        ],
        [
            'id' => 23,
            'name' => 'Delete Shipping Method',
            'label' => 'delete_shipping_method'
        ],
        [
            'id' => 24,
            'name' => 'View Shipping Methods',
            'label' => 'view_shipping_methods'
        ],
        [
            'id' => 25,
            'name' => 'Create Tax Class',
            'label' => 'create_tax_class'
        ],
        [
            'id' => 26,
            'name' => 'Edit Tax Class',
            'label' => 'edit_tax_class'
        ],
        [
            'id' => 27,
            'name' => 'Delete Tax Class',
            'label' => 'delete_tax_class'
        ],
        [
            'id' => 28,
            'name' => 'View Tax Classes',
            'label' => 'view_tax_classes'
        ],
        [
            'id' => 29,
            'name' => 'Create Tax Rate',
            'label' => 'create_tax_rate'
        ],
        [
            'id' => 30,
            'name' => 'Edit Tax Rate',
            'label' => 'edit_tax_rate'
        ],
        [
            'id' => 31,
            'name' => 'Delete Tax Rate',
            'label' => 'delete_tax_rate'
        ],
        [
            'id' => 32,
            'name' => 'View Tax Rates',
            'label' => 'view_tax_rates'
        ],
        [
            'id' => 33,
            'name' => 'Create Order',
            'label' => 'create_order'
        ],
        [
            'id' => 34,
            'name' => 'Edit Order',
            'label' => 'edit_order'
        ],
        [
            'id' => 35,
            'name' => 'Delete Order',
            'label' => 'delete_order'
        ],
        [
            'id' => 36,
            'name' => 'View Orders',
            'label' => 'view_orders'
        ]
    ];


    protected $roles = [
        [
            'id' => 1,
            'name' => 'administrator',
            'label' => 'Administrator'
        ],
        [
            'id' => 2,
            'name' => 'user',
            'label' => 'Users'
        ]
    ];

    protected $user = [
        'id' => 1,
        'name' => 'John Doe',
        'email' => 'john@@gmail.com',
        // 'password' => Hash::make('123456'),
    ];

    private function combination($data, $index = 0, $result = [], &$final_result = [])
    {

        if (count($data) == $index) {

            $final_result[] = $result;

            return;
        }

        $ids = $data[$index];

        foreach ($ids as $id) {

            $this->combination($data, $index + 1, array_merge($result, [$id]), $final_result);
        }
    }

    public function run()
    {
        DB::connection()->disableQueryLog();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');


        DB::transaction(function () {
            // Category::withoutEvents(function () {
            //     Brand::withoutEvents(function () {
            //         for ($i = 0; $i < 10; $i++) {
            //             Category::create([
            //                 'name' => fake()->sentence(1)
            //             ]);

            //             Brand::create([
            //                 'name' => fake()->sentence(1)
            //             ]);
            //         }
            //     });
            // });

            Product::withoutEvents(function () {
                ProductVariation::withoutEvents(function () {
                    ProductAttribute::withoutEvents(function () {
                        ProductAttributeOption::withoutEvents(function () {
                            ProductVariationImage::withoutEvents(function () {
                                ProductVariationOption::withoutEvents(function () {                                    
                                    for ($i = 0; $i < 5000; $i++) {
                                        $product = Product::create([
                                            'title' => fake()->sentence(),
                                            'short_description' => fake()->text(),
                                            'description' => fake()->text(4000),
                                            'is_active' => fake()->boolean(),
                                            'is_featured' => fake()->boolean(),
                                            'is_variant' => true,
                                            'category_id' => fake()->numberBetween(1, 10),
                                            'brand_id' => fake()->numberBetween(1, 10),
                                        ]);

                                        $option_ids = [];

                                        for ($j = 0; $j < 2; $j++) {
                                            $attribute = $product->attributes()->create([
                                                'name' => fake()->sentence(1),
                                                'position' => fake()->randomDigit(),
                                                'type' => 'select'
                                            ]);

                                            $ids = [];

                                            for ($k = 0; $k < 2; $k++) {
                                                $option = $attribute->options()->create([
                                                    'name' => fake()->sentence(1),
                                                    'position' => fake()->randomDigit(),
                                                    'value' => null
                                                ]);

                                                $ids[] = $option->id;
                                            }

                                            $option_ids[] = $ids;
                                        }

                                        $option_combinations = [];

                                        $this->combination($option_ids, 0, [], $option_combinations);

                                        foreach ($option_combinations as $combination_ids) {
                                            $variation = $product->variations()->create([
                                                'regular_price' => fake()->numberBetween(400, 500),
                                                'sale_price' => fake()->numberBetween(300, 400),
                                                'sale_start_at' => null,
                                                'sale_end_at' => null,

                                                'manage_stock' => false,
                                                'stock_quantity' => null,
                                                'stock_threshold' => null,
                                                'allow_backorder' => null,
                                                'stock_status' => 'in_stock',
                                                'sku' => null,
                                                'barcode' => null,

                                                'download_link' => null,
                                                'link_expires_at' => null,
                                                'download_limit' => null,

                                                'length' => fake()->numberBetween(10, 20),
                                                'width' => fake()->numberBetween(10, 20),
                                                'height' => fake()->numberBetween(10, 20),
                                                'weight' => fake()->numberBetween(10, 20),
                                            ]);

                                            $variation->options()->attach($combination_ids);

                                            for ($k = 0; $k < 3; $k++) {
                                                $variation->images()->create([
                                                    'src' => fake()->imageUrl(),
                                                    'position' => fake()->randomDigit()
                                                ]);
                                            }
                                        }

                                        if($i % 500 == 0)
                                        {
                                            $this->command->info('Inserted ' . $i . ' records...');
                                        }
                                    }
                                });
                            });
                        });
                    });
                });
            });

            // Product::withoutEvents(function () {
            //     ProductVariation::withoutEvents(function () {
            //         ProductVariationImage::withoutEvents(function () {
            //             for ($i = 0; $i < 10000; $i++) {
            //                 $product = Product::create([
            //                     'title' => fake()->sentence(),
            //                     'short_description' => fake()->text(),
            //                     'description' => fake()->text(4000),
            //                     'is_active' => fake()->boolean(),
            //                     'is_featured' => fake()->boolean(),
            //                     'is_variant' => true,
            //                     'category_id' => fake()->numberBetween(1, 10),
            //                     'brand_id' => fake()->numberBetween(1, 10),
            //                 ]);


            //                 $variation = $product->variations()->create([
            //                     'regular_price' => fake()->numberBetween(400, 500),
            //                     'sale_price' => fake()->numberBetween(300, 400),
            //                     'sale_start_at' => null,
            //                     'sale_end_at' => null,

            //                     'manage_stock' => false,
            //                     'stock_quantity' => null,
            //                     'stock_threshold' => null,
            //                     'allow_backorder' => null,
            //                     'stock_status' => 'in_stock',
            //                     'sku' => null,
            //                     'barcode' => null,

            //                     'download_link' => null,
            //                     'link_expires_at' => null,
            //                     'download_limit' => null,

            //                     'length' => fake()->numberBetween(10, 20),
            //                     'width' => fake()->numberBetween(10, 20),
            //                     'height' => fake()->numberBetween(10, 20),
            //                     'weight' => fake()->numberBetween(10, 20),
            //                 ]);

            //                 for ($k = 0; $k < 3; $k++) {
            //                     $variation->images()->create([
            //                         'src' => fake()->imageUrl(),
            //                         'position' => fake()->randomDigit()
            //                     ]);
            //                 }

            //                 if ($i % 500 == 0) {
            //                     $this->command->info('Inserted ' . $i . ' records...');
            //                 }
            //             }
            //         });
            //     });
            // });
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');



        // for ($i = 0; $i < 500; $i++) {
        //     $product = Product::create([
        //         'title' => fake()->sentence(),
        //         'short_description' => fake()->text(),
        //         'description' => fake()->text(4000),
        //         'is_active' => fake()->boolean(),
        //         'is_featured' => fake()->boolean(),
        //         'is_variant' => true,
        //         'category_id' => fake()->numberBetween(1, 10),
        //         'brand_id' => fake()->numberBetween(1, 10),
        //     ]);

        //     $option_ids = [];

        //     for ($j = 0; $j < 2; $j++) {
        //         $attribute = $product->attributes()->create([
        //             'name' => fake()->sentence(1),
        //             'position' => fake()->randomDigit(),
        //             'type' => 'select'
        //         ]);

        //         $ids = [];

        //         for ($k = 0; $k < 2; $k++) {
        //             $option = $attribute->options()->create([
        //                 'name' => fake()->sentence(1),
        //                 'position' => fake()->randomDigit(),
        //                 'value' => null
        //             ]);

        //             $ids[] = $option->id;
        //         }

        //         $option_ids[] = $ids;
        //     }

        //     $option_combinations = [];

        //     $this->combination($option_ids, 0, [], $option_combinations);

        //     foreach ($option_combinations as $combination_ids) {
        //         $variation = $product->variations()->create([
        //             'regular_price' => fake()->numberBetween(400, 500),
        //             'sale_price' => fake()->numberBetween(300, 400),
        //             'sale_start_at' => null,
        //             'sale_end_at' => null,

        //             'manage_stock' => false,
        //             'stock_quantity' => null,
        //             'stock_threshold' => null,
        //             'allow_backorder' => null,
        //             'stock_status' => 'in_stock',
        //             'sku' => null,
        //             'barcode' => null,

        //             'download_link' => null,
        //             'link_expires_at' => null,
        //             'download_limit' => null,

        //             'length' => fake()->numberBetween(10, 20),
        //             'width' => fake()->numberBetween(10, 20),
        //             'height' => fake()->numberBetween(10, 20),
        //             'weight' => fake()->numberBetween(10, 20),
        //         ]);

        //         $variation->options()->attach($combination_ids);

        //         for ($k = 0; $k < 3; $k++) {
        //             $variation->images()->create([
        //                 'src' => fake()->imageUrl(),
        //                 'position' => fake()->randomDigit()
        //             ]);
        //         }
        //     }
        // }

        // for($i = 0; $i < 1000; $i++)
        // {
        //     $product = Product::create([
        //         'title' => fake()->sentence(),
        //         'short_description' => fake()->text(),
        //         'description' => fake()->text(4000),
        //         'is_active' => fake()->boolean(),
        //         'is_featured' => fake()->boolean(),
        //         'is_variant' => false,
        //         'category_id' => fake()->numberBetween(1, 10),
        //         'brand_id' => fake()->numberBetween(1, 10),
        //     ]);

        //     $variation = $product->variations()->create([
        //         'regular_price' => fake()->numberBetween(400, 500),
        //         'sale_price' => fake()->numberBetween(300, 400),
        //         'sale_start_at' => null,
        //         'sale_end_at' => null,

        //         'manage_stock' => false,
        //         'stock_quantity' => null,
        //         'stock_threshold' => null,
        //         'allow_backorder' => null,
        //         'stock_status' => 'in_stock',
        //         'sku' => null,
        //         'barcode' => null,

        //         'download_link' => null, 
        //         'link_expires_at' => null, 
        //         'download_limit' => null, 

        //         'length' => fake()->numberBetween(10, 20),
        //         'width' => fake()->numberBetween(10, 20),
        //         'height' => fake()->numberBetween(10, 20),
        //         'weight' => fake()->numberBetween(10, 20),
        //     ]);

        //     for($k = 0; $k < 3; $k++)
        //     {
        //         $variation->images()->create([
        //             'src' => fake()->imageUrl(),
        //             'position' => fake()->randomDigit()
        //         ]);
        //     }
        // }

        // DB::table('roles')->insert($this->roles);

        // DB::table('permissions')->insert($this->permissions);

        // DB::table('users')->insert($this->user);

        // for($i = 1; $i <= 36; $i++) {

        //     DB::table('role_permissions')->insert([
        //         'role_id' => 1,
        //         'permission_id' => $i
        //     ]);
        // }
    }
}
