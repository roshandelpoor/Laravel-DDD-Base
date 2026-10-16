<?php

declare(strict_types=1);

namespace App\Contexts\Identity\Application\UseCase;

use App\Contexts\Identity\Application\Dto\RegisterUserInput;
use App\Contexts\Identity\Application\Dto\UserData;
use App\Contexts\Identity\Domain\Entity\User;
use App\Contexts\Identity\Domain\Exception\UserAlreadyExistsException;
use App\Contexts\Identity\Domain\Repository\UserRepository;
use App\Contexts\Identity\Domain\Service\PasswordHasher;
use App\Contexts\Identity\Domain\ValueObject\Email;
use App\Contexts\Identity\Domain\ValueObject\HashedPassword;
use App\Contexts\Identity\Domain\ValueObject\UserId;
use App\Contexts\Shared\Domain\Event\DomainEventDispatcher;

/**
 * Use case: register a new user.
 *
 * Orchestrates domain objects only — no framework code here.
 */
final readonly class RegisterUser
{
    public function __construct(
        private UserRepository $users,
        private PasswordHasher $hasher,
        private DomainEventDispatcher $events,
    ) {}

    public function execute(RegisterUserInput $input): UserData
    {
        $email = new Email($input->email);

        if ($this->users->findByEmail($email) !== null) {
            throw new UserAlreadyExistsException($email);
        }

        $user = User::register(
            id: UserId::generate(),
            name: $input->name,
            email: $email,
            password: new HashedPassword($this->hasher->hash($input->password)),
        );

        $this->users->save($user);
        $this->events->dispatch(...$user->pullDomainEvents());

        return UserData::fromEntity($user);
    }
}
