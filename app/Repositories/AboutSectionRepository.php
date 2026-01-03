<?php

namespace App\Repositories;

use App\Models\AboutSection;

class AboutSectionRepository extends BaseRepository
{
    public function __construct(AboutSection $model)
    {
        parent::__construct($model);
    }

    public function getActive()
    {
        return $this->model->active()->first();
    }
}
