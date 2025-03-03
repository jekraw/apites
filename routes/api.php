<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/get-user', [App\Http\Controllers\UserController::class, 'getUser']);
Route::post('/add-user', [App\Http\Controllers\UserController::class, 'postUser']);
Route::put('/update-user/{id}', [App\Http\Controllers\UserController::class, 'updateUser']);
Route::delete('/delete-user/{id}', [App\Http\Controllers\UserController::class, 'deleteUser']);
Route::post('login', [UserController::class, 'login']);