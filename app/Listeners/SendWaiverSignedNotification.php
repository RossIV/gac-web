<?php

namespace App\Listeners;

use App\Events\SignatureUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWaiverSignedNotification implements ShouldQueue
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
     * @param  SignatureUpdated $event
     * @return void
     */
    public function handle(SignatureUpdated $event)
    {
        $signature = $event->signature;

        if ($event->was_signed) {
            Mail::to($signature->user)
                ->bcc(config('app.admin_email'))
                ->send(new \App\Mail\WaiverSigned($signature));

            activity('email')
                ->event('sent')
                ->performedOn($signature)
                ->causedBy($signature->user)
                ->withProperties([
                    'type' => 'waiver-signed',
                    'to' => $signature->user->email
                ])
                ->log('Sent Waiver Signed notification');
        }
    }
}
