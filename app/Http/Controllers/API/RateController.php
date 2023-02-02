<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Mechanic;
use App\Models\Rate;
use App\Models\User;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class RateController extends Controller
{
    public function store($mechanic_id, Request $request)
    {

        $rules = array(
            "rate" => "required|integer|between:1,5",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $mechanic = Mechanic::findOrFail($mechanic_id);
            $user_id = Auth::user()->id;
            if (Rate::findForChange($mechanic->id, $user_id)->count()) {
                $rate = Rate::findForChange($mechanic->id, $user_id)->firstOrFail();
                $rate->rate = $request->rate;
                $rate->save();

            } else {
                $rate = Rate::create([
                    'user_id' => $user_id,
                    'mechanic_id' => $mechanic->id,
                    'rate' => $request->rate
                ]);
            }
            $rate_average = Rate::calculateAverage($mechanic->id);
            return response()->json(['status' => "thanks for your rate.", 'rate' => $rate_average], 200);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], 401);
        }
    }

    public function top_rate_mechanic()
    {
        try {
            $rates = Rate::select('mechanic_id', DB::raw('avg(rate) as rate'))->groupBy('mechanic_id')->orderByDesc('rate')->get();
            $mechanics = [];
            foreach ($rates as $rate) {
                $mechanic = Mechanic::findOrFail($rate->mechanic_id);
                if (@$mechanic->activated) {
                    $user = User::findOrFail($mechanic->user_id);
                    array_push($mechanics, [
                        'rate' => $rate->rate,
                        'mechanic_id' => $rate->mechanic_id,
                        'avatar' => $user->avatar,
                        'mechanic_name' => $mechanic->name,
                        'admin' => $user->name,
                    ]);
                }
            }
            return response()->json(['top_rates' => $mechanics], 200);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], 401);
        }
    }

}
