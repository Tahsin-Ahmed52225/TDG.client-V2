<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('guest')->group(function () {
    Route::match(['get', 'post'], '/login', 'Auth/LoginController@show')->name('login');
    Route::match(['get', 'post'], '/forget_password', 'AuthController@forget_password')->middleware('guest')->name('forget_password');
});

