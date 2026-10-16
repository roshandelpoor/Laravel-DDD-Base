<?php

declare(strict_types=1);

namespace Tests\Feature\Identity;

use App\Contexts\Identity\Domain\Event\UserRegistered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

final class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_registers_a_user_and_dispatches_domain_event(): void
    {
        Event::fake([UserRegistered::class]);

        $response = $this->postJson('/api/users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret1234',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.email', 'john@example.com')
            ->assertJsonPath('data.name', 'John Doe');

        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);

        Event::assertDispatched(UserRegistered::class);
    }

    public function test_it_rejects_duplicate_emails(): void
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret1234',
        ];

        $this->postJson('/api/users', $payload)->assertCreated();
        $this->postJson('/api/users', $payload)->assertUnprocessable();
    }

    public function test_it_validates_the_payload(): void
    {
        $this->postJson('/api/users', [
            'name' => '',
            'email' => 'not-an-email',
            'password' => 'short',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function test_it_fetches_a_registered_user_by_id(): void
    {
        $created = $this->postJson('/api/users', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'secret1234',
        ])->assertCreated();

        $id = $created->json('data.id');

        $this->getJson("/api/users/{$id}")
            ->assertOk()
            ->assertJsonPath('data.id', $id)
            ->assertJsonPath('data.email', 'jane@example.com');
    }

    public function test_it_returns_404_for_unknown_user(): void
    {
        $this->getJson('/api/users/'.'3f47a6e5-1e57-4c9a-9f2c-9a1b2c3d4e5f')
            ->assertNotFound();
    }
}
