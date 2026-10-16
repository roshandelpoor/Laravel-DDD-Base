<?php

declare(strict_types=1);

namespace App\Contexts\Identity\Domain\Exception;

use App\Contexts\Identity\Domain\ValueObject\UserId;
use App\Contexts\Shared\Domain\Exception\EntityNotFoundException;

final class UserNotFoundException extends EntityNotFoundException
{
    public function __construct(UserId|string $id)
    {
        parent::__construct(sprintf('User "%s" was not found.', (string) $id));
    }
}
