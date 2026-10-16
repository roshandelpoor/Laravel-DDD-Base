<?php

declare(strict_types=1);

namespace App\Contexts\Clinic\Domain\Entity;

use App\Contexts\Clinic\Domain\Event\ClinicRegistered;
use App\Contexts\Clinic\Domain\ValueObject\ClinicId;
use App\Contexts\Shared\Domain\Event\RecordsDomainEvents;

/**
 * Clinic aggregate root.
 */
final class Clinic
{
    use RecordsDomainEvents;

    private function __construct(
        private ClinicId $id,
        private string $name,
        private string $address,
        private string $phone,
    ) {}

    public static function register(
        ClinicId $id,
        string $name,
        string $address,
        string $phone,
    ): self {
        $clinic = new self($id, trim($name), trim($address), trim($phone));
        $clinic->record(new ClinicRegistered($id, $name));

        return $clinic;
    }

    /**
     * Rebuild a clinic from persistence without recording domain events.
     */
    public static function reconstitute(
        ClinicId $id,
        string $name,
        string $address,
        string $phone,
    ): self {
        return new self($id, $name, $address, $phone);
    }

    public function id(): ClinicId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function address(): string
    {
        return $this->address;
    }

    public function phone(): string
    {
        return $this->phone;
    }
}
