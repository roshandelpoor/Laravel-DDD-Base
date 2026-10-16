<?php

declare(strict_types=1);

namespace App\Contexts\Doctor\Application\Dto;

final readonly class GetDoctorInput
{
    public function __construct(public string $id) {}
}
