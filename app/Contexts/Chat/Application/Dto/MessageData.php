<?php

declare(strict_types=1);

namespace App\Contexts\Chat\Application\Dto;

use App\Contexts\Chat\Domain\Entity\Message;

final readonly class MessageData
{
    public function __construct(
        public string $id,
        public string $senderId,
        public string $recipientId,
        public string $body,
        public string $sentAt,
    ) {}

    public static function fromEntity(Message $message): self
    {
        return new self(
            id: (string) $message->id(),
            senderId: $message->senderId(),
            recipientId: $message->recipientId(),
            body: $message->body(),
            sentAt: $message->sentAt()->format(DATE_ATOM),
        );
    }
}
