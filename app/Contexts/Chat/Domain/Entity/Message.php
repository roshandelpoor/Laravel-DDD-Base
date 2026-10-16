<?php

declare(strict_types=1);

namespace App\Contexts\Chat\Domain\Entity;

use App\Contexts\Chat\Domain\Event\MessageSent;
use App\Contexts\Chat\Domain\Exception\EmptyMessageBodyException;
use App\Contexts\Chat\Domain\ValueObject\MessageId;
use App\Contexts\Shared\Domain\Event\RecordsDomainEvents;
use DateTimeImmutable;

/**
 * Message aggregate root.
 *
 * Sender/recipient are stored as plain UUID strings — the Chat context
 * references Identity users by id only, keeping the contexts decoupled.
 */
final class Message
{
    use RecordsDomainEvents;

    private function __construct(
        private MessageId $id,
        private string $senderId,
        private string $recipientId,
        private string $body,
        private DateTimeImmutable $sentAt,
    ) {}

    public static function send(
        MessageId $id,
        string $senderId,
        string $recipientId,
        string $body,
    ): self {
        $body = trim($body);

        if ($body === '') {
            throw new EmptyMessageBodyException;
        }

        $message = new self($id, $senderId, $recipientId, $body, new DateTimeImmutable);
        $message->record(new MessageSent($id, $senderId, $recipientId));

        return $message;
    }

    /**
     * Rebuild a message from persistence without recording domain events.
     */
    public static function reconstitute(
        MessageId $id,
        string $senderId,
        string $recipientId,
        string $body,
        DateTimeImmutable $sentAt,
    ): self {
        return new self($id, $senderId, $recipientId, $body, $sentAt);
    }

    public function id(): MessageId
    {
        return $this->id;
    }

    public function senderId(): string
    {
        return $this->senderId;
    }

    public function recipientId(): string
    {
        return $this->recipientId;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function sentAt(): DateTimeImmutable
    {
        return $this->sentAt;
    }
}
