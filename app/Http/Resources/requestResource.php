<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class requestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'user'=>new userResource($this->User),
            'salon'=>new salonResource($this->Salon),
            'salon_seat'=>new salonSeatResource($this->SalonSeat),
            'status'=>$this->status,
            'time'=>$this->time,
        ];
    }
}
