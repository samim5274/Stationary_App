<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            ['name' => 'Cash', 'description' => 'Cash Payment', 'status' => 1],
            ['name' => 'Credit Card', 'description' => 'Pay via credit/debit card', 'status' => 1],
            ['name' => 'Bkash', 'description' => 'Mobile banking payment', 'status' => 1],
            ['name' => 'Nagad', 'description' => 'Mobile banking payment', 'status' => 1],
            ['name' => 'Rocket', 'description' => 'Mobile banking payment', 'status' => 1],
        ];

        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }
    }
}
