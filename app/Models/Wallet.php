<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Wallet
 *
 * @property int $id
 * @property float $amount
 * @property int $has_credit
 * @property int $walletable_id
 * @property string $walletable_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Wallet newModelQuery()
 * @method static Builder|Wallet newQuery()
 * @method static Builder|Wallet query()
 * @method static Builder|Wallet whereAmount($value)
 * @method static Builder|Wallet whereCreatedAt($value)
 * @method static Builder|Wallet whereHasCredit($value)
 * @method static Builder|Wallet whereId($value)
 * @method static Builder|Wallet whereUpdatedAt($value)
 * @method static Builder|Wallet whereWalletableId($value)
 * @method static Builder|Wallet whereWalletableType($value)
 * @mixin Eloquent
 * @property-read Model|Eloquent $Walletable
 * @property float $bonus
 * @method static Builder|Wallet whereBonus($value)
 * @property int $user_id
 * @property-read User $User
 * @method static Builder|Wallet whereUserId($value)
 * @property-read Collection|Payment[] $Payments
 * @property-read int|null $payments_count
 */
class Wallet extends Model
{
    use HasFactory;

    protected $guarded = [];

    /******************************
     * @return BelongsTo
     * کیف پول متعلق به این کاربر هست
     */
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /***********************
     * پرداختی های این کیف پول
     */
    public function Payments()
    {
        return $this->hasMany(Payment::class);
    }

}
