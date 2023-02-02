<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Rent
 *
 * @property int $id
 * @property string $source
 * @property string $destination
 * @property int $basket_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Basket $Basket
 * @property-read \App\Models\Price|null $price
 * @method static \Illuminate\Database\Eloquent\Builder|Rent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rent query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rent whereBasketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rent whereDestination($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rent whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rent whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $distance_km
 * @method static \Illuminate\Database\Eloquent\Builder|Rent whereDistanceKm($value)
 */
class Rent extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function price()
    {
        return $this->morphOne(Price::class, 'priceable');
    }

    public function Basket()
    {
        return $this->belongsTo(Basket::class);
    }

}
