<?php

declare(strict_types=1);

namespace App\Contexts\Clinic\Infrastructure\Providers;

use App\Contexts\Clinic\Domain\Repository\ClinicRepository;
use App\Contexts\Clinic\Infrastructure\Persistence\Eloquent\EloquentClinicRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Registers the Clinic bounded context: port bindings + routes.
 */
final class ClinicServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ClinicRepository::class, EloquentClinicRepository::class);
    }

    public function boot(): void
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('app/Contexts/Clinic/Interfaces/Http/routes.php'));
    }
}
