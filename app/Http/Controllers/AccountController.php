<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
                'fname' => 'required',
                'lname' => 'required',
                'phone' => 'required',
                'national_code' => 'required|min:10|max:10',
                'username' => 'required',
                'password' => 'required|confirmed'
            ]);

        $hashedPassword = Hash::make(request('password'));
        $user = User::create([
            'role_id' => 2 ,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'phone' => $request->phone,
            'national_code' => $request->national_code,
            'username' => $request->username,
            'password' => $hashedPassword,
            'status' => '0',
        ]);
        auth()->login($user);
        return redirect()->home();
    }

    public function uniqueCode(Request $request)
    {
        $national_code = $request->input('national_code', '');
        $uniqueCode = User::where('national_code',$national_code)->first();
        if ($uniqueCode == null)
        {
            return json_encode(false);
        }
        return json_encode(true);
    }

    //Do login
    public function login(Request $request)
    {
        $this->validate(request(),
            [
                'national_code' => 'required|min:10|max:10',
                'password' => 'required',
            ]);
        if (!Auth::attempt(request(['national_code','password']))) {
            return back();
        }
        $loginUser = User::where('national_code' , \request('national_code'))->first();
        \Session::put('id', $loginUser['id']);
        \Session::put('username', $loginUser['username']);
        \Session::put('islogin', true);
        return redirect()->home();
    }
    //Log out
    public function destroy(Request $request)
    {
        auth()->logout();
        $request->session()->flush();
        return redirect()->home();
    }



}
