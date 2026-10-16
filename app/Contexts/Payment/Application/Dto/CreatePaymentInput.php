<?php

declare(strict_types=1);

namespace App\Contexts\Payment\Application\Dto;

final readonly class CreatePaymentInput
{
    public function __construct(
        public float $amount,
        public string $currency,
    ) {}
}
