<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brandRecords = [
            ['id'=>1,
            'name'=>'Porsche',
            'url'=>'Porsche',
            'brand_image'=>'',
            'description'=>'',
            'meta_title'=>'',
            'meta_description'=>'',
            'meta_keywords'=>'',
            'schema'=>'',
            'status'=>1,],

            ['id'=>2,
            'name'=>'Tesla',
            'url'=>'Tesla',
            'brand_image'=>'',
            'description'=>'',
            'meta_title'=>'',
            'meta_description'=>'',
            'meta_keywords'=>'',
            'schema'=>'',
            'status'=>1,],

            ['id'=>3,
            'name'=>'Kia',
            'url'=>'Kia',
            'brand_image'=>'',
            'description'=>'',
            'meta_title'=>'',
            'meta_description'=>'',
            'meta_keywords'=>'',
            'schema'=>'',
            'status'=>1,],
        ];
        Brand::insert($brandRecords);
    }
}
