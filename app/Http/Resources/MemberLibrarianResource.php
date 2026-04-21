<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class MemberLibrarianResource extends JsonResource
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
            'full_name' => trim(implode(' ', array_filter([
                $this->first_name,
                ($this->middle_name && $this->middle_name !== 'null') ? $this->middle_name : null,
                $this->last_name,
            ]))),
            'memberdate' => $this->memberdate,
            'photo_url' => $this->photo
                ? URL::to('/resource/member_images/' . $this->photo)
                : null,
        ];
    }
}
