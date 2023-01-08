<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::match(['get', 'post'], '/login', 'Auth\LoginController@index')->name('login');
Route::match(['get', 'post'], '/forget_password', 'Auth\LoginController@forget_password')->middleware('guest')->name('forget_password');

//Profile Controll
Route::middleware(['auth', 'profile-unlocked'])->group(function () {
    #######Sorting Project Routes

    ######Profile Routes
    Route::get('/my-profile', 'ProfileController@index')->name("my_profile");
    Route::match(['get', 'post'], '/edit-profile', 'ProfileController@edit')->name('edit_profile');
    Route::match(['get', 'post'], '/change-password', 'ProfileController@changePassword')->name('change_password');
    Route::post('/change-profile-pic', 'ProfileController@changeProfilePic')->name("change_profile_image");


    ######Logout Route
    Route::get('/logout', 'Auth\LoginController@logout')->name("logout");
});

Route::middleware(['auth','web','has-permisson','profile-unlocked'])->group(function () {
    // Employee Controll
        Route::match(['get', 'post'], '/view-member/{stage?}', 'EmployeeController@index')->name('view_member');
        Route::match(['get', 'post'], '/add-member', 'EmployeeController@create')->name('add_member');
        Route::get('/delete-member', 'EmployeeController@destroy')->name("deleteMember");
        Route::get('/update-member', 'EmployeeController@update')->name("updateMember");
        Route::post('/employee-login', 'EmployeeController@employeeLogin')->name("employee_login");
});


