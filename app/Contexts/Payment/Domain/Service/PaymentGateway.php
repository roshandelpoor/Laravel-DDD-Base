<?php

declare(strict_types=1);

namespace App\Contexts\Payment\Domain\Service;

use App\Contexts\Payment\Domain\ValueObject\PaymentId;

/**
 * Port for an external payment gateway.
 * Swap the bound adapter in PaymentServiceProvider for a real provider.
 */
interface PaymentGateway
{
    /**
     * Charge the given amount; returns the gateway's transaction reference.
     */
    public function charge(PaymentId $paymentId, float $amount, string $currency): string;
}
