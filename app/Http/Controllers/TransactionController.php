<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function createTransaction(Request $request)
    {
        $AUTH_USER = 'poscloud@zuva#appclient';
        $AUTH_PASS = 'Pass@poscloud@3$!!!';
        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        $has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
        $is_not_authenticated = (
            !$has_supplied_credentials ||
            $_SERVER['PHP_AUTH_USER'] != $AUTH_USER ||
            $_SERVER['PHP_AUTH_PW']   != $AUTH_PASS
        );
        if ($is_not_authenticated) {
            return response()->json([
                "code" => 401,
                "message" => 'You do not have permission to access this resource',
                "data" => []
            ]);
            exit;
        }

        $validator = Validator::make($request->all(), [
            "company" => "required",
            "card_number" => "required",
            "currency" => "required",
            "amount" => "required",
            "terminal_id" => "required",
            "service_station" => "required",
            "reference" => "required",
            "transaction_type" => "required",
            "description" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'message' => 'Validation errors',
                'data' => $validator->errors()
            ], 422);
        } else {

            try {

                $transaction = new Transaction();
                $transaction->company = $request->company;
                $transaction->card_number = $request->card_number;
                $transaction->currency = $request->currency;
                $transaction->amount = $request->amount;
                $transaction->terminal_id = $request->terminal_id;
                $transaction->service_station = $request->service_station;
                $transaction->reference = $request->reference;
                $transaction->transaction_type = $request->transaction_type;
                $transaction->description = $request->description;
                $transaction->save();
                return response()->json([
                    "code" => 200,
                    "message" => 'Transaction successfully posted to Zuva.',
                    "data" => $transaction
                ]);


            } catch (\Exception $exception) {
                return response()->json([
                    "code" => 422,
                    "message" => $exception->getMessage(),
                    "data" => []
                ], 422);
            }

        }
    }

    public function checkBalance(Request $request)
    {
        $AUTH_USER = 'poscloud@zuva#appclient';
        $AUTH_PASS = 'Pass@poscloud@3$!!!';
        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        $has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
        $is_not_authenticated = (
            !$has_supplied_credentials ||
            $_SERVER['PHP_AUTH_USER'] != $AUTH_USER ||
            $_SERVER['PHP_AUTH_PW']   != $AUTH_PASS
        );
        if ($is_not_authenticated) {
            return response()->json([
                "code" => 401,
                "message" => 'You do not have permission to access this resource',
                "data" => []
            ]);
            exit;
        }
        try {
            $company=$request->company;
            $top_up =Transaction::where('company','LIKE',"%$company%")
                ->where('transaction_type','=','TOP-UP')
                ->sum('amount');

            $sale =Transaction::where('company','LIKE',"%$company%")
                ->where('transaction_type','=','SALE')
                ->sum('amount');
            $balance=$top_up-$sale;
            return response()->json([
                "code" => 200,
                "message" => 'Transaction successfully posted to Zuva.',
                "balance" =>$balance
            ]);



        }catch (\Exception $exception){
            return response()->json([
                "code"      => 422,
                "message"   => $exception->getMessage(),
                "data"=> []
            ],422);
        }


    }

}
