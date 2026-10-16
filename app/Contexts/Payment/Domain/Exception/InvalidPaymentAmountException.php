<?php

declare(strict_types=1);

namespace App\Contexts\Payment\Domain\Exception;

use App\Contexts\Shared\Domain\Exception\DomainException;

final class InvalidPaymentAmountException extends DomainException
{
    public function __construct(float $amount)
    {
        parent::__construct(sprintf('Payment amount must be greater than zero, got "%s".', $amount));
    }
}
