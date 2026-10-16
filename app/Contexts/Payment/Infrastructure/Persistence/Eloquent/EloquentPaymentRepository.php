<?php

declare(strict_types=1);

namespace App\Contexts\Payment\Infrastructure\Persistence\Eloquent;

use App\Contexts\Payment\Domain\Entity\Payment;
use App\Contexts\Payment\Domain\Repository\PaymentRepository;
use App\Contexts\Payment\Domain\ValueObject\PaymentId;
use App\Contexts\Payment\Domain\ValueObject\PaymentStatus;

/**
 * Eloquent adapter for the PaymentRepository port.
 */
final class EloquentPaymentRepository implements PaymentRepository
{
    public function findById(PaymentId $id): ?Payment
    {
        $model = PaymentEloquentModel::query()->find((string) $id);

        return $model ? $this->toDomain($model) : null;
    }

    public function save(Payment $payment): void
    {
        PaymentEloquentModel::query()->updateOrCreate(
            ['id' => (string) $payment->id()],
            [
                'amount' => $payment->amount(),
                'currency' => $payment->currency(),
                'status' => $payment->status()->value,
                'gateway_reference' => $payment->gatewayReference(),
            ],
        );
    }

    private function toDomain(PaymentEloquentModel $model): Payment
    {
        return Payment::reconstitute(
            id: new PaymentId((string) $model->getKey()),
            amount: (float) $model->amount,
            currency: $model->currency,
            status: PaymentStatus::from($model->status),
            gatewayReference: $model->gateway_reference,
        );
    }
}
