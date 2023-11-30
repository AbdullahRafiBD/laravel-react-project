<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRecords = [
            'id'=>1,
            'name'=>'jhon',
            'address'=>'cp-112',
            'city'=>'Dhaka',
            'state'=>'Dhaka',
            'country'=>'Bangladesh',
            'pincode'=>'1212',
            'mobile'=>'01965885386',
            'email'=>'vendor@vendor.com',
            'status'=>0,
        ];
        Vendor::insert($vendorRecords);
    }
}
