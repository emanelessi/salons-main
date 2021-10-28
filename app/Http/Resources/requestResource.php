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
//            'user_id'=>userResource::collection($this->name),
//            'salon_id'=>salonResource::collection($this->name),
//            'salon_seat_id'=>salonResource::collection($this->seats_number),

            'user_id'=>$this->user_id,
            'salon_id'=>$this->salon_id,
            'salon_seat_id'=>$this->salon_seat_id,
            'status'=>$this->status,
            'time'=>$this->time,

        ];
    }
}
