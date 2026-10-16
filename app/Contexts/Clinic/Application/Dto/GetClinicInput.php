<?php

declare(strict_types=1);

namespace App\Contexts\Clinic\Application\Dto;

final readonly class GetClinicInput
{
    public function __construct(public string $id) {}
}
