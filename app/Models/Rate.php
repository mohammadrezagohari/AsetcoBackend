<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Rate
 *
 * @property-read \App\Models\Mechanic $Mechanic
 * @method static \Illuminate\Database\Eloquent\Builder|Rate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rate query()
 * @mixin \Eloquent
 * @property-read \App\Models\User $User
 * @property int $id
 * @property int $rate
 * @property int $user_id
 * @property int $mechanic_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereMechanicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Rate onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Rate withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Rate withoutTrashed()
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Rate whereDeletedAt($value)
 */
class Rate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    /******************
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * each rate for one mechanic
     */
    public function Mechanic()
    {
        return $this->belongsTo(Mechanic::class);
    }


    /****************
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * each user can have a rate for mechanic
     */
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    /*********************
     * @param $mechanic
     * @param $user
     * @return Rate|\Illuminate\Database\Eloquent\Builder
     * find rate for change value
     */
    public static function findForChange($mechanic, $user)
    {
        return self::whereMechanicId($mechanic)->where('user_id', '=', $user);
    }

    /****************
     * @param $mechanic_id
     * @return mixed
     * calculate rate for spacial mechanic
     */
    public static function calculateAverage($mechanic_id)
    {
        return self::whereMechanicId($mechanic_id)->avg('rate');
    }

    public function calculateAverageAttribute($mechanic_id)
    {
        return $this->where('mechanic_id', '=', $mechanic_id)->avg('rate');
    }

}


