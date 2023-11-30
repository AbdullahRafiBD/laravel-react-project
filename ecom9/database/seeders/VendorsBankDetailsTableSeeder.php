<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBankDetail;

class VendorsBankDetailsTableSeeder extends Seeder
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
            'account_holder_name'=>'Jhon cena',
            'bank_name'=>'city Bank LTD',
            'account_number'=>'546132789',
            'bank_ifsc_code'=>'98754621',
        ];
        VendorsBankDetail::insert($vendorRecords);
    }
}
