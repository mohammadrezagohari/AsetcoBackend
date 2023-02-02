<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Dailywork
 *
 * @property int $id
 * @property string $day
 * @property string $from
 * @property string $to
 * @property int $mechanic_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mechanic $Mechanic
 * @method static \Illuminate\Database\Eloquent\Builder|Dailywork newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dailywork newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dailywork query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dailywork whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dailywork whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dailywork whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dailywork whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dailywork whereMechanicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dailywork whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dailywork whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Dailywork extends Model
{
    use HasFactory;

    protected $guarded = [];

    /*******
     * Any Mechanics has many work time but
     * someone of work time has mechanic
     */
    public function Mechanic()
    {
        return $this->belongsTo(Mechanic::class);
    }

    public function getFromAttribute($value)
    {
        return Carbon::parse($value)->format('H:i');
    }
    public function getToAttribute($value)
    {
        return Carbon::parse($value)->format('H:i');
    }
}
