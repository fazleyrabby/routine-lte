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
                            <div class="mt-0 header-title mb-4">
                                {{ ucfirst($user->user->firstname)." ".ucfirst($user->user->lastname) }}
                                <a href="{{ route('profile_edit', $id) }}" class="btn btn-primary float-right ml-2">Edit</a>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="btn btn-dark float-right">Password Reset</a>
                                @endif

                                <a href="{{ route('password_edit') }}" class="btn btn-danger float-right mr-2">Password Edit</a>
                            </div>
                            @if (Session::has('message'))
                                <div class="alert-dismissable alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x
                                    </button>
                                    {{ Session('message') }}
                                </div>
                            @endif
                            @if (Session::has('delete-message'))
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x
                                    </button>
                                    {{ Session('delete-message') }}
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <table class="table table-striped table-bordered dt-responsive nowrap"
                                           style="font-size: 18px">
                                        @if($is_teacher)
                                            <tbody>
                                            <tr>
                                                <th>Photo</th>
                                                <td><img width="100" src={{ asset('storage/uploads/' . $user->user->photo)  }} alt=""></td>
                                            </tr>
                                            <tr>
                                                <th>Username</th>
                                                <td><strong>{{ $user->user->username }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>E-mail</th>
                                                <td><strong>{{ $user->user->email }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>Name</th>
                                                <td><strong>{{ ucfirst($user->user->firstname)." ".ucfirst($user->user->lastname) }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>Department</th>
                                                <td><strong class="text-uppercase">{{ $user->department->department_name }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>Rank</th>
                                                <td><strong class="text-uppercase">{{ $user->rank->rank }} </strong></td>
                                            </tr>
                                            <tr>
                                                <th>Role</th>
                                                <td><strong class="text-uppercase">{{ $user->user->role }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>In Committee</th>
                                                <td><strong class="text-uppercase">{{ $user->user->in_committee }}</strong></td>
                                            </tr>
                                            <tr>

                                                <th>Offday</th>
                                                <td>
                                                    @foreach($user->teachers_offday as $key => $offday)
                                                        {{ count( $user->teachers_offday ) != $key + 1 ? $offday->day->slug.',' : $offday->day->slug }}
                                                    @endforeach
                                                    &nbsp;&nbsp;<a href="{{ route('teacher_offday', $user->id) }}"
                                                                   class="btn btn-sm btn-secondary">Assign</a>
                                                </td>

                                            </tr>

                                            </tbody>
                                        @else
                                            <tbody>
                                            <tr>
                                                <th>Photo</th>
                                                <td><strong>{{ $user->photo }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>Username</th>
                                                <td><strong>{{ $user->username }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>E-mail</th>
                                                <td><strong>{{ $user->email }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>Name</th>
                                                <td><strong class="text-uppercase">{{ $user->firstname." ".$user->lastname }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>Role</th>
                                                <td><strong class="text-uppercase">{{ $user->role }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>In Committee</th>
                                                <td><strong class="text-uppercase">{{ $user->in_committee }}</strong></td>
                                            </tr>


                                            </tbody>
                                        @endif
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


@push('script')
    <!-- Datatable init js -->

    <!-- Required datatable js -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.colVis.min.js') }}"></script>
    <script src="../"></script>
    <!-- Buttons examples -->


    <script>
        $(document).ready(function () {
            $('#datatable').DataTable();

            //Buttons examples
            var table = $('#datatable-buttons').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print',]
            });

            table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
        });
    </script>


@endpush
