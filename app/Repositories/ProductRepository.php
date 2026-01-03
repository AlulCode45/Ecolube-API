<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function getActive()
    {
        return $this->model->active()->ordered()->get();
    }

    public function getFeatured()
    {
        return $this->model->active()->featured()->ordered()->get();
    }

    public function getByCategory($category)
    {
        return $this->model->active()->category($category)->ordered()->get();
    }

    public function getInStock()
    {
        return $this->model->active()->inStock()->ordered()->get();
    }

    public function search($keyword)
    {
        return $this->model->active()
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('sku', 'like', "%{$keyword}%")
                    ->orWhere('brand', 'like', "%{$keyword}%");
            })
            ->ordered()
            ->get();
    }

    public function reorder(array $order)
    {
        foreach ($order as $index => $id) {
            $this->model->where('id', $id)->update(['order' => $index]);
        }
    }

    public function getCategories()
    {
        return $this->model->distinct()->pluck('category')->filter()->values();
    }
}
