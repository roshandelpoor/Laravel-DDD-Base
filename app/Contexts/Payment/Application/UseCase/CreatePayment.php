<?php

declare(strict_types=1);

namespace App\Contexts\Payment\Application\UseCase;

use App\Contexts\Payment\Application\Dto\CreatePaymentInput;
use App\Contexts\Payment\Application\Dto\PaymentData;
use App\Contexts\Payment\Domain\Entity\Payment;
use App\Contexts\Payment\Domain\Repository\PaymentRepository;
use App\Contexts\Payment\Domain\Service\PaymentGateway;
use App\Contexts\Payment\Domain\ValueObject\PaymentId;
use App\Contexts\Shared\Domain\Event\DomainEventDispatcher;

/**
 * Use case: initiate a payment through the gateway and persist it.
 */
final readonly class CreatePayment
{
    public function __construct(
        private PaymentRepository $payments,
        private PaymentGateway $gateway,
        private DomainEventDispatcher $events,
    ) {}

    public function execute(CreatePaymentInput $input): PaymentData
    {
        $id = PaymentId::generate();
        $reference = $this->gateway->charge($id, $input->amount, $input->currency);

        $payment = Payment::initiate($id, $input->amount, $input->currency, $reference);

        $this->payments->save($payment);
        $this->events->dispatch(...$payment->pullDomainEvents());

        return PaymentData::fromEntity($payment);
    }
}
