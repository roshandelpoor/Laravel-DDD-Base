<?php

declare(strict_types=1);

namespace App\Contexts\Payment\Application\UseCase;

use App\Contexts\Payment\Application\Dto\GetPaymentInput;
use App\Contexts\Payment\Application\Dto\PaymentData;
use App\Contexts\Payment\Domain\Exception\PaymentNotFoundException;
use App\Contexts\Payment\Domain\Repository\PaymentRepository;
use App\Contexts\Payment\Domain\ValueObject\PaymentId;

final readonly class GetPayment
{
    public function __construct(private PaymentRepository $payments) {}

    public function execute(GetPaymentInput $input): PaymentData
    {
        $id = new PaymentId($input->id);
        $payment = $this->payments->findById($id)
            ?? throw new PaymentNotFoundException($id);

        return PaymentData::fromEntity($payment);
    }
}
