@extends('layouts.app')

@section('title', 'Users')

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
                                Users - List
                                <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary float-right">Add New</a>
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
                            <table id="datatable-buttons"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>In Routine Committee</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th>Routine Access</th>
                                    <th>Invite for Routine Entry</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($users as $key => $user)
                                    <tr>
                                        <td>{{ $sl++ }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->firstname." ".$user->lastname }}</td>
                                        <td><strong class="text-uppercase">{{ $user->role }}</strong></td>
                                        <td><strong class="text-uppercase">{{ $user->in_committee }}</strong></td>
                                        <td>{{ $user->is_active == 'yes' ? 'Active' : 'Inactive' }}</td>
                                        <td>


{{--                                            <a href="{{ route('users.edit', $user->id) }}"--}}
{{--                                               class="btn btn-sm btn-primary">Edit</a>--}}

{{--                                            <button type="button" class="btn btn-sm btn-{{ $user->is_active == 'yes' ? 'danger' : 'warning' }}" data-toggle="modal" data-target=".bs-example-modal-center{{$user->id}}">{{ $user->is_active == 'yes' ? 'Inactive' : 'Active' }}</button>--}}
                                        </td>
                                        <td>
                                            @if(!empty($user->receiver->request_status))
                                                    <span class="p-2 text-light font-weight-bold {{ $user->receiver->request_status == 'active' && $user->receiver->expired_date >= now() ? 'bg-dark' : 'bg-danger' }}">
                                                        {{ ( $user->receiver->request_status == "active" && $user->receiver->expired_date >= now()) ? 'Active' : 'Expired' }}
                                                    </span>
                                            @else
                                                    <span>--</span>
                                            @endif

                                        </td>
                                        <td>
                                            @if(Auth::user()->id != $user->id && $user->role == 'user')
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".invite_{{$user->id}}"> Invite </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <div class="modal fade bs-example-modal-center{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5>Are you sure? You want to delete this?</h5>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open(['route' => ['users.destroy', $user->id ], 'method' => 'post', 'style' => 'display:inline']) !!}
                                                    <input type="text" value="{{$user->is_active == 'yes' ? 'no' : 'yes'}}">
                                                    {!! Form::submit('Yes', ['class' => 'btn btn-lg btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                    <button type="button" class="btn btn-lg btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-center{{$user->id}}"> No </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="modal fade invite_{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5>Invite {{ ucfirst($user->firstname)." ".ucfirst($user->lastname) }} for routine entry!</h5>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open(['route' => ['routine_committee_invite'], 'method' => 'post', 'style' => 'display:inline']) !!}
                                                    {!! Form::hidden('sender_id', Auth::user()->id, ['class'=> 'form-control']) !!}
                                                    {!! Form::hidden('receiver_id', $user->id, ['class'=> 'form-control']) !!}
                                                    {!! Form::label('Invite Expire after (Days)') !!}
                                                    <select name="expire_after" class="form-control" required>
                                                        <option value="">Select</option>
                                                        @for($i = 1; $i <= 10; $i++)
                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                    <br>
{{--                                                    {!! Form::textarea('message', 'Please insert your routine data before time expires', ['class'=> 'form-control','rows' => 4, 'cols' => 54,'style' => 'resize:none']) !!}--}}
{{--                                                    <br>--}}
                                                    {!! Form::submit('Send', ['class' => 'btn btn-lg btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                    <button type="button" class="btn btn-lg btn-primary waves-effect waves-light" data-toggle="modal" data-target=".invite_{{$user->id}}"> Cancel </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end row -->
        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end page content-->

{{--    </div>--}}
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
