<x-mail::message>


Welecome {{ $user->name }}.
to Reset password use This Code: {{ $user->reset_code }}
<x-mail::button :url="'url'">
Reset Password
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
