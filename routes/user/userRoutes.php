<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard/users', [UserController::class, 'index'])->middleware(['auth', 'verified']);
Route::post('/users', [UserController::class, 'create'])->name('users.add')->middleware(['auth', 'verified']);
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update')->middleware(['auth', 'verified']);
Route::delete('/users/{id}', [UserController::class, 'delete'])->name('users.delete')->middleware(['auth', 'verified']);
