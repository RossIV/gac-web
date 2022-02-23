@component('mail::message')
Greetings from {{ config('app.admin_name') }}!

To finish logging in, please click the link below.
@component('mail::button', ['url' => $url])
Login Now
@endcomponent

If you did not try to sign in to your {{ config('app.name') }} account, you can safely delete this email.
If you have any questions, feel free to get in touch with {{ config('app.admin_name') }} at {{ config('app.admin_email') }}.
@endcomponent
