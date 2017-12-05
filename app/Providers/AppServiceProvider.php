<?php

namespace App\Providers;

use App\Http\Controllers\Traits\Permission;
use App\Page;
use App\User;
use Illuminate\Support\Facades\Schema;
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
            $infoProfile = User::with(['profile' => function ($query ) {
                $id = \Session::get('id');
                $query->where('user_id', $id);
            }])->first();
            $permission = $this->permissionsLoginUser();
            $manage_category = $permission['role']['manage_category'];
            $create_user = $permission['role']['create_user'];
            $list_user = $permission['role']['list_user'];
            $promote_user = $permission['role']['promote_user'];
            \View::share([ 'manage_category' => $manage_category , 'create_user' => $create_user , 'list_user' => $list_user , 'promote_user' => $promote_user , 'infoProfile' => $infoProfile]);
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
