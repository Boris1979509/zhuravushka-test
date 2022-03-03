<?php

/** @var Factory $factory */

use App\Models\Shop\ProductCategory;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(ProductCategory::class, static function (Faker $faker) {

    return [
        'title'       => $name = $faker->unique()->words(random_int(1, 3), true),
        'slug'        => Str::slug($name),
        'parent_id'   => 0,
        'description' => $faker->text(random_int(10, 150)),
    ];
});
