<?php

declare(strict_types=1);

namespace App\Contexts\Identity\Infrastructure\Hashing;

use App\Contexts\Identity\Domain\Service\PasswordHasher;
use Illuminate\Contracts\Hashing\Hasher;

/**
 * Adapter for the PasswordHasher port, backed by Laravel's Hasher.
 */
final class LaravelPasswordHasher implements PasswordHasher
{
    public function __construct(private readonly Hasher $hasher) {}

    public function hash(string $plainPassword): string
    {
        return $this->hasher->make($plainPassword);
    }

    public function verify(string $plainPassword, string $hashedPassword): bool
    {
        return $this->hasher->check($plainPassword, $hashedPassword);
    }
}
