<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/get-user', [App\Http\Controllers\UserController::class, 'getUser']);
Route::post('/add-user', [App\Http\Controllers\UserController::class, 'postUser']);
Route::put('/update-user/{id}', [App\Http\Controllers\UserController::class, 'updateUser']);
Route::delete('/delete-user/{id}', [App\Http\Controllers\UserController::class, 'deleteUser']);
Route::post('login', [UserController::class, 'login']);