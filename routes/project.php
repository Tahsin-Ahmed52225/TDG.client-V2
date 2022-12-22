<?php

use Illuminate\Support\Facades\Route;

Route::get('/view-projects', 'Project\ProjectController@index')->name("view");
Route::get('/add-project', 'Project\ProjectController@create')->name("add");
Route::post('/add-project', 'Project\ProjectController@store')->name("store");
Route::post('/edit-project/{id}', 'Project\ProjectController@edit')->name("edit");
Route::post('/update-title', 'Project\ProjectController@updateTitle')->name("update_title");
Route::post('/update-description', 'Project\ProjectController@updateDescription')->name("update_project_description");
Route::post('/update-member/{project_id}', 'Project\ProjectController@updateMember')->name("update_member");
Route::get('/project/{project_id}', 'Project\ProjectController@show')->name("show");
Route::post('/delete-project/{project_id}', 'Project\ProjectController@destroy')->name("delete");


Route::get('/get-subtask/{task_id}', 'Project\SingleProjectController@getSubtask')->name("get_subtask");
Route::post('/add-subtask/{project_id}', 'Project\SingleProjectController@createSubtask')->name("create_subtask");
Route::post('/update-subtask/{task_id}', 'Project\SingleProjectController@updateSubtask')->name("update_subtask");
Route::get('/delete-subtask/{task_id}', 'Project\SingleProjectController@deleteSubtask')->name("delete_subtask");
Route::get('/task-complete-toggle', 'Project\SingleProjectController@taskCompleteToggle')->name("task_complete_toggle");



Route::get('/project-assign-by-userID', 'Project\SingleProjectController@getProjectAssignDetails')->name("project_assign_by_user");
Route::get('/remove-member/{id}', 'Project\SingleProjectController@removeMember')->name("remove_member");
Route::get('/remove-manager/{id}', 'Project\SingleProjectController@removeManager')->name("remove_manager");
Route::get('/assign-manager/{user_id}/{project_id}', 'Project\SingleProjectController@assignManager')->name("assign_manager");


Route::post('/add-file/{project_id}', 'Project\SingleProjectController@addFile')->name("add_file");
Route::get('/get-file/{file_id}', 'Project\SingleProjectController@getFile')->name("get_file");
Route::post('/delete-file/{file_id}', 'Project\SingleProjectController@deleteFile')->name("delete_file");
Route::post('/edit-file/{file_id}', 'Project\SingleProjectController@editFile')->name("edit_file");
// Route::match(['get', 'post'], '/view-projects', 'Project\ProjectController@index')->name('view');
// Route::match(['get', 'post'], '/add-project', 'Project\ProjectController@create')->name('add');

