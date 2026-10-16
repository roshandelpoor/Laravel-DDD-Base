<?php

declare(strict_types=1);

namespace App\Contexts\Identity\Infrastructure\Persistence\Eloquent;

use App\Contexts\Identity\Domain\Entity\User;
use App\Contexts\Identity\Domain\Repository\UserRepository;
use App\Contexts\Identity\Domain\ValueObject\Email;
use App\Contexts\Identity\Domain\ValueObject\HashedPassword;
use App\Contexts\Identity\Domain\ValueObject\UserId;
use Illuminate\Support\Carbon;

/**
 * Eloquent adapter for the UserRepository port.
 * Translates between the persistence model and the domain entity.
 */
final class EloquentUserRepository implements UserRepository
{
    public function findById(UserId $id): ?User
    {
        $model = UserEloquentModel::query()->find((string) $id);

        return $model ? $this->toDomain($model) : null;
    }

    public function findByEmail(Email $email): ?User
    {
        $model = UserEloquentModel::query()
            ->where('email', (string) $email)
            ->first();

        return $model ? $this->toDomain($model) : null;
    }

    public function save(User $user): void
    {
        UserEloquentModel::query()->updateOrCreate(
            ['id' => (string) $user->id()],
            [
                'name' => $user->name(),
                'email' => (string) $user->email(),
                'password' => (string) $user->password(),
                'email_verified_at' => $user->emailVerifiedAt(),
            ],
        );
    }

    private function toDomain(UserEloquentModel $model): User
    {
        return User::reconstitute(
            id: new UserId((string) $model->getKey()),
            name: $model->name,
            email: new Email($model->email),
            password: new HashedPassword($model->password),
            emailVerifiedAt: $model->email_verified_at
                ? Carbon::parse($model->email_verified_at)->toDateTimeImmutable()
                : null,
        );
    }
}
