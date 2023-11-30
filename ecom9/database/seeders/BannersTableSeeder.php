<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bannerRecords = [
            [
                'id' => 1,
                'image' => 'banner-1.png',
                'link' => 'banner-1',
                'title' => 'banner-1.png',
                'alt' => 'banner-1.png',
                'status' => 1,
            ],

            [
                'id' => 2,
                'image' => 'banner-2.png',
                'link' => 'banner-2',
                'title' => 'banner-2.png',
                'alt' => 'banner-2.png',
                'status' => 1,
            ],

        ];
        Banner::insert($bannerRecords);
    }
}
