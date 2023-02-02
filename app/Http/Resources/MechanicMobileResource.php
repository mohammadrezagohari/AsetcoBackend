<?php

namespace App\Http\Resources;

use App\Models\Basket;
use Illuminate\Http\Resources\Json\JsonResource;

class MechanicMobileResource extends JsonResource
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
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'count_available' => $this->count_available,
            'count_can_do' => ($this->count_available - Basket::whereMechanicId($this->id)->count()),
        ];
    }
}
