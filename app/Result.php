<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{   
    protected $appends = [
        'voter','post','nominee','election','signature_id'
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

    public function voter(){
        return $this->belongsTo(Voter::class);
    }

    public function position(){
        return $this->belongsTo(Position::class);
    }

    public function nominee(){
        return $this->belongsTo(Nominee::class);
    }

    public function election(){
        return $this->belongsTo(Election::class);
    }

    public function signature(){
        return $this->belongsTo(Signature::class);
    }

    public function scopeFilter($query,$keywords)
    {   
        if($keywords)
        {   
            return $query->whereHas('voter', function ($query) use($keywords){
                    $query->where('email',$keywords);
                })
                ->orWhereHas('position', function ($query) use($keywords){
                    $query->where('name',$keywords);
                })
                ->orWhereHas('nominee', function ($query) use($keywords){
                    $query->where('first_name','like',"%".$keywords."%")
                    ->orWhere('last_name','like',"%".$keywords."%");
                })
                ->orWhereHas('election', function ($query) use($keywords){
                    $query->where('title',$keywords);
                }
            );
        }
        return $query;
    }
}
