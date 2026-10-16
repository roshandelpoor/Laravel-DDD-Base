<?php

declare(strict_types=1);

namespace App\Contexts\Payment\Infrastructure\Gateway;

use App\Contexts\Payment\Domain\Service\PaymentGateway;
use App\Contexts\Payment\Domain\ValueObject\PaymentId;
use Illuminate\Support\Str;

/**
 * Stub adapter for the PaymentGateway port.
 * Replace the binding in PaymentServiceProvider with a real
 * implementation (Zarinpal, Stripe, ...) when going live.
 */
final class FakePaymentGateway implements PaymentGateway
{
    public function charge(PaymentId $paymentId, float $amount, string $currency): string
    {
        return 'fake_'.Str::random(24);
    }
}
