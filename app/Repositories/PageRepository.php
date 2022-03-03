<?php


namespace App\Repositories;

use App\Models\Shop\Page as Model;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Collection;


class PageRepository extends CoreRepository
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
     * @return Application[]|Collection|\Illuminate\Database\Eloquent\Model[]|mixed[]
     */
    public function getAllPagesNav($columns = ['*'])
    {
        return $this->startConditions()
            ->select($columns)
            ->where('page', '<>', 'home')
            ->with(['children', 'parent'])
            ->get();
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function getFirstPageBySlug(string $slug)
    {
        return $this->startConditions()
            ->where('slug', $slug)->first();
    }

    /**
     * Load Home page
     * @param string $page
     * @return mixed
     */
    public function getFirstPage(string $page)
    {
        return $this->startConditions()
            ->where('page', $page)->first();
    }
}
