<?php

declare(strict_types=1);

namespace App\Contexts\Identity\Interfaces\Http\Controllers;

use App\Contexts\Identity\Application\Dto\RegisterUserInput;
use App\Contexts\Identity\Application\UseCase\RegisterUser;
use App\Contexts\Identity\Interfaces\Http\Requests\RegisterUserRequest;
use App\Contexts\Identity\Interfaces\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * Thin controller — validates input, calls the use case, shapes output.
 * No business logic belongs here.
 */
final class RegisterUserController extends Controller
{
    public function __invoke(RegisterUserRequest $request, RegisterUser $registerUser): JsonResponse
    {
        $user = $registerUser->execute(new RegisterUserInput(
            name: $request->string('name')->toString(),
            email: $request->string('email')->toString(),
            password: $request->string('password')->toString(),
        ));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(201);
    }
}
