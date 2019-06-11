<?php

namespace App\Http\Controllers\Front;

use App\Result;
use App\Election;
use App\Ipvalidation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VotingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:voter');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $elections = Election::withCount(['results','slots'])
            ->oldest('start')->paginate(20);

        return view('front.elections',compact('elections'));
    }

    public function show(Election $election)
    {
        return view('front.vote',compact('election'));
    }

    public function store(Request $request,$election)
    {   
        $selectedPositions = $request->except(['_token','election']);
        
        $results = array_map(function($selectedNominee,$position)use($election){
            return [
                'voter_id'=>auth('voter')->id(),
                'position_id'=>$position,
                'nominee_id'=>$selectedNominee,
                'election_id'=>$election
            ];
        },$selectedPositions,array_keys($selectedPositions));
       
        \DB::transaction(function()use($election,$results,$request){
            Result::insert($results);

            Ipvalidation::create([
                'ip'=>$request->ip(),
                'election_id'=>$election
            ]);
        });
        
        return redirect(route('front.elections.index'))->withSuccess(
            __('Thank you for voting.')
        );
    }
}
