<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Routine Management System</title>
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
                <h2 class="navbar-brand navbar-brand-autodark">Routine Management System</h2>
            </div>
            <div class="card card-md">
                <div class="card-body text-center">
                    <h3 class="mb-4">Select option</h3>
                    <div class="row g-2">
                        <div class="col-6">
                            <a class="btn btn-primary w-100" href="{{ route('routine') }}">View Routine</a>
                        </div>
                        <div class="col-6">
                            <a class="btn btn-danger w-100" href="{{ route('login') }}">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('backend/tabler/js/tabler.min.js') }}" defer></script>
</body>
</html>
