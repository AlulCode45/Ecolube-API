<?php

namespace App\Repositories;

use App\Models\Feature;

class FeatureRepository extends BaseRepository
{
    public function __construct(Feature $model)
    {
        parent::__construct($model);
    }

    public function getActive()
    {
        return $this->model->active()->ordered()->get();
    }

    public function reorder(array $order)
    {
        foreach ($order as $index => $id) {
            $this->model->where('id', $id)->update(['order' => $index]);
        }
    }
}
