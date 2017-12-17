<?php

namespace App\Providers;

use App\Http\Controllers\Traits\Permission;
use App\Page;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    use Permission;
    public function boot()
    {
        Schema::defaultStringLength(191);
        view()->composer('layout.layout', function($view)
        {
            $pages = Page::where('published' , '1')->get();
            \View::share(['pages'=> $pages]);
        });
        view()->composer('layout.adminLayout', function($view)
        {
            $id = Session::get('id');
            $infoProfile = User::where('id', $id)->with('profile') ->first();
            $pIsLogin = Session::get('permissions');
            $dashboard = $pIsLogin['dashboard'];
            $manage_category = $pIsLogin['manage_category'];
            $create_posts = $pIsLogin['create_posts'];
            $create_pages = $pIsLogin['create_pages'];
            $create_user = $pIsLogin['create_user'];
            $promote_user = $pIsLogin['promote_user'];
            $manage_user = $pIsLogin['manage_user'];
            $edit_pages = $pIsLogin['edit_pages'];
            $del_pages = $pIsLogin['del_pages'];
            $edit_posts = $pIsLogin['edit_posts'];
            $del_posts = $pIsLogin['del_posts'];
            \View::share([ 'manage_category' => $manage_category ,
                'create_posts' => $create_posts,
                'manage_user' => $manage_user ,
                'create_pages' => $create_pages ,
                'dashboard' => $dashboard ,
                'create_user' => $create_user ,
                'promote_user' => $promote_user ,
                'edit_pages' => $edit_pages ,
                'del_pages' => $del_pages ,
                'del_posts' => $del_posts ,
                'edit_posts' => $edit_posts ,
                'infoProfile' => $infoProfile]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
