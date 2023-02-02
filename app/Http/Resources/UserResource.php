<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'national_identity' => $this->national_identity,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'gender' => $this->gender,
            'detail_address' => @$this->Useraddress ? $this->Useraddress->detail_address : null ,
            'city_id' => @$this->Useraddress ? $this->Useraddress->city_id : null ,
            'province_id' => @$this->Useraddress ? $this->Useraddress->province_id : null ,
        ];
    }
}
