<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Useraddress
 *
 * @property int $id
 * @property string|null $street
 * @property string|null $alley
 * @property string|null $flat
 * @property string|null $detail_address
 * @property string|null $lat
 * @property string|null $lon
 * @property int $province_id
 * @property int $city_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $Useraddress
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress newQuery()
 * @method static \Illuminate\Database\Query\Builder|Useraddress onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereAlley($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereDetailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereFlat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Useraddress withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Useraddress withoutTrashed()
 * @mixin \Eloquent
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $User
 * @method static \Database\Factories\UseraddressFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Useraddress whereUserId($value)
 */
class Useraddress extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class);
    }


}
