<?php

declare(strict_types=1);

namespace App\Contexts\Chat\Application\UseCase;

use App\Contexts\Chat\Application\Dto\GetConversationInput;
use App\Contexts\Chat\Application\Dto\MessageData;
use App\Contexts\Chat\Domain\Entity\Message;
use App\Contexts\Chat\Domain\Repository\MessageRepository;

/**
 * Use case: list the conversation between two users.
 */
final readonly class GetConversation
{
    public function __construct(private MessageRepository $messages) {}

    /**
     * @return list<MessageData>
     */
    public function execute(GetConversationInput $input): array
    {
        return array_map(
            fn (Message $message) => MessageData::fromEntity($message),
            $this->messages->findBetween($input->userAId, $input->userBId),
        );
    }
}
