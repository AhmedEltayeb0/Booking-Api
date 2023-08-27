<x-mail::message>


Welecome {{ $customr->name }}.
to Reset password use This Code: {{ $customr->reset_code }}
<x-mail::button :url="'url'">
Reset Password
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
