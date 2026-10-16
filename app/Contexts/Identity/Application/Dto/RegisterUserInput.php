<?php

declare(strict_types=1);

namespace App\Contexts\Identity\Application\Dto;

/**
 * Input DTO for the RegisterUser use case.
 * Carries primitive data across the application boundary.
 */
final readonly class RegisterUserInput
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}
}
