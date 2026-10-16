<?php

declare(strict_types=1);

namespace App\Contexts\Chat\Interfaces\Http\Controllers;

use App\Contexts\Chat\Application\Dto\GetConversationInput;
use App\Contexts\Chat\Application\UseCase\GetConversation;
use App\Contexts\Chat\Interfaces\Http\Resources\MessageResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class GetConversationController extends Controller
{
    public function __invoke(string $userA, string $userB, GetConversation $getConversation): AnonymousResourceCollection
    {
        $messages = $getConversation->execute(new GetConversationInput($userA, $userB));

        return MessageResource::collection(collect($messages));
    }
}
