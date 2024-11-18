<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\UserController;

Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('user/{id}', [UserController::class, 'getUserById'])->name('user.getUserById');
    Route::get('users', [UserController::class, 'getAll'])->name('user.getAll');

    //post
    Route::get('posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('posts/{id}', [PostController::class, 'show'])->name('posts.show');;
    Route::post('posts', [PostController::class, 'store'])->name('posts.store');;
    Route::patch('posts/{id}', [PostController::class, 'update'])->name('posts.update');;
    Route::delete('posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');;
});
