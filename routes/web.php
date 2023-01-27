<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;
use App\Http\Controllers\Demo\HomeController;
use App\Http\Controllers\Demo\FileController;
use App\Http\Controllers\Demo\FolderController;
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

Route::middleware(Authenticate::class)->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('folder/{id}', [FolderController::class,'index'])->name('folder');
    Route::post('folder', [FolderController::class,'store'])->name('folder.create');
    Route::get('/file/{id}/download', [FileController::class,'download'] )->name('file');

    Route::post('file',[FileController::class,'store'])->name('file.store');
    Route::put('file/{id}',[FileController::class,'update'])->name('file.update');
    Route::get('file/{id}',[FileController::class,'download'])->name('file.download');
    Route::delete('file/{id}',[FileController::class,'destroy'])->name('file.delete');
});
