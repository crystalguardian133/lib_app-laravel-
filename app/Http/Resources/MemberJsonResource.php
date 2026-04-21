<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class MemberJsonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'full_name' => trim(implode(' ', array_filter([
                $this->first_name,
                ($this->middle_name && $this->middle_name !== 'null') ? $this->middle_name : null,
                $this->last_name,
            ]))),
            'member_since' => $this->memberdate,
            'photo_url' => $this->photo
                ? URL::to('/resource/member_images/' . $this->photo)
                : null,
            'email_verified' => (bool) $this->email_verified,
            'phone_verified' => (bool) $this->phone_verified,
        ];
    }
}
