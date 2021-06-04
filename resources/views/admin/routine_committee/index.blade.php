@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- page wrapper start -->
    <div class="wrapper">
        <div class="page-title-box">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-sm-12">

                        <h4 class="page-title">Teachers</h4>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}

                    </div>
                </div>
            </div>
            <!-- end container-fluid -->

        </div>
        <!-- page-title-box -->

        <div class="page-content-wrapper">
            <div class="container-fluid">
                <!-- end row -->

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 header-title mb-4">Latest Trasaction</h4>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                        <tr>
                                            <th scope="col">(#) Id</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col" colspan="2">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row">#15236</th>
                                            <td>
                                                <div>
                                                    <img src="assets/images/users/user-2.jpg" alt="" class="thumb-md rounded-circle mr-2"> Jeanette James
                                                </div>
                                            </td>
                                            <td>14/8/2018</td>
                                            <td>$104</td>
                                            <td><span class="badge badge-success">Delivered</span></td>
                                            <td>
                                                <div>
                                                    <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">#15237</th>
                                            <td>
                                                <div>
                                                    <img src="assets/images/users/user-3.jpg" alt="" class="thumb-md rounded-circle mr-2"> Christopher Taylor
                                                </div>
                                            </td>
                                            <td>15/8/2018</td>
                                            <td>$112</td>
                                            <td><span class="badge badge-warning">Pending</span></td>
                                            <td>
                                                <div>
                                                    <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">#15238</th>
                                            <td>
                                                <div>
                                                    <img src="assets/images/users/user-4.jpg" alt="" class="thumb-md rounded-circle mr-2"> Edward Vazquez
                                                </div>
                                            </td>
                                            <td>15/8/2018</td>
                                            <td>$116</td>
                                            <td><span class="badge badge-success">Delivered</span></td>
                                            <td>
                                                <div>
                                                    <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">#15239</th>
                                            <td>
                                                <div>
                                                    <img src="assets/images/users/user-5.jpg" alt="" class="thumb-md rounded-circle mr-2"> Michael Flannery
                                                </div>
                                            </td>
                                            <td>16/8/2018</td>
                                            <td>$109</td>
                                            <td><span class="badge badge-primary">Cancel</span></td>
                                            <td>
                                                <div>
                                                    <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">#15240</th>
                                            <td>
                                                <div>
                                                    <img src="assets/images/users/user-6.jpg" alt="" class="thumb-md rounded-circle mr-2"> Jamie Fishbourne
                                                </div>
                                            </td>
                                            <td>17/8/2018</td>
                                            <td>$120</td>
                                            <td><span class="badge badge-success">Delivered</span></td>
                                            <td>
                                                <div>
                                                    <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 header-title mb-4">Latest Order</h4>
                                <div class="table-responsive order-table">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                        <tr>
                                            <th scope="col">(#) Id</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Date/Time</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col" colspan="2">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row">#14562</th>
                                            <td>
                                                <div>
                                                    <img src="assets/images/users/user-4.jpg" alt="" class="thumb-md rounded-circle mr-2"> Matthew Drapeau
                                                </div>
                                            </td>
                                            <td>17/8/2018
                                                <p class="font-13 text-muted mb-0">8:26AM</p>
                                            </td>
                                            <td>$104</td>
                                            <td><span class="badge badge-success badge-pill"><i class="mdi mdi-checkbox-blank-circle text-success"></i> Delivered</span></td>
                                            <td>
                                                <div>
                                                    <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">#14563</th>
                                            <td>
                                                <div>
                                                    <img src="assets/images/users/user-5.jpg" alt="" class="thumb-md rounded-circle mr-2"> Ralph Shockey
                                                </div>
                                            </td>
                                            <td>18/8/2018
                                                <p class="font-13 text-muted mb-0">10:18AM</p>
                                            </td>
                                            <td>$112</td>
                                            <td><span class="badge badge-warning badge-pill"><i class="mdi mdi-checkbox-blank-circle text-warning"></i> Pending</span></td>
                                            <td>
                                                <div>
                                                    <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">#14564</th>
                                            <td>
                                                <div>
                                                    <img src="assets/images/users/user-6.jpg" alt="" class="thumb-md rounded-circle mr-2"> Alexander Pierson
                                                </div>
                                            </td>
                                            <td>18//8/2018
                                                <p class="font-13 text-muted mb-0">12:36PM</p>
                                            </td>
                                            <td>$116</td>
                                            <td><span class="badge badge-success badge-pill"><i class="mdi mdi-checkbox-blank-circle text-success"></i> Delivered</span></td>
                                            <td>
                                                <div>
                                                    <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">#14565</th>
                                            <td>
                                                <div>
                                                    <img src="assets/images/users/user-7.jpg" alt="" class="thumb-md rounded-circle mr-2"> Robert Rankin
                                                </div>
                                            </td>
                                            <td>19/8/2018
                                                <p class="font-13 text-muted mb-0">11:47AM</p>
                                            </td>
                                            <td>$109</td>
                                            <td><span class="badge badge-primary badge-pill"><i class="mdi mdi-checkbox-blank-circle text-primary"></i> Cancel</span></td>
                                            <td>
                                                <div>
                                                    <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">#14566</th>
                                            <td>
                                                <div>
                                                    <img src="assets/images/users/user-8.jpg" alt="" class="thumb-md rounded-circle mr-2"> Myrna Shields
                                                </div>
                                            </td>
                                            <td>20/8/2018
                                                <p class="font-13 text-muted mb-0">02:52PM</p>
                                            </td>
                                            <td>$120</td>
                                            <td><span class="badge badge-success badge-pill"><i class="mdi mdi-checkbox-blank-circle text-success"></i> Delivered</span></td>
                                            <td>
                                                <div>
                                                    <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container-fluid -->
        </div>
        <!-- end page content-->

    </div>
    <!-- page wrapper end -->
@endsection
