<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::insert([
            [
                'name'    => 'EasyShopX Ltd',
                'address' => 'House 12, Road 5, Uttara, Dhaka',
                'email'   => 'info@easyshopx.com',
                'phone'   => '01711111111',
                'website' => 'https://easyshopx.com',
                'logo'    => 'companies/logo1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'    => 'Smart Tech Solution',
                'address' => 'Mirpur 10, Dhaka',
                'email'   => 'contact@smarttech.com',
                'phone'   => '01822222222',
                'website' => 'https://smarttech.com',
                'logo'    => 'companies/logo2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'    => 'NextGen IT',
                'address' => 'Dhanmondi, Dhaka',
                'email'   => 'hello@nextgenit.com',
                'phone'   => '01933333333',
                'website' => 'https://nextgenit.com',
                'logo'    => 'companies/logo3.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
