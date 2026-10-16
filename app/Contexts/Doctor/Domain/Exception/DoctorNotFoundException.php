<?php

declare(strict_types=1);

namespace App\Contexts\Doctor\Domain\Exception;

use App\Contexts\Doctor\Domain\ValueObject\DoctorId;
use App\Contexts\Shared\Domain\Exception\EntityNotFoundException;

final class DoctorNotFoundException extends EntityNotFoundException
{
    public function __construct(DoctorId|string $id)
    {
        parent::__construct(sprintf('Doctor "%s" was not found.', (string) $id));
    }
}
