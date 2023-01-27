<?php

namespace App\Http\Controllers;



class UserController extends Controller
{
    public function index(){
        $user = auth()->user();
        return response()->json(['user'=>$user]);
    }

}
