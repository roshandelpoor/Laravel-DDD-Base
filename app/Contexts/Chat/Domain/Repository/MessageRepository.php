<?php

declare(strict_types=1);

namespace App\Contexts\Chat\Domain\Repository;

use App\Contexts\Chat\Domain\Entity\Message;
use App\Contexts\Chat\Domain\ValueObject\MessageId;

/**
 * Persistence port for the Message aggregate.
 */
interface MessageRepository
{
    public function findById(MessageId $id): ?Message;

    /**
     * All messages exchanged between two users, oldest first.
     *
     * @return list<Message>
     */
    public function findBetween(string $userAId, string $userBId): array;

    public function save(Message $message): void;
}
