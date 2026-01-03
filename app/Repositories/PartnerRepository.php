<?php

namespace App\Repositories;

use App\Models\Partner;

class PartnerRepository extends BaseRepository
{
    public function __construct(Partner $model)
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
