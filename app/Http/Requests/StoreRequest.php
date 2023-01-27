<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Rules\FileExtensionRule;
use App\Rules\StorageSizeRule;

class StoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'folder_id'=>'nullable|int',
            'file' => ['required','max:'.config('storage.file_max_size'), new FileExtensionRule, new StorageSizeRule ],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Bad request',
            'data'      => $validator->errors()
        ], 400));
    }
}
