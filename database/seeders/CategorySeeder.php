<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{

    private $categories = [
        [
            'name' => 'Category 1',
        ],
        [
            'name' => 'Category 2',
        ],
        [
            'name' => 'Category 3',
        ],
        [
            'name' => 'Category 4',
        ],
        [
            'name' => 'Category 5',
        ],
    ];

    public function run(): void
    {
        DB::table('categories')->delete();
        DB::statement('ALTER TABLE categories AUTO_INCREMENT = 1');
        foreach ($this->categories as $category) {
            Category::create($category);
        }
    }
}
