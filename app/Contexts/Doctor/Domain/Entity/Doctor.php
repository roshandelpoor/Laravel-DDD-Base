<?php

declare(strict_types=1);

namespace App\Contexts\Doctor\Domain\Entity;

use App\Contexts\Doctor\Domain\Event\DoctorRegistered;
use App\Contexts\Doctor\Domain\ValueObject\DoctorId;
use App\Contexts\Shared\Domain\Event\RecordsDomainEvents;

/**
 * Doctor aggregate root.
 *
 * clinicId is stored as a plain UUID string — cross-context references
 * (to the Clinic context) happen by id only, keeping contexts decoupled.
 */
final class Doctor
{
    use RecordsDomainEvents;

    private function __construct(
        private DoctorId $id,
        private string $name,
        private string $specialty,
        private string $licenseNumber,
        private ?string $clinicId,
    ) {}

    public static function register(
        DoctorId $id,
        string $name,
        string $specialty,
        string $licenseNumber,
        ?string $clinicId = null,
    ): self {
        $doctor = new self($id, trim($name), trim($specialty), trim($licenseNumber), $clinicId);
        $doctor->record(new DoctorRegistered($id, $licenseNumber));

        return $doctor;
    }

    /**
     * Rebuild a doctor from persistence without recording domain events.
     */
    public static function reconstitute(
        DoctorId $id,
        string $name,
        string $specialty,
        string $licenseNumber,
        ?string $clinicId,
    ): self {
        return new self($id, $name, $specialty, $licenseNumber, $clinicId);
    }

    public function id(): DoctorId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function specialty(): string
    {
        return $this->specialty;
    }

    public function licenseNumber(): string
    {
        return $this->licenseNumber;
    }

    public function clinicId(): ?string
    {
        return $this->clinicId;
    }

    public function assignToClinic(string $clinicId): void
    {
        $this->clinicId = $clinicId;
    }
}
