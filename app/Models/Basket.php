<?php

namespace App\Models;

use App\Enums\BasketStatusOrder;
use App\Enums\MechanicTypes;
use App\Enums\StatusMechanicRequest;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\Basket
 *
 * @property int $id
 * @property int|null $save_step
 * @property string $status
 * @property bool|null $i_know_problem
 * @property int $serve_product_by_mechanic
 * @property string $mechanic_type
 * @property int|null $problem_id
 * @property int|null $carmodel_id
 * @property int|null $user_id
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Carmodel|null $Carmodel
 * @property-read Collection|\App\Models\Mechanic[] $Mechanics
 * @property-read int|null $mechanics_count
 * @property-read Collection|\App\Models\Rent[] $Prices
 * @property-read int|null $prices_count
 * @property-read \App\Models\Problem|null $Problem
 * @property-read Collection|\App\Models\Product[] $Products
 * @property-read int|null $products_count
 * @property-read \App\Models\Rent|null $Rent
 * @property-read Collection|\App\Models\Service[] $Services
 * @property-read int|null $services_count
 * @property-read \App\Models\User|null $User
 * @method static Builder|Basket newModelQuery()
 * @method static Builder|Basket newQuery()
 * @method static Builder|Basket query()
 * @method static Builder|Basket whereCarmodelId($value)
 * @method static Builder|Basket whereCreatedAt($value)
 * @method static Builder|Basket whereDeletedAt($value)
 * @method static Builder|Basket whereIKnowProblem($value)
 * @method static Builder|Basket whereId($value)
 * @method static Builder|Basket whereLatitude($value)
 * @method static Builder|Basket whereLongitude($value)
 * @method static Builder|Basket whereMechanicType($value)
 * @method static Builder|Basket whereProblemId($value)
 * @method static Builder|Basket whereSaveStep($value)
 * @method static Builder|Basket whereServeProductByMechanic($value)
 * @method static Builder|Basket whereStatus($value)
 * @method static Builder|Basket whereUpdatedAt($value)
 * @method static Builder|Basket whereUserId($value)
 * @mixin Eloquent
 * @property-read mixed $mechanic
 * @property-read mixed $last_basket
 * @property-read mixed $check_has_mechanic_basket
 * @method static Builder|Basket checkHasMechanicBasket()
 * @method static Builder|Basket activeStatus()
 * @method static Builder|Basket typeMobile()
 * @property string|null $delivery_step
 * @property-read Collection|\App\Models\Transaction[] $Transactions
 * @property-read int|null $transactions_count
 * @method static Builder|Basket whereDeliveryStep($value)
 * @property int|null $kilometers
 * @property-read \App\Models\Room|null $room
 * @method static Builder|Basket whereKilometers($value)
 */
class Basket extends Model
{
    use HasFactory;

    protected $casts = [
        'i_know_problem' => 'boolean',
    ];
    protected $guarded = [];


    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            $model->room()->create();
        });
    }


    public function Reservation()
    {
        return $this->hasOne(Reservation::class);
    }

    /**********************
     * @return BelongsToMany
     *  Relations for Services
     * @var mixed
     */
    public function Services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class)->withPivot(["status"]);
    }

    /*********************
     * @return BelongsToMany
     *  Relations for Products
     */
    public function Products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /*****************
     * @return BelongsTo
     */
    public function Carmodel(): BelongsTo
    {
        return $this->belongsTo(Carmodel::class);
    }

    /******************
     * @return BelongsTo
     */
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*********************
     * @return BelongsTo
     */
    public function Problem(): BelongsTo
    {
        return $this->belongsTo(Problem::class);
    }

    /**********************
     * @return HasOne
     */
    public function Rent(): HasOne
    {
        return $this->hasOne(Rent::class);
    }

    /**********************
     * @return HasOne
     */
    public function room(): HasOne
    {
        return $this->hasOne(Room::class);
    }

    /***********************
     * @return HasMany
     */
    public function Transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /****************
     * @return HasMany
     */
    public function Prices(): HasMany
    {
        return $this->hasMany(Rent::class);
    }

    public function Mechanics()
    {
        return $this->belongsToMany(Mechanic::class)->withPivot(["status"]);
    }

    public function getBasket($mechanic)
    {
        return $this->where('id', '=', $mechanic)->whereIn('status', BasketStatusOrder::WORK)->whereDate('created_at', \Carbon\Carbon::today());
    }

    public function getMechanicAttribute()
    {
        return $this->Mechanics()->wherePivot('status', BasketStatusOrder::ACTIVE)->first();
    }

    /**************
     * @return Basket|Builder
     *
     */
    public static function checkMechanicHasThisBasket()
    {
        return self::where('mechanic_type', MechanicTypes::MOBILE)->where('status', '=', BasketStatusOrder::ACTIVE);
    }


    /***************
     * @param $query
     * @return mixed
     */
    public function scopeTypeMobile($query)
    {
        return $query->where('type', MechanicTypes::MOBILE);
    }

    /****************
     * @param $query
     * @return mixed
     */
    public static function scopeActiveStatus($query)
    {
        return $query->where('status', '=', BasketStatusOrder::ACTIVE);
    }

}
