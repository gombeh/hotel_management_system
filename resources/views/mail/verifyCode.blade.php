<x-mail::message>

    # Verify email and create an account



    Hi,

    You just requested a verification code for {{ $customer->email }}. This unique code allows you to create a
    {{ config('app.url')  }} account.

<x-mail::panel># {{ $code }}</x-mail::panel>

    Thanks, {{config('app.name')}}
</x-mail::message>
