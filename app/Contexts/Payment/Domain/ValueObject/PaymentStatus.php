<?php

declare(strict_types=1);

namespace App\Contexts\Payment\Domain\ValueObject;

/**
 * Lifecycle states of a Payment aggregate.
 */
enum PaymentStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Failed = 'failed';
}
