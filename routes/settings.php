<?php

use Illuminate\Support\Facades\Route;


# User roles settings
Route::get('/roles', 'SystemController@role')->name("roles");
Route::get('/role/{id}', 'SystemController@roleShow')->name("role");
Route::post('/add-role', 'SystemController@roleStore')->name("role_add");
Route::post('/edit-role/{id}', 'SystemController@roleEdit')->name("roles_edit");
Route::post('/delete-role/{id}', 'SystemController@roleDelete')->name("roles_delete");
# User permissions settings
Route::match(['get', 'post'], '/permissions/{id}','SystemController@permission')->name('permissions');
# System log
Route::get('/log', 'SystemController@log')->name("log");
Route::post('/delete-log/{id}', 'SystemController@logDelete')->name("log_delete");
Route::post('/delete-log-all', 'SystemController@logAllDelete')->name("log_delete_all");
Route::post('/permission-toggle', 'SystemController@permissionToggle')->name("permission_toggle");
