<?php

use Illuminate\Support\Facades\Route;


# User roles settings
Route::get('/roles', 'SystemController@role')->name("roles");
Route::get('/role/{id}', 'SystemController@roleShow')->name("role");
Route::post('/add-role', 'SystemController@roleStore')->name("role_add");
Route::post('/edit-role/{id}', 'SystemController@roleEdit')->name("roles_edit");
Route::post('/delete-role/{id}', 'SystemController@roleDelete')->name("roles_delete");



Route::match(['get', 'post'], '/permissions','SystemController@permisson')->name('permissons');
