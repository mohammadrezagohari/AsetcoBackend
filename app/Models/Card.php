<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*********************
 * @Card Card
 * کارت بانکی
 */
/**
 * App\Models\Card
 *
 * @property int $id
 * @property string $card_number
 * @property string $bank_name
 * @property string $full_name
 * @property int $user_id
 * @property int $payment_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Payment $Payment
 * @property-read \Plank\Mediable\MediableCollection|\App\Models\User[] $User
 * @property-read int|null $user_count
 * @method static \Illuminate\Database\Eloquent\Builder|Card newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Card newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Card query()
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereCardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereUserId($value)
 * @mixin \Eloquent
 */
class Card extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function User()
    {
        return $this->hasMany(User::class);
    }
}
