<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ipvalidation extends Model
{
    protected $fillable = ['ip','election_id'];
}