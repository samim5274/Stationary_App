<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Excategory;

class ExcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Writing Instruments',
            'Paper Products',
            'Office Supplies',
            'School Supplies',
            'Art & Craft',
            'Files & Folders',
            'Electronics',
            'Printing & Accessories',
            'Others'
        ];

        foreach ($categories as $cat) {
            Excategory::firstOrCreate([
                'name' => $cat
            ]);
        }
    }
}
