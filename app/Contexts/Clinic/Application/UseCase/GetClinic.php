<?php

declare(strict_types=1);

namespace App\Contexts\Clinic\Application\UseCase;

use App\Contexts\Clinic\Application\Dto\ClinicData;
use App\Contexts\Clinic\Application\Dto\GetClinicInput;
use App\Contexts\Clinic\Domain\Exception\ClinicNotFoundException;
use App\Contexts\Clinic\Domain\Repository\ClinicRepository;
use App\Contexts\Clinic\Domain\ValueObject\ClinicId;

final readonly class GetClinic
{
    public function __construct(private ClinicRepository $clinics) {}

    public function execute(GetClinicInput $input): ClinicData
    {
        $id = new ClinicId($input->id);
        $clinic = $this->clinics->findById($id)
            ?? throw new ClinicNotFoundException($id);

        return ClinicData::fromEntity($clinic);
    }
}
