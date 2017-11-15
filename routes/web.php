<?php


Route::get('/' , 'HomeController@index')->name('home');
Route::get('/aboutUs' , 'HomeController@aboutUs')->name('aboutUs');
Route::get('account' , 'AccountController@index')->name('account');
Route::post('addCat','AdminController@addCat')->name('addCat');
Route::post('addPage', 'AdminController@addPage')->name('addPage');
Route::post('addPost', 'AdminController@addPost')->name('addPost');
Route::get('category','AdminController@category')->name('category');
Route::get('/contactUs' , 'HomeController@contactUs')->name('contactUs');
Route::get('deleteCat/{category}','AdminController@deleteCat')->name('deleteCat');
Route::get('deletePage/{page}', 'AdminController@deletePage')->name('deletePage');
Route::get('deletePost/{post}', 'AdminController@deletePost')->name('deletePost');
Route::get('editCat/{category}', 'AdminController@editCat')->name('editCat');
Route::get('editPage/{page}', 'AdminController@editPage')->name('editPage');
Route::get('editPost/{post}', 'AdminController@editPost')->name('editPost');
Route::post('login' , 'AccountController@login')->name('login');
Route::get('logout','AccountController@destroy')->name('logout');
Route::get('page', 'AdminController@page')->name('page');
Route::get('pageList', 'AdminController@pageList')->name('pageList');
Route::get('post', 'AdminController@post')->name('post');
Route::get('postList', 'AdminController@postList')->name('postList');
Route::post('register' , 'AccountController@register')->name('register');
Route::post('updateCat/{category}', 'AdminController@updateCat')->name('updateCat');
Route::post('updatePage/{page}', 'AdminController@updatePage')->name('updatePage');
Route::post('updatePost/{post}', 'AdminController@updatePost')->name('updatePost');
Route::get('/{title}' , 'HomeController@showPage')->name('showPage');

