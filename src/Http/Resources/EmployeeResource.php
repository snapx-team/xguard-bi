<?php

namespace Xguard\BusinessIntelligence\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'role' => $this->role,
            'createdAt' => $this->created_at,
            'user' => new UserResource($this->whenLoaded('user'))
        ];
    }
}
