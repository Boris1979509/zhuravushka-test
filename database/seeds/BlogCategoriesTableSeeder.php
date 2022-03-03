<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BlogCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {

        $data = [];
        $created = Carbon::now();
        $category = [
            ['title' => 'Своими руками'],
            ['title' => 'Как выбрать'],
            ['title' => 'Уход и благоустройство'],
            ['title' => 'Как использовать'],
            ['title' => 'О строительных материалах'],
            ['title' => 'О компании'],
            ['title' => 'Обзоры'],
        ];

        foreach ($category as $key => $value) {
            $data[$key]['slug'] = Str::slug($value['title']);
            $data[$key]['title'] = $value['title'];
            $data[$key]['created_at'] = $created;
            $data[$key]['updated_at'] = $created;
        }
        DB::table('blog_categories')->insert($data);
    }
}
