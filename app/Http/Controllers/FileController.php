<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FileStorage;


class FileController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id=null)
    {
        $user = auth()->user();
        $files = File::where('user_id',$user->id)->orderBy('updated_at','DESC')->get();
        $folders = Folder::where('user_id',$user->id)->get();
        $size =   number_format($files->sum('size')/1024/1024,2) .'MB';
        return response()->json(['files'=>$files,'folders'=>$folders, 'size'=>$size], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $folder_id = $request->only('folder_id')['folder_id']??NULL;
        $file = $request->file('file');
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $file->storeAs(auth()->user()->id.($folder_id?'/'.$folder_id:''), $name.'.'.$extension);

        $file = File::create([
            'title'=> $name,
            'extension'=>$extension,
            'size'=>$request->file('file')->getSize(),
            'folder_id'=>$folder_id,
            'user_id'=>auth()->user()->id,

        ]);

        return response()->json(['file' => $file], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file = File::findOrFail($id);
        return response()->json(['data'=>$file],200);

    }

    /**
     * Download the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $file = File::where('user_id',auth()->user()->id)->findOrFail($id);
        return response()->download($file->path.'/'.$file->name);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $file = File::findOrFail($id);
        $new_title = $request->only('title');
        $old_title = $file->title;
        $file->update($new_title);
        FileStorage::move( $file->path . $old_title.'.'. $file->extension, $file->path.$new_title['title'].'.'.$file->extension);
        return response()->json(['file'=>$file]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = File::findOrFail($id);
        FileStorage::delete($file->path.$file->name);
        $file->delete();
    }
}
