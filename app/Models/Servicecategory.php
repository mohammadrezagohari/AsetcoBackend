<?php

namespace App\Models;

use Database\Factories\ServicecategoryFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Servicecategory
 *
 * @property int $id
 * @property string $category
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Service[] $Services
 * @property-read int|null $services_count
 * @method static ServicecategoryFactory factory(...$parameters)
 * @method static Builder|Servicecategory newModelQuery()
 * @method static Builder|Servicecategory newQuery()
 * @method static Builder|Servicecategory query()
 * @method static Builder|Servicecategory whereCategory($value)
 * @method static Builder|Servicecategory whereCreatedAt($value)
 * @method static Builder|Servicecategory whereId($value)
 * @method static Builder|Servicecategory whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|\App\Models\Car[] $Cars
 * @property-read int|null $cars_count
 * @property-read string $name
 */
class Servicecategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    /*************
     * @return HasMany
     */
    public function Services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /*************************
     * @return BelongsToMany
     */
    public function Cars(): BelongsToMany
    {
        return $this->belongsToMany(Car::class);
    }

    public function getNameAttribute(): string
    {
        return $this->category;
    }

}
