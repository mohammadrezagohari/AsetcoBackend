<?php

namespace App\Http\Resources;

use App\Models\Rate;
use App\Models\Yourcar;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @property mixed $Mechanic
 * @property mixed $Basket
 */
class MechanicLocationResource extends JsonResource
{

    /*****************
     * @var $basket
     */
    protected $basket;

    /******************
     * @param $value
     * @return $this
     */
    public function basket($value): MechanicLocationResource
    {
        $this->basket = $value;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'basket' => $this->basket->id,
            'mechain_type' => $this->Mechanic->type_vehicle,
            'plaque' =>$this->Mechanic->pelak,
            'mechanic_id' => $this->mechanic_id,
            'latitude' => $this->lat,
            'longitude' => $this->lon,
            'full_name' => $this->Mechanic->full_name,
            'name' => $this->Mechanic->name,/////equal to mechanic's name
            'phone' => $this->Mechanic->phone,
            'rates' => Rate::calculateAverage($this->mechanic_id)
        ];
    }


}


