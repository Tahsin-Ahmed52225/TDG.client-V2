<?php

use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/dashboard','Employee\DashboardController@index')->name('dashboard');

# Task Board

Route::match(['get', 'post'], '/task-board','Employee\TaskBoardController@index')->name('taskboard');
Route::post('/task-change-stage', 'Employee\TaskBoardController@changeStatus')->name("change_task_stage");

