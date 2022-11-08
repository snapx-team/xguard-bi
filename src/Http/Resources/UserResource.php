<?php

namespace Xguard\BusinessIntelligence\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->first_name,
            'fullName' => $this->full_name,
            'email' => $this->email,
            'language' => $this->locale,
        ];
    }
}
