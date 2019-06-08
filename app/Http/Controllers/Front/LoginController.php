<?php

namespace App\Http\Controllers\Front;

use App\Voter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{   
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
        // $this->validate($request, [
        //     $this->username() => 'required|email',
        // ]);

        $findUser = Voter::whereEmail($request->email)->first();
        
        Auth::guard('voter')->login($findUser);
        
        request()->session()->regenerate();

        return redirect(route('front.elections.index'));
    }

    public function logout(Request $request)
    {
        Auth::guard('voter')->logout();

        $request->session()->invalidate();

        return redirect(route('front.vote.login'));
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
