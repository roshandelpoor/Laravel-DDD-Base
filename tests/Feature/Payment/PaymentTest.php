<?php

declare(strict_types=1);

namespace Tests\Feature\Payment;

use App\Contexts\Payment\Domain\Event\PaymentCreated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

final class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_payment_and_dispatches_domain_event(): void
    {
        Event::fake([PaymentCreated::class]);

        $response = $this->postJson('/api/payments', [
            'amount' => 150.50,
            'currency' => 'usd',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.amount', 150.5)
            ->assertJsonPath('data.currency', 'USD')
            ->assertJsonPath('data.status', 'pending')
            ->assertJsonStructure(['data' => ['gateway_reference']]);

        $this->assertDatabaseHas('payments', ['currency' => 'USD', 'status' => 'pending']);

        Event::assertDispatched(PaymentCreated::class);
    }

    public function test_it_fetches_a_payment_by_id(): void
    {
        $created = $this->postJson('/api/payments', [
            'amount' => 99.99,
            'currency' => 'EUR',
        ])->assertCreated();

        $id = $created->json('data.id');

        $this->getJson("/api/payments/{$id}")
            ->assertOk()
            ->assertJsonPath('data.id', $id);
    }

    public function test_it_returns_404_for_unknown_payment(): void
    {
        $this->getJson('/api/payments/3f47a6e5-1e57-4c9a-9f2c-9a1b2c3d4e5f')
            ->assertNotFound();
    }

    public function test_it_validates_the_amount(): void
    {
        $this->postJson('/api/payments', [
            'amount' => -5,
            'currency' => 'USD',
        ])->assertUnprocessable();
    }
}
