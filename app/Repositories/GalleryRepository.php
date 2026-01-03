<?php

namespace App\Repositories;

use App\Models\Gallery;

class GalleryRepository extends BaseRepository
{
    public function __construct(Gallery $model)
    {
        parent::__construct($model);
    }

    public function getActive()
    {
        return $this->model->active()->ordered()->get();
    }

    public function getByCategory(string $category)
    {
        return $this->model->active()->byCategory($category)->ordered()->get();
    }

    public function getCategories()
    {
        return $this->model->distinct()->pluck('category')->filter();
    }
}
