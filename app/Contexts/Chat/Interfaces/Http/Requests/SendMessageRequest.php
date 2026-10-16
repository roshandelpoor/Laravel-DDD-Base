<?php

declare(strict_types=1);

namespace App\Contexts\Chat\Interfaces\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class SendMessageRequest extends FormRequest
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
            'sender_id' => ['required', 'uuid'],
            'recipient_id' => ['required', 'uuid', 'different:sender_id'],
            'body' => ['required', 'string', 'max:5000'],
        ];
    }
}
