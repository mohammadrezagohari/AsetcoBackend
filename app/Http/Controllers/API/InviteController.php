<?php

namespace App\Http\Controllers\API;

use App\Enums\DeliveryStep;
use App\Enums\RegularExpressionLocation;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvitesResource;
use App\Jobs\SendSmsInvite;
use App\Models\Basket;
use App\Models\Invite;
use App\Models\Wallet;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class InviteController extends Controller
{
    /*****************************************
     * @param Request $request
     * @return InvitesResource|JsonResponse
     */
    public function generate(Request $request)
    {
        $rules = array(
            "name" => ['required', 'string'],
            "mobile" => ["required", "ir_mobile", Rule::unique('invites', 'invited_mobile_number')->where(function ($query) use ($request) {
                return $query->where('accepted', true);
            })]
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $user = Auth::user();
            $priceItems = [5000, 10000, 12000, 15000, 20000];
            $invite = $user->Invites()->create([
                'invited_full_name' => $request->name,
                'accepted' => false,
                'price' => $priceItems[rand(0, 4)],
                'invited_mobile_number' => $request->mobile,
            ]);
            SendSmsInvite::dispatch($invite);
            return InvitesResource::make($invite);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    /**********************************
     * @return JsonResponse|AnonymousResourceCollection
     * user invite list
     */
    public function listYourInvites()
    {
        try {
            $user = Auth::user();
            $invites = $user->Invites;
            return InvitesResource::collection($invites);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    /***********************************
     * @param $user_id
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function userInviteList($user_id)
    {
        try {
            $invites = Invite::whereUserId($user_id)->get();
            return InvitesResource::collection($invites);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    /************************
     * @param $invite_id
     * @return JsonResponse
     */
    public function verifyInvite($invite_id): JsonResponse
    {
        try {
            $invite = Invite::findOrFail($invite_id); //// پیدا کردن شناسه دعوت
            /////// check accepted invite if is exists return alert abort.
            if (@Invite::whereInvitedMobileNumber($invite->invited_mobile_number)->whereAccepted(true)->count())
                return response()->json(["warning" => "درخواست شما منقضی شده است"], HTTPResponse::HTTP_BAD_REQUEST);
            ///// change flag invite status
            $invite->accepted = true;
            $invite->save();
            ///// find your wallet
            $wallet = Wallet::findOrFail($invite->User->Wallet->id);
            ///// added award to your wallet...
            $wallet->bonus = @$wallet->bonus ? $wallet->bonus + $invite->price : $invite->price;
            $wallet->has_credit = true;
            $wallet->save();
            ////// if user wallet want to update and get award you must add code here ....
            return response()->json(["success" => "شماره همراه شما شارژ شده است"], HTTPResponse::HTTP_OK);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

}
