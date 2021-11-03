<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleryRequest;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller

{
    public function index() :array
    {
        // specify user's email and directory name
        $email = Auth::user()['email'];

        // get user's images (email & filepath)
        $gallery = Gallery::where('email', $email)->orderBy('created_at', 'asc')->get();
        $images = $gallery->map->only(['email', 'filepath']);

        return $this->returnValue($images);
    }

    public function store(GalleryRequest $request) :void
    {
        // specify reference to uploaded request
        $validated = $request->validated();
        $upload_request = $validated['file'];

        // specify user's email and directory name
        $email = Auth::user()['email'];
        $final_dir = self::dirName($email);

        // store uploaded data to storage and database
        for ($i = 0; $i < count($upload_request); $i++) {

            $type = explode("/", $upload_request[$i]->getClientMimeType());

            // save to storage
            $path = $upload_request[$i]->store($final_dir, 'public');

            // save to database
            $image = new Gallery();

            $image->email = $email;
            $image->filepath = $path;
            $image->filetype = $type[1];
            $image->filesize = $upload_request[$i]->getSize();

            $image->save();
        }
    }

    public function show($num) :array
    {
        // specify user's email and directory name
        $email = Auth::user()['email'];

        // get user's images (email & filepath)
        $gallery = Gallery::where('email', $email)->orderBy('created_at', 'desc')->take($num)->get();
        $images = $gallery->map->only(['email', 'filepath']);

        return $this->returnValue($images);
    }

    public function destroy(Request $request) :void
    {
        $validated = $request->validate([
            'path' => ['required', 'string']
        ]);
        $email = Auth::user()['email'];

        $path = str_replace('/storage/', '', $validated['path']);
        $image = Gallery::where('email', $email)->where('filepath', $path)->first();

        Storage::disk('public')->delete($path);

        $image->delete();
    }

    private function dirName($e) :string
    {
        $email = $e;
        $prep_dir = explode('@', $email);
        $sec_prep_dir = implode('_', $prep_dir);
        $final_prep_dir = explode('.', $sec_prep_dir);
        return implode('_', $final_prep_dir);
    }

    private function returnValue($images) :array
    {
        // retrieve url to images & sent to site
        $return_links = [];

        for ($i = 0; $i < count($images); $i++) {
            if (Storage::disk('public')->exists($images[$i]['filepath'])) {
                $url = Storage::url($images[$i]['filepath']);
                array_push($return_links, ['url' => $url]);
            }
        }

        return $return_links;
    }
}
