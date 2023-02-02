<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\SelectResource;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class ColorController extends Controller
{
    public function index()
    {
        try {
            $models = Color::all()->take(100);
            return SelectResource::collection($models);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function store(Request $request)
    {
        $rules = array(
            "name" => "required|unique:colors,name",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            Color::create(['name' => $request->name]);
            return response()->json(['message' => 'Color add successfully.'], HTTPResponse::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function update($id, Request $request)
    {
        $rules = array(
            "name" => "required|unique:colors,name",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $color = Color::findOrFail($id);
            $color->name = $request->name;
            $color->save();
            return response()->json(['message' => 'Color update successfully.'], HTTPResponse::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function delete($id)
    {
        try {
            $color = Color::findOrFail($id);
            $color->delete();
            return response()->json(['message' => 'Color delete successfully.'], HTTPResponse::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

}
