<?php

declare(strict_types=1);

namespace App\Contexts\Doctor\Domain\Exception;

use App\Contexts\Shared\Domain\Exception\DomainException;

final class DoctorAlreadyExistsException extends DomainException
{
    public function __construct(string $licenseNumber)
    {
        parent::__construct(sprintf('A doctor with license number "%s" already exists.', $licenseNumber));
    }
}
