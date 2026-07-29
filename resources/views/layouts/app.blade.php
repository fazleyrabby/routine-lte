<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('title')</title>
    <meta content="Admin Dashboard" name="description" />
    <link href="{{ asset('backend/tabler/css/tabler.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/tabler/css/tabler-flags.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/tabler/css/tabler-vendors.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/tabler/css/tabler-themes.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/dist/css/custom.css') }}" rel="stylesheet" />
    <style>
        @import url("https://rsms.me/inter/inter.css");
    </style>
    @yield('stylesheets')
</head>
<body>
    <script src="{{ asset('backend/tabler/js/tabler-theme.min.js') }}"></script>
    <div class="page">

        @if(Auth::check())
            @include('layouts.partials.nav')
        @endif

        <div class="page-wrapper">
            @if(Auth::check())
                @include('layouts.partials.breadcrumbs')
            @endif

            <div class="page-body">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            @include('layouts.partials.footer')
        </div>

    </div>

    <!-- Tabler Core -->
    <script src="{{ asset('backend/tabler/js/tabler.min.js') }}" defer></script>
    <!-- jQuery (needed for DataTables) -->
    <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    @stack('script')
</body>
</html>
