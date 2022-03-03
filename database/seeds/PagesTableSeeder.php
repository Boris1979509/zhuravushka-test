<?php

use Illuminate\Database\Seeder;
use App\Models\Shop\Page;
use Illuminate\Support\Str;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $pages = [
            ['title' => 'Главная', 'page' => 'home'],
            ['title' => 'О компании', 'page' => 'about_company'],
            ['title' => 'Услуги', 'page' => 'services'],
            ['title' => 'Контакты', 'page' => 'contacts'],
            ['title' => 'Поставщики', 'page' => 'providers'],
            ['title' => 'Реквизиты', 'page' => 'requisites'],
            ['title' => 'Акции', 'page' => 'stocks'],
            ['title' => 'Доставка и оплата', 'page' => 'delivery_and_payment', 'parent_id' => 3],
            ['title' => 'Резка металла', 'page' => 'cut_metal', 'parent_id' => 3],
            ['title' => 'Прокат', 'page' => 'rental', 'parent_id' => 3],
            ['title' => 'Возврат денежных средств или обмен товара', 'page' => 'return_money', 'parent_id' => 3],
        ];
        $data = [];
        foreach ($pages as $key => $value) {
            $data[$key]['title'] = $value['title'];
            $data[$key]['slug'] = Str::slug($value['title']);
            $data[$key]['page'] = $value['page'];
            $data[$key]['parent_id'] = (isset($value['parent_id'])) ? $value['parent_id'] : 0;

        }
        app(Page::class)->insert($data);
    }
}
