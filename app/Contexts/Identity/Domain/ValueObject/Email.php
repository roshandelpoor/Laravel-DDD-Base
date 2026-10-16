<?php

declare(strict_types=1);

namespace App\Contexts\Identity\Domain\ValueObject;

use App\Contexts\Identity\Domain\Exception\InvalidEmailException;
use Stringable;

final class Email implements Stringable
{
    public readonly string $value;

    public function __construct(string $value)
    {
        $normalized = strtolower(trim($value));

        if (! filter_var($normalized, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException($value);
        }

        $this->value = $normalized;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
