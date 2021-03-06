<?php

namespace App\Providers;

use App\Events\TeamRegistered;
use App\Events\SignatureUpdated;
use App\Listeners\SendTeamRegistrationNotifications;
use App\Listeners\SendWaiverSignedNotification;
use App\Models\Payment;
use App\Observers\PaymentObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        TeamRegistered::class => [
            SendTeamRegistrationNotifications::class
        ],
        SignatureUpdated::class => [
            SendWaiverSignedNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Payment::observe(PaymentObserver::class);
    }
}
