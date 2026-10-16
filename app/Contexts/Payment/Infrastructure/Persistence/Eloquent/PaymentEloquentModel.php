<?php

declare(strict_types=1);

namespace App\Contexts\Payment\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent persistence model for the payments table.
 * Infrastructure detail — never reference from Domain or Application code.
 */
#[Fillable(['id', 'amount', 'currency', 'status', 'gateway_reference'])]
final class PaymentEloquentModel extends Model
{
    protected $table = 'payments';

    /** UUID primary key — matches the domain PaymentId value object. */
    public $incrementing = false;

    protected $keyType = 'string';

    protected function casts(): array
    {
        return [
            'amount' => 'float',
        ];
    }
}
