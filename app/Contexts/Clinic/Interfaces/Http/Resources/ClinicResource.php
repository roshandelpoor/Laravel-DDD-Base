<?php

declare(strict_types=1);

namespace App\Contexts\Clinic\Interfaces\Http\Resources;

use App\Contexts\Clinic\Application\Dto\ClinicData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ClinicData
 */
final class ClinicResource extends JsonResource
{
    /**
     * @return array<string, string>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
        ];
    }
}
