<?php

/** @var Factory $factory */

use App\Models\Shop\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Product::class, static function (Faker $faker) {

    return [
        'title'       => $name = $faker->unique()->words(random_int(1, 3), true),
        'code'       => $faker->unique()->word,
        'slug'        => Str::slug($name),
        'price'       => $faker->randomFloat(2, 100, 10000),
        'photo'       => 'images/leader-sales-product-item.jpg',
        'category_id' => random_int(11, 35),
        'description' => $faker->text(random_int(10, 50)),
    ];
});
