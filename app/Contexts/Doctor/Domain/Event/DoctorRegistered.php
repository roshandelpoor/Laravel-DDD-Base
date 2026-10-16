<?php

declare(strict_types=1);

namespace App\Contexts\Doctor\Domain\Event;

use App\Contexts\Doctor\Domain\ValueObject\DoctorId;
use App\Contexts\Shared\Domain\Event\DomainEvent;
use DateTimeImmutable;

final class DoctorRegistered implements DomainEvent
{
    public readonly DateTimeImmutable $occurredOn;

    public function __construct(
        public readonly DoctorId $doctorId,
        public readonly string $licenseNumber,
    ) {
        $this->occurredOn = new DateTimeImmutable;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
