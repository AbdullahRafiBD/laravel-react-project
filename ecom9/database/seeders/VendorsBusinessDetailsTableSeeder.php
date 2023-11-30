<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBusinessDetail;

class VendorsBusinessDetailsTableSeeder extends Seeder
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
            'vendor_id'=>1,
            'shop_name'=>'Jhon Electronic Store',
            'shop_address'=>'sp-1122',
            'shop_city'=>'Dhaka',
            'shop_state'=>'Dhaka',
            'shop_country'=>'Bangladesh',
            'shop_pincode'=>'1212',
            'shop_mobile'=>'01234567890',
            'shop_website'=>'vendor.com',
            'shop_email'=>'vendor@shop.com',
            'address_proof'=>'passport',
            'address_proof_image'=>'test.jpg',
            'business_license_number'=>'123456',
            'gst_number'=>'654321',
            'pan_number'=>'13579',
        ];
        VendorsBusinessDetail::insert($vendorRecords);
    }
}
