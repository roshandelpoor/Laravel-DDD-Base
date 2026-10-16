<?php

declare(strict_types=1);

namespace App\Contexts\Clinic\Infrastructure\Persistence\Eloquent;

use App\Contexts\Clinic\Domain\Entity\Clinic;
use App\Contexts\Clinic\Domain\Repository\ClinicRepository;
use App\Contexts\Clinic\Domain\ValueObject\ClinicId;

/**
 * Eloquent adapter for the ClinicRepository port.
 */
final class EloquentClinicRepository implements ClinicRepository
{
    public function findById(ClinicId $id): ?Clinic
    {
        $model = ClinicEloquentModel::query()->find((string) $id);

        return $model ? $this->toDomain($model) : null;
    }

    public function save(Clinic $clinic): void
    {
        ClinicEloquentModel::query()->updateOrCreate(
            ['id' => (string) $clinic->id()],
            [
                'name' => $clinic->name(),
                'address' => $clinic->address(),
                'phone' => $clinic->phone(),
            ],
        );
    }

    private function toDomain(ClinicEloquentModel $model): Clinic
    {
        return Clinic::reconstitute(
            id: new ClinicId((string) $model->getKey()),
            name: $model->name,
            address: $model->address,
            phone: $model->phone,
        );
    }
}
