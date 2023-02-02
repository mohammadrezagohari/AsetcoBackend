<?php

namespace App\Http\Controllers;

use App\Enums\DaysOfTheWeek;
use App\Enums\MediaTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Plank\Mediable\Facades\MediaUploader;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class MediaController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $rules = array(
            'type' => ['required', Rule::in(MediaTypes::ALL)],
            'media' => ['required', 'file']
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        $media = MediaUploader::fromSource($request->file('media'))->useFilename(Str::random(16))->upload();

        return response()->json([
            'filename' => "$media->filename.$media->extension" ,
        ], 201);
    }
}
