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

    public function scopeFilter($query,$keywords)
    {   
        if($keywords)
        {   
            return $query->where('first_name','like',"%".$keywords."%")
                   ->orWhere('last_name','like',"%".$keywords."%")
                   ->orWhere('description','like',"%".$keywords."%");
        }
        return $query;
    }
}
