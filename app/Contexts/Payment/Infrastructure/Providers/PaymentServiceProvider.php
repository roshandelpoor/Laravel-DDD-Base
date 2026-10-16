<?php

declare(strict_types=1);

namespace App\Contexts\Payment\Infrastructure\Providers;

use App\Contexts\Payment\Domain\Repository\PaymentRepository;
use App\Contexts\Payment\Domain\Service\PaymentGateway;
use App\Contexts\Payment\Infrastructure\Gateway\FakePaymentGateway;
use App\Contexts\Payment\Infrastructure\Persistence\Eloquent\EloquentPaymentRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Registers the Payment bounded context: port bindings + routes.
 */
final class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PaymentRepository::class, EloquentPaymentRepository::class);
        $this->app->bind(PaymentGateway::class, FakePaymentGateway::class);
    }

    public function boot(): void
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('app/Contexts/Payment/Interfaces/Http/routes.php'));
    }
}
