<?php

use Illuminate\Database\Seeder;
use App\Models\Shop\ProductCategory;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        factory(ProductCategory::class, 10)
            ->create()
            ->each(static function (ProductCategory $category) {
                $counts = [0, random_int(3, 7)];
                $category->children()
                    ->saveMany(factory(ProductCategory::class, $counts[array_rand($counts)])
                        ->create());
            });
    }
}
