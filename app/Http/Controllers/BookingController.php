<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;
use App\Models\Centre;
use App\Models\Room;
use Auth ;
use App\Helpers\TimeHelper ;
use DateTime;
use DatePeriod;
use DateInterval;
use App\Http\Resources\BookingResource;

use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmBooking;

class BookingController extends Controller
{
    public function __construct()
    {
        //  $this->middleware('auth', ['except' => ['login', 'register', 'forgetPassword' , 'resetPassword']]);

        $this->middleware('auth:user_api')->only('checkbooking');

        // $this->middleware('auth:customrs_api', ['except' => ['login', 'register', 'forgetPassword' , 'resetPassword']]);
        $this->middleware('auth:customrs_api', ['except' => ['checkbooking']]);
    }
    public function index()
    {
        return BookingResource::collection(Auth::User()->bookings);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingRequest $request)
    {

        $validate = $request->validated();
        if($validate) {
            $room = Room::whereId($request['room_id'])->first();
            $room_status = $room->status;  // if 0 off -- 1 is on
            $centre = $room->centre ;
            $customr = Auth::user();
            if($room_status == 0) {
                return [
                    'message' => 'this room is offline Now',
                    'code' => '400',
                    'status' => 'decline booking'
                ];
            } elseif($room->workinghours == null) {
                return [
                    'message' => 'this room is fully Booking ',
                    'code' => '400',
                    'status' => 'decline booking'
                ];
            } elseif($room_status == 1) {
                $bookedhours = array();
                $from = strtotime($request['from']);
                $to = strtotime($request['to']);
                $period = (int) gmdate('H:i', $to - $from);
                $bookedhours = (new TimeHelper())->RangeCreator($request['from'], $request['to']);
                $availablehours  = array_values(array_diff($room->workinghours, $bookedhours)) ;
                $emails = array();
                foreach($room->centre->users as $users) {
                    $emails = $users->email;
                }
                $reservation = Booking::updateOrCreate([
                    'customr_id' => Auth::user()->id,
                    'room_id' => $request['room_id'],
                    'booking_date' => $request['booking_date'],
                    'from' => $request['from'],
                    'to' => $request['to'],
                    'period' =>  $period . " hours",
                    'status' => 0, // 0 pending - 1 is accept - 2 is reject
                ]);
                Mail::to($emails)->queue(new ConfirmBooking($room, $reservation));

                //room update working hours
                $room->update(['workinghours' => $availablehours]);

                return [
                    'message' => 'sent booking successfuly we approve your request Soon' ,
                    'code' => 200 ,
                ];
            } else {
                //TODO: add
            }

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $reservation = $booking;
        if(Auth::user()->id == $booking->customr_id) {
            $val = $request->validate([
                // 'room_id'=> 'exists:rooms,id',
                'booking_date' => 'date_format:Y-m-d H:i',
                'from' => 'date_format:H:i',
                'to' => 'date_format:H:i',
            ]);

        } else {
            return [
                'message' => 'this Booking did not refare to this customr',
                'code' => '400',

            ];
        }

        if($val) {
            $from = strtotime($request['from']);
            $to = strtotime($request['to']);
            $period = (int) gmdate('H:i', $to - $from);


            $oldbookedhours = array();
            $oldbookedhours = (new TimeHelper())->RangeCreator($booking->from, $booking->to);
            $newbookedhours = (new TimeHelper())->RangeCreator($request['from'], $request['to']);
            $room = Room::whereId($booking->room_id)->first();
            // return   $room->workinghours ;
            // return $oldbookedhours ;
             $merge = array_merge($room->workinghours, $oldbookedhours);
        //   return    $availablehours  = array_values(array_diff($room->workinghours, $newbookedhours)) ;
             $Newavailablehours = array_values(array_diff( $merge ,$newbookedhours)) ;
            $reservation->update([
                // 'room_id' => $request['room_id'],
                'booking_date' => $request['booking_date'],
                'from' => $request['from'],
                'to' => $request['to'],
                'period' =>  $period . " hours",
                'status' => 0, // 0 pending - 1 is accept - 2 is reject
            ]);
            $emails = array();
                foreach($room->centre->users as $users) {
                    $emails = $users->email;
                }
            Mail::to($emails)->queue(new ConfirmBooking($room, $reservation));
            $room->update(['workinghours' => $Newavailablehours]);
            return [
                'message' => 'booking updated ',
                'code' => '200',

            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
       $booking->delete();
       return [
        'message' => 'this Booking Was Deleted',
        'code' => '200',

    ];
    }

    public function checkbooking($id, $check)
    {

        //   return $id ;
        // return $validated['id'] ;
        $booking = Booking::whereId($id)->first();
        // return $booking ;
        if($check == 1) {
            $booking->update(['status' => $check ]);
            return [
                'message' => 'this Booking Request is Accepted',
                'code' => '200',
                'status' => 'Accept booking'
            ];
        } elseif($check == 2) {
            $booking->update(['status' => $check ]);
            return [
                'message' => 'this Booking Request is Reject ',
                'code' => '400',
                'status' => 'decline booking'
            ];


        }
    }
   
}
