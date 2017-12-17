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
                'fname' => 'required|max:30',
                'lname' => 'required|max:30',
                'phone' => 'required|max:11|min:11',
                'national_code' => 'required|max:10|min:10|unique:users',
                'username' => 'required',
                'password' => 'required|confirmed'
            ]);

        $hashedPassword =  Hash::make(request('password'));
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
                'ncode' => 'required|min:10|max:10',
                'pass' => 'required',
            ]);
        $remember_me = $request->has('remember_me') ? true : false;
        if (!Auth::attempt(['national_code' => $request->input('ncode') ,'password' => $request->input('pass')] , $remember_me)) {
            return back();
        }

        $pLoginUser = User::where('national_code' , \request('ncode'))->with('role')->first();

        //Session for user login
        Session::put('id', $pLoginUser['id']);
        Session::put('username', $pLoginUser['username']);
        Session::put('islogin', true);

        //Session for permission user login
        Session::put('permissions' , [
            'dashboard' => $pLoginUser['role']['dashboard'],

            'edit_posts' => $pLoginUser['role']['edit_posts'],
            'del_posts' => $pLoginUser['role']['del_posts'],
            'create_posts' => $pLoginUser['role']['create_posts'],

            'edit_pages' =>  $pLoginUser['role']['edit_pages'],
            'del_pages' => $pLoginUser['role']['del_pages'],
            'create_pages' => $pLoginUser['role']['create_pages'],

            'manage_category' => $pLoginUser['role']['manage_category'],

            'create_user' => $pLoginUser['role']['create_user'],
            'promote_user' => $pLoginUser['role']['promote_user'],
            'manage_user' => $pLoginUser['role']['manage_user'],
        ]);
        //return Session::all();
        return redirect()->home();
    }
    //Log out
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect()->home();
    }



}
