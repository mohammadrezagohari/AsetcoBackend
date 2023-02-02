<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\SelectResource;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class YearController extends Controller
{
    /*****************
     * @return \Illuminate\Http\JsonResponse
     * List of the Year
     */
    public function index()
    {
        try {
            $models = Year::all();
            return SelectResource::collection($models);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }


    /*********************
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Store in the model of the Year
     */
    public function store(Request $request)
    {
        $rules = array(
            "name" => "required|string|max:250",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $year = Year::create([
                'name' => $request->name,
            ]);
            return response()->json([$year->id, 'Year added successfully.'], HTTPResponse::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    /*****************
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * update the Year
     */
    public function update($id, Request $request)
    {
        $rules = array(
            "name" => "required|string|max:250",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }

        try {
            $year = Year::find($id);
            $year->name = $request->name;
            $year->save();
            return response()->json([$year->id, 'Year update successfully.'], HTTPResponse::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }


    /***********************
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     *
     * delete Year in the database
     */
    public function delete($id)
    {
        try {
            $year = Year::findOrFail($id);
            $year->delete();
            return response()->json(['Year delete successfully.'], HTTPResponse::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }
}
