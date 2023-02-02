<?php

namespace App\Http\Resources;

use App\Enums\BasketStatusOrder;
use App\Models\Basket;
use App\Models\Mechanic;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @mixin Mechanic
 */
class MechanicOutResource extends JsonResource
{
    public static $currentServices = null;
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    static $currentService = null;
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'count_available' => $this->count_available,
            'currentServices' => self::$currentService ? MechanicServiceResource::collection($this->Services->whereIn('id', self::$currentService)) : null,
//            'count_can_do' => ($this->count_available - ($this->MechanicRequests()->where('mechanic_id','=',$this->id)->where('status','=',BasketStatusOrder::WORK)->count())),
        ];
    }
}
