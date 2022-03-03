<?php

use Illuminate\Database\Seeder;
use App\Models\Blog\BlogPost;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(ProductCategoriesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(BlogCategoriesTableSeeder::class);
        factory(BlogPost::class, 100)->create();
    }
}
