<?php

declare(strict_types=1);

namespace App\Contexts\Doctor\Application\Dto;

use App\Contexts\Doctor\Domain\Entity\Doctor;

final readonly class DoctorData
{
    public function __construct(
        public string $id,
        public string $name,
        public string $specialty,
        public string $licenseNumber,
        public ?string $clinicId,
    ) {}

    public static function fromEntity(Doctor $doctor): self
    {
        return new self(
            id: (string) $doctor->id(),
            name: $doctor->name(),
            specialty: $doctor->specialty(),
            licenseNumber: $doctor->licenseNumber(),
            clinicId: $doctor->clinicId(),
        );
    }
}
