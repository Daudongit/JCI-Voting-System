<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>JCI Voting system</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="/assets/css/login.css">
    </head>
    <body>
        <div class="login-form">
            <form action="/examples/actions/confirmation.php" method="post">
                <h2 class="text-center">Sign in</h2>		
                <div class="text-center social-btn">
                    {{-- <a href="#" class="btn btn-primary btn-block"><i class="fa fa-facebook"></i> Sign in with <b>Facebook</b></a>
                    <a href="#" class="btn btn-info btn-block"><i class="fa fa-twitter"></i> Sign in with <b>Twitter</b></a> --}}
                    <a href="#" class="btn btn-danger btn-block"><i class="fa fa-google"></i> Sign in with <b>Google</b></a>
                </div>
                <div class="or-seperator"><i>or</i></div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" name="email" placeholder="...enter your email address" required="required">
                    </div>
                </div>
                {{-- <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="password" class="form-control" name="password" placeholder="Password" required="required">
                    </div>
                </div>         --}}
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block login-btn">Start Voting</button>
                </div>
                {{-- <div class="clearfix">
                    <label class="pull-left checkbox-inline"><input type="checkbox"> Remember me</label>
                    <a href="#" class="pull-right text-success">Forgot Password?</a>
                </div>   --}}
                
            </form>
            {{-- <div class="hint-text small">Don't have an account? <a href="#" class="text-success">Register Now!</a></div> --}}
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>                            