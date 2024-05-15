<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at ? $this->created_at->format('d M Y H:i') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('d M Y H:i') : null,
            // 'dfh_created_at' => $this->created_at ? $this->created_at->diffForHumans() : null,
            // 'dfh_updated_at' => $this->updated_at ? $this->updated_at->diffForHumans() : null,
        ];
    }
}
