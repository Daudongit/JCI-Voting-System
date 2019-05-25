<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Nominee extends Authenticatable
{   
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
