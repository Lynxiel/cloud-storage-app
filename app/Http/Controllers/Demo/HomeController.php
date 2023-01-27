<?php

namespace App\Http\Controllers\Demo;


use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = Request::create('/api/file/', 'GET' );
        $response = Route::dispatch($request);
        $response = json_decode($response->getContent(),true);
        $files = File::hydrate($response['files'])->where('folder_id', null);
        $folders = Folder::hydrate($response['folders']);
        $storage_size = $response['size'];
        $size = $files->sum('sizemb');
        return view('welcome', compact('files','folders', 'size', 'storage_size'));
    }




}
