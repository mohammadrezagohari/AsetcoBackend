<?php

namespace App\Http\Controllers\API;

use App\Enums\RegularExpressionLocation;
use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Http\Resources\WalletMechanicResource;
use App\Http\Resources\WalletResource;
use App\Models\Mechanic;
use App\Models\User;
use App\Models\Wallet;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class WalletController extends Controller
{
    /*************************
     * کیف پول من
     */
    public function index()
    {
        try {
            $user = Auth::user();
            $wallet = Wallet::whereUserId($user->id)->first();
            if (@$user->checkedHasAnyRole([RoleTypes::MECHANIC])->count()) {
                if (@$wallet) {
                    return new WalletMechanicResource($wallet);
                }
            }
            if (@$wallet) {
                return new WalletResource($wallet);
            }
            return response()->json(["message" => 'کیف پول شما خالیست'], HTTPResponse::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }


    public function increaseMechanic(Request $request)
    {
        $rules = array(
            "amount" => "nullable",
            "bonus" => "nullable",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $user = Auth::user();
            $wallet = Wallet::whereUserId($user->id)->first();
            if (@$wallet) {
                $wallet->amount = @$request->amount ? $wallet->amount + $request->amount : $wallet->amount;
                $wallet->bonus = @$request->bonus ? ($wallet->bonus + $request->bonus) : $wallet->bonus;
                $wallet->has_credit = true;
                $wallet->save();
                return  WalletMechanicResource::make($wallet);
            }
            $wallet = $user->Wallet()->create([
                "amount" => $request->amount,
                "bonus" => $request->bonus,
                'has_credit' => true,
            ]);
            return new WalletMechanicResource($wallet);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function increaseUser(Request $request)
    {
        $rules = array(
            "amount" => "required",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $user = Auth::user();
            $wallet = Wallet::whereUserId($user->id)->first();
            if (@$wallet) {
                $wallet->amount = @$request->amount ? $wallet->amount + $request->amount : $wallet->amount;
                $wallet->bonus = @$request->bonus ? ($wallet->bonus + $request->bonus) : $wallet->bonus;
                $wallet->has_credit = true;
                $wallet->save();
                return new WalletResource($wallet);
            }
            $wallet = $user->Wallet()->create([
                "amount" => $request->amount,
                "bonus" => $request->bonus,
                'has_credit' => true,
            ]);
            return new WalletResource($wallet);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

}
