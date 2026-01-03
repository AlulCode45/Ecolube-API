<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

abstract class BaseImageService
{
    protected function uploadImage($image, string $folder)
    {
        if (!$image) {
            return null;
        }

        return $image->store($folder, 'public');
    }

    protected function uploadMultipleImages(array $images, string $folder): array
    {
        $paths = [];

        foreach ($images as $image) {
            $paths[] = $this->uploadImage($image, $folder);
        }

        return $paths;
    }

    protected function deleteImage(?string $path)
    {
        if (!$path) {
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    protected function deleteMultipleImages(array $paths)
    {
        foreach ($paths as $path) {
            $this->deleteImage($path);
        }
    }

    protected function getImageUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }
}
