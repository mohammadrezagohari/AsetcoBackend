<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\SelectResource;
use App\Models\Problem;
use Illuminate\Http\Request;

class ProblemController extends Controller
{
    public function list()
    {
        $problems = Problem::all();
        return SelectResource::collection($problems);

    }

}
