<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Userrequest
 *
 * @property int $id
 * @property int $status
 * @property int $user_id
 * @property int $service_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Service $Service
 * @property-read \App\Models\User $User
 * @method static \Illuminate\Database\Eloquent\Builder|Userrequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Userrequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Userrequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|Userrequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Userrequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Userrequest whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Userrequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Userrequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Userrequest whereUserId($value)
 * @mixin \Eloquent
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Userrequest whereDeletedAt($value)
 */
class Userrequest extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function User() {
        return $this->belongsTo(User::class);
    }

    public function Service() {
        return $this->belongsTo(Service::class);
    }

}
