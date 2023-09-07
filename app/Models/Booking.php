<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Booking extends Model
{
    use HasFactory, softDeletes;
     
    protected $guarded =[];

    public function customr()
    {
        return $this->belongsTo(Customr::class);
    }
}
