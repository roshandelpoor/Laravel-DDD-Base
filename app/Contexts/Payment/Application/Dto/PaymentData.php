<?php

declare(strict_types=1);

namespace App\Contexts\Payment\Application\Dto;

use App\Contexts\Payment\Domain\Entity\Payment;

final readonly class PaymentData
{
    public function __construct(
        public string $id,
        public float $amount,
        public string $currency,
        public string $status,
        public ?string $gatewayReference,
    ) {}

    public static function fromEntity(Payment $payment): self
    {
        return new self(
            id: (string) $payment->id(),
            amount: $payment->amount(),
            currency: $payment->currency(),
            status: $payment->status()->value,
            gatewayReference: $payment->gatewayReference(),
        );
    }
}
