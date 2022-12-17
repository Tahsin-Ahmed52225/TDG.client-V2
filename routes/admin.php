<?php

use Illuminate\Support\Facades\Route;



Route::match(['get', 'post'], '/dashboard','Admin\DashboardController@index')->name('dashboard');
// Employee Controll
Route::match(['get', 'post'], '/view-member', 'Admin\EmployeeController@index')->name('view_member');
Route::match(['get', 'post'], '/add-member', 'Admin\EmployeeController@create')->name('add_member');
Route::get('/delete-member', 'Admin\EmployeeController@destroy')->name("deleteMember");
Route::get('/update-member', 'Admin\EmployeeController@update')->name("updateMember");

// Project Controll

