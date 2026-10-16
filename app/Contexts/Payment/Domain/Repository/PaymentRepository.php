<?php

declare(strict_types=1);

namespace App\Contexts\Payment\Domain\Repository;

use App\Contexts\Payment\Domain\Entity\Payment;
use App\Contexts\Payment\Domain\ValueObject\PaymentId;

/**
 * Persistence port for the Payment aggregate.
 */
interface PaymentRepository
{
    public function findById(PaymentId $id): ?Payment;

    public function save(Payment $payment): void;
}
