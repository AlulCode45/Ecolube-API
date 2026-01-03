<?php

namespace App\Repositories;

use App\Models\BlogPost;

class BlogPostRepository extends BaseRepository
{
    public function __construct(BlogPost $model)
    {
        parent::__construct($model);
    }

    public function getPublished(int $perPage = 15)
    {
        return $this->model->published()
            ->with('author')
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->with('author')->firstOrFail();
    }

    public function getByCategory(string $category, int $perPage = 15)
    {
        return $this->model->published()
            ->byCategory($category)
            ->with('author')
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function search(string $query, int $perPage = 15)
    {
        return $this->model->published()
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('content', 'like', "%{$query}%")
                    ->orWhere('excerpt', 'like', "%{$query}%");
            })
            ->with('author')
            ->latest('published_at')
            ->paginate($perPage);
    }

    public function incrementViews(int $id)
    {
        $post = $this->find($id);
        $post->incrementViews();
        return $post;
    }
}
