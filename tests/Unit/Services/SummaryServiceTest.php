<?php

namespace Tests\Unit\Services;

use App\Services\SummaryService;
use Tests\UnitTestCase;

class SummaryServiceTest extends UnitTestCase
{
    /**
     * @var SummaryService
     */
    protected $summaryService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->summaryService = $this->app->make(SummaryService::class);
    }

    public function test_image_type_separator()
    {
        $imageTypeCollection = collect([
            [
                'filetype' => 'jpeg',
                'filesize' => 11111,
            ],
            [
                'filetype' => 'jpeg',
                'filesize' => 22222,
            ],
            [
                'filetype' => 'png',
                'filesize' => 33333,
            ],
            [
                'filetype' => 'png',
                'filesize' => 44444,
            ],
        ]);
        
        $separatedImageType = $this->summaryService->imageTypeSeparator($imageTypeCollection);

        $this->assertEquals($separatedImageType['all_files_num'], 4);
        $this->assertEquals($separatedImageType['all_files_size'], 111110);
        $this->assertEquals($separatedImageType['all_files_size_mb'], 0.11);
        $this->assertEquals($separatedImageType['jpeg_num'], 2);
        $this->assertEquals($separatedImageType['jpeg_size'], 33333);
        $this->assertEquals($separatedImageType['jpeg_size_mb'], 0.03);
        $this->assertEquals($separatedImageType['png_num'], 2);
        $this->assertEquals($separatedImageType['png_size'], 77777);
        $this->assertEquals($separatedImageType['png_size_mb'], 0.08);
    }
}
