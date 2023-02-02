<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * App\Models\Room
 *
 * @property-read \App\Models\Basket $basket
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Room newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room query()
 * @mixin \Eloquent
 */
class Room extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            $model->room_id = Str::uuid();

        });
    }

    public function basket()
    {
        return $this->belongsTo(Basket::class, 'basket_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
