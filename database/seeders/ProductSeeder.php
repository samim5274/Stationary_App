<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\PdrCategory;
use App\Models\PdrSubCategory;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = PdrCategory::all();
        $subcategories = PdrSubCategory::all();

        for ($i = 1; $i <= 50; $i++) {

            $category = $categories->random();
            $subcategory = $subcategories
                ->where('category_id', $category->id)
                ->random();

            Product::create([
                'name'           => "Product {$i}",
                'category_id'    => $category->id,
                'subcategory_id' => $subcategory->id,

                'price'          => rand(50, 500),
                'discount'       => rand(0, 50),
                'cost_price'     => rand(30, 400),

                'stock'          => rand(0, 200),
                'min_stock'      => rand(5, 20),

                'unit'           => 'pcs',
                'size'           => rand(250, 1000) . 'g',

                'availability'   => true,
                'status'         => true,

                'manufactured_at'=> now()->subDays(rand(10, 100)),
                'expired_at'     => now()->addDays(rand(30, 365)),

                'description'    => 'Seeder generated product',
            ]);
        }
    }
}
