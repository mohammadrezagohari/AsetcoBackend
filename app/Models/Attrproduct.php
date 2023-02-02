<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Attrproduct
 *
 * @property int $id
 * @property string $subject
 * @property string $value
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $Product
 * @method static \Illuminate\Database\Eloquent\Builder|Attrproduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attrproduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attrproduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attrproduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attrproduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attrproduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attrproduct whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attrproduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attrproduct whereValue($value)
 * @mixin \Eloquent
 * @method static \Database\Factories\AttrproductFactory factory(...$parameters)
 * @method static \Illuminate\Database\Query\Builder|Attrproduct onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Attrproduct withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Attrproduct withoutTrashed()
 */
class Attrproduct extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function Product() {
        return $this->belongsTo(Product::class);
    }

}
