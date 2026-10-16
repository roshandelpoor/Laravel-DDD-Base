<?php

declare(strict_types=1);

namespace App\Contexts\Doctor\Interfaces\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class RegisterDoctorRequest extends FormRequest
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
            'specialty' => ['required', 'string', 'max:255'],
            'license_number' => ['required', 'string', 'max:50'],
            'clinic_id' => ['nullable', 'uuid'],
        ];
    }
}
