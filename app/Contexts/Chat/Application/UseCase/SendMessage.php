<?php

declare(strict_types=1);

namespace App\Contexts\Chat\Application\UseCase;

use App\Contexts\Chat\Application\Dto\MessageData;
use App\Contexts\Chat\Application\Dto\SendMessageInput;
use App\Contexts\Chat\Domain\Entity\Message;
use App\Contexts\Chat\Domain\Repository\MessageRepository;
use App\Contexts\Chat\Domain\ValueObject\MessageId;
use App\Contexts\Shared\Domain\Event\DomainEventDispatcher;

/**
 * Use case: send a message from one user to another.
 */
final readonly class SendMessage
{
    public function __construct(
        private MessageRepository $messages,
        private DomainEventDispatcher $events,
    ) {}

    public function execute(SendMessageInput $input): MessageData
    {
        $message = Message::send(
            id: MessageId::generate(),
            senderId: $input->senderId,
            recipientId: $input->recipientId,
            body: $input->body,
        );

        $this->messages->save($message);
        $this->events->dispatch(...$message->pullDomainEvents());

        return MessageData::fromEntity($message);
    }
}
