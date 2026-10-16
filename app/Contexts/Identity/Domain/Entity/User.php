<?php

declare(strict_types=1);

namespace App\Contexts\Identity\Domain\Entity;

use App\Contexts\Identity\Domain\Event\UserRegistered;
use App\Contexts\Identity\Domain\ValueObject\Email;
use App\Contexts\Identity\Domain\ValueObject\HashedPassword;
use App\Contexts\Identity\Domain\ValueObject\UserId;
use App\Contexts\Shared\Domain\Event\RecordsDomainEvents;
use DateTimeImmutable;

/**
 * User aggregate root.
 *
 * Pure PHP — no Laravel dependencies. Construction always goes through
 * a named constructor: register() for new users (records a domain
 * event), reconstitute() for hydration from persistence.
 */
final class User
{
    use RecordsDomainEvents;

    private function __construct(
        private UserId $id,
        private string $name,
        private Email $email,
        private HashedPassword $password,
        private ?DateTimeImmutable $emailVerifiedAt,
    ) {}

    public static function register(
        UserId $id,
        string $name,
        Email $email,
        HashedPassword $password,
    ): self {
        $user = new self($id, trim($name), $email, $password, null);
        $user->record(new UserRegistered($id, $email));

        return $user;
    }

    /**
     * Rebuild a user from persistence without recording domain events.
     */
    public static function reconstitute(
        UserId $id,
        string $name,
        Email $email,
        HashedPassword $password,
        ?DateTimeImmutable $emailVerifiedAt,
    ): self {
        return new self($id, $name, $email, $password, $emailVerifiedAt);
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function password(): HashedPassword
    {
        return $this->password;
    }

    public function emailVerifiedAt(): ?DateTimeImmutable
    {
        return $this->emailVerifiedAt;
    }

    public function rename(string $name): void
    {
        $this->name = trim($name);
    }

    public function verifyEmail(): void
    {
        $this->emailVerifiedAt = new DateTimeImmutable;
    }
}
