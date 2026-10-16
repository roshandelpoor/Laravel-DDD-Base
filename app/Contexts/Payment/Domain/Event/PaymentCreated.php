<?php

declare(strict_types=1);

namespace App\Contexts\Payment\Domain\Event;

use App\Contexts\Payment\Domain\ValueObject\PaymentId;
use App\Contexts\Shared\Domain\Event\DomainEvent;
use DateTimeImmutable;

final class PaymentCreated implements DomainEvent
{
    public readonly DateTimeImmutable $occurredOn;

    public function __construct(
        public readonly PaymentId $paymentId,
        public readonly float $amount,
        public readonly string $currency,
    ) {
        $this->occurredOn = new DateTimeImmutable;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
