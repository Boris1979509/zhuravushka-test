<?php


namespace App\Repositories;

use App\Models\Blog\BlogCategory;
use App\Models\Blog\BlogCategory as Model;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;


class BlogCategoryRepository extends CoreRepository
{

    /**
     * @return mixed|string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function getAllCategory($columns = ['*'])
    {
        $result = $this->startConditions()
            ->select($columns)
            ->with(['posts' => static function ($query) {
                $query->selectRaw('category_id, count(*) as count')
                    ->where('is_published', true)
                    ->groupBy('category_id');
            }])->get();
        return $result;
    }

    /**
     * @return Collection
     */
    public function getForComboBox(): Collection
    {
        $columns = implode(', ', [
            'id',
            'CONCAT (id, ". ", title) AS id_title',
        ]);

        return $this->startConditions()
            ->selectRaw($columns)
            ->toBase()
            ->get();
    }

    /**
     * @param string $slug
     * @return BlogCategory
     */
    public function getCategoryBySlug(string $slug): BlogCategory
    {
        return $this->startConditions()
            ->where('slug', $slug)
            ->firstOrFail();
    }

    /**
     * @return mixed
     */
    public function getWithTrashed()
    {
        return $this->startConditions()
            ->withTrashed()->get();
    }

    /**
     * @param integer $id
     * @return Model
     */
    public function getEdit($id): Model
    {
        return $this->startConditions()
            ->find($id);
    }
    /**
     * @param $id
     * @return mixed
     */
    public function getRestore($id)
    {
        return $this->startConditions()
            ->where('id', $id);
    }
}
