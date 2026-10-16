<?php

declare(strict_types=1);

namespace App\Contexts\Clinic\Application\UseCase;

use App\Contexts\Clinic\Application\Dto\ClinicData;
use App\Contexts\Clinic\Application\Dto\RegisterClinicInput;
use App\Contexts\Clinic\Domain\Entity\Clinic;
use App\Contexts\Clinic\Domain\Repository\ClinicRepository;
use App\Contexts\Clinic\Domain\ValueObject\ClinicId;
use App\Contexts\Shared\Domain\Event\DomainEventDispatcher;

/**
 * Use case: register a clinic.
 */
final readonly class RegisterClinic
{
    public function __construct(
        private ClinicRepository $clinics,
        private DomainEventDispatcher $events,
    ) {}

    public function execute(RegisterClinicInput $input): ClinicData
    {
        $clinic = Clinic::register(
            id: ClinicId::generate(),
            name: $input->name,
            address: $input->address,
            phone: $input->phone,
        );

        $this->clinics->save($clinic);
        $this->events->dispatch(...$clinic->pullDomainEvents());

        return ClinicData::fromEntity($clinic);
    }
}
