<?php

declare(strict_types=1);

namespace App\Contexts\Doctor\Infrastructure\Persistence\Eloquent;

use App\Contexts\Doctor\Domain\Entity\Doctor;
use App\Contexts\Doctor\Domain\Repository\DoctorRepository;
use App\Contexts\Doctor\Domain\ValueObject\DoctorId;

/**
 * Eloquent adapter for the DoctorRepository port.
 */
final class EloquentDoctorRepository implements DoctorRepository
{
    public function findById(DoctorId $id): ?Doctor
    {
        $model = DoctorEloquentModel::query()->find((string) $id);

        return $model ? $this->toDomain($model) : null;
    }

    public function findByLicenseNumber(string $licenseNumber): ?Doctor
    {
        $model = DoctorEloquentModel::query()
            ->where('license_number', $licenseNumber)
            ->first();

        return $model ? $this->toDomain($model) : null;
    }

    public function save(Doctor $doctor): void
    {
        DoctorEloquentModel::query()->updateOrCreate(
            ['id' => (string) $doctor->id()],
            [
                'name' => $doctor->name(),
                'specialty' => $doctor->specialty(),
                'license_number' => $doctor->licenseNumber(),
                'clinic_id' => $doctor->clinicId(),
            ],
        );
    }

    private function toDomain(DoctorEloquentModel $model): Doctor
    {
        return Doctor::reconstitute(
            id: new DoctorId((string) $model->getKey()),
            name: $model->name,
            specialty: $model->specialty,
            licenseNumber: $model->license_number,
            clinicId: $model->clinic_id,
        );
    }
}
