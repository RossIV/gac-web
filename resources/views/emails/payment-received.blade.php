@component('mail::message')
Greetings from {{ config('app.admin_name') }}!

We have received your payment.

@component('mail::panel')
**Amount:** ${{ $payment->amount }}

**Method:** {{ $payment->method->name }}
@endcomponent

Please keep this email as proof of payment.

If you have any questions, feel free to get in touch with {{ config('app.admin_name') }} at {{ config('app.admin_email') }}.
@endcomponent
