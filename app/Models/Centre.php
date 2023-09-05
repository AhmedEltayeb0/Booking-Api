<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Centre extends Model
{
    use HasFactory , softDeletes;

    protected $guarded =[];


    public function rooms()
    {
        return $this->hasMany(Room::class , 'centre_id');
    }

    public function users()
    {
        return $this->hasMany(User::class , 'centre_id');
    }

    
}
