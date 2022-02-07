<?php

namespace Tests\Unit\Services;

use App\Services\GalleryService;
use Illuminate\Support\Facades\Storage;
use Tests\UnitTestCase;

class GalleryServiceTest extends UnitTestCase
{
    /**
     * @var GalleryService
     */
    protected $galleryService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->galleryService = $this->app->make(GalleryService::class);
    }

    public function test_get_links()
    {
        $disk = 'tests';
        $folderName = 'storage_for_test';

        Storage::fake($disk);

        $linksCollection = collect([
            ['filepath' => $folderName.'/filepath_1'],
            ['filepath' => $folderName.'/filepath_2'],
            ['filepath' => $folderName.'/filepath_3'],
            ['filepath' => $folderName.'/filepath_4'],
        ]);

        $linksCollection->each(function ($link) use ($disk) {
            Storage::disk($disk)->put($link['filepath'], $this->faker->image);
        });
        
        $returnLinks = $this->galleryService->getLinks($disk, $linksCollection);

        $this->assertCount(4, $returnLinks);

        /**
         * by default Storage::url() with local driver will just prepend '/storage/' in front of the path.
         */
        $this->assertEquals('/storage/'.$linksCollection->shift()['filepath'], array_shift($returnLinks));
        $this->assertEquals('/storage/'.$linksCollection->shift()['filepath'], array_shift($returnLinks));
        $this->assertEquals('/storage/'.$linksCollection->shift()['filepath'], array_shift($returnLinks));
        $this->assertEquals('/storage/'.$linksCollection->shift()['filepath'], array_shift($returnLinks));
    }
}
