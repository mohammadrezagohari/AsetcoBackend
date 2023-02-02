<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Mechanicaddress
 *
 * @property int $id
 * @property string|null $street
 * @property string|null $alley
 * @property string|null $flat
 * @property string|null $detail_address
 * @property int $province_id
 * @property int $city_id
 * @property int $mechanic_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mechanic $Mechanic
 * @method static \Database\Factories\MechanicaddressFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress newQuery()
 * @method static \Illuminate\Database\Query\Builder|Mechanicaddress onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereAlley($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereDetailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereFlat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereMechanicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Mechanicaddress withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Mechanicaddress withoutTrashed()
 * @mixin \Eloquent
 * @property int|null $support_space
 * @method static \Illuminate\Database\Eloquent\Builder|Mechanicaddress whereSupportSpace($value)
 */
class Mechanicaddress extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    /**************
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * each mechanic has an address
     */
    public function Mechanic()
    {
        return $this->belongsTo(Mechanic::class);
    }

    /****************
     * @param $lat
     * @param $lon
     * @return Mechanicaddress|\Illuminate\Database\Query\Builder
     * it's find near mechanic
     */
    public static function findNearMechanic($lat, $lon)
    {
        return self::selectRaw("mechanic_id, lat, lon,support_space, SQRT(POW(69.1 * (lat - '" . $lat .
            "'), 2) + POW(69.1 * ('" . $lon . "' - lon) * COS(lat / 57.3), 2)) AS distance ")
            ->havingRaw('distance < support_space')->orderBy('distance');
    }
}
