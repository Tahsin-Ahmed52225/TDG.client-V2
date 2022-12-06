<?php

use Illuminate\Support\Facades\Route;



Route::match(['get', 'post'], '/dashboard','Admin\DashboardController@index')->name('dashboard');
// Employee Controll
Route::match(['get', 'post'], '/view-member', 'Admin\EmployeeController@index')->name('view_member');
Route::match(['get', 'post'], '/add-member', 'Admin\EmployeeController@create')->name('add_member');
// Project Controll 
Route::match(['get', 'post'], '/view-projects', 'Project\ProjectController@index')->name('view_project');
Route::match(['get', 'post'], '/add-project', 'Project\ProjectController@create')->name('add_project');
