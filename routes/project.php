<?php

use Illuminate\Support\Facades\Route;

Route::get('/view-projects', 'Project\ProjectController@index')->name("view");
Route::get('/add-project', 'Project\ProjectController@create')->name("add");
Route::post('/add-project', 'Project\ProjectController@store')->name("store");
Route::post('/edit-project/{id}', 'Project\ProjectController@edit')->name("edit");
Route::post('/update-project-name', 'Project\ProjectController@updateTitle')->name("update_project_name");
Route::post('/update-project-description', 'Project\ProjectController@updateDescription')->name("update_project_description");
Route::post('/update-project-member/{project_id}', 'Project\ProjectController@updateMember')->name("update_member");
Route::get('/project/{project_id}', 'Project\ProjectController@show')->name("show");
Route::post('/delete-project/{project_id}', 'Project\ProjectController@destroy')->name("delete");



Route::get('/project-assign-by-userID', 'Project\SingleProjectController@getProjectAssignDetails')->name("project_assign_by_user");
Route::get('/remove-member/{id}', 'Project\SingleProjectController@removeMember')->name("remove_member");
Route::get('/remove-manager/{id}', 'Project\SingleProjectController@removeManager')->name("remove_manager");
Route::get('/assign-manager/{user_id}/{project_id}', 'Project\SingleProjectController@assignManager')->name("assign_manager");
Route::post('/add-file/{project_id}', 'Project\SingleProjectController@addFile')->name("add_file");
// Route::match(['get', 'post'], '/view-projects', 'Project\ProjectController@index')->name('view');
// Route::match(['get', 'post'], '/add-project', 'Project\ProjectController@create')->name('add');

