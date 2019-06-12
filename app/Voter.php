<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Voter extends Authenticatable
{
    //use Notifiable;

    protected $fillable = ['email','confirmation_token','ip'];
    /**
     * Mark the user's account as confirmed.
     */
    public function confirm()
    {
        $this->confirmation_token = null;

        $this->save();
    }
}
