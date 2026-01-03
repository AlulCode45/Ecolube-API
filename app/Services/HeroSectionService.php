<?php

namespace App\Services;

use App\Repositories\HeroSectionRepository;
use Illuminate\Support\Facades\Storage;

class HeroSectionService
{
    protected $repository;

    public function __construct(HeroSectionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->all();
    }

    public function getActive()
    {
        return $this->repository->getActive();
    }

    public function getPaginated(int $perPage = 15)
    {
        return $this->repository->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data)
    {
        if (isset($data['image']) && $data['image']) {
            $data['image'] = $this->uploadImage($data['image'], 'hero-sections');
        }

        return $this->repository->create($data);
    }

    public function update(int $id, array $data)
    {
        $heroSection = $this->repository->find($id);

        if (isset($data['image']) && $data['image']) {
            // Delete old image
            if ($heroSection->image) {
                $this->deleteImage($heroSection->image);
            }
            $data['image'] = $this->uploadImage($data['image'], 'hero-sections');
        }

        return $this->repository->update($id, $data);
    }

    public function delete(int $id)
    {
        $heroSection = $this->repository->find($id);

        // Delete image
        if ($heroSection->image) {
            $this->deleteImage($heroSection->image);
        }

        return $this->repository->delete($id);
    }

    public function reorder(array $order)
    {
        return $this->repository->reorder($order);
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
