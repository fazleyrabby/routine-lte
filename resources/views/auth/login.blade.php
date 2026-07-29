@section('title', 'Login')
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
                    <a href="{{ route('routine') }}" class="btn btn-outline-info btn-sm mb-3">View Routine &rarr;</a>
                    <h2 class="h2 text-center mb-4">Login</h2>
                    <form method="POST" action="{{ route('login') }}" autocomplete="off">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('E-Mail / Username') }}</label>
                            <input type="text" class="form-control @if ($errors->has('username') || $errors->has('email')) is-invalid @endif" name="login" value="{{ old('username') ? old('email') : 'superadmin' }}" autocomplete="login" autofocus>
                            @if ($errors->has('username') || $errors->has('email'))
                                <div class="invalid-feedback">{{ $errors->first('username') ?: $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Password') }}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="123456" autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-check">
                                <input type="checkbox" class="form-check-input" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span class="form-check-label">{{ __('Remember Me') }}</span>
                            </label>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">{{ __('Login') }}</button>
                        </div>
                        <hr class="my-3">
                        <div class="row g-2">
                            <div class="col-6">
                                <button type="button" class="btn btn-dark w-100 quick-login" data-username="superadmin" data-password="123456">
                                    Admin
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-dark w-100 quick-login" data-username="alice_rahman" data-password="password">
                                    User
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.quick-login').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelector('input[name="login"]').value = this.dataset.username;
                document.querySelector('input[name="password"]').value = this.dataset.password;
                document.querySelector('form').submit();
            });
        });
    </script>
    <script src="{{ asset('backend/tabler/js/tabler.min.js') }}" defer></script>
</body>
</html>
