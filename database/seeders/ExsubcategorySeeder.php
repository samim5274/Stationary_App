<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Excategory;
use App\Models\Exsubcategory;

class ExsubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Writing Instruments' => [
                'Ball Pen','Gel Pen','Pencil','Marker','Highlighter','Eraser','Sharpener'
            ],
            'Paper Products' => [
                'A4 Paper','A3 Paper','Notebook','Diary','Drawing Paper','Carbon Paper'
            ],
            'Office Supplies' => [
                'Stapler','Staple Pin','Paper Clip','Calculator','Glue','Tape','Punch Machine'
            ],
            'School Supplies' => [
                'School Bag','Geometry Box','Color Pencil','Crayons','Scale','Exam Pad'
            ],
            'Art & Craft' => [
                'Paint Brush','Poster Color','Water Color','Canvas','Craft Paper'
            ],
            'Files & Folders' => [
                'File Folder','Ring File','Document File','Envelope'
            ],
            'Electronics' => [
                'Calculator','Pen Drive','Mouse','Keyboard'
            ],
            'Printing & Accessories' => [
                'Printer Ink','Toner','Lamination Sheet','Binding Comb'
            ],
            'Others' => [
                'Gift Item','Miscellaneous'
            ],
        ];

        foreach ($data as $catName => $subCats) {

            $category = Excategory::firstOrCreate([
                'name' => $catName
            ]);

            foreach ($subCats as $sub) {
                Exsubcategory::firstOrCreate([
                    'category_id' => $category->id,
                    'name'        => $sub
                ]);
            }
        }

    }
}
