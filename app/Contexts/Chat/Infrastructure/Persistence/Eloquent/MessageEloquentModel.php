<?php

declare(strict_types=1);

namespace App\Contexts\Chat\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent persistence model for the messages table.
 * Infrastructure detail — never reference from Domain or Application code.
 */
#[Fillable(['id', 'sender_id', 'recipient_id', 'body', 'sent_at'])]
final class MessageEloquentModel extends Model
{
    protected $table = 'messages';

    /** UUID primary key — matches the domain MessageId value object. */
    public $incrementing = false;

    protected $keyType = 'string';

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
        ];
    }
}
