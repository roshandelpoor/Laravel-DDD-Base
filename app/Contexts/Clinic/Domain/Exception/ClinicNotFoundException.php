<?php

declare(strict_types=1);

namespace App\Contexts\Clinic\Domain\Exception;

use App\Contexts\Clinic\Domain\ValueObject\ClinicId;
use App\Contexts\Shared\Domain\Exception\EntityNotFoundException;

final class ClinicNotFoundException extends EntityNotFoundException
{
    public function __construct(ClinicId|string $id)
    {
        parent::__construct(sprintf('Clinic "%s" was not found.', (string) $id));
    }
}
