
@component('mail::message')
# Verification Code

Your verification code is: {{ $verificationCode }}

Thanks,<br>
{{ config('Toselatk') }}
@endcomponent
