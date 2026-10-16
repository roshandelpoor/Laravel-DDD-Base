<?php

declare(strict_types=1);

namespace App\Contexts\Chat\Domain\Exception;

use App\Contexts\Chat\Domain\ValueObject\MessageId;
use App\Contexts\Shared\Domain\Exception\EntityNotFoundException;

final class MessageNotFoundException extends EntityNotFoundException
{
    public function __construct(MessageId|string $id)
    {
        parent::__construct(sprintf('Message "%s" was not found.', (string) $id));
    }
}
