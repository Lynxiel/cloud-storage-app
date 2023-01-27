<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'size', 'folder_id', 'extension', 'user_id'];

    public function folder(){
        return $this->belongsTo(Folder::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getPathAttribute(){
        return $this->path = storage_path().'/app/'.auth()->user()->id.'/'.($this->folder_id?$this->folder_id.'/':'');
    }

    public function getNameAttribute(){
        return $this->name = $this->title. '.' .$this->extension;
    }

    public function getSizeMBAttribute(){
        return $this->sizemb = number_format($this->size/1024/1024,2);
    }

}
