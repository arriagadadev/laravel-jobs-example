<?php

namespace App\Jobs;

use App\Payment;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\PaymentComplete;

class SaveDollarValueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $payment;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Obtaining a payment made today
        $paymentToday = Payment::select('clp_usd')->where('payment_date', now()->format('Y-m-d'))->first();
        if($paymentToday){
            //If there is a payment made today, I use its 'clp_usd' attribute to not reuse the API today
            $this->payment->clp_usd = $paymentToday->clp_usd;
        }else{
            //If no other payment has been made today, we have to consume the api to get the dollar value
            $client = new Client;
            $response = $client->get('https://mindicador.cl/api/dolar');
            $clp_usd = json_decode($response->getBody())->serie[0]->valor;
            $this->payment->clp_usd = $clp_usd;
        }
        //Updating the payment status
        $this->payment->payment_date = now();
        $this->payment->status = "paid";
        $this->payment->save();
        //Issuing an event indicating that the payment was confirmed
        event(new PaymentComplete($this->payment));
    }
}
