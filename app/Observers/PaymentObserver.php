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
        $amount_dirty = $payment->isDirty('amount');
        if ($payment->amount > 0 && $payment->payable_type == "App\Models\EventRegistration" && $amount_dirty) {
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
            ->queue(new PaymentReceived($payment));

        activity('email')
            ->event('sent')
            ->performedOn($payment)
            ->causedBy($notifiable)
            ->withProperties([
                'type' => 'payment-received',
                'to' => $notifiable->email
            ])
            ->log('Sent Payment Received notification');
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
