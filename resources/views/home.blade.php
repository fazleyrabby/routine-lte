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
    <div class="row justify-content-center align-items-center" style="height: 80vh">
        <div class="col-md-8 pt-4">
            <div class="card bg-none">
                <h4 class="text-center my-3">Select option</h4>
                <div class="card-body">
                        <div class="form-group row mb-0">
                            <div class="col-md-6">
                                <a class="w-100 btn btn-primary" href="{{ route('routine') }}">
                                    View Routine
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a class="w-100 btn btn-danger" href="{{ route('login') }}">
                                    login
                                </a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>


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




