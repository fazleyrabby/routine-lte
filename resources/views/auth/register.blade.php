@section('title', 'Register')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('title')</title>
    <link href="{{ asset('backend/tabler/css/tabler.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/tabler/css/tabler-themes.css') }}" rel="stylesheet" />
    <style>
        @import url("https://rsms.me/inter/inter.css");
        body {
            background: linear-gradient(rgba(0, 0, 0, .50), rgba(0, 0, 0, .50)), url('https://images.pexels.com/photos/3473569/pexels-photo-3473569.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body>
    <script src="{{ asset('backend/tabler/js/tabler-theme.min.js') }}"></script>
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <h2 class="text-white">Routine Management System</h2>
            </div>
            <div class="card card-md">
                <div class="card-body">
                    <h2 class="h2 text-center mb-4">Register</h2>
                    <form method="POST" action="{{ route('register') }}" autocomplete="off">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('Username') }}</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" autocomplete="username" autofocus>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('E-Mail Address') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Password') }}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Confirm Password') }}</label>
                            <input type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">{{ __('Register') }}</button>
                        </div>
                        <div class="text-center text-secondary mt-3">
                            Already have an account? <a href="{{ route('login') }}">Login here!</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('backend/tabler/js/tabler.min.js') }}" defer></script>
</body>
</html>
