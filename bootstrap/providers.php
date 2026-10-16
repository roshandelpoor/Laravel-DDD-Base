<?php

use App\Contexts\Chat\Infrastructure\Providers\ChatServiceProvider;
use App\Contexts\Clinic\Infrastructure\Providers\ClinicServiceProvider;
use App\Contexts\Doctor\Infrastructure\Providers\DoctorServiceProvider;
use App\Contexts\Identity\Infrastructure\Providers\IdentityServiceProvider;
use App\Contexts\Payment\Infrastructure\Providers\PaymentServiceProvider;
use App\Contexts\Shared\Infrastructure\Providers\SharedServiceProvider;
use App\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,
    SharedServiceProvider::class,
    IdentityServiceProvider::class,
    PaymentServiceProvider::class,
    ChatServiceProvider::class,
    DoctorServiceProvider::class,
    ClinicServiceProvider::class,
];
