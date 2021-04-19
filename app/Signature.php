<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    protected $fillable = ['ip','election_id','browser_signature'];
}