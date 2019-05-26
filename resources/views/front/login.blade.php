@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/login.css')}}">
@endpush
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="login-form">
                    <form action="{{route('front.vote.attempt')}}" method="post">
                        <h2 class="text-center">Sign in</h2>		
                        <div class="text-center social-btn">
                            <a href="#" class="btn btn-danger btn-block"><i class="fa fa-google"></i> Sign in with <b>Google</b></a>
                        </div>
                        <div class="or-seperator"><i>or</i></div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" name="email" placeholder="...enter your email address" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-success btn-block login-btn">login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection