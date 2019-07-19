<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{   
    protected $appends = [
        'voter','post','nominee','election','ip'
    ];
    
    public function getVoterAttribute()
    {
        return Voter::find($this->voter_id)->email;
    }

    public function getIpAttribute()
    {
        return Voter::find($this->voter_id)->ip;
    }
    
    public function getPostAttribute()
    {
        return Position::find($this->position_id)->name;
    }

    public function getNomineeAttribute()
    {   
        $nominee = Nominee::find($this->nominee_id);

        return $nominee->first_name.' '.$nominee->last_name;
    }

    public function getElectionAttribute()
    {
        return Election::find($this->election_id)->title;
    }
}
