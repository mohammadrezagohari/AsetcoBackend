<?php

namespace App\Http\Controllers;

use App\Enums\MediaTypes;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class ProvinceController extends Controller
{
    public function store(Request $request)
    {
        $rules = array(
            'country' => 'required',
            'name' => 'required|unique:provinces,name',
            'name_en' => 'required|unique:provinces,name_en',
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        $data = $request->except('_token');
        Province::create($data);
        return response()->json(['message' => 'province register successfully.'], 200);
    }
}
