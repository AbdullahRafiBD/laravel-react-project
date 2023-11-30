<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productRecords = [
            [
                'id' => 1,
                'section_id' => 11,
                'category_id' => 9,
                'brand_id' => 2,
                'vendor_id' => 1,
                'admin_id' => 0,
                'admin_type' => 'vendor',
                'product_name' => 'Iphone 11',
                'product_code' => 'i11',
                'product_color' => 'blue',
                'product_price' => 65000,
                'product_old_price' => 80000,
                'product_discount' => 10,
                'product_weight' => '120',
                'product_image' => '',
                'product_video' => '',
                'product_short_description' => '',
                'product_long_description' => '',
                'product_url' => 'iphone11',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
                'schema' => '',
                'is_featured' => 'Yes',
                'status' => 1,
            ],
            [
                'id' => 2,
                'section_id' => 10,
                'category_id' => 4,
                'brand_id' => 3,
                'vendor_id' => 0,
                'admin_id' => 1,
                'admin_type' => 'admin',
                'product_name' => 'solid color tshirt',
                'product_code' => 'scts',
                'product_color' => 'blue',
                'product_price' => 450,
                'product_old_price' => 8000,
                'product_discount' => 10,
                'product_weight' => '200',
                'product_image' => '',
                'product_video' => '',
                'product_short_description' => '',
                'product_long_description' => '',
                'product_url' => 'iphone11',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
                'schema' => '',
                'is_featured' => 'Yes',
                'status' => 1,
            ],
        ];
        Product::insert($productRecords);
    }
}
