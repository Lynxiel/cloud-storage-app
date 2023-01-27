<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Folder extends Model
{
    use HasFactory;

    public function files()
    {
        return $this->hasMany(File::class);
    }

    protected $fillable=['id','user_id','title'];

    public static function init():void{
        $user = auth()->user();
        File::makeDirectory($user->path);
    }

    public function getPathAttribute(){
        return $this->path = auth()->user()->id.'/'.$this->id;
    }

    public function getFullPathAttribute(){
        return $this->path = storage_path().'/'. auth()->user()->id.'/'.$this->id;
    }

}
