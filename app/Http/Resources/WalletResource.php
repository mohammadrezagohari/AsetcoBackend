<?php

namespace App\Http\Resources;

use App\Models\Wallet;
use Hekmatinasser\Verta\Verta;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/********************
 * @mixin Wallet
 */
class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $created = new Verta($this->created_at);
        return [
            'id' => $this->id,
            'bonus' => $this->bonus, //// هدیه دریافتی غیرقابل برداشت به عنوان کاربر
            'hasCredit' => $this->has_credit,   //// برای چک کردن سریع که اعتبار دارد یا فاقد اعتبار است
            'userName' => $this->User->name,
            'user_id' => $this->user_id,
            "create_date" => $created->format('Y/n/j'),
            "create_time" => $created->format('H:i'),
        ];
    }
}
