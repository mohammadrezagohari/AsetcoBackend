<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Yourcar
 *
 * @property int $id
 * @property string|null $pelak
 * @property int $year_id
 * @property int $color_id
 * @property int $carmodel_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Carmodel $Carmodel
 * @property-read \App\Models\Color $Color
 * @property-read \App\Models\User $User
 * @property-read \App\Models\Year $Year
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar query()
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar whereCarmodelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar whereColorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar wherePelak($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar whereYearId($value)
 * @mixin \Eloquent
 * @property string|null $shasi
 * @method static \Database\Factories\YourcarFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Yourcar whereShasi($value)
 */
class Yourcar extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Carmodel()
    {
        return $this->belongsTo(Carmodel::class);
    }

    public function Year()
    {
        return $this->belongsTo(Year::class);
    }

    public function Color()
    {
        return $this->belongsTo(Color::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
