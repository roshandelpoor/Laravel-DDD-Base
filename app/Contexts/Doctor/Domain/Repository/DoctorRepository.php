<?php

declare(strict_types=1);

namespace App\Contexts\Doctor\Domain\Repository;

use App\Contexts\Doctor\Domain\Entity\Doctor;
use App\Contexts\Doctor\Domain\ValueObject\DoctorId;

/**
 * Persistence port for the Doctor aggregate.
 */
interface DoctorRepository
{
    public function findById(DoctorId $id): ?Doctor;

    public function findByLicenseNumber(string $licenseNumber): ?Doctor;

    public function save(Doctor $doctor): void;
}
