<?php

declare(strict_types=1);

namespace App\Contexts\Chat\Domain\Exception;

use App\Contexts\Shared\Domain\Exception\DomainException;

final class EmptyMessageBodyException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Message body cannot be empty.');
    }
}
