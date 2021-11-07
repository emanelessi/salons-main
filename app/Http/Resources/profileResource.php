<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class profileResource extends JsonResource
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
            'name'=>$this->full_name,
            'email'=>$this->email,
            'photo'=>$this->photo,
        ];
    }
}
