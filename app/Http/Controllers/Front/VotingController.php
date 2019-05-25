<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Election;
use App\Result;

class VotingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function show(Election $election)
    {
        return view('front.vote',compact('election'));
    }

    public function store($election)
    {
        $selectedPositions = $request->except('_token');
        $results = array_map(function($selectedNominee,$position)use($election){
            return [
                'voter_id'=>1,
                'position_id'=>$position,
                'nominee_id'=>$selectedNominee,
                'election_id'=>$election
            ];
        },$selectedPositions,array_keys($selectedPositions));

        Result::insert($results);
    }
}
