<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;


class Customr extends Authenticatable
{
    use HasFactory , softDeletes , HasApiTokens;
     
    protected $guarded =[];
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
}
