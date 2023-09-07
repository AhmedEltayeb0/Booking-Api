<x-mail::message>


Welecome Admin of {{$room->centre->name}}  you have Booking for  Room {{$room->name}} - {{$room->id}}
from {{$resrvation->from}} To {{$resrvation->to}} withen {{$resrvation->period}}.
if you Accept this Booking click : 


@component('mail::button', ['url' => 'http://127.0.0.1:8000/api/admin/confirm/' . $resrvation->id.'/1'])
    Approve
@endcomponent
@component('mail::button', ['url' => 'http://127.0.0.1:8000/api/admin/confirm/' . $resrvation->id.'/2'])
    Decline
@endcomponent



<!-- [Click me](http://www.google.com){: .btn} -->

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
