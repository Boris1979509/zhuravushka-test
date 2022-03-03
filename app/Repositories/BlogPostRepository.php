<?php

namespace App\Repositories;

use App\Models\Blog\BlogPost as Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BlogPostRepository extends CoreRepository
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
     * @param null $perPage
     * @param null $id
     * @param bool $published
     * @return LengthAwarePaginator
     */
    public function getAllWithPaginate($perPage = null, $id = null, $published = true): LengthAwarePaginator
    {
        $columns = ['*'];
        $result = $this->startConditions()
            ->select($columns)
            ->where(static function ($query) use ($published, $id) {
                if (!is_null($id)) {
                    $query->where('category_id', $id);
                }
                if ($published) {
                    return $query->where('is_published', true);
                }
                return $query;
            })
            ->orderBy('id', 'DESC')
            ->with(['category:title,id']) // LazyLoad
            ->paginate($perPage);
        return $result;
    }

    /**
     * @param int|null $perPage
     * @return mixed
     */
    public function getAllWithTrashed($perPage = null)
    {
        return $this->startConditions()
            ->orderBy('id', 'DESC')
            ->with(['category' => static function ($query) {
                $query->withTrashed();
            }])->withTrashed()
            ->paginate($perPage);
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function getPostBySlug(string $slug)
    {
        return $this->startConditions()
            ->where('slug', $slug)
            ->firstOrFail();
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->startConditions()
            ->count();
    }

    /**
     * @param $id
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
