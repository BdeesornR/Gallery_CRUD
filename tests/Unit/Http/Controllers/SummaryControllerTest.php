<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\SummaryController;
use App\Models\Gallery;
use App\Models\User;
use Tests\UnitTestCase;

class SummaryControllerTest extends UnitTestCase
{
    /**
     * @var SummaryController
     */
    public function test_get_summary()
    {
        $imagesSize = 0;

        $user = User::factory()->create();
        $imagesCollection = Gallery::factory()->count(4)->create(['user_id' => $user->id]);

        $imagesCollection->each(function ($image) use (&$imagesSize) {
            $imagesSize += $image->filesize;
        });

        $response = $this->actingAs($user)->get(route('getSummary', $user->id));

        $this->assertEquals(4, $response['all_files_num']);
        $this->assertEquals($imagesSize, $response['all_files_size']);
        $this->assertEquals(4, $response['jpeg_num'] + $response['png_num']);
    }
}
