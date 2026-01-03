<?php

namespace App\Repositories;

use App\Models\Brand;

class BrandRepository extends BaseRepository
{
    public function __construct(Brand $model)
    {
        parent::__construct($model);
    }

    public function getActive()
    {
        return $this->model->active()->ordered()->get();
    }

    public function getByType($type)
    {
        return $this->model->active()->type($type)->ordered()->get();
    }

    public function reorder(array $order)
    {
        foreach ($order as $index => $id) {
            $this->model->where('id', $id)->update(['order' => $index]);
        }
    }

    public function getTypes()
    {
        return $this->model->distinct()->pluck('type')->filter()->values();
    }
}
