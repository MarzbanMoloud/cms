<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function register(Request $request)
    {
        $this->validate(request(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);

        $user=User::create(request(['name','email','password']));
        auth()->login($user);
        return redirect()->home();
    }

    public function login()
    {
        if(!auth()->attempt(request(['email','password'])))
        {
            return back();
        }
        return redirect()->home();
    }


    public function destroy()
    {
        auth()->logout();
        return redirect()->home();
    }
}
