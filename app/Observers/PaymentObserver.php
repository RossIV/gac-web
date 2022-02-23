<?php

namespace App\Observers;

use App\Mail\PaymentReceived;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function created(Payment $payment)
    {
        if ($payment->amount > 0 && $payment->payable_type == "App\Models\EventRegistration") {
            $this->handleNonZeroRegistrationPayment($payment);
        }
    }

    /**
     * Handle the Payment "updated" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function updated(Payment $payment)
    {
        if ($payment->amount > 0 && $payment->payable_type == "App\Models\EventRegistration") {
            $this->handleNonZeroRegistrationPayment($payment);
        }
    }

    /**
     * Handle non-zero registration payments
     *
     * @param Payment $payment
     * @return void
     */
    public function handleNonZeroRegistrationPayment(Payment $payment)
    {
        $notifiable = $payment->payable->user;
        Mail::to($notifiable)
            ->bcc(config('app.admin_email'))
            ->send(new PaymentReceived($payment));
    }

    /**
     * Handle the Payment "deleted" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function deleted(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "restored" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function restored(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function forceDeleted(Payment $payment)
    {
        //
    }
}
