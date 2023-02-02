<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Problem
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Basket[] $Baskets
 * @property-read int|null $baskets_count
 * @method static \Database\Factories\ProblemFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Problem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Problem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Problem query()
 * @method static \Illuminate\Database\Eloquent\Builder|Problem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Problem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Problem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Problem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Problem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Baskets(): BelongsToMany
    {
        return $this->belongsToMany(Basket::class);
    }
}
