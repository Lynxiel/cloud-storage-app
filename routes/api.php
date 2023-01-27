<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\File;
use App\Models\Folder;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenAuth;

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


   Route::post('/user', [RegisterController::class,'register']);

   Route::middleware(TokenAuth::class)->group(function (){
       Route::get('/user', [UserController::class,'index']);
       Route::resource('/file', FileController::class );
       Route::get('/file/{file}/download', [FileController::class,'download'] );
       Route::get('/folders', [FolderController::class,'index'] );
       Route::get('/folder', [FolderController::class,'show'] );
       Route::get('/folder/{id}', [FolderController::class,'show'] );
       Route::post('/folder', [FolderController::class,'create'] );
       Route::get('size/folder/', [FolderController::class,'size'] );
       Route::get('size/folder/{id}', [FolderController::class,'size'] );

    });


