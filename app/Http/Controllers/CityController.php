<?php

namespace App\Http\Controllers;

use App\Http\Resources\SelectResource;
use App\Models\Province;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function get(Province $province)
    {
        return SelectResource::collection($province->cities);
    }
}
