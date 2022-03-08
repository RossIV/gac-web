@component('mail::message')
Greetings from {{ config('app.admin_name') }}!

To finish logging in, please click the link below.
@component('mail::button', ['url' => $url])
Login Now
@endcomponent

@component('mail::panel')
**Users of some browsers (e.g. Safari) may experience issues using the button above and get an error (or see the login screen again) upon clicking.**
If you are getting such an error, request a new link first, then _instead of clicking the button_, copy/paste the link below into your browser to log in.

{{ $url }}
@endcomponent

If you did not try to sign in to your {{ config('app.name') }} account, you can safely delete this email.
If you have any questions, feel free to get in touch with {{ config('app.admin_name') }} at {{ config('app.admin_email') }}.
@endcomponent
