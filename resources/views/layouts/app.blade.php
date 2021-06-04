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


@if(Auth::check())
    @include('layouts.partials.nav')
    @include('layouts.partials.breadcrumbs')
@endif
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper ml-0">
@yield('content')
<!-- /.content -->
</div>

<!-- /.content-wrapper -->
@include('layouts.partials.footer')



<!-- jQuery -->
<script src="{{asset ('backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset ('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{asset ('backend/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset ('backend/dist/js/demo.js') }}"></script>


</body>
</html>




