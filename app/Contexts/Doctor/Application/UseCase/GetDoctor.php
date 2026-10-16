<?php

declare(strict_types=1);

namespace App\Contexts\Doctor\Application\UseCase;

use App\Contexts\Doctor\Application\Dto\DoctorData;
use App\Contexts\Doctor\Application\Dto\GetDoctorInput;
use App\Contexts\Doctor\Domain\Exception\DoctorNotFoundException;
use App\Contexts\Doctor\Domain\Repository\DoctorRepository;
use App\Contexts\Doctor\Domain\ValueObject\DoctorId;

final readonly class GetDoctor
{
    public function __construct(private DoctorRepository $doctors) {}

    public function execute(GetDoctorInput $input): DoctorData
    {
        $id = new DoctorId($input->id);
        $doctor = $this->doctors->findById($id)
            ?? throw new DoctorNotFoundException($id);

        return DoctorData::fromEntity($doctor);
    }
}
