<?php


namespace App\Repositories;

use App\Models\Shop\ProductPropertyValue as Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;


class ProductPropertyValueRepository extends CoreRepository
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
        $properties = $this->startConditions()
            ->select('product_property_id')
            ->where(static function ($query) use ($category) {
                if ($category->children->count()) {
                    return $query->where('category_id', $category->id)
                    ->whereIn('sub_category_id', $category->children);
                }
                $query->where('category_id', $category->parent_id)
                    ->where('sub_category_id', $category->id);

            })->with('property')
            ->groupBy('product_property_id')
            ->distinct()
            ->get();

        $values = $this->startConditions()
            ->select('title', 'id', 'product_property_id', 'slug')
            ->where(static function ($query) use ($category) {
                if ($category->children->count()) {
                    return $query->where('category_id', $category->id)
                        ->whereIn('sub_category_id', $category->children);
                }
                $query->where('category_id', $category->parent_id)
                    ->where('sub_category_id', $category->id);
            })->get();

        $resultData = [];
        foreach ($properties as $key => $itemProp) {
            $arr = [];
            foreach ($values as $k => $itemVal) {
                $resultData[$key] = $itemProp->property;
                if ($itemProp->property->id === $itemVal->product_property_id) {
                    $arr[$itemVal->slug] = $itemVal;
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
