<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Voter extends Authenticatable
{
    //use Notifiable;

    /**
     * Mark the user's account as confirmed.
     */
    public function confirm()
    {
        $this->confirmation_token = null;

        $this->save();
    }
}
