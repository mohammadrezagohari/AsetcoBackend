<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MechanicTypeResource extends JsonResource
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
            'basket_id'=>$this->id,
            'mechanic_type' => $this->mechanic_type,
        ];
    }
}
