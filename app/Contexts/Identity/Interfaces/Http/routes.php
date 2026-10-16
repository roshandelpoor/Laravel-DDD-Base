<?php

declare(strict_types=1);

use App\Contexts\Identity\Interfaces\Http\Controllers\GetUserController;
use App\Contexts\Identity\Interfaces\Http\Controllers\RegisterUserController;
use Illuminate\Support\Facades\Route;

Route::post('users', RegisterUserController::class)->name('users.register');
Route::get('users/{id}', GetUserController::class)->name('users.show');
