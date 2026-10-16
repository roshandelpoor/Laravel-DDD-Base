<?php

declare(strict_types=1);

namespace App\Contexts\Payment\Interfaces\Http\Controllers;

use App\Contexts\Payment\Application\Dto\CreatePaymentInput;
use App\Contexts\Payment\Application\UseCase\CreatePayment;
use App\Contexts\Payment\Interfaces\Http\Requests\CreatePaymentRequest;
use App\Contexts\Payment\Interfaces\Http\Resources\PaymentResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

final class CreatePaymentController extends Controller
{
    public function __invoke(CreatePaymentRequest $request, CreatePayment $createPayment): JsonResponse
    {
        $payment = $createPayment->execute(new CreatePaymentInput(
            amount: (float) $request->input('amount'),
            currency: $request->string('currency')->toString(),
        ));

        return (new PaymentResource($payment))
            ->response()
            ->setStatusCode(201);
    }
}
