<?php

declare(strict_types=1);

namespace App\Contexts\Payment\Application\Dto;

final readonly class GetPaymentInput
{
    public function __construct(public string $id) {}
}
