<?php

declare(strict_types=1);

namespace App\Contexts\Chat\Application\Dto;

final readonly class GetConversationInput
{
    public function __construct(
        public string $userAId,
        public string $userBId,
    ) {}
}
