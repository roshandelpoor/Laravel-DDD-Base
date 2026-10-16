<?php

declare(strict_types=1);

namespace App\Contexts\Payment\Domain\Exception;

use App\Contexts\Payment\Domain\ValueObject\PaymentId;
use App\Contexts\Shared\Domain\Exception\EntityNotFoundException;

final class PaymentNotFoundException extends EntityNotFoundException
{
    public function __construct(PaymentId|string $id)
    {
        parent::__construct(sprintf('Payment "%s" was not found.', (string) $id));
    }
}
