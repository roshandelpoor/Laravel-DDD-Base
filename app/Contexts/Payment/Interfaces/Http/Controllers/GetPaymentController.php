<?php

declare(strict_types=1);

namespace App\Contexts\Payment\Interfaces\Http\Controllers;

use App\Contexts\Payment\Application\Dto\GetPaymentInput;
use App\Contexts\Payment\Application\UseCase\GetPayment;
use App\Contexts\Payment\Interfaces\Http\Resources\PaymentResource;
use App\Http\Controllers\Controller;

final class GetPaymentController extends Controller
{
    public function __invoke(string $id, GetPayment $getPayment): PaymentResource
    {
        return new PaymentResource($getPayment->execute(new GetPaymentInput($id)));
    }
}
