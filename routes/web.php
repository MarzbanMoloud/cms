<?php
Route::get('/' , 'HomeController@index')->name('home');
Route::get('aboutUs' , 'HomeController@aboutUs')->name('aboutUs');
Route::get('account' , 'AccountController@index')->name('account');
Route::post('addRole', 'AdminController@addRole')->name('addRole');

Route::match(['get', 'post'],'category/{category?}', ['uses'=>'AdminController@category'])->name('category');
Route::get('contactUs' , 'HomeController@contactUs')->name('contactUs');
Route::post('copyRole' , 'AdminController@copyRole')->name('copyRole');
Route::get('dashboard' , 'AdminController@dashboard')->name('dashboard');
Route::get('deleteCat/{category}','AdminController@deleteCat')->name('deleteCat');
Route::get('deletePage/{page}', 'AdminController@deletePage')->name('deletePage');
Route::get('deletePost/{post}', 'AdminController@deletePost')->name('deletePost');
Route::get('loadingRole' , 'AdminController@loadingRole')->name('loadingRole');
Route::group(['middleware' => 'web'], function () {
    Route::post('login', 'AccountController@login')->name('login');
});
Route::get('logout','AccountController@destroy')->name('logout');
Route::match(['get', 'post'],'page/{page?}',  ['uses' =>  'AdminController@page'])->name('page');
Route::get('pageList', 'AdminController@pageList')->name('pageList');
Route::match(['get', 'post'],'post/{post?}' , ['uses' => 'AdminController@post'])->name('post');
Route::get('postList', 'AdminController@postList')->name('postList');
Route::match(['get', 'post'] , 'profile' , ['uses'=> 'AdminController@profile'])->name('profile');
Route::get('promote' , 'AdminController@promote')->name('promote');
Route::post('register' , 'AccountController@register')->name('register');
Route::get('removeUser/{user}' , 'AdminController@removeUser')->name('removeUser');
Route::post('savePermissions/{role}', 'AdminController@savePermissions')->name('savePermissions');
Route::post('statusUser/{user}' , 'AdminController@statusUser')->name('statusUser');
Route::post('uniqueCode', 'AccountController@uniqueCode')->name('uniqueCode');
Route::match(['get', 'post'], 'user/{user?}', 'AdminController@user')->name('user');
Route::get('userList' , 'AdminController@userList')->name('userList');
Route::get('/{title}' , 'HomeController@showPage')->name('showPage');

