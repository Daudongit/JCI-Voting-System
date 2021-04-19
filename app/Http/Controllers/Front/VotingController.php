<?php

namespace App\Http\Controllers\Front;

use Closure;
use App\Result;
use App\Election;
use App\Signature;
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
        $this->middleware(['auth:voter',function($request, Closure $next){
            if (!session()->has('sign')){
                session()->put('sign',session()->get('signature'));
            }
            return $next($request);
        }]);
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
        $selectedPositions = $request->except(['_token','election','signature']);
        $browserSignature = $request->signature;
        \Log::info($browserSignature);
        $ip = $request->ip();
        \DB::transaction(function()use($selectedPositions,$browserSignature,$election,$ip){
            $signature = Signature::create([
                'ip'=>$ip,
                'browser_signature'=>$browserSignature,
                'election_id'=>$election
            ]);
            $results = $this->prepareResult($selectedPositions,$election,$signature->id);
            Result::insert($results);
        });
        
        return redirect(route('front.elections.index'))->withSuccess(
            __('Thank you for voting.')
        );
    }

    //Helper
    private function prepareResult($selectedPositions,$election,$signatureId){
        return array_map(function($selectedNominee,$position)use($election,$signatureId){
            return [
                'voter_id'=>auth('voter')->id(),
                'position_id'=>$position,
                'nominee_id'=>$selectedNominee,
                'election_id'=>$election,
                'signature_id'=>$signatureId
            ];
        },$selectedPositions,array_keys($selectedPositions));
    }
}
