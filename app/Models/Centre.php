<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Centre extends Model
{
    use HasFactory ,softDeleted;

    protected $guarded =[];


    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    
}
