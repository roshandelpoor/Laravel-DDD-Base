<?php

declare(strict_types=1);

namespace App\Contexts\Doctor\Application\UseCase;

use App\Contexts\Doctor\Application\Dto\DoctorData;
use App\Contexts\Doctor\Application\Dto\RegisterDoctorInput;
use App\Contexts\Doctor\Domain\Entity\Doctor;
use App\Contexts\Doctor\Domain\Exception\DoctorAlreadyExistsException;
use App\Contexts\Doctor\Domain\Repository\DoctorRepository;
use App\Contexts\Doctor\Domain\ValueObject\DoctorId;
use App\Contexts\Shared\Domain\Event\DomainEventDispatcher;

/**
 * Use case: register a doctor.
 */
final readonly class RegisterDoctor
{
    public function __construct(
        private DoctorRepository $doctors,
        private DomainEventDispatcher $events,
    ) {}

    public function execute(RegisterDoctorInput $input): DoctorData
    {
        if ($this->doctors->findByLicenseNumber($input->licenseNumber) !== null) {
            throw new DoctorAlreadyExistsException($input->licenseNumber);
        }

        $doctor = Doctor::register(
            id: DoctorId::generate(),
            name: $input->name,
            specialty: $input->specialty,
            licenseNumber: $input->licenseNumber,
            clinicId: $input->clinicId,
        );

        $this->doctors->save($doctor);
        $this->events->dispatch(...$doctor->pullDomainEvents());

        return DoctorData::fromEntity($doctor);
    }
}
