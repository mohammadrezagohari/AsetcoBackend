<?php

namespace App\Http\Resources;

use App\Models\Mechanic;
use Illuminate\Http\Resources\Json\JsonResource;

class FactorResource extends JsonResource
{
    public static $mechanic = null;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "service_id" => $this->id,
            "subject" => $this->subject,
            "category_id" => $this->servicecategory_id,
            "category" => $this->Servicecategory->category,
            "currentPrice" => @Mechanic::whereId(self::$mechanic)->first()->Services()
                ->where('service_id', '=', $this->id)
                ->where('mechanic_id', '=', self::$mechanic)
                ->count() ? Mechanic::whereId(self::$mechanic)->first()->Services()
                ->where('service_id', '=', $this->id)
                ->where('mechanic_id', '=', self::$mechanic)
                ->first()->pivot->price : $this->price,
            "price" => $this->price,
        ];
    }
}
