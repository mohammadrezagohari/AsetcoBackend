<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * <<<<<<< HEAD
 * App\Models\City
 *
 * @property int $id
 * @property int $province_id
 * @property string|null $name
 * @property string|null $name_en
 * @property string|null $latitude
 * @property string|null $longitude
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereProvinceId($value)
 * @mixin \Eloquent
 * @method static create(string[] $array)
 * @method static \Database\Factories\CityFactory factory(...$parameters)
 * @property string|null $slug
 * @method static \Illuminate\Database\Eloquent\Builder|City whereSlug($value)
 */
class City extends Model {
    use HasFactory;

    protected $guarded = [];
    public $timestamps=false;

}





