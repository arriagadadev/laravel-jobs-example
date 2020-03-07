<?php

namespace App\Listener;

use App\Events\PaymentComplete;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\PaymentCompleted;
use Illuminate\Support\Facades\Mail;

class SendConfirmationEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PaymentComplete  $event
     * @return void
     */
    public function handle(PaymentComplete $event)
    {
        //This Listener sends an email with the payment details after it's confirmed
        Mail::to($event->payment->client)->send(new PaymentCompleted($event->payment));
    }
}
