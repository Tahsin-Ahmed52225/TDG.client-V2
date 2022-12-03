<?php

use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/dashboard', 'Admin\DashboardController@index')->name('dashboard');
