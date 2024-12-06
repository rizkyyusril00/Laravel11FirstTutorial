<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Web Design',
            'slug' => 'Web-Design',
        ]);
        Category::create([
            'name' => 'UI/UX',
            'slug' => 'ui-ux',
        ]);
        Category::create([
            'name' => 'Database Architecture',
            'slug' => 'database-architecture',
        ]);
        // jika ingin menggunakan factory : 
        // Category::factory(3)->create();
    }
}
