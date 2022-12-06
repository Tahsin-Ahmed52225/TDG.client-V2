<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::match(['get', 'post'], '/login', 'Auth\LoginController@index')->name('login');
Route::match(['get', 'post'], '/forget_password', 'Auth\LoginController@forget_password')->middleware('guest')->name('forget_password');

//Profile Controll
Route::middleware('auth')->group(function () {
    #######Sorting Project Routes


    ######Profile Routes
    Route::get('/my-profile', 'ProfileController@index')->name("my_profile");
    Route::match(['get', 'post'], '/edit-profile', 'ProfileController@edit')->name('edit_profile');
    Route::match(['get', 'post'], '/change-password', 'ProfileController@changePassword')->name('change_password');
    Route::post('/change-profile-pic', 'ProfileController@changeProfilePic')->name("change_profile_image");


    ######Logout Route
    Route::get('/logout', 'Auth\LoginController@logout')->name("logout");
});

