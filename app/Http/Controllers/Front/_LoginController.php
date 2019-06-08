<?php

namespace App\Http\Controllers\Front;

use App\Voter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class LoginController extends Controller
{   
    use ThrottlesLogins;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:voter')->except('logout');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginForm()
    {
        return view('front.login');
    }

    public function loginAttempt(Request $request)
    {   
        $this->validate($request, [
            $this->username() => 'required|email',
        ]);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $findUser = Voter::whereEmail($request->email)->first();
		
        if($findUser == null)
		{   
            $this->incrementLoginAttempts(request());
            
            return redirect(route('front.vote.login'))->with([
                'warning'=>__('You have no permission to login')
            ]);
        }

        $this->loginFindUser($findUser);

        return redirect(route('front.elections.index'));
    }

    public function logout(Request $request)
    {
        Auth::guard('voter')->logout();

        $request->session()->invalidate();

        return redirect(route('front.vote.login'));
        //return redirect(route('front.vote.attempt'));
    }

    public function username()
    {
        return 'email';
    }

    private function loginFindUser($findUser)
    {
        Auth::guard('voter')->login($findUser);
        
        request()->session()->regenerate();

        $this->clearLoginAttempts(request());
    }

    public function confirmation()
    {
        $voter = Voter::where('confirmation_token', request('token'))->first();

        if (! $voter) {
            return redirect(route('front.vote.login'))->withWarning(
                __('Unknown token.')
            );
        }

        $voter->confirm();

        auth('voter')->login($voter);

        return redirect(route('front.elections.index'));
    }
}
