<?php

namespace App\Http\Resources;

use App\Models\Service;
use Illuminate\Http\Resources\Json\JsonResource;

/**********
 * @mixin Service
 */
class ServicesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'carmodel' => $this->Carmodel->name,
            'car_brand' => $this->Carmodel->Car->brand,
            'service_category_name' => $this->Servicecategory->category,
            'service_name' => $this->subject,
            'price' => $this->price,
            'your_price' => @$this->pivot->price ? $this->pivot->price : $this->price,
            //// اگر نبود همون پرایس پیش فرض اتحادیه رو بده
        ];
    }
}
