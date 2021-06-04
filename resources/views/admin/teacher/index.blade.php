@extends('layouts.app')

@section('title', 'Teacher')

@section('stylesheets')
    <!-- DataTables -->
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/bootstrap-md-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
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
                                Teacher - List
                                <a href="{{ route('teachers.create') }}" class="btn btn-sm btn-primary float-right">Add
                                    New</a>
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
{{--                                    <th>Photo</th>--}}
                                    <th>Teacher Name</th>
                                    <th>Slug</th>
                                    <th>Department</th>
                                    <th>Rank</th>
                                    <th>Email</th>
                                    <th width="15%">Off day</th>
                                    <th>Role</th>
                                    <th>In Routine Committee</th>
{{--                                    <th>Status</th>--}}
                                    <th>Temp. Routine Access</th>
                                    <th>Action</th>
                                </tr>
                                </thead>


                                <tbody>
                                @foreach($teachers as $teacher)
                                    <tr>
                                        <td>{{ $teacher->id }}</td>
{{--                                        <td><img width="100" src={{ asset('storage/uploads/' . $teacher->user->photo)  }} alt=""></td>--}}
                                        <td>{{ $teacher->user->firstname." ".$teacher->user->lastname }}</td>
                                        <td>{{ $teacher->slug }}</td>

                                        <td>{{ $teacher->department->department_name }}</td>
                                        <td>{{ $teacher->rank->rank }}</td>
                                        <td>{{ $teacher->user->email }}</td>
                                        <td>@foreach($teacher->teachers_offday as $key => $offday)
                                                {{ count( $teacher->teachers_offday ) != $key + 1 ? $offday->day->slug.',' : $offday->day->slug }}
                                            @endforeach
                                            &nbsp;&nbsp;<a href="{{ route('teachers_offday', $teacher->id) }}"
                                                           class="btn btn-sm btn-secondary">Assign</a>
                                        </td>
                                        <td>{{ ucwords($teacher->user->role) }}</td>
                                        <td><strong class="text-uppercase">{{ $teacher->user->in_committee }}</strong> &nbsp;&nbsp;
                                            @if($teacher->user->role != 'admin')
                                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target=".routine_committee_{{$teacher->user->id}}"> Change Access </button>
                                            @endif
                                        </td>
{{--                                        <td>{{ $teacher->is_active == 'yes' ? 'Active' : 'Inactive' }}</td>--}}
                                        <td class="text-center font-weight-bold">
                                            @if(!empty($teacher->user->receiver->request_status))
                                                <span class="p-2 {{ $teacher->user->receiver->request_status == 'active' && $teacher->user->receiver->expired_date >= now() ? 'bg-dark text-light' : 'text-dark' }}">
                                                        {{ ( $teacher->user->role == 'admin' || $teacher->user->receiver->request_status == "active" && $teacher->user->receiver->expired_date >= now()) ? 'Active' : '--' }}
                                                    </span>


                                                @if( $teacher->user->receiver->request_status == 'active' && $teacher->user->receiver->expired_date >= now() )
                                                    <button type="button" class="shadow-none border-0 btn btn-link" data-toggle="modal" data-target=".remove_invite_access_{{$teacher->user->id}}"> Remove access </button>
                                                @endif


                                            @else
                                                <span>--</span>
                                            @endif

                                        </td>

                                        <td>
                                            @if(Auth::user()->id != $teacher->user->id && $teacher->user->role == 'user')
                                                <button type="button" class="btn btn-sm btn-dark" data-toggle="modal" data-target=".invite_{{$teacher->user->id}}"> Invite </button>
                                            @endif

                                            <a href="{{ route('teachers.edit', $teacher->id) }}"
                                               class="btn btn-sm btn-primary">Edit</a>

                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target=".bs-example-modal-center{{$teacher->id}}">Delete</button>
                                        </td>

                                    </tr>

                                    <div class="modal fade remove_invite_access_{{$teacher->user->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5> Remove access of temporary access for {{ ucfirst($teacher->user->firstname)." ".ucfirst($teacher->user->lastname) }} ??
                                                    </h5>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open(['route' => ['temp_routine_access'], 'method' => 'post', 'style' => 'display:inline']) !!}
                                                    {!! Form::hidden('user_id', $teacher->user->id, ['class'=> 'form-control']) !!}
                                                    {!! Form::submit('Yes', ['class' => 'btn btn-lg btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                    <button type="button" class="btn btn-lg btn-primary waves-effect waves-light" data-toggle="modal" data-target=".remove_invite_access_{{$teacher->user->id}}"> Cancel </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="modal fade invite_{{$teacher->user->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5>Invite {{ ucfirst($teacher->user->firstname)." ".ucfirst($teacher->user->lastname) }} for routine entry!</h5>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open(['route' => ['routine_committee_invite'], 'method' => 'post', 'style' => 'display:inline']) !!}
                                                    {!! Form::hidden('sender_id', Auth::user()->id, ['class'=> 'form-control']) !!}
                                                    {!! Form::hidden('receiver_id', $teacher->user->id, ['class'=> 'form-control']) !!}
                                                    {!! Form::label('Invite Expire after (Days)') !!}
{{--                                                    <select name="expire_after" class="form-control" required>--}}
{{--                                                        <option value="">Select</option>--}}
{{--                                                        @for($i = 1; $i <= 10; $i++)--}}
{{--                                                            <option value="{{ $i }}">{{ $i }}</option>--}}
{{--                                                        @endfor--}}
{{--                                                    </select>--}}
                                                    <div>
                                                        <input type="text" name="expired_date"  class="form-control min-date floating-label" placeholder="Expired on" required>
                                                    </div>
                                                    <br>
                                                    {{--                                                    {!! Form::textarea('message', 'Please insert your routine data before time expires', ['class'=> 'form-control','rows' => 4, 'cols' => 54,'style' => 'resize:none']) !!}--}}
                                                    {{--                                                    <br>--}}
                                                    {!! Form::submit('Send', ['class' => 'btn btn-lg btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                    <button type="button" class="btn btn-lg btn-primary waves-effect waves-light" data-toggle="modal" data-target=".invite_{{$teacher->user->id}}"> Cancel </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="modal fade routine_committee_{{$teacher->user->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5> {{ $teacher->user->in_committee == 'yes' ? 'Remove from committee' : 'Add on committee' }}
                                                        ( {{ ucfirst($teacher->user->firstname)." ".ucfirst($teacher->user->lastname) }} )
                                                    </h5>

                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open(['route' => ['routine_committee_status'], 'method' => 'post', 'style' => 'display:inline']) !!}
                                                    {!! Form::hidden('user_id', $teacher->user->id, ['class'=> 'form-control']) !!}
                                                    {!! Form::hidden('in_committee', $teacher->user->in_committee == 'yes' ? 'no' : 'yes', ['class'=> 'form-control']) !!}

                                                    {!! Form::submit('Yes', ['class' => 'btn btn-lg btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                    <button type="button" class="btn btn-lg btn-primary waves-effect waves-light" data-toggle="modal" data-target=".routine_committee_{{$teacher->user->id}}"> Cancel </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade bs-example-modal-center{{$teacher->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5>Are you sure? You want to delete this?</h5>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open(['route' => ['teachers.destroy', $teacher->id ], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                                    {!! Form::submit('Yes', ['class' => 'btn btn-lg btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                    <button type="button" class="btn btn-lg btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-center{{$teacher->id}}"> No </button>
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

    </div>
    <!-- page wrapper end -->
@endsection


@push('script')
    <!-- Datatable init js -->

    <!-- Required datatable js -->

    <script src="{{ asset('assets/plugins/bootstrap-md-datetimepicker/js/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-md-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
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
{{--    <script src="../../../../.."></script>--}}
    <!-- Buttons examples -->


    <script>
        $(document).ready(function () {
            $('#datatable').DataTable();

            //Buttons examples
            let table = $('#datatable-buttons').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
        });

        $('.min-date').bootstrapMaterialDatePicker({ format : 'DD-MM-YYYY hh:mm a', minDate : new Date() });
    </script>
@endpush
