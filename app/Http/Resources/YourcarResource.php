<?php

namespace App\Http\Resources;

use App\Models\Yourcar;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Yourcar
 */
class YourcarResource extends JsonResource
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
            'id'    => $this->id,
            'carmodel_id' => $this->Carmodel->id,
            'car_id' => $this->Carmodel->Car->id,
            'year_id' => $this->year->id,
            'model' => $this->Carmodel->name,
            'color' => $this->Color->name,
            'color_id' => $this->Color->id,
            'pelak' => $this->pelak,
            'shasi' => $this->shasi,
            'brand' => $this->Carmodel->Car->name,
            'year'  => $this->year->name,
        ];
    }
}
