<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Room extends Model
{
    use HasFactory , softDeletes;

    protected $guarded =[];



    protected $casts = [
        'workinghours' => 'array',
    ];

    public function centre()
    {
        return $this->belongsTo(Centre::class);
    }



    public function timeslots()
    {
        return $this->belongsToMany(Timeslot::class);
    }
}
