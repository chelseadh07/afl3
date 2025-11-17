<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed admin dan test user
        $this->call(AdminSeeder::class);
        
        // Seed categories, services, dan products
        Category::factory(5)->create();
        Service::factory(5)->create();
        Product::factory(100)->create();
    }
}
