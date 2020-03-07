<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\Client;
use App\Jobs\SaveDollarValueJob;

class PaymentController extends Controller
{
    public function getPayments(Request $request){
        //It's necessary to send the attribute 'client' in the get request
        $client = Client::findOrFail($request->client);
        return Payment::where('user_id', $client->id)->get();
    }

    public function storePayment(Request $request){
        //It's necessary to send the attribute 'client' in the post request
        $client = Client::findOrFail($request->client);
        //Payment created (but still pending)
        $payment = Payment::create([
            "user_id" => $client->id,
            "expires_at" => now()->addMonth()->format('Y-m-d'),
            "payment_date" => null,
            "status" => "pending",
            "clp_usd" => null
        ]);

        /*
        *   Job delayed 1 minute to show the example
        */
        SaveDollarValueJob::dispatch($payment)->delay(now()->addMinute());
        //Payment is returned with 'pending' status
        return $payment;
    }
}
