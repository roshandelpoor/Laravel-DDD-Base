<?php

declare(strict_types=1);

namespace App\Contexts\Identity\Domain\ValueObject;

use InvalidArgumentException;
use Stringable;

/**
 * Holds an already-hashed password. Plain-text passwords never enter
 * the domain; hashing is delegated to the PasswordHasher port.
 */
final class HashedPassword implements Stringable
{
    public function __construct(public readonly string $value)
    {
        if ($value === '') {
            throw new InvalidArgumentException('Hashed password cannot be empty.');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
