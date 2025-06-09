<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;

Route::resource('users', UserController::class);

Route::get('/permissions', [PermissionController::class, 'index']);
