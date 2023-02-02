<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Comment
 *
 * @property int $id
 * @property int $user_id
 * @property int $mechanic_id
 * @property int $accepted
 * @property string $context
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $User
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereContext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereMechanicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $parent_id
 * @method static \Database\Factories\CommentFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|Comment onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Comment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Comment withoutTrashed()
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereDeletedAt($value)
 */
class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    #region relationship

    /***********************
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * this method for relation one to many between user and comment.
     */
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    #endregion

    #region Method_Action
    /**************
     * @param $id
     * @return Comment|\Illuminate\Database\Eloquent\Builder
     * find mechanic by mechanic identity
     */
    public function findMechanic($id)
    {
        return self::whereMechanicId($id);
    }

    /***************
     * @param $id
     * @return Comment|\Illuminate\Database\Eloquent\Builder
     * find user by user identity
     */
    public function findUser($id)
    {
        return self::whereUserId($id);
    }
    #endregion
}
