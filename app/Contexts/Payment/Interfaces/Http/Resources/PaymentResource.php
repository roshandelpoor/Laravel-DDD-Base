<?php

declare(strict_types=1);

namespace App\Contexts\Payment\Interfaces\Http\Resources;

use App\Contexts\Payment\Application\Dto\PaymentData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PaymentData
 */
final class PaymentResource extends JsonResource
{
    /**
     * @return array<string, string|float|null>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'status' => $this->status,
            'gateway_reference' => $this->gatewayReference,
        ];
    }
}
