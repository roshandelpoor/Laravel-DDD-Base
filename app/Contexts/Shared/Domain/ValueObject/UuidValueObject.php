<?php

declare(strict_types=1);

namespace App\Contexts\Shared\Domain\ValueObject;

use InvalidArgumentException;
use Stringable;

/**
 * Base value object for UUID-backed identifiers.
 *
 * Usage: final class UserId extends UuidValueObject {}
 *
 * @phpstan-consistent-constructor
 */
abstract class UuidValueObject implements Stringable
{
    public function __construct(public readonly string $value)
    {
        if (! preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $value)) {
            throw new InvalidArgumentException(sprintf('Invalid UUID value: %s', $value));
        }
    }

    public static function generate(): static
    {
        return new static(self::newUuidV4());
    }

    public function equals(self $other): bool
    {
        return static::class === $other::class && $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private static function newUuidV4(): string
    {
        $data = random_bytes(16);
        $data[6] = chr((ord($data[6]) & 0x0F) | 0x40);
        $data[8] = chr((ord($data[8]) & 0x3F) | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
