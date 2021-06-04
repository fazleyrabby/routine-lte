@extends('layouts.app')

@section('title', 'Profile')

@section('stylesheets')
    <!-- DataTables -->
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <!-- end row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mt-0 header-title mb-4 text-center">
                               <h4>Role Access</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <table class="table table-striped table-bordered dt-responsive nowrap"
                                           style="font-size: 15px">
                                            <thead>
                                                <tr>
                                                    <th>User Type</th>
                                                    <th>In Committee</th>
                                                    <th>Temporary Routine Access</th>
                                                    <th>Access</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <tr>
                                                <td>Admin</td>
                                                <td>Yes / No</td>
                                                <td>-</td>
                                                <td>
                                                    <ul>
                                                        <li>All Module Access</li>
                                                        <li>Can Update Any module</li>
                                                        <li>Can Generate Routine</li>
                                                        <li>Can Access Application Settings</li>
                                                        <li>Can Add new admin/users</li>
                                                        <li>Can add other users in routine committee</li>
                                                        <li>Can give temporary access of generate routine to users</li>
                                                        <li>Can give access of generate routine to other users</li>
                                                        <li>Print Routines</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>User</td>
                                                <td>Yes</td>
                                                <td>-</td>
                                                <td>
                                                    <ul>
                                                        <li>Can Generate Routine</li>
                                                        <li>Can View all type Routine</li>
                                                        <li>Print Routines</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>User</td>
                                                <td>No</td>
                                                <td>-</td>
                                                <td>
                                                    <ul>
                                                        <li>Can View all type Routine</li>
                                                        <li>Print Routines</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>User</td>
                                                <td>No</td>
                                                <td>Active</td>
                                                <td>
                                                    <ul>
                                                        <li>Can Generate Routine (*Limited time access)</li>
                                                        <li>Can View all type Routine</li>
                                                        <li>Print Routines</li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Guest</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td>
                                                    <ul>
                                                        <li>Can View all type Routine</li>
                                                        <li>Print Routines</li>
                                                    </ul>
                                                </td>
                                            </tr>

                                            </tbody>

                                    </table>
                                </div>

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

