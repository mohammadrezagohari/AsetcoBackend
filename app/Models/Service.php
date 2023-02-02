<?php

namespace App\Models;

use App\Scopes\TakeLastScope;
use Database\Factories\ServiceFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Service
 *
 * @property int $id
 * @property string $subject
 * @property string $description
 * @property float $price
 * @property int $car_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Car $Car
 * @property-read Collection|Mechanic[] $MechanicOwn
 * @property-read int|null $mechanic_own_count
 * @property-read Collection|Mechanic[] $Mechanics
 * @property-read int|null $mechanics_count
 * @property-read Collection|Order[] $Orders
 * @property-read int|null $orders_count
 * @method static Builder|Service newModelQuery()
 * @method static Builder|Service newQuery()
 * @method static \Illuminate\Database\Query\Builder|Service onlyTrashed()
 * @method static Builder|Service query()
 * @method static Builder|Service whereCarId($value)
 * @method static Builder|Service whereCreatedAt($value)
 * @method static Builder|Service whereDeletedAt($value)
 * @method static Builder|Service whereDescription($value)
 * @method static Builder|Service whereId($value)
 * @method static Builder|Service wherePrice($value)
 * @method static Builder|Service whereSubject($value)
 * @method static Builder|Service whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Service withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Service withoutTrashed()
 * @mixin Eloquent
 * @method static ServiceFactory factory(...$parameters)
 * @property-read Collection|Mechanicrequest[] $Mechanicrequests
 * @property-read int|null $mechanicrequests_count
 * @property-read Collection|Userrequest[] $Userrequests
 * @property-read int|null $userrequests_count
 * @property int $servicecategory_id
 * @property int $carmodel_id
 * @property-read Collection|\App\Models\Basket[] $Baskets
 * @property-read int|null $baskets_count
 * @property-read \App\Models\Carmodel $Carmodel
 * @property-read \App\Models\Servicecategory $Servicecategory
 * @method static Builder|Service whereCarmodelId($value)
 * @method static Builder|Service whereServicecategoryId($value)
 * @property-read mixed $where_in_service
 * @property-read string $name
 * @property-read int|null $price_count
 */
class Service extends Model
{
    use HasFactory;
    use SoftDeletes;

    /************
     * @var array
     */
    protected $guarded = [];

    #region Relationship

    /************
     * @return BelongsToMany
     */
    public function Mechanics()
    {
        return $this->belongsToMany(Mechanic::class)->withPivot(["price", "status"]);
    }


    /***************
     * @return BelongsToMany
     */
    public function Baskets()
    {
        return $this->belongsToMany(Basket::class)->withPivot(["status"]);
    }

    /*************
     * @return BelongsTo
     */
    public function Carmodel()
    {
        return $this->belongsTo(Carmodel::class);
    }

    /***********
     * @return BelongsToMany
     */
    public function MechanicOwn()
    {
        return $this->belongsToMany(Mechanic::class, 'preinvoices', 'mechanic_id');
    }

    /**************
     * @return HasMany
     */
    public function Userrequests(): HasMany
    {
        return $this->hasMany(Userrequest::class);
    }

    /*****************
     * @return BelongsTo
     */
    public function Servicecategory(): BelongsTo
    {
        return $this->belongsTo(Servicecategory::class);
    }

    public function price()
    {
        return $this->morphMany(Price::class, 'priceable');
    }



    #endregion
    ////////////////////////////////////////////// Methods list //////////////////////////////////////////////
    ///
    /*********
     * @return \Illuminate\Database\Query\Builder
     */
    public static function giveLastItems()
    {
        return self::orderByDesc("id")->take(5);
    }

    /************
     * @param $car
     *
     * @return Service|Builder|\Illuminate\Database\Query\Builder
     */
    public static function giveLastItemsWithCar($car)
    {
        return self::where('brand', 'like', '%' . $car . '%')
            ->orWhere('model', 'like', '%' . $car . '%')
            ->orderByDesc("id")->take(5);
    }

    /***************
     * @param $service
     *
     * @return Service|Builder|\Illuminate\Database\Query\Builder
     */
    public static function giveLastItemsWithService($service)
    {
        return self::where('subject', 'like', '%' . $service . '%')
            ->orderByDesc("id")->take(5);
    }

    /***************
     * @param $service
     *
     * @return Service|Builder|Model|object|null
     */
    public static function findByName($service)
    {
        return self::where('subject', 'like', '%' . $service . '%')->first();
    }

    public static function calculatePrice($collectionService)
    {
        return self::whereIn('id', $collectionService)->sum('price');
    }

    /*********************
     * @param $ids
     * @return Service|\Illuminate\Database\Query\Builder
     */
    public function getWhereInServiceAttribute($ids)
    {
        return $this->whereIn('id', $ids);
    }

    public function getNameAttribute(): string
    {
        return $this->subject;
    }
    ///
    ////////////////////////////////////////////////////////////////////////////////////

}
