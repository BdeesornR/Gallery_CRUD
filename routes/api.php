<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');
Route::get('/get-user', 'UserController@getUser');
Route::post('/logout', 'UserController@logout');

Route::middleware('auth:sanctum')->prefix('{user}')->group(function() {
    Route::get('/get-data', 'SummaryController@getSummary');
    Route::get('/get-image', 'GalleryController@getAllImages');
    Route::get('/update-image/{amount}', 'GalleryController@getRecentImages');
    Route::post('/post-image', 'GalleryController@saveImages');
    Route::post('/remove-image', 'GalleryController@deleteImage');
});
