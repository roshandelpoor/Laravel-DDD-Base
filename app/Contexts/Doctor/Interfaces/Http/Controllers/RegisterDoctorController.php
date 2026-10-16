<?php

declare(strict_types=1);

namespace App\Contexts\Doctor\Interfaces\Http\Controllers;

use App\Contexts\Doctor\Application\Dto\RegisterDoctorInput;
use App\Contexts\Doctor\Application\UseCase\RegisterDoctor;
use App\Contexts\Doctor\Interfaces\Http\Requests\RegisterDoctorRequest;
use App\Contexts\Doctor\Interfaces\Http\Resources\DoctorResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

final class RegisterDoctorController extends Controller
{
    public function __invoke(RegisterDoctorRequest $request, RegisterDoctor $registerDoctor): JsonResponse
    {
        $doctor = $registerDoctor->execute(new RegisterDoctorInput(
            name: $request->string('name')->toString(),
            specialty: $request->string('specialty')->toString(),
            licenseNumber: $request->string('license_number')->toString(),
            clinicId: $request->input('clinic_id'),
        ));

        return (new DoctorResource($doctor))
            ->response()
            ->setStatusCode(201);
    }
}
