<?php



Route::get('/' , 'HomeController@index')->name('home');
Route::get('account' , 'AccountController@index')->name('account');
Route::post('register' , 'AccountController@register')->name('register');
Route::post('login' , 'AccountController@login')->name('login');
Route::get('logout','AccountController@destroy')->name('logout');
