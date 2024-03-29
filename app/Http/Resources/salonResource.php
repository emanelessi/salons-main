<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class salonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'seats_number' => $this->seats_number,
            'is_active' => $this->is_active,
            'is_online' => $this->is_online,
        ];
    }
}
