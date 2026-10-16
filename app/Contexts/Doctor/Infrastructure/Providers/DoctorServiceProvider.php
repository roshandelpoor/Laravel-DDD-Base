<?php

declare(strict_types=1);

namespace App\Contexts\Doctor\Infrastructure\Providers;

use App\Contexts\Doctor\Domain\Repository\DoctorRepository;
use App\Contexts\Doctor\Infrastructure\Persistence\Eloquent\EloquentDoctorRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Registers the Doctor bounded context: port bindings + routes.
 */
final class DoctorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(DoctorRepository::class, EloquentDoctorRepository::class);
    }

    public function boot(): void
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('app/Contexts/Doctor/Interfaces/Http/routes.php'));
    }
}
