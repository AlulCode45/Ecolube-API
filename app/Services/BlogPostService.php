<?php

namespace App\Services;

use App\Repositories\BlogPostRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPostService
{
    protected $repository;

    public function __construct(BlogPostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(int $perPage = 15)
    {
        return $this->repository->paginate($perPage);
    }

    public function getPublished(int $perPage = 15)
    {
        return $this->repository->getPublished($perPage);
    }

    public function find(int $id)
    {
        return $this->repository->find($id, ['*'], ['author']);
    }

    public function findBySlug(string $slug)
    {
        $post = $this->repository->findBySlug($slug);
        $this->repository->incrementViews($post->id);
        return $post;
    }

    public function getByCategory(string $category, int $perPage = 15)
    {
        return $this->repository->getByCategory($category, $perPage);
    }

    public function search(string $query, int $perPage = 15)
    {
        return $this->repository->search($query, $perPage);
    }

    public function create(array $data)
    {
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Ensure unique slug
        $data['slug'] = $this->ensureUniqueSlug($data['slug']);

        if (isset($data['featured_image']) && $data['featured_image']) {
            $data['featured_image'] = $this->uploadImage($data['featured_image'], 'blog');
        }

        // Set published_at if status is published
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $this->repository->create($data);
    }

    public function update(int $id, array $data)
    {
        $post = $this->repository->find($id);

        // Update slug if title changed
        if (isset($data['title']) && $data['title'] !== $post->title) {
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
            }
            $data['slug'] = $this->ensureUniqueSlug($data['slug'], $id);
        }

        if (isset($data['featured_image']) && $data['featured_image']) {
            if ($post->featured_image) {
                $this->deleteImage($post->featured_image);
            }
            $data['featured_image'] = $this->uploadImage($data['featured_image'], 'blog');
        }

        // Set published_at when changing to published
        if (isset($data['status']) && $data['status'] === 'published' && $post->status !== 'published') {
            $data['published_at'] = now();
        }

        return $this->repository->update($id, $data);
    }

    public function delete(int $id)
    {
        $post = $this->repository->find($id);

        if ($post->featured_image) {
            $this->deleteImage($post->featured_image);
        }

        return $this->repository->delete($id);
    }

    protected function ensureUniqueSlug(string $slug, ?int $excludeId = null)
    {
        $originalSlug = $slug;
        $count = 1;

        while (true) {
            $query = $this->repository->getModel()->where('slug', $slug);

            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }

            if (!$query->exists()) {
                break;
            }

            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    protected function uploadImage($image, string $folder)
    {
        return $image->store($folder, 'public');
    }

    protected function deleteImage(string $path)
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
