<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IncomeCategory;
use App\Models\IncomeSubCategory;

class IncomeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Printing & Photocopy' => [
                'Black & White Print',
                'Color Print',
                'Photocopy',
                'Scanning',
                'Lamination',
                'Binding',
            ],

            'Stationery Services' => [
                'Document Typing',
                'Online Form Fill-up',
                'Photo Print',
                'Passport Size Photo',
            ],

            'Commission Income' => [
                'Bkash Commission',
                'Nagad Commission',
                'Rocket Commission',
            ],

            'Educational Services' => [
                'Assignment Print',
                'Project Print',
                'Thesis Print',
                'Question Paper Print',
            ],

            'Other Income' => [
                'Delivery Charge',
                'Service Charge',
                'Miscellaneous Income',
            ],
        ];

        foreach ($categories as $categoryName => $subCategories) {

            $category = IncomeCategory::create([
                'name' => $categoryName,
            ]);

            foreach ($subCategories as $subName) {
                IncomeSubCategory::create([
                    'category_id' => $category->id,
                    'name'        => $subName,
                ]);
            }
        }
    }
}
