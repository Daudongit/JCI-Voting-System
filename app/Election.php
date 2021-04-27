<?php

namespace App;

use App\Slot;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
     /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($election) {
            $election->results->each->delete();
        });
    }
    
    protected $dates = ['start','end'];

    public function slots()
    {
        return $this->belongsToMany(Slot::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    /**
     * Check if the election is closed
     *
     * @return bool
     */
    public function isLocked()
    {   
        return $this->status === 0;
    }

    /*
     * Check if the election is open
     *
     * @return bool
     */
    public function isOpen()
    {
        return !$this->isLocked();
    }

    /**
     * Running is open and started
     *
     * @return bool
     */
    public function isRunning()
    {
        return $this->isOpen() && $this->hasStarted();
    }

    /**
     * If the election has already started
     *
     * @return bool
     */
    public function hasStarted()
    {
        return $this->start <= Carbon::now();
    }

    /**
     * Is open and will start in the future
     *
     * @return bool
     */
    public function isComingSoon()
    {
        return $this->isOpen() && Carbon::now() < $this->start;
    }

    public function isEnd()
    {
        return Carbon::now() > $this->end;
    }
}
