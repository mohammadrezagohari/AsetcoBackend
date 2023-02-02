<?php

namespace App\Models;

use App\Enums\LocationType;
use Database\Factories\MechanicFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Mechanic
 *
 * @property int $id
 * @property string $type
 * @property string|null $full_name
 * @property int|null $parts_supplier
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $gender
 * @property int|null $supplier
 * @property string|null $license
 * @property string|null $identity_number
 * @property string|null $email
 * @property int $activated
 * @property string|null $type_vehicle
 * @property string|null $pelak
 * @property int|null $count_available
 * @property int $user_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Basket[] $Baskets
 * @property-read int|null $baskets_count
 * @property-read Collection|Location[] $Locations
 * @property-read int|null $locations_count
 * @property-read Mechanicaddress|null $MechanicAddress
 * @property-read Collection|Rate[] $Rates
 * @property-read int|null $rates_count
 * @property-read Collection|Service[] $ServiceOwn
 * @property-read int|null $service_own_count
 * @property-read Collection|Service[] $Services
 * @property-read int|null $services_count
 * @property-read Car|null $carable
 * @property-read Collection|Dailywork[] $dailyworks
 * @property-read int|null $dailyworks_count
 * @property-read mixed $mobile_location
 * @property-read mixed $stable_location
 * @property-read Collection|Car[] $supportedBrands
 * @property-read int|null $supported_brands_count
 * @method static MechanicFactory factory(...$parameters)
 * @method static Builder|Mechanic newModelQuery()
 * @method static Builder|Mechanic newQuery()
 * @method static \Illuminate\Database\Query\Builder|Mechanic onlyTrashed()
 * @method static Builder|Mechanic query()
 * @method static Builder|Mechanic whereActivated($value)
 * @method static Builder|Mechanic whereCountAvailable($value)
 * @method static Builder|Mechanic whereCreatedAt($value)
 * @method static Builder|Mechanic whereDeletedAt($value)
 * @method static Builder|Mechanic whereEmail($value)
 * @method static Builder|Mechanic whereFullName($value)
 * @method static Builder|Mechanic whereGender($value)
 * @method static Builder|Mechanic whereId($value)
 * @method static Builder|Mechanic whereIdentityNumber($value)
 * @method static Builder|Mechanic whereLicense($value)
 * @method static Builder|Mechanic whereName($value)
 * @method static Builder|Mechanic wherePartsSupplier($value)
 * @method static Builder|Mechanic wherePelak($value)
 * @method static Builder|Mechanic wherePhone($value)
 * @method static Builder|Mechanic whereSupplier($value)
 * @method static Builder|Mechanic whereType($value)
 * @method static Builder|Mechanic whereTypeVehicle($value)
 * @method static Builder|Mechanic whereUpdatedAt($value)
 * @method static Builder|Mechanic whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Mechanic withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Mechanic withoutTrashed()
 * @mixin Eloquent
 * @property-read \App\Models\User $User
 * @property-read Model|\Eloquent $Wallet
 */
class Mechanic extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $fillable = [
        'type',
        'full_name',
        'parts_supplier',
        'name',
        'phone',
        'gender',
        'supplier',
        'license',
        'identity_number',
        'email',
        'activated',
        'type_vehicle',
        'pelak',
        'count_available',
        'user_id',
    ];
    protected $table = "mechanics";

    #region Relationship  /*************** this part of related to others tables **********/

    public function Baskets(): BelongsToMany
    {
        return $this->belongsToMany(Basket::class)->withPivot(["status"]);
    }


    /**********
     *  Relations for address
     *
     */

    public function MechanicAddress(): HasOne
    {
        return $this->hasOne(Mechanicaddress::class);
    }

    /*****************
     * Relation to User Model
     * @return BelongsTo
     */
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**********
     *  Relations for Car
     *
     */
    public function carable()
    {
        return $this->morphOne(Car::class, 'carable');
    }

    /**********
     *  Relations for Daily work
     *
     */
    public function dailyworks()
    {
        return $this->hasMany(Dailywork::class);
    }

    /**********
     *  Relations for Services
     *
     */
    public function Services()
    {
        return $this->belongsToMany(Service::class)->withPivot(["id", "price", "status"]);
    }

    /***************
     * @return BelongsToMany
     */
    public function ServiceOwn()
    {
        return $this->belongsToMany(Service::class, 'preinvoices', 'service_id');
    }

    /******************
     * @return HasMany
     * each mechanic has many rates
     */
    public function Rates()
    {
        return $this->hasMany(Rate::class);
    }

    /********
     * each mechanic can location fix and mobile
     */
    public function Locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    /********
     * specifies the supported brands of the mechanic
     */
    public function supportedBrands(): BelongsToMany
    {
        return $this->belongsToMany(Car::class);
    }

//    /***********************************
//     * کیف پول
//     */
//    public function Wallet()
//    {
//        return $this->morphOne(Wallet::class,'walletable');
//    }

    #endregion

    #region Methods /*** Query Methods **/
    /////////////////////////////////
    ///
    ///     Query Methods
    ///
    public static function findByName($mechanic)
    {
        return self::whereName('%' . $mechanic . '%')->orderByDesc('id')->take(10);
    }

    public static function findByPhone($phone)
    {
        return self::wherePhone($phone);
    }

    public static function findByType($type)
    {
        return self::whereType($type);
    }

    public static function findByTypeVehicle($TypeVehicle)
    {
        return self::whereTypeVehicle($TypeVehicle);
    }

    public static function IsActivated($status)
    {
        return self::whereActivated($status);
    }

    public function getStableLocationAttribute()
    {
        return $this->Locations()->firstWhere('type', LocationType::STABLE);
    }

    public function getMobileLocationAttribute()
    {
        return $this->Locations()->firstWhere('type', LocationType::MOBILE);
    }
//
//    public function getSumPriceAttribute()
//    {
//        return $this->withPivot(["price", "status"])->wherePivot('status', '=', 0)->sum('basket_service.price')
//    }

    public static function CanRepairCar($mechanic, $count)
    {
        return self::whereId($mechanic)->where('activated', true)->where('count_available', '>', $count);
    }


    ///
    ///
    ///
    /////////////////////////////////////////
    #endregion
}
