<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StorageSizeRule implements Rule
{
    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value->getClientOriginalExtension() != 'php';

    }

    /**
     * @return string
     */
    public function message()
    {
        return 'The php files not allowed';
    }
}
