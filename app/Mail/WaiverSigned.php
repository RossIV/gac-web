<?php

namespace App\Mail;

use App\Models\Signature;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WaiverSigned extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The Signature instance.
     *
     * @var Signature
     */
    public $signature;

    /**
     * Create a new message instance.
     *
     * @param Signature $signature
     * @return void
     */
    public function __construct(Signature $signature)
    {
        $this->signature = $signature;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Waiver Signed')->markdown('emails.waiver-signed');
    }
}
