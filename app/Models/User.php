<?php

namespace App\Models;

use App\Enums\Gender;
use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Plank\Mediable\Exceptions\MediaUrlException;
use Plank\Mediable\Media;
use Plank\Mediable\Mediable;
use Plank\Mediable\MediableCollection;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string $mobile
 * @property int $activated
 * @property string $national_identity
 * @property string $gender
 * @property string $password
 * @property int|null $addressbar_id
 * @property string|null $remember_token
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Useraddress|null $addressbar
 * @property-read Collection|Media[] $media
 * @property-read int|null $media_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static MediableCollection|static[] all($columns = ['*'])
 * @method static UserFactory factory(...$parameters)
 * @method static MediableCollection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereActivated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddressbarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereHasMedia($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereHasMediaMatchAll(array $tags)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNationalIdentity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withMedia($tags = [], bool $matchAll = false, bool $withVariants = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User withMediaAndVariants($tags = [], bool $matchAll = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User withMediaAndVariantsMatchAll($tags = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User withMediaMatchAll(bool $tags = [], bool $withVariants = false)
 * @method static Builder|User withTrashed()
 * @method static Builder|User withoutTrashed()
 * @mixin Eloquent
 * @method static create(array $input)
 * @method static paginate(int $int)
 * @method static first(): self
 * @method static latest()
 * @property-read Collection|Car[] $Cars
 * @property-read int|null $cars_count
 * @property-read Useraddress|null $Useraddress
 * @property-read BankAccount|null $bank_account
 * @property-read Mechanic|null $mechanic
 * @property-read Collection|Role[] $roles
 * @property-read int|null $roles_count
 * @property-read Collection|VerificationCode[] $verificationCodes
 * @property-read int|null $verification_codes_count
 * @property-read Collection|Userrequest[] $Userrequests
 * @property-read int|null $userrequests_count
 * @property-read mixed $avatar
 * @property-read Collection|Comment[] $Comments
 * @property-read int|null $comments_count
 * @property-read Collection|Rate[] $Rates
 * @property-read int|null $rates_count
 * @property-read Userlocation $Userlocation
 * @property-read Collection|Yourcar[] $YourCars
 * @property-read int|null $your_cars_count
 * @property-read Collection|Basket[] $Baskets
 * @property-read int|null $baskets_count
 * @property-read Collection|Invite[] $Invites
 * @property-read int|null $invites_count
 * @property-read Model|Eloquent $Wallet
 * @property-read Collection|\App\Models\Room[] $rooms
 * @property-read int|null $rooms_count
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Mediable, SoftDeletes;

    #region properties /****** properties such as fillable and hidden and ... ******/

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'activated',
        'national_identity',
        'gender',
        'password',
        'detail_address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $appends = [
        'avatar',
    ];


    #endregion

    #region Relationship /********** this model related to other model *********/
    public function Comments()
    {
        return $this->hasMany(Comment::class);
    }


    /****************
     * @return HasMany
     * Relations for your select cars
     */
    public function YourCars()
    {
        return $this->hasMany(Yourcar::class);
    }

    /****************
     * @return HasOne
     * Relations for address
     */
    public function Useraddress()
    {
        return $this->hasOne(Useraddress::class);
    }


    /*************************
     * @return HasOne
     *
     * Relations for Mechanic
     */
    public function mechanic(): HasOne
    {
        return $this->hasOne(Mechanic::class);
    }

    /*********************
     * @return HasOne
     * Relations for Bank Account
     */
    public function bank_account(): HasOne
    {
        return $this->hasOne(BankAccount::class);
    }

    /****************************
     * @return BelongsToMany
     *  Relations for Bank Account
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /***************
     * @return HasMany
     *  Relations for Verification Code
     */
    public function verificationCodes(): HasMany
    {
        return $this->hasMany(VerificationCode::class);
    }

    /**************
     * @return HasMany
     *
     */
    public function Userrequests(): HasMany
    {
        return $this->hasMany(Userrequest::class);
    }

    /****************
     * @return HasMany
     * each user has many rates.
     * نظر یا درجه کاربر به مکانیکی
     */
    public function Rates()
    {
        return $this->hasMany(Rate::class);
    }

    /********************
     * @return HasMany
     * relation to the user basket
     * سبد خرید
     */
    public function Baskets()
    {
        return $this->hasMany(Basket::class);
    }

    /***********************
     * @return HasMany
     * دعوتی ها
     */
    public function Invites(): HasMany
    {
        return $this->hasMany(Invite::class);
    }

    /************
     * @return HasOne
     * کیف پول من
     */
    public function Wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    /***********************
     * @return HasMany
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    #endregion

    #region methods /******** methods action in this model ****/
    /***************
     * @param string $permission
     * @return bool
     */
    public function able(string $permission): bool
    {
        $role = $this->roles()->wherePivot('selected', true)->first();

        if (!$role->toArray())
            return false;
        if ($role->permissions()->where('permissions.name', $permission)->exists())
            return true;

        return false;
    }

    /***************
     * @return string
     * @throws MediaUrlException
     */
    public function getAvatarAttribute()
    {
        $media = $this->firstMedia('avatar');
        if (!$media)
            return '';

        return $media->getUrl();

    }

    /*****************
     * @param $roles
     * @return BelongsToMany
     */
    public function checkedHasAnyRole($roles)
    {
        return self::roles()->whereIn("name", $roles);
    }


    public function routeNotificationForKavenegar($driver, $notification = null)
    {
        return $this->mobile;
    }

    #endregion
}
