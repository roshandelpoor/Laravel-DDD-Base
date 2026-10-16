<?php

declare(strict_types=1);

namespace App\Contexts\Chat\Infrastructure\Persistence\Eloquent;

use App\Contexts\Chat\Domain\Entity\Message;
use App\Contexts\Chat\Domain\Repository\MessageRepository;
use App\Contexts\Chat\Domain\ValueObject\MessageId;
use Illuminate\Support\Carbon;

/**
 * Eloquent adapter for the MessageRepository port.
 */
final class EloquentMessageRepository implements MessageRepository
{
    public function findById(MessageId $id): ?Message
    {
        $model = MessageEloquentModel::query()->find((string) $id);

        return $model ? $this->toDomain($model) : null;
    }

    public function findBetween(string $userAId, string $userBId): array
    {
        return MessageEloquentModel::query()
            ->where(function ($query) use ($userAId, $userBId) {
                $query->where('sender_id', $userAId)->where('recipient_id', $userBId);
            })
            ->orWhere(function ($query) use ($userAId, $userBId) {
                $query->where('sender_id', $userBId)->where('recipient_id', $userAId);
            })
            ->orderBy('sent_at')
            ->get()
            ->map(fn (MessageEloquentModel $model) => $this->toDomain($model))
            ->all();
    }

    public function save(Message $message): void
    {
        MessageEloquentModel::query()->updateOrCreate(
            ['id' => (string) $message->id()],
            [
                'sender_id' => $message->senderId(),
                'recipient_id' => $message->recipientId(),
                'body' => $message->body(),
                'sent_at' => $message->sentAt(),
            ],
        );
    }

    private function toDomain(MessageEloquentModel $model): Message
    {
        return Message::reconstitute(
            id: new MessageId((string) $model->getKey()),
            senderId: $model->sender_id,
            recipientId: $model->recipient_id,
            body: $model->body,
            sentAt: Carbon::parse($model->sent_at)->toDateTimeImmutable(),
        );
    }
}
