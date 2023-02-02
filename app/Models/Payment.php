<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\Payment
 * پرداختی ها
 *
 * @property int $id
 * @property string $status
 * @property float $amount
 * @property int $wallet_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Wallet $Wallet
 * @method static Builder|Payment newModelQuery()
 * @method static Builder|Payment newQuery()
 * @method static Builder|Payment query()
 * @method static Builder|Payment whereAmount($value)
 * @method static Builder|Payment whereCreatedAt($value)
 * @method static Builder|Payment whereId($value)
 * @method static Builder|Payment whereStatus($value)
 * @method static Builder|Payment whereUpdatedAt($value)
 * @method static Builder|Payment whereWalletId($value)
 * @mixin Eloquent
 * @property-read \App\Models\Card|null $Card
 */
class Payment extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**************************
     * @return BelongsTo
     * کیف پول درخواست کننده پرداخت
     */
    public function Wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    /********************************
     * @return HasOne
     * کارت بانکی
     */
    public function Card(): HasOne
    {
        return $this->hasOne(Card::class);
    }
}
