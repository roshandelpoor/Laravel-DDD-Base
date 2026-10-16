<?php

declare(strict_types=1);

namespace App\Contexts\Chat\Interfaces\Http\Resources;

use App\Contexts\Chat\Application\Dto\MessageData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin MessageData
 */
final class MessageResource extends JsonResource
{
    /**
     * @return array<string, string>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sender_id' => $this->senderId,
            'recipient_id' => $this->recipientId,
            'body' => $this->body,
            'sent_at' => $this->sentAt,
        ];
    }
}
