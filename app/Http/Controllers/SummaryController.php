<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Support\Facades\Auth;

class SummaryController extends Controller
{
    public function index() :array
    {
        $email = Auth::user()['email'];

        $gallery = Gallery::where('email', $email)->get();
        $data = $gallery->map->only(['email', 'filetype', 'filesize']);

        $return_data = [
            'all_files_num' => 0,
            'all_files_size' => 0,
            'jpeg_num' => 0,
            'jpeg_size' => 0,
            'png_num' => 0,
            'png_size' => 0,
        ];

        for ($i = 0; $i < count($data); $i++) {
            $type = $data[$i]['filetype'];
            $return_data[$type.'_num'] += 1;
            $return_data[$type.'_size'] += $data[$i]['filesize'];
        }

        $return_data['all_files_num'] = $return_data['jpeg_num'] + $return_data['png_num'];
        $return_data['all_files_size'] = $return_data['jpeg_size'] + $return_data['png_size'];

        return $return_data;
    }
}
