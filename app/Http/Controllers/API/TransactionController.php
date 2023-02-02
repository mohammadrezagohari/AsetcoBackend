<?php

namespace App\Http\Controllers\API;

use App\Enums\BankMethodType;
use App\Enums\BankName;
use App\Enums\StatusBank;
use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\Mechanic;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class TransactionController extends Controller
{
    public function connect_bank_saderat($basket_id, Request $request)
    {

        $rules = array(
           "carmodel" => "required|exists:carmodels,id",
           "user_id" => "nullable|exists:users,id",
        );
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], HTTPResponse::HTTP_BAD_REQUEST);
        }
        try {
            \DB::beginTransaction();
            $basket = Basket::findOrFail($basket_id);
            /*calculate price*/
            $servicePivot = $basket->Services()->wherePivotNull('status')->pluck('id')->toArray();
            $allServices = Mechanic::findOrFail($basket->mechanic->id)->Services()->wherePivotIn('id', $servicePivot)->get();//->pluck('price');
            $sumPriceService = 0;
            foreach ($allServices as $service) {
                $sumPriceService += $service->pivot->price;
            }
            $productSumPrice = 0;
            $sumAllPrice = $sumPriceService + $productSumPrice;

            /// here need to create a new row transaction table
            $transaction = $basket->Transactions()->create([
                'bank' => BankName::BANK_SADERAT,
                'amount' => $sumAllPrice,
            ]);
            $response = \Http::post(env('SADERAT_TOKEN_ADDRESS'), [
                'Amount' => $sumAllPrice,
                'callbackURL' => route('callback.saderat'),
                'invoiceID' => $basket->id,
                'terminalID' => env('SADERAT_TERMINAL_ID'),
                'payload' => $basket->User->id,
            ]);
            $bankResponse = json_decode($response->body());
            $accessToken = $bankResponse->Accesstoken;
            // sleep(10);

            switch ($bankResponse->Status) {
                case (StatusBank::SUCCESS):
                    $transaction->status =  (string) StatusBank::SUCCESS;
                    $transaction->save();
                    \DB::commit();
                    dd($transaction);
                    return response()->json(["status" => $bankResponse->Status], HTTPResponse::HTTP_OK);
                case (StatusBank::NOTFOUND):
                    $transaction->status = (string) StatusBank::NOTFOUND;
                    $transaction->save();
                    \DB::commit();
                    if (@$accessToken) {
                        //// can connect to the bank port
                        $response = \Http::post(env('SADERAT_IPG_PAY_ADDRESS'), [
                            'getMethod' => BankMethodType::POST_METHOD,
                            'token' => $accessToken,
                            'TerminalID' => env('SADERAT_TERMINAL_ID'),
                        ]);

                        foreach ($basket->Services as $service) {
                            $basket->Services()->wherePivot('service_id', '=', $service->id)
                                ->wherePivot('basket_id', '=', $basket_id)
                                ->updateExistingPivot($service->id, ['status' => true]);
                        }
                        foreach ($basket->Products as $product) {
                            $basket->Products()->wherePivot('product_id', '=', $product->id)
                                ->wherePivot('basket_id', '=', $basket_id)
                                ->updateExistingPivot($basket_id, ['status' => true]);
                        }
                    }
                    return response()->json(["NOTFOUND" => $bankResponse->Status], HTTPResponse::HTTP_BAD_REQUEST);
                    break;
                case (StatusBank::CONFLICT):
                    $transaction->status =  (string)  StatusBank::CONFLICT;
                    $transaction->save();
                    \DB::commit();
                    dd($transaction);

                    return response()->json(["CONFLICT" => $bankResponse->Status], HTTPResponse::HTTP_BAD_REQUEST);
                    break;
                case (StatusBank::EXCEPTION):
                    $transaction->status = StatusBank::EXCEPTION;
                    $transaction->save();
                    return response()->json(["EXCEPTION" => $bankResponse->Status], HTTPResponse::HTTP_BAD_REQUEST);
                    break;
                case StatusBank::CAN_NOT_DO:
                    $transaction->status = StatusBank::CAN_NOT_DO;
                    $transaction->save();
                    return response()->json(["CAN_NOT_DO" => $bankResponse->Status], HTTPResponse::HTTP_BAD_REQUEST);
                    break;
                case StatusBank::IP_INVALID:
                    $transaction->status = StatusBank::IP_INVALID;
                    $transaction->save();
                    return response()->json(["IP_INVALID" => $bankResponse->Status], HTTPResponse::HTTP_BAD_REQUEST);
                    break;
                case StatusBank::FAIL_SERVICE:
                    $transaction->status = StatusBank::FAIL_SERVICE;
                    $transaction->save();
                    return response()->json(["FAIL_SERVICE" => $bankResponse->Status], HTTPResponse::HTTP_BAD_REQUEST);
                    break;
            }

           $response = \Http::post('https://map.ir/distancematrix', [
               'TerminalID' => env('SADERAT_TERMINAL_ID'),
               'TerminalID' => env('SADERAT_TERMINAL_ID'),
           ]);


        } catch (\Exception $exception) {
            \DB::rollBack();
            dd($exception->getTrace());
        }
    }

    public function callback_saderat(Request $request)
    {
        if (@$request->respcode && @$request->invoiceid) {
            ////////////////////////////////
            // کد پاسخ وضعیت
            $respcode = $request->respcode;
            // متن پاسخ وضعیت
            $respmsg = $request->respmsg;
            // شماره پیگیری
            $tracenumber = $request->tracenumber;
            // شماره سند بانکی
            $rrn = $request->rrn;
            // زمان و تاریخ تراکنش
            $datePaid = $request->datepaid;
            // رسید دیجیتال
            $digitalreceipt = $request->digitalreceipt;
            // بانک صادرکننده کارت
            $issuerbank = $request->issuerbank;
            // شماره کارت
            $cardnumber = $request->cardnumber;
            if ($respcode == 0) {
                //// TODO: here write code for invalid response Action

            } else {
                //// TODO: here write code for Success Response.
            }


        }
        //// here for no-response Action
    }

}
