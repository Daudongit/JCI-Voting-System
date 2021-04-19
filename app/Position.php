<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{   
     /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($position) {
            $position->slots->each->delete();
        });
    }

    public function nominees()
    {
        return $this->hasMany(Nominee::class);
    }

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }

    public function scopeFilter($query,$keywords)
    {   
        return $keywords?$query->where('name','like',"%".$keywords."%"):$query;
    } 
}
