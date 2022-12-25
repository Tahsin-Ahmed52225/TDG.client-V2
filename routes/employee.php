<?php

use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/dashboard','Employee\DashboardController@index')->name('dashboard');
