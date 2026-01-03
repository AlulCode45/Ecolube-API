<?php

namespace App\Repositories;

use App\Models\Promotion;

class PromotionRepository extends BaseRepository
{
    public function __construct(Promotion $model)
    {
        parent::__construct($model);
    }

    public function getActive()
    {
        return $this->model->active()->ordered()->get();
    }

    public function getValid()
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
