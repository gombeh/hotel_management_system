@component('mail::message')
# Hello {{ $user->full_name }},

We wanted to let you know that the password for your **{{ config('app.name') }}** account was successfully changed.

---

### 🔍 Details
- **Time:** {{ now()->toDateTimeString() }}
- **IP Address:** {{ $ip ?? 'Not available' }}
- **Device:** {{ $agent ?? 'Not available' }}

---

If you made this change, no further action is needed.

@if($resetUrl)
@component('mail::button', ['url' => $resetUrl])
    Reset Password
@endcomponent
@endif

If you didn’t make this change, please reset your password immediately or contact our support team.

Thanks,
**{{ config('app.name') }} Team**
@endcomponent
