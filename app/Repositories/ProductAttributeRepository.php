<?php


namespace App\Repositories;

use App\Models\Shop\ProductAttribute as Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;


class ProductAttributeRepository extends CoreRepository
{

    /**
     * @return mixed|string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * @param $category
     * @return mixed
     */
    public function getAttributes($category)
    {
        if ($category->children->count()) return null;
        $properties = $this->startConditions()
            ->select('product_property_id')
            ->where(static function ($query) use ($category) {
                $query->where('category_id', $category->parent_id)
                    ->where('sub_category_id', $category->id);

            })->with('property')
            ->groupBy('product_property_id')
            ->distinct()
            ->get();
        $ids = $properties->map(static function ($item) {
            return $item->property->id;
        });
        $values = $this->startConditions()
            ->select('product_property_value_id')
            ->where(static function ($query) use ($category) {
                $query->where('category_id', $category->parent_id)
                    ->where('sub_category_id', $category->id);

            })
            ->whereIn('product_property_id', $ids)
            ->with('value')
            ->groupBy('product_property_value_id')
            ->distinct()
            ->get();

        $resultData = [];
        foreach ($properties as $key => $itemProp) {
            $arr = [];
            foreach ($values as $k => $itemVal) {
                $resultData[$key] = $itemProp->property;
                if ($itemProp->property->id === $itemVal->value->product_property_id) {
                    $arr[] = $itemVal;
                    $resultData[$key]['values'] = $arr;
                }
            }
        }
        return $resultData;
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->startConditions()
            ->newQuery();
    }

}
