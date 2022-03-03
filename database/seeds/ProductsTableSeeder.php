<?php

use Illuminate\Database\Seeder;
use App\Models\Shop\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        factory(Product::class, 20)->create();
    }
}
