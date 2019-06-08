<?php

namespace App\Http\Middleware;

use Closure;
use App\Voter;
use App\Mail\PleaseConfirmYourEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class IsVotableMiddleware
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
        if(!Voter::where('email',$request->email)->exits())
        {
            $voter = Voter::create([
                'email'=>$request->email,
                'confirmation_token' => str_limit(
                    md5($request->email . str_random()), 25, ''
                )
            ]);

            Mail::to($voter)->send(new PleaseConfirmYourEmail($voter));

            return redirect(route('front.vote.login'))->withStatus(
                __(
                    'A confirmation link has been send to your email.
                    please confirm your account to complete the voting'
                 )
            );
        }
        else
        {
            return $next($request);
        }
    }
}
