<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Error</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="" name="author" />

    <link href="{{asset ('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset ('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset ('assets/css/style.css') }}" rel="stylesheet" type="text/css">
</head>

<body>

<!-- Background -->
<div class="account-pages"></div>

<!-- Begin page -->
<div class="wrapper-page">
    <div class="card">
        <div class="card-block">

            <div class="ex-page-content text-center">
                <h1 class="text-dark">404!</h1>
                <h5 class="">Sorry, You are not allowed to access this page!</h5><br>
                <a class="btn btn-info mb-5 waves-effect waves-light" href="{{ route('admin') }}"><i class="mdi mdi-home"></i> Back to Dashboard</a>
            </div>

        </div>
    </div>


</div>


</body>

</html>
