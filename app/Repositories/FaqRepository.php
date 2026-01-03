<?php

namespace App\Repositories;

use App\Models\Faq;

class FaqRepository extends BaseRepository
{
    public function __construct(Faq $model)
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

    public function reorder(array $order)
    {
        foreach ($order as $index => $id) {
            $this->model->where('id', $id)->update(['order' => $index]);
        }
    }
}
