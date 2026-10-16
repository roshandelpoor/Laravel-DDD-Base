<?php

declare(strict_types=1);

namespace App\Contexts\Identity\Domain\Event;

use App\Contexts\Identity\Domain\ValueObject\Email;
use App\Contexts\Identity\Domain\ValueObject\UserId;
use App\Contexts\Shared\Domain\Event\DomainEvent;
use DateTimeImmutable;

final class UserRegistered implements DomainEvent
{
    public readonly DateTimeImmutable $occurredOn;

    public function __construct(
        public readonly UserId $userId,
        public readonly Email $email,
    ) {
        $this->occurredOn = new DateTimeImmutable;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
