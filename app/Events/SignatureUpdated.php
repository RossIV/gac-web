<?php

namespace App\Events;

use App\Models\Signature;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SignatureUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The Signature instance.
     *
     * @var \App\Models\Signature
     */
    public $signature;


    /**
     * Whether document was signed during this update
     *
     * @var bool
     */
    public $was_signed;

    /**
     * Create a new Signature instance.
     *
     * @return void
     */
    public function __construct(Signature $signature)
    {
        $this->signature = $signature;

        // Pass signing status to downstream listeners to control sending emails
        // Dirty status of attributes isn't available outside of the event apparently
        $signed_at_orig = $signature->getOriginal('signed_at');
        $signed_at_dirty = $signature->isDirty('signed_at');
        $this->was_signed = ($signed_at_dirty && $signed_at_orig === null);
    }
}
