<?php

declare(strict_types=1);

namespace App\Contexts\Identity\Domain\Repository;

use App\Contexts\Identity\Domain\Entity\User;
use App\Contexts\Identity\Domain\ValueObject\Email;
use App\Contexts\Identity\Domain\ValueObject\UserId;

/**
 * Persistence port for the User aggregate.
 * Implementation lives in the Infrastructure layer.
 */
interface UserRepository
{
    public function findById(UserId $id): ?User;

    public function findByEmail(Email $email): ?User;

    public function save(User $user): void;
}
