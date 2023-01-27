<?php

namespace App\Rules;

use App\Models\File;
use Illuminate\Contracts\Validation\Rule;

class FileExtensionRule implements Rule
{
    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $storage_size = File::where('user_id',auth()->user()->id)->sum('size');
        $file_size = $value->getSize();

        return ($storage_size+$file_size<=config('storage.max_size'));

    }

    /**
     * @return string
     */
    public function message()
    {
        return 'Not enough disk space';
    }
}
