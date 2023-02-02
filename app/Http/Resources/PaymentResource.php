<?php

namespace App\Http\Resources;

use App\Models\Payment;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/*******************
 * @mixin Payment
 */
class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'pay_status' => $this->status,
            'amount' => $this->amount,
            'user_id' => @$this->Wallet ? $this->Wallet->User->id : null,
            'card_bank_number' => @$this->Card ? $this->Card->card_number : null,
            'card_bank_name' => @$this->Card ? $this->Card->bank_name : null,
            'card_full_name' => @$this->Card ? $this->Card->full_name : null,

        ];
    }
}
