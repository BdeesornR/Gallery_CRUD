<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class GalleryService
{
    public function getLinks(string $disk, Collection $imagePathCollection): array
    {
        $returnLinks = [];

        $imagePathCollection->each(function ($image) use ($disk, &$returnLinks) {
            if (Storage::disk($disk)->exists($image['filepath'])) {
                $url = Storage::url($image['filepath']);
                array_push($returnLinks, $url);
            }
        });

        return $returnLinks;
    }
}