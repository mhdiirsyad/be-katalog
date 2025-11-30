<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Buku', 'icon' => '📚'],
            ['name' => 'Alat Tulis', 'icon' => '✏️'],
            ['name' => 'Alat Pijat', 'icon' => '💆'],
            ['name' => 'E-book', 'icon' => '📱'],
            ['name' => 'Elektronik', 'icon' => '💻'],
            ['name' => 'Aksesoris', 'icon' => '⌚'],
            ['name' => 'Lainnya', 'icon' => '•••'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}