<?php

declare(strict_types=1);

namespace App\Contexts\Clinic\Application\Dto;

use App\Contexts\Clinic\Domain\Entity\Clinic;

final readonly class ClinicData
{
    public function __construct(
        public string $id,
        public string $name,
        public string $address,
        public string $phone,
    ) {}

    public static function fromEntity(Clinic $clinic): self
    {
        return new self(
            id: (string) $clinic->id(),
            name: $clinic->name(),
            address: $clinic->address(),
            phone: $clinic->phone(),
        );
    }
}
