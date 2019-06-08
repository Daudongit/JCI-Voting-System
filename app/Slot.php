<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{   
    //protected $with = ['position'];

    public function nominees()
    {
        return $this->belongsToMany(Nominee::class);
    }

    public function nomineesWithResultCount($electionId)
    {
        return $this->nominees()->withCount(
            [
                'results'=>function($query)use($electionId){
                    $query->where('election_id',$electionId);
                }
            ]
        )->get();
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

}

