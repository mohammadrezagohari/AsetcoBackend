<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Invite
 *
 * @property int $id
 * @property int $user_id
 * @property bool $accepted
 * @property int|null $invited_user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $User
 * @method static Builder|Invite newModelQuery()
 * @method static Builder|Invite newQuery()
 * @method static Builder|Invite query()
 * @method static Builder|Invite whereAccepted($value)
 * @method static Builder|Invite whereCreatedAt($value)
 * @method static Builder|Invite whereId($value)
 * @method static Builder|Invite whereInvitedUserId($value)
 * @method static Builder|Invite whereUpdatedAt($value)
 * @method static Builder|Invite whereUserId($value)
 * @mixin Eloquent
 * @property string|null $invited_mobile_number
 * @property-read mixed $invite_user
 * @method static Builder|Invite whereInvitedMobileNumber($value)
 * @property string|null $invited_full_name
 * @method static Builder|Invite whereInvitedFullName($value)
 * @property float|null $price
 * @method static Builder|Invite wherePrice($value)
 */
class Invite extends Model
{
    use HasFactory;

    protected $guarded = [];

    /*******************************
     * @return BelongsTo
     *
     */
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /***********************************************
     * @param $user_id
     * @return Invite|Builder
     */
    public function getInviteUserAttribute($user_id)
    {
        return $this->whereInvitedUserId($user_id);
    }
}
