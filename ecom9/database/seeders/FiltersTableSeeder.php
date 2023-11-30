<?php

namespace Database\Seeders;

use App\Models\ProductsFilter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FiltersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filterRecords = [
            [
                'id' => 1,
                'cat_ids' => '1,2,3,4,5,6,7',
                'filter_name' => 'Fabric',
                'filter_column' => 'Fabric',
                'status' => 1,
            ],

            [
                'id' => 2,
                'cat_ids' => '8,9,10',
                'filter_name' => 'Ram',
                'filter_column' => 'Ram',
                'status' => 1,
            ],
        ];
        ProductsFilter::insert($filterRecords);
    }
}
