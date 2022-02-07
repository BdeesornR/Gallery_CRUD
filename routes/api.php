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

Route::post('/register', 'UserController@register')->name('register');
Route::post('/login', 'UserController@login')->name('login');
Route::get('/get-user', 'UserController@getUser')->name('getUser');
Route::post('/logout', 'UserController@logout')->name('logout');

Route::middleware('auth:sanctum')->prefix('{user}')->group(function() {
    Route::get('/get-summary', 'SummaryController@getSummary')->name('getSummary');
    Route::get('/get-images', 'GalleryController@getAllImages')->name('getImages');
    Route::get('/update-images/{amount}', 'GalleryController@getRecentImages')->name('updateImages');
    Route::post('/post-images', 'GalleryController@saveImages')->name('postImages');
    Route::post('/remove-image', 'GalleryController@deleteImage')->name('removeImage');
});
