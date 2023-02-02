<?php

namespace App\Http\Resources;

use App\Models\Basket;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Basket
 */
class BasketResource extends JsonResource
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
        //// TODO: the laravel documentation write when you need to relational query in resource using with
        if (!isset($this->save_step)) return [
            'save_step' => 0,
        ];
        FactoryResource::$currentMechanic = self::$currentMechanic;
        FactorResource::$mechanic = $this->mechanic ? $this->mechanic->id : null;
        $v = new Verta($this->created_at);
        $arrive = new Verta($this->Reservation->date);

        return [
            'id' => $this->id,
            'save_step' => $this->save_step,
            'status' => $this->status,
            'user_name' => $this->User->name,
//            'status_request' => @$this->MechanicRequest != null ? $this->MechanicRequest->status : null,
            'i_know_problem' => $this->i_know_problem,
            'serve_product_by_mechanic' => $this->serve_product_by_mechanic,
            'mechanic_type' => $this->mechanic_type,/// default both of them equals to null
            'carmodel' => $this->Carmodel->name,
            'carbrand' => $this->Carmodel->Car->name,
            'carmodel_id' => $this->carmodel_id,
            'services' => $this->Services,
            'room' => @$this->room ? $this->room->room_id : null,
            'delivery_step' => $this->delivery_step,
            'mechanic' => $this->mechanic ? new MechanicBasketResource($this->mechanic) : null,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'date_arrive' => $arrive->format('Y/n/j'),
            'time_arrive' => $this->Reservation->time,
            'invoice_factor' => @$this->Services ? FactoryResource::collection($this->Services()->withPivot(["status"])->get()) : null,
            'factor' => @$this->mechanic ? FactorResource::collection($this->Services) : null,
            "create_date" => $v->format('Y/n/j'),
            "create_time" => $v->format('H:i'),
        ];
    }
}
