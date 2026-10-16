<?php

declare(strict_types=1);

use App\Contexts\Doctor\Interfaces\Http\Controllers\GetDoctorController;
use App\Contexts\Doctor\Interfaces\Http\Controllers\RegisterDoctorController;
use Illuminate\Support\Facades\Route;

Route::post('doctors', RegisterDoctorController::class)->name('doctors.register');
Route::get('doctors/{id}', GetDoctorController::class)->name('doctors.show');
