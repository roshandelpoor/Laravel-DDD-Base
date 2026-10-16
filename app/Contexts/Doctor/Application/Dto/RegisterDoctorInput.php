<?php

declare(strict_types=1);

namespace App\Contexts\Doctor\Application\Dto;

final readonly class RegisterDoctorInput
{
    public function __construct(
        public string $name,
        public string $specialty,
        public string $licenseNumber,
        public ?string $clinicId = null,
    ) {}
}
