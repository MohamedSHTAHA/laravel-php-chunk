<?php

use App\Http\Controllers\ChunkFileController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('file-upload',[ChunkFileController::class,'create']) ;
Route::post('chunk',[ChunkFileController::class,'chunkStore'])->name('chunk.store');
Route::post('upload',[UploadController::class,'upload'])->name('upload');
// Route::post('/upload', 'UploadController@upload');


//Media library routes
Route::get('/medialibrary', [App\Http\Controllers\MediaLibraryController::class, 'mediaLibrary'])->name('media-library');

//FILE UPLOADS CONTROLER
Route::post('medialibrary/upload', [App\Http\Controllers\UploaderController::class, 'upload'])->name('file-upload');
Route::post('medialibrary/delete', [App\Http\Controllers\UploaderController::class, 'delete'])->name('file-delete');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
