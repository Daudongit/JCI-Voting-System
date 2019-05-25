<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{   
    //protected $with = ['position'];

    public function nominees()
    {
        return $this->belongsToMany(Nominee::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
