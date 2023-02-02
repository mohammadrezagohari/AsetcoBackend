<?php

namespace App\Http\Controllers\API;

use App\Enums\PaymentStatus;
use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\WalletResource;
use App\Models\Card;
use App\Models\Payment;
use App\Models\Role;
use App\Models\Wallet;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class PaymentController extends Controller
{
    /*************
     * list of all payments just access with admin ....
     */
    public function index()
    {
        try {
            $payment = Auth::user()->Wallet->Payments;
            return PaymentResource::Collection($payment);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function request(Request $request)
    {
        $rules = array(
            "amount" => "required",
            "card_number" => "required|string|min:16|max:16",
            "full_name" => "required|string",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $user = Auth::user();
            $sumPending = $user->Wallet->Payments
                    ->where('status', '=', PaymentStatus::PENDING)->sum('amount') + $request->amount;

            if (!(@$request->amount <= $user->Wallet->amount &&
                $sumPending <= $user->Wallet->amount))
                return response()->json(['message' => 'مبلغ درخواستی شما خارج از محدوده مجاز می باشد'], HTTPResponse::HTTP_BAD_REQUEST);

            $payment = $user->Wallet->first()->Payments()->create([
                'status' => PaymentStatus::PENDING,
                'amount' => $request->amount,
            ]);
            $payment->Card()->updateOrCreate([
                "card_number" => $request->card_number,
                "bank_name" => $request->bank_name,
                "full_name" => $request->full_name,
                "user_id" => $user->id
            ]);
            return PaymentResource::make($payment);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function acceptPayment($payment_id, Request $request)
    {
        $rules = array(
            "amount" => "required",
            "status" => ["required", Rule::in(PaymentStatus::ALL)],
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            $user = Auth::user();
            $payment = Payment::findOrFail($payment_id);
            if ($payment->status != PaymentStatus::PENDING)
                return response()->json(['message' => 'این درخواست قبلا تایید شده است.'], HTTPResponse::HTTP_BAD_REQUEST);
            if (!@$payment)
                return response()->json(['message' => 'چنین درخواستی وجهی وجود ندارد'], HTTPResponse::HTTP_BAD_REQUEST);
            $sumPending = $user->Wallet->Payments
                    ->where('status', '=', PaymentStatus::PENDING)->where('id', '<>', $payment->id)->sum('amount') + $request->amount;

            if (!(@$request->amount <= $user->Wallet->amount &&
                $sumPending <= $user->Wallet->amount))
                return response()->json(['message' => 'مبلغ درخواستی شما خارج از محدوده مجاز می باشد'], HTTPResponse::HTTP_BAD_REQUEST);

            $payment->status = PaymentStatus::PAYED;
            $payment->amount = $request->amount;
            $payment->save();
            $user->Wallet()->update([
                'amount' => ($user->Wallet->amount - $payment->amount)
            ]);
            return PaymentResource::make($payment);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()], HTTPResponse::HTTP_BAD_REQUEST);
        }
    }

    public function yourRequest()
    {

    }
}
