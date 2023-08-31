<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;
use App\Models\Centre;
use App\Models\Room;
use Auth ;

class BookingController extends Controller
{
    public function __construct()

    {
        //  $this->middleware('auth', ['except' => ['login', 'register', 'forgetPassword' , 'resetPassword']]);

        // $this->middleware('auth:user_api', ['except' => ['login', 'register', 'forgetPassword' , 'resetPassword']]);

        // $this->middleware('auth:customrs_api', ['except' => ['login', 'register', 'forgetPassword' , 'resetPassword']]);
        $this->middleware('auth:customrs_api');
    }
    public function index()
    {
        //
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
       if($validate){
        $room = Room::whereId($request['room_id'])->first();
        $centre = $room->centre()->first();
        // $timeroom = centre->
        // return $timecentre ;
        $room_status = $room->status;  // if 0 off -- 1 is on
        if($room_status == 0){
            return [
                'message' => 'this room is offline Now',
                'code' => '400',
                'status' => 'decline booking'
            ];







        }elseif($room_status == 1){
            $from = strtotime($request['from']);
            $to = strtotime($request['to']);
            $period = gmdate('H:i', $to - $from);
            // $period =  $request['from'] - $request['from'] ;
            // return $period ;
            $reservation = Booking::create(
                [
            'customr_id' => Auth::user()->id,
            'room_id' => $request['room_id'],
            'booking_date' => $request['booking_date'],
            'from' => $request['from'],
            'to' => $request['to'],
            'period' =>  $period,
            'status' => 0, // 0 pending - 1 is accept - 2 is reject
                ]
            );
            return [
                'message' => 'add booking successfuly' ,
                'code' => 200 ,
            ];
        }else{

        }

        // $centre = Room::whereRoom_id($request['room_id'])->get() ;
        // $centre = Centre::whereRoom_id($request['room_id'])->get() ;
        // return $centre ;

       }
    }
    public  function time($start ,$end){
    return $start;


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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
