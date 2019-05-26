<?php

namespace App;

//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Nominee extends Model
{   
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
