<?php

declare(strict_types=1);

namespace Tests\Feature\Doctor;

use App\Contexts\Doctor\Domain\Event\DoctorRegistered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

final class DoctorTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_registers_a_doctor_and_dispatches_domain_event(): void
    {
        Event::fake([DoctorRegistered::class]);

        $response = $this->postJson('/api/doctors', [
            'name' => 'Dr. Smith',
            'specialty' => 'Cardiology',
            'license_number' => 'MD-12345',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.name', 'Dr. Smith')
            ->assertJsonPath('data.license_number', 'MD-12345');

        $this->assertDatabaseHas('doctors', ['license_number' => 'MD-12345']);

        Event::assertDispatched(DoctorRegistered::class);
    }

    public function test_it_rejects_duplicate_license_numbers(): void
    {
        $payload = [
            'name' => 'Dr. Smith',
            'specialty' => 'Cardiology',
            'license_number' => 'MD-12345',
        ];

        $this->postJson('/api/doctors', $payload)->assertCreated();
        $this->postJson('/api/doctors', $payload)->assertUnprocessable();
    }

    public function test_it_fetches_a_doctor_by_id(): void
    {
        $created = $this->postJson('/api/doctors', [
            'name' => 'Dr. Jones',
            'specialty' => 'Neurology',
            'license_number' => 'MD-99999',
        ])->assertCreated();

        $id = $created->json('data.id');

        $this->getJson("/api/doctors/{$id}")
            ->assertOk()
            ->assertJsonPath('data.id', $id);
    }

    public function test_it_returns_404_for_unknown_doctor(): void
    {
        $this->getJson('/api/doctors/3f47a6e5-1e57-4c9a-9f2c-9a1b2c3d4e5f')
            ->assertNotFound();
    }
}
