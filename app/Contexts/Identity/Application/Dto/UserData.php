<?php

declare(strict_types=1);

namespace App\Contexts\Identity\Application\Dto;

use App\Contexts\Identity\Domain\Entity\User;

/**
 * Output DTO — what the outside world is allowed to see of a User.
 */
final readonly class UserData
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public ?string $emailVerifiedAt,
    ) {}

    public static function fromEntity(User $user): self
    {
        return new self(
            id: (string) $user->id(),
            name: $user->name(),
            email: (string) $user->email(),
            emailVerifiedAt: $user->emailVerifiedAt()?->format(DATE_ATOM),
        );
    }
}
