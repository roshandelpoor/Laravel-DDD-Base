<?php

declare(strict_types=1);

namespace App\Contexts\Identity\Domain\Exception;

use App\Contexts\Shared\Domain\Exception\DomainException;

final class InvalidEmailException extends DomainException
{
    public function __construct(string $email)
    {
        parent::__construct(sprintf('"%s" is not a valid email address.', $email));
    }
}
