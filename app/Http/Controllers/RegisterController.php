<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Folder;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegisterController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $credentials = $request->validated();
        $user = User::create([
                       'name'=>$credentials['name'],
                       'email'=>$credentials['email'],
                       'password'=>Hash::make($credentials['password']),
                       'api_token'=> Str::random(60)]);
        Auth::login($user);
        return $this->registered();
//
    }

    protected function registered()
    {
        Folder::init();
        return response()->json(['user' => auth()->user()->toArray()], 201);

    }
}
