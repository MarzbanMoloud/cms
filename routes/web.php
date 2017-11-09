<?php



Route::get('/' , 'HomeController@index')->name('home');
Route::get('account' , 'AccountController@index')->name('account');
Route::post('register' , 'AccountController@register')->name('register');
Route::post('login' , 'AccountController@login')->name('login');
Route::get('logout','AccountController@destroy')->name('logout');


Route::get('category','AdminController@category')->name('category');
Route::post('addCat','AdminController@addCat')->name('addCat');
Route::get('editCat/{category}', 'AdminController@editCat')->name('editCat');
Route::post('updateCat/{category}', 'AdminController@updateCat')->name('updateCat');
Route::get('deleteCat/{category}','AdminController@deleteCat')->name('deleteCat');


Route::get('post', 'AdminController@post')->name('post');
Route::post('addPost', 'AdminController@addPost')->name('addPost');
