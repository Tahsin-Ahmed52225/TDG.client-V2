<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::match(['get', 'post'], '/login', 'Auth\LoginController@index')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name("logout");
Route::match(['get', 'post'], '/forget_password', 'AuthController@forget_password')->middleware('guest')->name('forget_password');


