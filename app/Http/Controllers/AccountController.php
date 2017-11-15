<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    //Show login and register form
    public function index()
    {
        return view('login');
    }
    //Register data form
    public function register(Request $request)
    {
        $this->validate(request(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|confirmed'
            ]);

        $hashedPassword = Hash::make(request('password'));
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $hashedPassword
        ]);
        auth()->login($user);
        return redirect()->home();
    }
    //Do login
    public function login()
    {
        if (!Auth::attempt(request(['email','password']))) {
            return back();
        }
        return redirect()->home();
    }
    //Log out
    public function destroy()
    {
        auth()->logout();
        return redirect()->home();
    }



}
