<?php

declare(strict_types=1);

namespace App\Contexts\Doctor\Interfaces\Http\Controllers;

use App\Contexts\Doctor\Application\Dto\GetDoctorInput;
use App\Contexts\Doctor\Application\UseCase\GetDoctor;
use App\Contexts\Doctor\Interfaces\Http\Resources\DoctorResource;
use App\Http\Controllers\Controller;

final class GetDoctorController extends Controller
{
    public function __invoke(string $id, GetDoctor $getDoctor): DoctorResource
    {
        return new DoctorResource($getDoctor->execute(new GetDoctorInput($id)));
    }
}
