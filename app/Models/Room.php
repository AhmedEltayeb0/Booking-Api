<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Room extends Model
{
    use HasFactory , softDeletes;
     
    protected $guarded =[];


    public function centre(): BelongsTo
    {
        return $this->belongsTo(Centre::class , 'Centre' , 'centre_id');
    }



    public function timeslots()
    {
        return $this->belongsToMany(Timeslot::class);
    }
}
