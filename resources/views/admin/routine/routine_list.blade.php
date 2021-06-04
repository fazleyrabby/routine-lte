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
                                {{ $session->session->session_name."-".$session->year }}
                            </div>

                            <h3 class="text-center">Teacher List</h3>
                            <table class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Teacher Name</th>
                                    <th>Slug</th>
                                    <th>Department</th>
                                    <th>Rank</th>
                                    <th>Download</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($teachers as $teacher)
                                    <tr>
                                        <td>{{ $teacher->id }}</td>
                                        <td>{{ $teacher->user->firstname." ".$teacher->user->lastname }}</td>
                                        <td>{{ $teacher->slug }}</td>
                                        <td>{{ $teacher->department->department_name }}</td>
                                        <td>{{ $teacher->rank->rank }}</td>
                                        <td>
                                            <form class="float-left m-r-5" action="{{ route('teacher_wise_view') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="y_session_id" value="{{ $session->id }}">
                                                <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                                                <button type="submit" class="btn btn-sm btn-danger">View</button>
                                            </form>

                                            <form class="float-left m-r-5" action="{{ route('teacher_wise_print') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="y_session_id" value="{{ $session->id }}">
                                                <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                                                <button type="submit" class="btn btn-sm btn-dark">Download</button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                            <h3 class="text-center">Batch List</h3>
                            <table class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Batch </th>
                                    <th>Download</th>
                                </tr>
                                </thead>
                                <tbody>

{{--                                    <option value="{{ $batch->batch_id.",".$batch->section_id }}">--}}
{{--                                        {{ $batch->department_name."-".$batch->batch_no."-".$batch->slug }}{{ $batch->section_name != '' ? " - ".$batch->section_name : '' }}--}}
{{--                                    </option>--}}

                                @foreach($batches as $batch)

                                    <tr>
                                        <td>{{ $batch->batch_id }}</td>

                                        <td>{{ $batch->department_name."-".$batch->batch_no."-".$batch->slug }}{{ $batch->section_name != '' ? " - ".$batch->section_name : '' }}</td>

                                        <td>
                                            <form class="float-left m-r-5" action="{{ route('batch_wise_view') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="batch_id" value="{{ $batch->batch_id.",".$batch->section_id }}">
                                                <input type="hidden" name="y_session_id" value="{{ $session->id }}">
                                                <button type="submit" class="btn btn-sm btn-danger">View</button>
                                            </form>

                                            <form class="float-left m-r-5" action="{{ route('routine_print') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="batch_id" value="{{ $batch->batch_id.",".$batch->section_id }}">
                                                <input type="hidden" name="y_session_id" value="{{ $session->id }}">
                                                <button type="submit" class="btn btn-sm btn-dark">Download</button>
                                            </form>
                                        </td>

                                    </tr>
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
