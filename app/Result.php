<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{   
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
    // public function scopeVotes($query)
    // {
    //     return $query->select(
    //         \DB::Raw(
    //             'select title from positions where position.id=results.position_id as post',
    //             'select name from nominees where nominees.id=results.nominee_id as nominee',
    //             'select title from elections where elections.id=results.election_id as election',
    //             'created_at'
    //         )
    //     );
    // }
}
