<?php

namespace App\Http\Resources;

use App\Models\Mechanic;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Mechanic
 */
class MechanicBasketResource extends JsonResource
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
            'name' => $this->User->name,
            'stable_location' => $this->stable_location,
            'mobile_location' => $this->mobile_location,
            'pelak' => $this->pelak,
            'type_vehicle' => $this->type_vehicle
        ];
    }
}
