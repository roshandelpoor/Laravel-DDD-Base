<?php

declare(strict_types=1);

namespace App\Contexts\Identity\Interfaces\Http\Controllers;

use App\Contexts\Identity\Application\Dto\GetUserInput;
use App\Contexts\Identity\Application\UseCase\GetUser;
use App\Contexts\Identity\Interfaces\Http\Resources\UserResource;
use App\Http\Controllers\Controller;

final class GetUserController extends Controller
{
    public function __invoke(string $id, GetUser $getUser): UserResource
    {
        return new UserResource($getUser->execute(new GetUserInput($id)));
    }
}
