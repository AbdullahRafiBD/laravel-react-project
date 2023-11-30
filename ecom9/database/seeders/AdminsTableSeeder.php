<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRecords = [
            // [
            //     'id'=>1,
            //     'name'=>'super Admin',
            //     'type'=>'superadmin',
            //     'vendor_id'=>0,
            //     'mobile'=>'01965885387',
            //     'email'=>'admin@admin.com',
            //     'password'=>'$2a$12$XeV0Z18rwq4SJQP1utUviOWKVWWlXHaswjJ53cxJva3UZcLy8hiKO',
            //     'image'=>'',
            //     'status'=>1,
            // ],
            [
                'id'=>2,
                'name'=>'jhon',
                'type'=>'vendor',
                'vendor_id'=>1,
                'mobile'=>'01965885386',
                'email'=>'vendor@vendor.com',
                'password'=>'$2a$12$XeV0Z18rwq4SJQP1utUviOWKVWWlXHaswjJ53cxJva3UZcLy8hiKO',
                'image'=>'',
                'status'=>0,
            ],
        ];
        Admin::insert($adminRecords);
    }
}
