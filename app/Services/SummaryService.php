<?php

namespace App\Services;

use Illuminate\Support\Collection;

class SummaryService
{
    public function imageTypeSeparator(Collection $imageCollection): array
    {
        $returnData = [
            'all_files_num' => 0,
            'all_files_size' => 0,
            'all_files_size_mb' => 0,
            'jpeg_num' => 0,
            'jpeg_size' => 0,
            'jpeg_size_mb' => 0,
            'png_num' => 0,
            'png_size' => 0,
            'png_size_mb' => 0,
        ];

        $imageCollection->each(function ($image) use (&$returnData) {
            $fileType = $image['filetype'];
            $returnData[$fileType.'_num'] += 1;
            $returnData[$fileType.'_size'] += $image['filesize'];
        });

        $returnData['all_files_num'] = $returnData['jpeg_num'] + $returnData['png_num'];
        $returnData['all_files_size'] = $returnData['jpeg_size'] + $returnData['png_size'];
        $returnData['all_files_size_mb'] = round($returnData['all_files_size'] / 1000000, 2);
        $returnData['jpeg_size_mb'] = round($returnData['jpeg_size'] / 1000000, 2);
        $returnData['png_size_mb'] = round($returnData['png_size'] / 1000000, 2);

        return $returnData;
    }
}