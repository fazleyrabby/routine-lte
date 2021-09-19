@section('title', 'Login')
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title> @yield('title') </title>
        <meta content="Admin Dashboard" name="description" />
          <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="{{asset ('backend/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset ('backend/dist/css/adminlte.min.css') }}">
        @yield('stylesheets')
    </head>
<body>

<style>
     body {
        background: linear-gradient(rgba(0, 0, 0, .50),rgba(0, 0, 0, .50) ), url( 'https://images.pexels.com/photos/3473569/pexels-photo-3473569.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260');
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>
<div class="container">
    <h4 class="text-center mt-4 text-light">Routine Management System</h4>
    <div class="row justify-content-center">
        <div class="col-md-8 pt-4">
            <div class="card">
                <div class="card-header">
                    Login
                    <a href="{{ route('home') }}" class="btn btn-sm btn-primary float-right">Home</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail / Username') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control
                                @if ($errors->has('username') || $errors->has('email'))
                                    is-invalid
                                @endif " name="login" value="{{ old('username') ?: old('email') }}" required autocomplete="login" autofocus>

                                @if ($errors->has('username') || $errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif


                            </div>

{{--                            <div class="col-md-8 offset-md-4 pt-3">--}}
{{--                                Don't have account??--}}
{{--                                <a class="" href="{{ route('register') }}">--}}
{{--                                    Register here--}}
{{--                                </a>--}}
{{--                            </div>--}}


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




</body>
</html>


