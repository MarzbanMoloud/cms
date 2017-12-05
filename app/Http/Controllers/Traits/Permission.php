<?php

namespace App\Http\Controllers\Traits;
use App\User;

trait Permission
{
    protected function permissionsLoginUser()
    {
        $id = \Session::get('id');
        $permissionsLoginUser = User::where('id' , $id)->with('role')->first();
        return $permissionsLoginUser;
    }

}