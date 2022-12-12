<?php

use Illuminate\Support\Facades\Route;

Route::get('/view-projects', 'Project\ProjectController@index')->name("view");
Route::get('/add-project', 'Project\ProjectController@create')->name("add");
Route::post('/add-project', 'Project\ProjectController@store')->name("store");
Route::get('/show-project/{project_id}', 'Project\ProjectController@show')->name("show");
Route::post('/delete-project/{project_id}', 'Project\ProjectController@destroy')->name("delete");
// Route::match(['get', 'post'], '/view-projects', 'Project\ProjectController@index')->name('view');
// Route::match(['get', 'post'], '/add-project', 'Project\ProjectController@create')->name('add');

