<?php

namespace App;

//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Nominee extends Model
{   
    protected $fillable = [
        'first_name','last_name',
        'email','description','image'
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

}
