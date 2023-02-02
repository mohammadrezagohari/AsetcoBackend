<?php

namespace App\Http\Resources;

use App\Models\Basket;
use Hekmatinasser\Verta\Verta;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use Carbon\Carbon;

/**
 * @mixin Basket
 */
class LastRequestMechanicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $v = new Verta($this->created_at);
        return [
            "id" => $this->id,
            "status" => $this->status,
            "user_mobile" => $this->User->mobile,
            "request_full_name" => $this->User->full_name,
            "type" => $this->mechanic_type,
            "carmodel" => $this->Carmodel->name,
            "latitude" => @$this->latitude ? $this->latitude : null,
            "longitude" => @$this->longitude ? $this->longitude : null,
            "save_step" => $this->save_step,
            "create_date" => $v->format('Y/n/j'),
            "create_time" => $v->format('H:i')
        ];
    }
}
