<?php


namespace App\Repositories;

use App\Models\Shop\Product as Model;
use App\Models\Shop\ProductCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository extends CoreRepository
{

    /**
     * Возвращает полное имя класса
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function getAllProducts($columns = ['*'])
    {
        return $this->startConditions()
            ->select($columns)
            ->where('price', '<>', 0)
            ->with(['category', 'favorites'])
            ->take(20)->get();
    }

    /**
     * @param $product
     * @return mixed
     */
    public function getProductFirst($product)
    {
        return $this->startConditions()
            ->find($product);
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug)
    {
        $columns = ['*'];
        return $this->startConditions()
            ->select($columns)
            ->with(['category', 'visits', 'attributes' => function($query){
                $query->with(['property','value']);
            }])
            ->where('slug', $slug)
            ->first();
    }

    public function getMoreGoods($product)
    {
        $columns = ['*'];
        return $this->startConditions()
            ->select($columns)
            ->where('id', '!=', $product->id)
            ->where('price', '<>', 0)
            ->where('category_id', $product->category_id)
            ->limit(20)
            ->get();
    }

    /**
     * @param null $perPage
     * @param $array
     * @param array $columns
     * @return mixed
     */
    public function whereIn($array, $perPage = null, $columns = ['*'])
    {
        return $this->startConditions()
            ->where('price', '<>', 0)
            ->whereIn('category_id', $array)
            ->orderBy('price')
            ->paginate($perPage);
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->startConditions()
            ->newQuery();
    }

    /**
     * @param array $array
     * @return Collection
     */
    public function whereInProducts($array): Collection
    {
        return $this->startConditions()
            ->whereIn('id', $array)
            ->get();
    }

    /**
     * @param $sort
     * @param $id
     * @param null $perPage
     * @return LengthAwarePaginator
     */
    public function sortBy($sort, $id, $perPage = null): ?LengthAwarePaginator
    {
        $columns = ['*'];
        switch ($sort) {
            case 'popular':
            case 'price':
                return $this->query()
                    ->select($columns)
                    ->where('price', '<>', 0)
                    ->whereIn('category_id', $id)
                    ->orderBy('price')
                    ->paginate($perPage);
                break;
            case 'name':
                return $this->query()
                    ->select($columns)
                    ->where('price', '<>', 0)
                    ->whereIn('category_id', $id)
                    ->orderBy('title')
                    ->paginate($perPage);
                break;
        }
    }

    /**
     * @param integer $id
     * @param null|integer $perPage
     * @return LengthAwarePaginator
     */
    public function sortByStock($id, $perPage = null): LengthAwarePaginator
    {
        $columns = ['*'];
        return $this->query()
            ->select($columns)
            ->where('price', '<>', 0)
            ->where('quantity', '<>', 0)
            ->whereIn('category_id', $id)
            ->orderBy('price')
            ->paginate($perPage);

    }

    /**
     * @param mixed $category
     * @param integer|array $num
     * @param string $opr
     * @param null|integer $perPage
     * @return LengthAwarePaginator
     */
    public function getPriceSort($category, $num, $opr = null, $perPage = null): LengthAwarePaginator
    {
        $columns = ['*'];

        return $this->query()
            ->select($columns)
            ->where(static function ($query) use ($category) {
                if ($category instanceof ProductCategory) {
                    return $query->where('category_id', $category->id);
                }
                $query->whereIn('category_id', $category);
            })
            ->where(static function ($query) use ($num, $opr) {
                if (is_array($num)) {
                    return $query->whereBetween('price', $num);
                }
                $query->where('price', $opr, $num);
            })
            ->orderBy('price')
            ->paginate($perPage);
    }

    /**
     * @param int $product_id
     * @return mixed
     */
    public function find($product_id)
    {
        return $this->startConditions()
            ->where('id', $product_id)->first();
    }

    /**
     * @param array $productIds
     * @param integer $perPage
     * @return mixed
     */
    public function getFiltersAttributes($productIds, $perPage = null)
    {
        return $this->startConditions()
            ->whereIn('id', $productIds)
            ->orderBy('price')
            ->paginate($perPage);
    }
}
