<?php

declare(strict_types=1);

namespace App\Contexts\Clinic\Application\Dto;

final readonly class RegisterClinicInput
{
    public function __construct(
        public string $name,
        public string $address,
        public string $phone,
    ) {}
}
