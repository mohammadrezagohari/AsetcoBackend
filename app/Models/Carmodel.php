<?php

namespace App\Models;

use Database\Factories\CarmodelFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\Carmodel
 *
 * @property int $id
 * @property string $name
 * @property int $car_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Car $Car
 * @property-read Collection|Yourcar[] $YourCars
 * @property-read int|null $your_cars_count
 * @method static CarmodelFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Carmodel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Carmodel newQuery()
 * @method static Builder|Carmodel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Carmodel query()
 * @method static \Illuminate\Database\Eloquent\Builder|Carmodel whereCarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carmodel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carmodel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carmodel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carmodel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carmodel whereUpdatedAt($value)
 * @method static Builder|Carmodel withTrashed()
 * @method static Builder|Carmodel withoutTrashed()
 * @mixin Eloquent
 * @property-read Collection|Service[] $Services
 * @property-read int|null $services_count
 * @property-read Collection|Carmodel[] $Carmodels
 * @property-read int|null $carmodels_count
 */
class Carmodel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "carmodels";
    protected $guarded = [];

    /*****************
     * @return BelongsTo
     */
    public function Car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }


    public function Carmodels()
    {
        return $this->hasMany(Carmodel::class);
    }

    /*****************
     * @return HasMany
     */
    public function Services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /*****************
     * @return HasMany
     */
    public function YourCars(): HasMany
    {
        return $this->hasMany(Yourcar::class);
    }

}
