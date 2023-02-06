<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\ImgPostController;
use App\Http\Controllers\ImgViewController;
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

Route::get('/', function () {
    return view('home');
});

Route::get('/look', function () {
    return view('home');
});

Route::get('/ImgPost/{keyword}/{name}/{path}', [ImgPostController::class, 'index'])->name('ImgPost');

Route::post('/look', [ViewController::class, 'index'])->name('look');
Route::get('/getImg', [ViewController::class, 'fetch'])->name('tweet');


