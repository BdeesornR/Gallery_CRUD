<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GalleryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/get-data', [SummaryController::class, 'show']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/get-user', [UserController::class, 'get_user']);
Route::post('/logout', [UserController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/get-image', [GalleryController::class, 'create']);
Route::middleware('auth:sanctum')->get('/update-image/{num}', [GalleryController::class, 'show']);
Route::middleware('auth:sanctum')->post('/post-image', [GalleryController::class, 'store']);
Route::middleware('auth:sanctum')->post('/remove-image', [GalleryController::class, 'destroy']);
