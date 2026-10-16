<?php

declare(strict_types=1);

use App\Contexts\Payment\Interfaces\Http\Controllers\CreatePaymentController;
use App\Contexts\Payment\Interfaces\Http\Controllers\GetPaymentController;
use Illuminate\Support\Facades\Route;

Route::post('payments', CreatePaymentController::class)->name('payments.create');
Route::get('payments/{id}', GetPaymentController::class)->name('payments.show');
