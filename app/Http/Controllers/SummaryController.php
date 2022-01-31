<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repos\GalleryRepo;
use App\Services\SummaryService;

class SummaryController extends Controller
{
    protected $galleryRepo;
    protected $summaryService;

    public function __construct(GalleryRepo $galleryRepo, SummaryService $summaryService)
    {
        $this->galleryRepo = $galleryRepo;
        $this->summaryService = $summaryService;
    }

    public function getSummary(User $user): array
    {
        $galleries = $this->galleryRepo->getAllImages($user);
        $imageCollection = $galleries->map->only(['filetype', 'filesize']);

        return $this->summaryService->imageTypeSeparator($imageCollection);
    }
}
