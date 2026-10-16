<?php

declare(strict_types=1);

namespace App\Contexts\Doctor\Interfaces\Http\Resources;

use App\Contexts\Doctor\Application\Dto\DoctorData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin DoctorData
 */
final class DoctorResource extends JsonResource
{
    /**
     * @return array<string, string|null>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'specialty' => $this->specialty,
            'license_number' => $this->licenseNumber,
            'clinic_id' => $this->clinicId,
        ];
    }
}
