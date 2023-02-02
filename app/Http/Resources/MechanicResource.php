<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
/**
 * @mixin User
 */
class MechanicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name' => $this->name,
            'phone' => $this->mechanic ? $this->mechanic->phone: null,
            'full_name' => $this->mechanic ? $this->mechanic->full_name: null,
            'national_identity' => $this->national_identity,
            'gender' => $this->gender,
            'mobile' => $this->mobile,
            'detail_address' => $this->mechanic ? $this->mechanic->mechanicaddress->detail_address: null,
            'type_vehicle' => $this->mechanic ? $this->mechanic->type_vehicle: null,
            'license' => $this->mechanic ? $this->mechanic->license: null,
            'city_id' => $this->mechanic ? $this->mechanic->mechanicaddress->city_id: null,
            'province_id' => $this->mechanic ? $this->mechanic->mechanicaddress->province_id: null,
            'working_day' => $this->mechanic ? $this->mechanic->dailyworks: null,
            'supported_services' => $this->mechanic ? $this->mechanic->Services: null,
            'supported_brands'=> $this->mechanic ? $this->mechanic->supportedBrands: null,
            'pelak' => $this->mechanic ? $this->mechanic->pelak: null,
            'parts_supplier' => $this->mechanic? $this->mechanic->parts_supplier: null,
            'location' => $this->mechanic? $this->mechanic->stable_location: null,
        ];
    }
}
