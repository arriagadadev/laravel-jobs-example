<?php

namespace App\Jobs;

use App\Payment;
use Carbon\Carbon;
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
        $paymentToday = Payment::select('clp_usd')->where('payment_date', Carbon::now()->format('Y-m-d'))->first();
        if($paymentToday){
            $this->payment->clp_usd = $paymentToday->clp_usd;
        }else{
            $client = new Client;
            $response = $client->get('https://mindicador.cl/api/dolar');
            $clp_usd = json_decode($response->getBody())->serie[0]->valor;
            $this->payment->clp_usd = $clp_usd;
        }
        $this->payment->payment_date = Carbon::now();
        $this->payment->status = "paid";
        $this->payment->save();
        event(new PaymentComplete($this->payment));
    }
}
