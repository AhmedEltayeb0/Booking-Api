<x-mail::message>


Welecome Admin of {{$room->centre->name}}  you have Booking for  Room {{$room->name}} - {{$room->id}}.
if you Accept this Booking click : 
<x-mail::button :url="'url/1'">
Accept Booking
</x-mail::button>
<x-mail::button :url="'url/0'">
Reject Booking
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
