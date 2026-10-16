<?php

declare(strict_types=1);

namespace App\Contexts\Clinic\Interfaces\Http\Controllers;

use App\Contexts\Clinic\Application\Dto\RegisterClinicInput;
use App\Contexts\Clinic\Application\UseCase\RegisterClinic;
use App\Contexts\Clinic\Interfaces\Http\Requests\RegisterClinicRequest;
use App\Contexts\Clinic\Interfaces\Http\Resources\ClinicResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

final class RegisterClinicController extends Controller
{
    public function __invoke(RegisterClinicRequest $request, RegisterClinic $registerClinic): JsonResponse
    {
        $clinic = $registerClinic->execute(new RegisterClinicInput(
            name: $request->string('name')->toString(),
            address: $request->string('address')->toString(),
            phone: $request->string('phone')->toString(),
        ));

        return (new ClinicResource($clinic))
            ->response()
            ->setStatusCode(201);
    }
}
