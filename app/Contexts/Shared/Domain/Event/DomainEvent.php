<?php

declare(strict_types=1);

namespace App\Contexts\Shared\Domain\Event;

/**
 * Contract every domain event must implement.
 */
interface DomainEvent
{
    public function occurredOn(): \DateTimeImmutable;
}
