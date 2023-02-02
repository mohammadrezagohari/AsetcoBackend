<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $subject
 * @property float $price
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Attrproduct[] $Attrproducts
 * @property-read int|null $attrproducts_count
 * @property-read Collection|Order[] $Orders
 * @property-read int|null $orders_count
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static Builder|Product query()
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDeletedAt($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereSubject($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 * @mixin Eloquent
 * @method static ProductFactory factory(...$parameters)
 * @property int $carmodel_id
 * @property int $year_id
 * @method static Builder|Product whereCarmodelId($value)
 * @method static Builder|Product whereYearId($value)
 * @property-read Collection|\App\Models\Basket[] $Baskets
 * @property-read int|null $baskets_count
 */
class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    /******************
     * @return HasMany
     *
     * Attribute Products
     */
    public function Attrproducts(): HasMany
    {
        return $this->hasMany(Attrproduct::class);
    }


    /***************
     * @return BelongsToMany
     *
     * Attribute Baskets
     */
    public function Baskets(): BelongsToMany
    {
        return $this->belongsToMany(Basket::class);
    }
}
