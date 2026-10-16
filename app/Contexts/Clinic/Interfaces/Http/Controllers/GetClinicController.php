<?php

declare(strict_types=1);

namespace App\Contexts\Clinic\Interfaces\Http\Controllers;

use App\Contexts\Clinic\Application\Dto\GetClinicInput;
use App\Contexts\Clinic\Application\UseCase\GetClinic;
use App\Contexts\Clinic\Interfaces\Http\Resources\ClinicResource;
use App\Http\Controllers\Controller;

final class GetClinicController extends Controller
{
    public function __invoke(string $id, GetClinic $getClinic): ClinicResource
    {
        return new ClinicResource($getClinic->execute(new GetClinicInput($id)));
    }
}
