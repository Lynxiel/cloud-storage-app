<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;


class FolderController extends Controller
{
    public function index(){
        $user = auth()->user();
        $folders = Folder::where('user_id',$user->id)->get();
        return response()->json(['folders'=>$folders]);
    }

    public function show($id=null){


        $files = File::where('user_id',auth()->user()->id)
            ->where('folder_id',$id)->get();

        $folder = Folder::where('user_id',auth()->user()->id)
            ->where('id',$id)->first();

        $size =  $files->sum('sizemb');
        return response()->json(['files'=>$files,'folder'=>$folder, 'size'=>$size]);
    }

    public function create(Request $request){
        //TODO: validate title
        $folder = Folder::create([
            'user_id'=>auth()->user()->id,
            'title'=>$request->only('title')['title'],
        ]);
        Storage::makeDirectory($folder->path, 0755, true, true);

        return response()->json(['folder'=>$folder]);
    }

    public function size(Request $request, $id=null){
        $user = auth()->user();
        $files = File::where('user_id',$user->id);
        if ($id) $files->where('folder_id',$id);
        return response()->json(['total_weight'=>$files->sum('size')]);
    }

}
