@component('mail::message')
Greetings from {{ config('app.admin_name') }}!

We have received your signed waiver.

Please keep this email as proof of completion.

If you have any questions, feel free to get in touch with {{ config('app.admin_name') }} at {{ config('app.admin_email') }}.
@endcomponent
