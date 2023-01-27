<?php
namespace App\Traits;

trait ResponseHandle{
    protected function response($response){
        if ($response->getStatusCode()=='200') {
            return redirect()->back();
        }
        return redirect()->back()->withErrors(['msg' => json_decode($response->getContent())->data->file]);
    }
}
