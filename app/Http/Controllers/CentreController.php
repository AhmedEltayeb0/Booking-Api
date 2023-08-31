<?php

namespace App\Http\Controllers;

use App\Models\Centre;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Resources\CentreResource;


class CentreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centres = Centre::with('rooms')->get();
        return [
            'data' => $centres ,
            'status' => 'succes'
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request = $request->validate([
            'name' =>'required|string',
            'phone' => 'required|numeric' ,
            'address'=> 'string|required',
            'capacity' =>'required|numeric',
             'date_from' =>'required|date_format:Y-m-d',
             'date_to' =>'required|date_format:Y-m-d',
             'from' =>'required|date_format:H:i',
             'to' =>'required|date_format:H:i',
        ]);
        if($request){
            // return "done" ;
            $from = strtotime($request['from']);
            $to = strtotime($request['to']);
            $period = gmdate('H:i', $to - $from);
            $centre = Centre::create([
                'name' => $request['name'],
                'phone' => $request['phone'],
                'address' => $request['address'],
                'capacity' => $request['capacity'],
                'date_from' => $request['date_from'],
                'date_to' => $request['date_to'],
                'from' => $request['from'],
                'to' => $request['to'],
                'period' => $period ,
            ]);
            // $centre->rooms()->createMany([],[],[]);
            for( $i=1 ; $i<= $request['capacity'] ; $i++){

                $room[$i] = $centre->rooms()->create([
                'name' => "Room" . $i,
                'price/hour' => "100",
                'capacity' => "50",
                'status' => 0
                ]);
            }

            return new CentreResource($centre);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Centre $centre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Centre $centre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Centre $centre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Centre $centre)
    {
        //
    }
}
