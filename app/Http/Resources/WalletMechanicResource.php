<?php

namespace App\Http\Resources;

use Hekmatinasser\Verta\Verta;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class WalletMechanicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $created = new Verta($this->created_at);
        return [
            'id' => $this->id,
            'amount' => $this->amount, //// پول قابل برداشت مکانیک
            'bonus' => $this->bonus, //// هدیه دریافتی غیرقابل برداشت به عنوان کاربر
            'sumPrice' => ($this->bonus + $this->amount), ///// مجموع پول برداشتی
            'hasCredit' => $this->has_credit,   //// برای چک کردن سریع که اعتبار دارد یا فاقد اعتبار است
            'userName' => $this->User->name,
            'userId' => $this->user_id,
            "create_date" => $created->format('Y/n/j'),
            "create_time" => $created->format('H:i'),
        ];
    }
}
