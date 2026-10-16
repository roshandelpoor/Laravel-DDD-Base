<?php

declare(strict_types=1);

namespace App\Contexts\Identity\Domain\Exception;

use App\Contexts\Identity\Domain\ValueObject\Email;
use App\Contexts\Shared\Domain\Exception\DomainException;

final class UserAlreadyExistsException extends DomainException
{
    public function __construct(Email $email)
    {
        parent::__construct(sprintf('A user with email "%s" already exists.', (string) $email));
    }
}
