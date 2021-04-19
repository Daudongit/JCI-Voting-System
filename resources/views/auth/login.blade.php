@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/login.css')}}">
@endpush
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="login-form">
                    <form method="POST" action="{{ route('admin.login') }}">
                        {{ csrf_field() }}
                        <h2 class="text-center">Admin Sign in</h2>		
                        <div class="text-center social-btn"></div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>        
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block login-btn">Login</button>
                        </div>
                    </form>
                    <div class="hint-text small">Voting page <a href="/" class="text-success">Vote Now!</a></div>
                </div>
            </div>
        </div>
    </div>
@endsection                         