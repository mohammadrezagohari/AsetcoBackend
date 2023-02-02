<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'basket_id',
        'date',
        'time',
    ];

    public function Basket()
    {
        return $this->belongsTo(Basket::class);
    }
}
