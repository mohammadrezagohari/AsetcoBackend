<?php

namespace App\Http\Resources;

use App\Models\Service;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Service
 */
class MechanicServiceResource extends JsonResource
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
        'id'     =>$this->id,
        'name'   =>$this->name,
        'price'  => $this->price,
        'mechanicPrice'  => $this->pivot->price,

    ];
    }
}
