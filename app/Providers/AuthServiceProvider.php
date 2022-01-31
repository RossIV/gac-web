<?php

namespace App\Providers;

use App\Models\Affiliation;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Signature;
use App\Models\User;
use App\Policies\AffiliationPolicy;
use App\Policies\EventPolicy;
use App\Policies\EventRegistrationPolicy;
use App\Policies\PaymentMethodPolicy;
use App\Policies\PaymentPolicy;
use App\Policies\SignaturePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Affiliation::class => AffiliationPolicy::class,
        Event::class => EventPolicy::class,
        EventRegistration::class => EventRegistrationPolicy::class,
        Payment::class => PaymentPolicy::class,
        PaymentMethod::class => PaymentMethodPolicy::class,
        Signature::class => SignaturePolicy::class,
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
