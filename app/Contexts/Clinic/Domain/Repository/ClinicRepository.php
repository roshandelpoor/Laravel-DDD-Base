<?php

declare(strict_types=1);

namespace App\Contexts\Clinic\Domain\Repository;

use App\Contexts\Clinic\Domain\Entity\Clinic;
use App\Contexts\Clinic\Domain\ValueObject\ClinicId;

/**
 * Persistence port for the Clinic aggregate.
 */
interface ClinicRepository
{
    public function findById(ClinicId $id): ?Clinic;

    public function save(Clinic $clinic): void;
}
