<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

//model
use App\Models\User;

class GuestController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except(['logout']);
    }

    function Index(){
        return view("Components.UserLogin");
    }
    
    function register(){
        return view("Components.register");
    }
    
    function Login(){
        return view("Components.AdminLogin");
    }

    function postLogin(Request $request)
{
    $user = new User();
    $user->login($request->all());

    if (Auth::check()) {
        $redirect = Auth::user()->User_type == 1 ? '/member' : '/admin';

        return response()->json([
            'status' => 'success',
            'redirect_url' => $redirect
        ]);
    }

    return response()->json([
        'status' => 'error',
        'message' => 'Invalid credentials.'
    ]);
}


public function postRegister(Request $request)
{
    $rules = [
        'first_name' => ['required', 'string', 'min:2'],
        'last_name' => ['required', 'string', 'min:1'],
        'email' => ['required', 'string', 'min:3', 'unique:users,email'],
        'password' => ['required', 'string', 'min:2'],
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 422);
    }

    User::create([
        "User_type" => 1,
        "FirstName" => $request->first_name,
        "MiddleName" => $request->middle_name,
        "LastName" => $request->last_name,
        "Username" => $request->username,
        "email" =>  $request->email,
        "contact_number" => $request->contact_number,
        "password" => Hash::make($request->password)
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Registration successful.'
    ]);
}
    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}