<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'Microcontrollers']);
        Category::create(['name' => 'Sensors']);
        Category::create(['name' => 'Development Boards']);
        Category::create(['name' => 'Components']);
    }
}
