<?php

/** @var Factory $factory */

use App\Models\Blog\BlogPost;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

/*
  |--------------------------------------------------------------------------
  | Model Factories
  |--------------------------------------------------------------------------
  |
  | This directory should contain each of the model factory definitions for
  | your application. Factories provide a convenient way to generate new
  | model instances for testing / seeding your application's database.
  |
 */

$factory->define(BlogPost::class, function (Faker $faker) {
    $title = $faker->sentence(random_int(3, 8), true);
    $content = $faker->realText(random_int(1000, 4000));
    $isPublished = (random_int(1, 5) > 1) ? true : false;
    $createdAt = $faker->dateTimeBetween('-2 month', '-1 days');
    $data = [
        'category_id' => random_int(1, 7),
        'title' => $title,
        'slug' => Str::slug($title),
        'excerpt' => $faker->text(random_int(40, 100)),
        'content' => $content,
        'is_published' => $isPublished,
        'published_at' => $isPublished ? $faker->dateTimeBetween('-2 month', '-1 days') : null,
        'created_at' => $createdAt,
        'updated_at' => $createdAt,
    ];
    return $data;
});
