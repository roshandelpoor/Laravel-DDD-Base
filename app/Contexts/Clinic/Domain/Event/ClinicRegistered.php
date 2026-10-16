<?php

declare(strict_types=1);

namespace App\Contexts\Clinic\Domain\Event;

use App\Contexts\Clinic\Domain\ValueObject\ClinicId;
use App\Contexts\Shared\Domain\Event\DomainEvent;
use DateTimeImmutable;

final class ClinicRegistered implements DomainEvent
{
    public readonly DateTimeImmutable $occurredOn;

    public function __construct(
        public readonly ClinicId $clinicId,
        public readonly string $name,
    ) {
        $this->occurredOn = new DateTimeImmutable;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
