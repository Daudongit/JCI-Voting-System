<?php

namespace App\Http\Middleware;

use Closure;
use App\Result;
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
        if (Result::where('voter_id', Auth::guard('voter')->id())->count() > 0)
        {   
            Auth::guard('voter')->logout();

            $request->session()->invalidate();

            return redirect(route('front.vote.login'))->withWarning(
                __('You can only vote once.')
            );
        } 
            
        return $next($request);
    }
}
