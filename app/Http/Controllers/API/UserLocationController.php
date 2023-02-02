<?php

namespace App\Http\Controllers\API;

use App\Enums\RegularExpressionLocation;
use App\Http\Controllers\Controller;
use App\Models\Userlocation;
use Illuminate\Support\Facades\Validator;
use Request;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class UserLocationController extends Controller
{
    public function index()
    {
        $location = Userlocation::whereUserId(\Auth::user()->id)->firstOrFail();
        return response()->json($location, HTTPResponse::HTTP_OK);
    }

    public function update_location(Request $request)
    {
        $rules = array(
            "lat" => ['required', 'regex:' . RegularExpressionLocation::LATITUDE],
            "lon" => ['required', 'regex:' . RegularExpressionLocation::LONGITUDE],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $location = Userlocation::updateOrCreate([
                'lat' => $request->lat,
                'lon' => $request->lon,
                'user_id' => \Auth::user()->id,
            ]);
            return response()->json([$location->id, 'Location update successfully.'], HTTPResponse::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }



    }

}
