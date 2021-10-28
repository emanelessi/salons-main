<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class salonSeatResource extends JsonResource
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
            'seat_number'=>$this->seat_number,
            'status'=>$this->status,
            'salon_id'=>$this->salon_id,

        ];
    }
}
