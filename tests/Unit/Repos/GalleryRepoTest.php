<?php

namespace Tests\Unit\Repos;

use App\Models\Gallery;
use App\Models\User;
use App\Repos\GalleryRepo;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\UnitTestCase;

class GalleryRepoTest extends UnitTestCase
{
    /**
     * @var GalleryRepo
     */
    protected $galleryRepo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->galleryRepo = $this->app->make(GalleryRepo::class);
    }

    public function test_get_all_images()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        Gallery::factory()->count(4)->create(['user_id' => $user1->id]);
        Gallery::factory()->create(['user_id' => $user2->id]);

        $imagesCollection = $this->galleryRepo->getAllImages($user1);

        $this->assertCount(4, $imagesCollection);
    }

    public function test_get_all_order_by_created_at()
    {
        $user = User::factory()->create();

        $image1 = Gallery::factory()->create(['user_id' => $user->id, 'created_at' => Carbon::create(2021, 8)]);
        $image2 = Gallery::factory()->create(['user_id' => $user->id, 'created_at' => Carbon::create(2021, 5)]);
        $image3 = Gallery::factory()->create(['user_id' => $user->id, 'created_at' => Carbon::create(2021, 6)]);
        $image4 = Gallery::factory()->create(['user_id' => $user->id, 'created_at' => Carbon::create(2021, 7)]);

        $imagesCollection = $this->galleryRepo->getAllOrderByCreatedAt($user, 'asc');

        $this->assertCount(4, $imagesCollection);
        $this->assertEquals($image2['filepath'], $imagesCollection->shift()->filepath);
        $this->assertEquals($image3['filepath'], $imagesCollection->shift()->filepath);
        $this->assertEquals($image4['filepath'], $imagesCollection->shift()->filepath);
        $this->assertEquals($image1['filepath'], $imagesCollection->shift()->filepath);

        $imagesCollection = $this->galleryRepo->getAllOrderByCreatedAt($user, 'desc');

        $this->assertEquals($image1['filepath'], $imagesCollection->shift()->filepath);
        $this->assertEquals($image4['filepath'], $imagesCollection->shift()->filepath);
        $this->assertEquals($image3['filepath'], $imagesCollection->shift()->filepath);
        $this->assertEquals($image2['filepath'], $imagesCollection->shift()->filepath);
    }

    public function test_get_some_order_by_created_at()
    {
        $user = User::factory()->create();

        $image1 = Gallery::factory()->create(['user_id' => $user->id, 'created_at' => Carbon::create(2021, 8)]);
        $image2 = Gallery::factory()->create(['user_id' => $user->id, 'created_at' => Carbon::create(2021, 5)]);
        $image3 = Gallery::factory()->create(['user_id' => $user->id, 'created_at' => Carbon::create(2021, 6)]);
        $image4 = Gallery::factory()->create(['user_id' => $user->id, 'created_at' => Carbon::create(2021, 7)]);

        $imagesCollection = $this->galleryRepo->getSomeOrderByCreatedAt($user, 'asc', 3);

        $this->assertCount(3, $imagesCollection);
        $this->assertEquals($image2['filepath'], $imagesCollection->shift()->filepath);
        $this->assertEquals($image3['filepath'], $imagesCollection->shift()->filepath);
        $this->assertEquals($image4['filepath'], $imagesCollection->shift()->filepath);

        $imagesCollection = $this->galleryRepo->getSomeOrderByCreatedAt($user, 'desc', 2);

        $this->assertCount(2, $imagesCollection);
        $this->assertEquals($image1['filepath'], $imagesCollection->shift()->filepath);
        $this->assertEquals($image4['filepath'], $imagesCollection->shift()->filepath);
    }

    public function test_save_images()
    {
        $disk = 'tests';
        $directory = 'storage_for_test';

        Storage::fake($disk);

        $user = User::factory()->create();

        $files = [
            UploadedFile::fake()->image('test_1.jpg'),
            UploadedFile::fake()->image('test_2.jpg'),
            UploadedFile::fake()->image('test_3.png'),
            UploadedFile::fake()->image('test_4.png'),
        ];

        $this->galleryRepo->saveImages($user, $disk, $directory, $files);

        $imagesCollection = $user->galleries;
        $filepathArray = [];
        $filetype = [
            'jpeg' => 0,
            'png' => 0
        ];

        $imagesCollection->each(function ($image) use (&$filepathArray, &$filetype) {
            if ($image->filetype === 'jpeg') {
                $filetype['jpeg'] += 1;
            } else if ($image->filetype === 'png') {
                $filetype['png'] += 1;
            } else {
                $this->fail('filetype should only be jpeg or png');
            }

            array_push($filepathArray, $image->filepath);
        });

        $this->assertCount(4, $imagesCollection);
        $this->assertEquals(2, $filetype['jpeg']);
        $this->assertEquals(2, $filetype['png']);

        $files = Storage::disk($disk)->allFiles($directory);

        $this->assertCount(4, $files);
        $this->assertEmpty(array_diff($files, $filepathArray));
    }

    public function test_delete_image()
    {
        $user = User::factory()->create();

        $image1 = Gallery::factory()->create(['user_id' => $user->id]);
        $image2 = Gallery::factory()->create(['user_id' => $user->id]);
        $image3 = Gallery::factory()->create(['user_id' => $user->id]);

        $this->galleryRepo->deleteImage($user, $image1->filepath);

        $imagesCollection = $user->galleries;
        
        $expectedFilepath = [
            $image2->filepath,
            $image3->filepath,
        ];
        $actualFilepath = [];

        $imagesCollection->each(function ($image) use (&$actualFilepath) {
            array_push($actualFilepath, $image->filepath);
        });

        $this->assertCount(2, $imagesCollection);
        $this->assertEmpty(array_diff($expectedFilepath, $actualFilepath));
    }
}
