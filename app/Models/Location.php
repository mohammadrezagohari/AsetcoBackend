<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Location
 *
 * @property int $id
 * @property string $lat
 * @property string $lon
 * @property int $mechanic_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mechanic $Mechanic
 * @method static \Illuminate\Database\Eloquent\Builder|Location newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location query()
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereMechanicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $support_space
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereSupportSpace($value)
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|Location onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereType($value)
 * @method static \Illuminate\Database\Query\Builder|Location withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Location withoutTrashed()
 * @method static \Database\Factories\LocationFactory factory(...$parameters)
 */
class Location extends Model
{
    use HasFactory;
    use SoftDeletes;

//    protected $guarded = [];
    protected $fillable = [
        'lat', 'lon', 'support_space', 'mechanic_id', 'type'
    ];

    /***************
     * Mechanic relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Mechanic()
    {
        return $this->belongsTo(Mechanic::class);
    }

    /****************
     * @param $lat
     * @param $lon
     * @return Mechanicaddress|\Illuminate\Database\Query\Builder
     * it's find near location
     */
//    public static function findNearMechanic($lat, $lon)
//    {
//        return self::selectRaw("id, mechanic_id, type,support_space, lat, lon, SQRT(POW(69.1 * (lat - '" . $lat .
//            "'), 2) + POW(69.1 * ('" . $lon . "' - lon) * COS(lat / 57.3), 2)) AS distance ")
//            ->havingRaw('distance < 20')->orderBy('distance');
//
//    }
    public static function findNearMechanic($lat, $lon)
    {
        return self::selectRaw("mechanic_id, lat, lon,support_space, SQRT(POW(69.1 * (lat - '" . $lat .
            "'), 2) + POW(69.1 * ('" . $lon . "' - lon) * COS(lat / 57.3), 2)) AS distance ")
            ->havingRaw('distance < support_space')->orderBy('distance');
    }

    /****************
     * @param $lat
     * @param $lon
     * @return Mechanicaddress|\Illuminate\Database\Query\Builder
     * it's find near location
     */
    public static function findNearBetweenMechanic($mechanicIds, $lat, $lon)
    {
        return self::selectRaw("id, mechanic_id, type,support_space, lat, lon, SQRT(POW(69.1 * (lat - '" . $lat .
            "'), 2) + POW(69.1 * ('" . $lon . "' - lon) * COS(lat / 57.3), 2)) AS distance ")
            ->whereIn('id', $mechanicIds)
            ->havingRaw('distance < 20')->orderBy('distance');
    }


    public function findNearCarMechanic($lat, $lon)
    {
        return self::selectRaw("mechanic_id, lat, lon,support_space, SQRT(POW(69.1 * (lat - '" . $lat .
            "'), 2) + POW(69.1 * ('" . $lon . "' - lon) * COS(lat / 57.3), 2)) AS distance ")
            ->havingRaw('distance < support_space')->orderBy('distance');
    }
}
