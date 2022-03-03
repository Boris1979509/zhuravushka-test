<?php

namespace App\Console\Commands;

use App\Models\Shop\ProductCategory;
use App\Models\Shop\ProductProperty;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ParseCatalog extends Command
{
    /**
     * File with category properties
     */
    public const PROPERTY_NAME_FILE = 'properties.json';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'catalog:parse {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Catalog parsing.';

    public const FIELDS_MAP = [
        ['name' => 'ГруппаКатегории'],
        ['name' => 'Категория'],
    ];
    /**
     * Properties names
     */
    public const FIELDS_MAP_PROPERTIES = [
        ['name' => 'Свойство'],
        ['name' => 'СписокВозможныхЗначенийСвойств'],
    ];
    /**
     * Clear tables
     */
    public const TABLES = [
        ['name' => 'product_properties'],
        ['name' => 'product_property_values'],
        ['name' => 'products'],
        ['name' => 'product_attributes'],
    ];

    public function handle(): bool
    {
        DB::table('product_categories')->truncate();
        DB::table('products')->truncate();
        DB::table('product_attributes')->truncate();
        DB::table('product_properties')->truncate();
        DB::table('product_property_values')->truncate();

        $pathPropertiesFile = $this->getProductCategoryProperties(self::PROPERTY_NAME_FILE);
        $propertiesFile = json_decode(file_get_contents($pathPropertiesFile), true);
        $dataPr = [];

        foreach ($propertiesFile as $propertyItemInFile) {
            $dataPr[trim($propertyItemInFile[self::FIELDS_MAP_PROPERTIES[0]['name']])] = [
                'title'      => $name = $propertyItemInFile[self::FIELDS_MAP_PROPERTIES[0]['name']],
                'slug'       => Str::slug($name),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        $productPropertiesTable = DB::table('product_properties')->insert($this->arrayDefaultKey($dataPr));

        $path = $this->getFileName(); // get file path
        $catalog = json_decode(file_get_contents($path), true);

        $data = [];
        foreach ($catalog as $catalogItem) {
            $data[$catalogItem[self::FIELDS_MAP[0]['name']]] = [
                'title'     => $name = trim($catalogItem[self::FIELDS_MAP[0]['name']]),
                'slug'      => Str::slug($name),
                'parent_id' => 0,
            ];
        }

        $productCategoriesTable = DB::table('product_categories')->insert($this->arrayDefaultKey($data));
        if ($productCategoriesTable) {
            $data = [];
            foreach (ProductCategory::all() as $categoryItem) {
                foreach ($catalog as $catalogItem) {
                    if ($categoryItem->title === $catalogItem[self::FIELDS_MAP[0]['name']]) {
                        $data[$catalogItem[self::FIELDS_MAP[1]['name']]] = [
                            'title'     => $name = trim($catalogItem[self::FIELDS_MAP[1]['name']]),
                            'slug'      => Str::slug($name),
                            'parent_id' => $categoryItem->id,
                        ];
                    }
                }
            }

            $subProductCategoriesTable = DB::table('product_categories')->insert($this->arrayDefaultKey($data));
            if ($subProductCategoriesTable) {
                /**
                 * Product property values
                 */
                if ($productPropertiesTable) {
                    $dataVal = [];
                    foreach (ProductProperty::all() as $propertyItem) {
                        foreach ($propertiesFile as $propertyItemInFile) {
                            $title = trim($propertyItemInFile[self::FIELDS_MAP_PROPERTIES[0]['name']]);
                            if ($propertyItem->title === $title) {
                                $category = DB::table('product_categories')->where('title', trim($propertyItemInFile[self::FIELDS_MAP[0]['name']]))->where('parent_id', 0)->first();
                                $subCategory = DB::table('product_categories')->where('title', trim($propertyItemInFile[self::FIELDS_MAP[1]['name']]))->where('parent_id', '<>', 0)->first();
                                foreach (explode('|', $propertyItemInFile[self::FIELDS_MAP_PROPERTIES[1]['name']]) as $itemValue) {
                                    if (!empty($itemValue)) {
                                        $dataVal[] = [
                                            'title'               => $name = trim($itemValue),
                                            'slug'                => Str::slug($name),
                                            'product_property_id' => $propertyItem->id,
                                            'category_id'         => $category->id,
                                            'sub_category_id'     => $subCategory->id,
                                            'created_at'          => Carbon::now(),
                                            'updated_at'          => Carbon::now(),
                                        ];
                                    }
                                }
                            }
                        }
                    }
                    DB::table('product_property_values')->insert($this->arrayDefaultKey($dataVal));
                }
                foreach ($catalog as $key => $catalogItem) {
                    foreach (ProductCategory::all() as $categoryItem) {
                        if ($categoryItem->title === $catalogItem[self::FIELDS_MAP[1]['name']]) {
                            $product_id = DB::table('products')->insertGetId([
                                'title'                     => $name = $catalogItem['Товар'],
                                'slug'                      => Str::slug($name),
                                'code'                      => $code = trim($catalogItem['Код']),
                                'photo'                     => $code,
                                'article'                   => trim($catalogItem['Артикул']),
                                'quantity'                  => $catalogItem['КоличествоОстаток'],
                                'price'                     => $catalogItem['Цена'],
                                'description'               => $catalogItem['Описание'],
                                'category_id'               => $categoryItem->id,
                                'unit_pricing_base_measure' => $catalogItem['ЕдИзмерения'],
                                'created_at'                => Carbon::now(),
                                'updated_at'                => Carbon::now(),
                            ]);
                            if (!empty($attributes = $catalogItem['СвойствоЗначение'])) {
                                $attrData = $this->attr($attributes, $categoryItem->id, $product_id);
                                DB::table('product_attributes')->insert($attrData);
                            }
                        }
                    }
                }
            }
        }

        $this->info('Successfully parsed.');
        return true;
    }

    /**
     * @return string
     */
    private function getFileName(): string
    {
        $file = $this->argument('file');
        return storage_path('app/catalog/' . $file);
    }

    /**
     * @param string $fileName
     * @return string
     */
    private function getProductCategoryProperties($fileName): string
    {
        return storage_path('app/catalog/' . $fileName);
    }

    /**
     * @param $array
     * @return array
     */
    private function arrayDefaultKey($array): array
    {
        $arrayTemp = [];
        $i = 0;
        foreach ($array as $key => $val) {
            $arrayTemp[$i] = $val;
            $i++;
        }
        return $arrayTemp;
    }

    /**
     * @param string $attributes
     * @param int $category_id
     * @param int $product_id
     * @return array
     */
    private function attr($attributes, $category_id, $product_id): array
    {
        $chars = ['{', '}']; // символы для удаления
        $str2 = str_replace($chars, '', $attributes);
        $arr = [];
        foreach (explode(';', $str2) as $item) {
            $parts = explode('|', $item);
            $product_property_id = DB::table('product_properties')->where('title', trim($parts[0]))->first();
            $product_property_value_id = DB::table('product_property_values')->where('title', trim($parts[1]))->first();
            $category = DB::table('product_categories')->where('id', $category_id)->where('parent_id', '<>', 0)->first();
            if ($product_property_value_id && $product_property_id) {
                $arr[] = [
                    'product_property_id'       => $product_property_id->id,
                    'product_property_value_id' => $product_property_value_id->id,
                    'category_id'               => $category->parent_id,
                    'sub_category_id'           => $category_id,
                    'product_id'                => $product_id,
                    'created_at'                => Carbon::now(),
                    'updated_at'                => Carbon::now(),
                ];
            }
        }
        return $arr;
    }
}
