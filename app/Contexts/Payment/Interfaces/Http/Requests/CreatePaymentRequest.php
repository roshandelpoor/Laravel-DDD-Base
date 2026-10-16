<?php

declare(strict_types=1);

namespace App\Contexts\Payment\Interfaces\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class CreatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'gt:0'],
            'currency' => ['required', 'string', 'size:3'],
        ];
    }
}
