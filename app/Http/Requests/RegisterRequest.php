<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>['required', 'min:2', 'max:40', 'not_regex:/[^(\w)|(\x7F-\xFF)|(\s)]/'],
            'email' => ['required','email:rfc,dns,strict','unique:users,email', 'not_regex:/[^(\w)|(\@)|(\.)|(\-)]/'],
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ], 400));
    }
}
