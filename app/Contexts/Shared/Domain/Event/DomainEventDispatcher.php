<?php

declare(strict_types=1);

namespace App\Contexts\Shared\Domain\Event;

/**
 * Port for dispatching domain events.
 *
 * The domain does not know about Laravel's event system; it only knows
 * this contract. The adapter lives in Shared\Infrastructure.
 */
interface DomainEventDispatcher
{
    public function dispatch(DomainEvent ...$events): void;
}
