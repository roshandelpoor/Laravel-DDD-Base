<?php

declare(strict_types=1);

namespace Tests\Feature\Clinic;

use App\Contexts\Clinic\Domain\Event\ClinicRegistered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

final class ClinicTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_registers_a_clinic_and_dispatches_domain_event(): void
    {
        Event::fake([ClinicRegistered::class]);

        $response = $this->postJson('/api/clinics', [
            'name' => 'City Health Clinic',
            'address' => '123 Main St',
            'phone' => '0215551234',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.name', 'City Health Clinic')
            ->assertJsonPath('data.phone', '0215551234');

        $this->assertDatabaseHas('clinics', ['name' => 'City Health Clinic']);

        Event::assertDispatched(ClinicRegistered::class);
    }

    public function test_it_fetches_a_clinic_by_id(): void
    {
        $created = $this->postJson('/api/clinics', [
            'name' => 'City Health Clinic',
            'address' => '123 Main St',
            'phone' => '0215551234',
        ])->assertCreated();

        $id = $created->json('data.id');

        $this->getJson("/api/clinics/{$id}")
            ->assertOk()
            ->assertJsonPath('data.id', $id);
    }

    public function test_it_returns_404_for_unknown_clinic(): void
    {
        $this->getJson('/api/clinics/3f47a6e5-1e57-4c9a-9f2c-9a1b2c3d4e5f')
            ->assertNotFound();
    }

    public function test_it_validates_the_payload(): void
    {
        $this->postJson('/api/clinics', [
            'name' => '',
            'address' => '',
            'phone' => '',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'address', 'phone']);
    }
}
