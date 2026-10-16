<?php

declare(strict_types=1);

namespace App\Contexts\Identity\Interfaces\Http\Resources;

use App\Contexts\Identity\Application\Dto\UserData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin UserData
 */
final class UserResource extends JsonResource
{
    /**
     * @return array<string, string|null>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->emailVerifiedAt,
        ];
    }
}
