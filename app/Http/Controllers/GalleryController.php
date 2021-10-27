<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Http\Requests\GalleryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class GalleryController extends Controller
{
    public function index()
    {
        return [[$_SESSION], [$_COOKIE]];
//        $gallery = Gallery::where('email', $_SESSION)->get();
    }

    public function store(Request $request)
    {
//        GalleryRequest $request
//        $validated = $request->validated();

        return $request->image;

//        $extension = $validated['image']->extension();
//        $validated['image']->storeAs('/public', $validated['name'].".".$extension);
//        $url = Storage::url($validated['name'].".".$extension);
//        $gallery = Gallery::create([
//            'name' => $validated['name'],
//            'url' => $url,
//        ]);
//        Session::flash('success', 'Success !!');
    }

    public function show()
    {

    }
}
