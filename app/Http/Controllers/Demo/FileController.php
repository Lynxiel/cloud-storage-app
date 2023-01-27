<?php

namespace App\Http\Controllers\Demo;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FileStorage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Traits\ResponseHandle;


class FileController extends Controller
{
    use ResponseHandle;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = Request::create('/api/file', 'POST',$request->only('file','folder_id') );
        $response = Route::dispatch($request);
        return $this->response($response);
    }



    /**
     * Download the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $request = Request::create('/api/file/'.$id.'/download', 'GET');
        $response = Route::dispatch($request);
        if ($response->getStatusCode()=='200'){
            return $response;
        }
        return redirect()->back()->withErrors(['msg'=>'Not found']);
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
        $request = Request::create('/api/file/'.$id, 'PUT',
            $request->only('title'), []);
        $response = Route::dispatch($request);
        return $this->response($response);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $request = Request::create('/api/file/'.$id, 'DELETE', [], []);
        $response = Route::dispatch($request);
        return $this->response($response);
    }



}
