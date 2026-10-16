<?php

declare(strict_types=1);

namespace App\Contexts\Identity\Domain\Service;

/**
 * Hashing port — the domain needs hashed passwords but must not depend
 * on a specific hashing implementation.
 */
interface PasswordHasher
{
    public function hash(string $plainPassword): string;

    public function verify(string $plainPassword, string $hashedPassword): bool;
}
