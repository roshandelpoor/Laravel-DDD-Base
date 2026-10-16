<?php

declare(strict_types=1);

namespace App\Contexts\Chat\Application\Dto;

final readonly class SendMessageInput
{
    public function __construct(
        public string $senderId,
        public string $recipientId,
        public string $body,
    ) {}
}
