<?php

namespace App\Http\Resources;

use App\Models\Service;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Service
 */
class FactoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $currentMechanic = null;

    public function toArray($request)
    {
        return [
            "service_id" => $this->id,
            "subject" => @$this->subject ? $this->subject : null,
            "category_id" => $this->servicecategory_id,
            "category" => $this->Servicecategory->category,
            "currentPrice" => $this->Mechanics()->wherePivot('mechanic_id', '=', self::$currentMechanic)->wherePivot('service_id', '=', $this->id)->count() ? $this->Mechanics()->wherePivot('mechanic_id', '=', self::$currentMechanic)->wherePivot('service_id', '=', $this->id)->first()->pivot->price : null,
            "price" => $this->price,
        ];
    }
}
