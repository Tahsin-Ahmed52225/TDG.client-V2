<?php

use Illuminate\Support\Facades\Route;


# User roles settings
Route::get('/roles', 'SystemController@role')->name("roles");
Route::get('/role/{id}', 'SystemController@role')->name("roles_show");
Route::post('/edit-role/{id}', 'SystemController@role')->name("roles_show");
Route::post('/delete-role/{id}', 'SystemController@role')->name("roles_show");



Route::match(['get', 'post'], '/permissions','SystemController@permisson')->name('permissons');
