<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PdrCategory;
use App\Models\PdrSubCategory;

class PdrSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $map = [
            'Grocery'  => ['Rice', 'Oil', 'Spices'],
            'Beverage' => ['Soft Drink', 'Juice', 'Energy Drink'],
            'Dairy'    => ['Milk', 'Butter', 'Cheese'],
            'Bakery'   => ['Bread', 'Cake', 'Biscuit'],
            'Snacks'   => ['Chips', 'Chocolate', 'Noodles'],
        ];

        foreach ($map as $categoryName => $subs) {
            $category = PdrCategory::where('name', $categoryName)->first();

            foreach ($subs as $sub) {
                PdrSubCategory::create([
                    'category_id' => $category->id,
                    'name'        => $sub,
                ]);
            }
        }
    }
}
