<?php

namespace App\Http\Controllers\Demo;


use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class FolderController extends Controller
{

    public function index($id)
    {
        $request = Request::create('/api/folder/'.$id, 'GET' );
        $response = Route::dispatch($request);

        $files = json_decode($response->getContent(),true);
        $size = $files['size'];
        $files = File::hydrate($files['files']);

        $current_folder = json_decode($response->getContent(),true)['folder'];
        $current_folder = (new Folder)->fill($current_folder);

        return view('welcome', compact('files', 'current_folder', 'size'));
    }

    public function store(Request $request){
        $request = Request::create('/api/folder', 'POST',$request->only('title') );
        $response = Route::dispatch($request);
        if ($response->getStatusCode()=='200')
            return redirect()->back();
        else echo $response;
    }


}
