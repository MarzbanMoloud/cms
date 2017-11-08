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
        $isUser = User::where('email' , \request('email'))
                      ->where('password' , \request('password'))
                      ->first();
        if($isUser != ''){
            auth()->login($isUser);
            return redirect()->home();
        }
        return redirect()->back();
    }


    public function destroy()
    {
        auth()->logout();
        return redirect()->home();
    }
}
