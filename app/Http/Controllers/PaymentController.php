<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\Client;
use Carbon\Carbon;
use App\Jobs\SaveDollarValueJob;

class PaymentController extends Controller
{
    public function getPayments(Request $request){
        $client = Client::findOrFail($request->client);
        return Payment::where('user_id', $client->id)->get();
    }

    public function storePayment(Request $request){
        $client = Client::findOrFail($request->client);
        $payment = Payment::create([
            "user_id" => $client->id,
            "expires_at" => Carbon::now()->addMonth()->format('Y-m-d'),
            "payment_date" => null,
            "status" => "pending",
            "clp_usd" => null
        ]);
        SaveDollarValueJob::dispatch($payment)->delay(Carbon::now()->addSeconds(10));
        return $payment;
    }
}
