<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class GalleryService
{
    public function getLinks(Collection $imagesCollection): array
    {
        $returnLinks = [];

        $imagesCollection->each(function ($image) use (&$returnLinks) {
            if (Storage::disk('public')->exists($image['filepath'])) {
                $url = Storage::url($image['filepath']);
                array_push($returnLinks, $url);
            }
        });

        return $returnLinks;
    }
}