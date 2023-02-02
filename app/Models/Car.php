<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Car
 *
 * @property int $id
 * @property string $brand
 * @property string $model
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Mechanic[] $Mechanics
 * @property-read int|null $mechanics_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $Orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Service[] $Services
 * @property-read int|null $services_count
 * @method static \Illuminate\Database\Eloquent\Builder|Car newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Car newQuery()
 * @method static \Illuminate\Database\Query\Builder|Car onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Car query()
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Car withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Car withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Plank\Mediable\MediableCollection|\App\Models\User[] $Users
 * @property-read int|null $users_count
 * @method static \Database\Factories\CarFactory factory(...$parameters)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Carmodel[] $CarModel
 * @property-read int|null $car_model_count
 * @property-read mixed $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Servicecategory[] $Servicecategories
 * @property-read int|null $servicecategories_count
 */
class Car extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function Users()
    {
        return $this->belongsToMany(User::class);
    }

    public function CarModel()
    {
        return $this->hasMany(Carmodel::class);
    }

    public function getNameAttribute()
    {
        return $this->brand;
    }

    /*****************
     * @return BelongsToMany
     */
    public function Servicecategories(): BelongsToMany
    {
        return $this->belongsToMany(Servicecategory::class);
    }

}
