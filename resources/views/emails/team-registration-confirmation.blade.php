@component('mail::message')
Greetings from {{ config('app.admin_name') }}!

We've received your registration for {{ $eventName }}.

@component('mail::panel')
## Team
**Team Name:** {{ $team->name }}
**Team Motto:** {{ $team->motto }}
**Additional Members:** {{ $team->accept_additional_members }}
**Payment Method:** {{ $paymentMethod }}

## Team Members:
@foreach($teamMembers as $member)
{{ $member->name }}
@endforeach
@endcomponent

If you have any questions, feel free to get in touch with {{ config('app.admin_name') }} at {{ config('app.admin_email') }}.

@endcomponent
