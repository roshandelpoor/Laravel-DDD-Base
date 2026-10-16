<?php

declare(strict_types=1);

namespace Tests\Feature\Chat;

use App\Contexts\Chat\Domain\Event\MessageSent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Tests\TestCase;

final class ChatTest extends TestCase
{
    use RefreshDatabase;

    private string $userA;

    private string $userB;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userA = (string) Str::uuid();
        $this->userB = (string) Str::uuid();
    }

    public function test_it_sends_a_message_and_dispatches_domain_event(): void
    {
        Event::fake([MessageSent::class]);

        $response = $this->postJson('/api/messages', [
            'sender_id' => $this->userA,
            'recipient_id' => $this->userB,
            'body' => 'Hello!',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.body', 'Hello!')
            ->assertJsonPath('data.sender_id', $this->userA);

        $this->assertDatabaseHas('messages', ['sender_id' => $this->userA, 'body' => 'Hello!']);

        Event::assertDispatched(MessageSent::class);
    }

    public function test_it_lists_the_conversation_between_two_users(): void
    {
        $this->postJson('/api/messages', [
            'sender_id' => $this->userA,
            'recipient_id' => $this->userB,
            'body' => 'Hi',
        ]);
        $this->postJson('/api/messages', [
            'sender_id' => $this->userB,
            'recipient_id' => $this->userA,
            'body' => 'Hey there',
        ]);
        // Unrelated message — must not appear
        $this->postJson('/api/messages', [
            'sender_id' => (string) Str::uuid(),
            'recipient_id' => (string) Str::uuid(),
            'body' => 'unrelated',
        ]);

        $this->getJson("/api/conversations/{$this->userA}/{$this->userB}")
            ->assertOk()
            ->assertJsonCount(2, 'data');
    }

    public function test_it_rejects_empty_body(): void
    {
        $this->postJson('/api/messages', [
            'sender_id' => $this->userA,
            'recipient_id' => $this->userB,
            'body' => '',
        ])->assertUnprocessable();
    }

    public function test_it_rejects_invalid_uuid(): void
    {
        $this->postJson('/api/messages', [
            'sender_id' => 'not-a-uuid',
            'recipient_id' => $this->userB,
            'body' => 'Hi',
        ])->assertUnprocessable();
    }
}
