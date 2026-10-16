<?php

declare(strict_types=1);

namespace App\Contexts\Chat\Domain\Event;

use App\Contexts\Chat\Domain\ValueObject\MessageId;
use App\Contexts\Shared\Domain\Event\DomainEvent;
use DateTimeImmutable;

final class MessageSent implements DomainEvent
{
    public readonly DateTimeImmutable $occurredOn;

    public function __construct(
        public readonly MessageId $messageId,
        public readonly string $senderId,
        public readonly string $recipientId,
    ) {
        $this->occurredOn = new DateTimeImmutable;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
