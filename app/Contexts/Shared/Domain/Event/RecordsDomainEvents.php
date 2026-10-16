<?php

declare(strict_types=1);

namespace App\Contexts\Shared\Domain\Event;

/**
 * Gives an aggregate root the ability to record and release domain events.
 *
 * Use inside aggregate roots: events recorded via record() are pulled by
 * the use case (pullDomainEvents) and dispatched through the
 * DomainEventDispatcher port — after persistence succeeds.
 */
trait RecordsDomainEvents
{
    /** @var list<DomainEvent> */
    private array $domainEvents = [];

    /**
     * @return list<DomainEvent>
     */
    public function pullDomainEvents(): array
    {
        $events = $this->domainEvents;
        $this->domainEvents = [];

        return $events;
    }

    private function record(DomainEvent $event): void
    {
        $this->domainEvents[] = $event;
    }
}
