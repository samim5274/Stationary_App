<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PdrCategory;

class PdrCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Grocery',
            'Beverage',
            'Dairy',
            'Bakery',
            'Snacks',
        ];

        foreach ($categories as $name) {
            PdrCategory::create([
                'name' => $name,
            ]);
        }
    }
}
