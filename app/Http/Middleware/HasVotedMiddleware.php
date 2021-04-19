<?php

namespace App\Http\Middleware;

use Closure;
use App\Voter;
use App\Result;
use App\Signature;
use Illuminate\Support\Facades\Auth;

class HasVotedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->hasEmail($request) || $this->hasSignature($request))
        {   
            Auth::guard('voter')->logout();

            $request->session()->invalidate();

            return redirect(route('front.vote.login'))->withWarning(
                __('You can only vote once.')
            );
        } 
            
        return $next($request);
    }

    private function hasEmail()
    {
        return Result::where(
            'voter_id', Auth::guard('voter')->id()
        )->count() > 0;
    }

    private function hasSignature($request)
    {   
        $electionId = $request->route('election')->id;
        $usedIp = Signature::where([
            ['ip','=',$request->ip()],
            ['election_id','=',$electionId]
        ])->orWhere([
            ['browser_signature','=',session()->get('sign')],
            ['election_id','=',$electionId]
        ])->exists();

        if($usedIp && !config('app.enable_email_voting'))
        {
            Voter::where('email',auth('voter')->user()->email)->delete();
        }

        return $usedIp;
    }
}
