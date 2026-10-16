<?php

declare(strict_types=1);

use App\Contexts\Clinic\Interfaces\Http\Controllers\GetClinicController;
use App\Contexts\Clinic\Interfaces\Http\Controllers\RegisterClinicController;
use Illuminate\Support\Facades\Route;

Route::post('clinics', RegisterClinicController::class)->name('clinics.register');
Route::get('clinics/{id}', GetClinicController::class)->name('clinics.show');
