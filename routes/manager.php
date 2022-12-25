<?php

use Illuminate\Support\Facades\Route;


Route::match(['get', 'post'], '/dashboard','Manager\DashboardController@index')->name('dashboard');
