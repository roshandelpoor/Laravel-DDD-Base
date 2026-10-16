<?php

declare(strict_types=1);

namespace App\Contexts\Clinic\Interfaces\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class RegisterClinicRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'phone' => ['required', 'string', 'max:20'],
        ];
    }
}
