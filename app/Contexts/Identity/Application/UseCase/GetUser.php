<?php

declare(strict_types=1);

namespace App\Contexts\Identity\Application\UseCase;

use App\Contexts\Identity\Application\Dto\GetUserInput;
use App\Contexts\Identity\Application\Dto\UserData;
use App\Contexts\Identity\Domain\Exception\UserNotFoundException;
use App\Contexts\Identity\Domain\Repository\UserRepository;
use App\Contexts\Identity\Domain\ValueObject\UserId;

/**
 * Use case: fetch a single user by id.
 */
final readonly class GetUser
{
    public function __construct(private UserRepository $users) {}

    public function execute(GetUserInput $input): UserData
    {
        $id = new UserId($input->id);
        $user = $this->users->findById($id)
            ?? throw new UserNotFoundException($id);

        return UserData::fromEntity($user);
    }
}
