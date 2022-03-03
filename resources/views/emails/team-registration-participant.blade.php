@component('mail::message')
Greetings from {{ config('app.admin_name') }}, {{ $teamMember->first_name }}!

You're receiving this message because {{ $teamLeader->name }} has listed you as a member of team {{ $team->name }} for {{ $eventName }}.

@component('mail::panel')
**Your Name:** {{ $teamMember->name }}

**Your Knight Name:** {{ $teamMember->alt_name }}

**Your Email:** {{ $teamMember->email }}

**Your Phone Number:** {{ $teamMember->phone }}

**Your Affiliation:** {{ $teamMember->affiliation->name }}
@endcomponent

If anything is not correct - please [update your profile]({{ route('profile') }}) ASAP.
If everything is correct - great! There are still a few more things we need you to do **before** game day:

1) Electronically sign a liability waiver and provide emergency contact information

@component('mail::button', ['url' => route('profile')])
Finish Participant Registration
@endcomponent

2) Download the ClueKeeper app to your phone

ClueKeeper is the app that we use to navigate you and your team throughout the day from clue site to clue site.

@component('mail::button', ['url' => 'https://cluekeeper.com/app'])
Download ClueKeeper
@endcomponent

That's it for now! If you have any questions, feel free to give us a shout.

Happy Hunting!

{{ config('app.admin_name') }}

If you were not expecting this invitation, please get in touch with {{ config('app.admin_name') }} at {{ config('app.admin_email') }}.
@endcomponent
