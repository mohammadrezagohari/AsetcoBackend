<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * <<<<<<< HEAD
 * App\Models\Province
 *
 * @property int $id
 * @property int|null $country
 * @property string|null $name
 * @property string|null $name_en
 * @method static \Illuminate\Database\Eloquent\Builder|Province newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Province newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Province query()
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereNameEn($value)
 * @mixin \Eloquent
 * =======
 * @method static create(string[] $array)
 * @method static \Database\Factories\ProvinceFactory factory(...$parameters)
 * @property string|null $slug
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $cities
 * @property-read int|null $cities_count
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereSlug($value)
 */
class Province extends Model {
    use HasFactory;

    protected $guarded = [];
    public $timestamps=false;

    public function cities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(City::class);
    }

}
