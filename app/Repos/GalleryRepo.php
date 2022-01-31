<?php

namespace App\Repos;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class GalleryRepo
{
    protected $gallery;

    public function __construct(Gallery $gallery)
    {
        $this->gallery = $gallery;
    }

    public function getAllImages(User $user): Collection
    {
        return $user->galleries;
    }

    public function getAllOrderByCreatedAt(User $user, string $order = 'asc'): Collection
    {
        return $user->galleries()->orderBy('created_at', $order)->get();
    }

    public function getSomeOrderByCreatedAt(User $user, string $order = 'asc', int $num): Collection
    {
        return $user->galleries()->orderBy('created_at', $order)->take($num)->get();
    }

    public function saveImages(User $user, string $directory, array $files): void
    {
        foreach ($files as $file) {
            $filetype = explode("/", $file->getClientMimeType());
            $filepath = $file->store($directory, 'public');

            $this->gallery->user_id = $user->id;
            $this->gallery->filepath = $filepath;
            $this->gallery->filetype = end($filetype);
            $this->gallery->filesize = $file->getSize();
    
            $this->gallery->save();
        }
    }

    public function deleteImage(User $user, string $filepath): void
    {
        $image = $user->galleries()->where('filepath', $filepath)->first();
        $image->delete();
    }
}