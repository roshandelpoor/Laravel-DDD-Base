<?php

declare(strict_types=1);

namespace App\Contexts\Clinic\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent persistence model for the clinics table.
 * Infrastructure detail — never reference from Domain or Application code.
 */
#[Fillable(['id', 'name', 'address', 'phone'])]
final class ClinicEloquentModel extends Model
{
    protected $table = 'clinics';

    /** UUID primary key — matches the domain ClinicId value object. */
    public $incrementing = false;

    protected $keyType = 'string';
}
