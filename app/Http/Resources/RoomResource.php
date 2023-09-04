<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'centre_id' => $this->centre_id,
            'name' => $this->name,
            // 'date_from' => $this->date_from,
            'priceperhour' => $this->priceperhour ,
            'capacity' => $this->capacity,
            'status' => "0",
            'workinghours' =>$this->workinghours,
            'period' => $this->period,
            // 'created_at' => $this->created_at,
        ];
    }
    public function with(Request $request){
        return [
            'code' =>'200' ,
            'status' =>'success' ,
        ];
    }

    // public function workinghours($from , $to){

    //     return 'Array' ;

    // }
}
