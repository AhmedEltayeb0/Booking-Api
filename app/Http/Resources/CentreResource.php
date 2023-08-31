<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CentreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'from' => $this->from,
            'to' => $this->to,
            'period' => $this->period,
            'rooms' => RoomResource::collection($this->rooms),
            'created_at' => $this->created_at,
        ];
    }

    public function with(Request $request){
        return [
            'code' =>'200' ,
            'status' =>'success' ,
        ];
    }
}
