<?php

namespace App\Http\Middleware;

use Closure;
use App\Voter;
use App\Result;
use App\Ipvalidation;
use Illuminate\Support\Facades\Auth;

class IsVotedMiddleware
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
        if ($this->hasEmail($request) || $this->hasIp($request))
        {   
            Auth::guard('voter')->logout();

            $request->session()->invalidate();

            return redirect(route('front.vote.login'))->withWarning(
                __('You can only vote once.')
            );
        } 
            
        return $next($request);
    }

    // private function conditions($request)
    // {   
    //     return (Result::where(
    //         'voter_id', Auth::guard('voter')->id()
    //         )->count() > 0
    //     ) ||
    //     Ipvalidation::where(
    //         [
    //             ['ip','=',$request->ip()],
    //             ['election_id','=',$request->route('election')->id]
    //         ]
    //     )->exists();
    // }

    private function hasEmail()
    {
        return Result::where(
            'voter_id', Auth::guard('voter')->id()
        )->count() > 0;
    }

    private function hasIp($request)
    {
        $usedIp = Ipvalidation::where(
            [
                ['ip','=',$request->ip()],
                ['election_id','=',$request->route('election')->id]
            ]
        )->exists();

        if($usedIp && !config('app.enable_email_voting'))
        {
            Voter::where('email',auth('voter')->user()->email)->delete();
        }

        return $usedIp;
    }
}
