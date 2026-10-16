<?php

declare(strict_types=1);

namespace App\Contexts\Payment\Domain\Entity;

use App\Contexts\Payment\Domain\Event\PaymentCreated;
use App\Contexts\Payment\Domain\Exception\InvalidPaymentAmountException;
use App\Contexts\Payment\Domain\ValueObject\PaymentId;
use App\Contexts\Payment\Domain\ValueObject\PaymentStatus;
use App\Contexts\Shared\Domain\Event\RecordsDomainEvents;

/**
 * Payment aggregate root.
 *
 * Pure PHP — no Laravel dependencies.
 */
final class Payment
{
    use RecordsDomainEvents;

    private function __construct(
        private PaymentId $id,
        private float $amount,
        private string $currency,
        private PaymentStatus $status,
        private ?string $gatewayReference,
    ) {}

    public static function initiate(
        PaymentId $id,
        float $amount,
        string $currency,
        ?string $gatewayReference,
    ): self {
        if ($amount <= 0) {
            throw new InvalidPaymentAmountException($amount);
        }

        $payment = new self($id, $amount, strtoupper($currency), PaymentStatus::Pending, $gatewayReference);
        $payment->record(new PaymentCreated($id, $amount, strtoupper($currency)));

        return $payment;
    }

    /**
     * Rebuild a payment from persistence without recording domain events.
     */
    public static function reconstitute(
        PaymentId $id,
        float $amount,
        string $currency,
        PaymentStatus $status,
        ?string $gatewayReference,
    ): self {
        return new self($id, $amount, $currency, $status, $gatewayReference);
    }

    public function markPaid(): void
    {
        $this->status = PaymentStatus::Paid;
    }

    public function markFailed(): void
    {
        $this->status = PaymentStatus::Failed;
    }

    public function id(): PaymentId
    {
        return $this->id;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function status(): PaymentStatus
    {
        return $this->status;
    }

    public function gatewayReference(): ?string
    {
        return $this->gatewayReference;
    }
}
