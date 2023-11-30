<?php

namespace Database\Seeders;

use App\Models\ProductsAttribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productAttributesRecords = [
            [
                'id' => 1,
                'product_id' => 1,
                'size' => 'Small',
                'price' => 30000,
                'stock' => 10,
                'sku' => 'i11-s',
                'status' => 1,
            ],
            [
                'id' => 2,
                'product_id' => 1,
                'size' => 'Medium',
                'price' => 35000,
                'stock' => 10,
                'sku' => 'i11-m',
                'status' => 1,
            ],
            [
                'id' => 3,
                'product_id' => 1,
                'size' => 'Large',
                'price' => 40000,
                'stock' => 10,
                'sku' => 'i11-l',
                'status' => 1,
            ],
        ];
        ProductsAttribute::insert($productAttributesRecords);
    }
}
