<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GalleryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/{any?}', [UserController::class, 'index'])->name('index');
Route::post('/login', [UserController::class, 'show'])->name('show_user');
Route::post('/register', [UserController::class, 'store'])->name('create_user');
Route::get('/get-data', [GalleryController::class, 'index'])->name('get_data');
Route::get('/get-image', [GalleryController::class, 'show'])->name('get_img');
Route::post('/post-image', [GalleryController::class, 'store'])->name('store_img');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
