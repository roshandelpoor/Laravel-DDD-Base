<?php

declare(strict_types=1);

namespace App\Contexts\Identity\Infrastructure\Persistence\Eloquent;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Eloquent persistence model for the users table.
 *
 * This is an infrastructure detail — never reference it from Domain or
 * Application code. It also serves as the auth provider model.
 */
#[Fillable(['id', 'name', 'email', 'password', 'email_verified_at'])]
#[Hidden(['password', 'remember_token'])]
final class UserEloquentModel extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'users';

    /** UUID primary key — matches the domain UserId value object. */
    public $incrementing = false;

    protected $keyType = 'string';

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
