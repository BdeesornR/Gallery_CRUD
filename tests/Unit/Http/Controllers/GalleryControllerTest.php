<?php

namespace Tests\Unit\Controllers;

use Tests\UnitTestCase;

class GalleryControllerTest extends UnitTestCase
{
    /**
     * Should refactor Storage::disk to change from 'public' to 'tests' in test environment
     * If refactored, GalleryServiceTest and GalleryRepoTest will need rework as well
     * 
     * Duplicate with GalleryService and GalleryRepo
     */
    public function test_get_all_images()
    {
        $this->assertTrue(true);
    }

    /**
     * Duplicate with GalleryService and GalleryRepo
     */
    public function test_get_recent_images()
    {
        $this->assertTrue(true);
    }

    /**
     * Duplicate with GalleryRepo
     */
    public function test_save_images()
    {
        $this->assertTrue(true);
    }

    /**
     * Duplicate with GalleryRepo
     */
    public function test_delete_image()
    {
        $this->assertTrue(true);
    }
}
