<?php

declare(strict_types=1);

namespace App\Contexts\Doctor\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent persistence model for the doctors table.
 * Infrastructure detail — never reference from Domain or Application code.
 */
#[Fillable(['id', 'name', 'specialty', 'license_number', 'clinic_id'])]
final class DoctorEloquentModel extends Model
{
    protected $table = 'doctors';

    /** UUID primary key — matches the domain DoctorId value object. */
    public $incrementing = false;

    protected $keyType = 'string';
}
