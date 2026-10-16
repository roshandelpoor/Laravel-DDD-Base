<?php

declare(strict_types=1);

namespace App\Contexts\Chat\Interfaces\Http\Controllers;

use App\Contexts\Chat\Application\Dto\SendMessageInput;
use App\Contexts\Chat\Application\UseCase\SendMessage;
use App\Contexts\Chat\Interfaces\Http\Requests\SendMessageRequest;
use App\Contexts\Chat\Interfaces\Http\Resources\MessageResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

final class SendMessageController extends Controller
{
    public function __invoke(SendMessageRequest $request, SendMessage $sendMessage): JsonResponse
    {
        $message = $sendMessage->execute(new SendMessageInput(
            senderId: $request->string('sender_id')->toString(),
            recipientId: $request->string('recipient_id')->toString(),
            body: $request->string('body')->toString(),
        ));

        return (new MessageResource($message))
            ->response()
            ->setStatusCode(201);
    }
}
