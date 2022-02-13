<?php

namespace App\Repos;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class GalleryRepo
{
    public function getAllImages(User $user): Collection
    {
        return $user->galleries;
    }

    public function getAllOrderByCreatedAt(User $user, string $order = 'asc'): Collection
    {
        return $user->galleries()->orderBy('created_at', $order)->get();
    }

    public function getSomeOrderByCreatedAt(User $user, string $order = 'asc', int $amount): Collection
    {
        return $user->galleries()->orderBy('created_at', $order)->take($amount)->get();
    }

    public function saveImage(User $user, string $disk, string $directory, UploadedFile $file): void
    {
        $filetype = explode("/", $file->getClientMimeType());
        $filepath = $file->store($directory, $disk);

        $gallery = new Gallery();
        
        $gallery->user_id = $user->id;
        $gallery->filepath = $filepath;
        $gallery->filetype = end($filetype);
        $gallery->filesize = $file->getSize();

        $gallery->save();
    }

    public function deleteImage(User $user, string $filepath): void
    {
        $image = $user->galleries()->where('filepath', $filepath)->first();
        $image->delete();
    }
}