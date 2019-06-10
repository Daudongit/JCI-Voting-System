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
        if(filter_var($request->email, FILTER_VALIDATE_EMAIL) === false)
        {   
            return redirect(route('front.vote.login'))->withWarning(
                __('Please enter a valid email address')
            );
        }

        if($this->condition($request))
        {
            $voter = $this->createVoter($request);

            Mail::to($voter)->send(new PleaseConfirmYourEmail($voter));

            return redirect(route('front.vote.login'))->withSuccess(
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

    private function condition($request)
    {
       return !Voter::where('email',$request->email)->exists() ||
            !is_null(Voter::where('email',$request->email)->first()
                ->confirmation_token);
    }

    private function createVoter($request)
    {   
        Voter::where('email',$request->email)->delete();

        return Voter::create([
            'email'=>$request->email,
            'confirmation_token' => str_limit(
                md5($request->email . str_random()), 25, ''
            )
        ]);
    }
}
