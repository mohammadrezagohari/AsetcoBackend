<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Userlocation
 *
 * @property int $id
 * @property string $lat
 * @property string $lon
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $User
 * @method static \Illuminate\Database\Eloquent\Builder|Userlocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Userlocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Userlocation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Userlocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Userlocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Userlocation whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Userlocation whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Userlocation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Userlocation whereUserId($value)
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|Userlocation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Userlocation whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Userlocation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Userlocation withoutTrashed()
 * @method static \Database\Factories\UserlocationFactory factory(...$parameters)
 */
class Userlocation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
