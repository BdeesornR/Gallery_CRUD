<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SummaryController extends Controller
{
    public function show(Request $request)
    {
        $data = $request->session()->all();
        return [Auth::check(), Auth::user(), Auth::id(), $data];
//        $gallery = Gallery::where('email', $_SESSION)->get();
    }
}
