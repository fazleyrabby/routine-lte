@extends('layouts.app')

@section('title', 'Time Slot')

@section('stylesheets')
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
                                Time Slot - list
                                <a href="{{ route('time_slots.create') }}" class="btn btn-sm btn-primary float-end">Assign New</a>
                            </div>
                            @if (Session::has('message'))
                                <div class="alert-dismissable alert alert-success">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">x
                                    </button>
                                    {{ Session('message') }}
                                </div>
                            @endif
                            @if (Session::has('delete-message'))
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">x
                                    </button>
                                    {{ Session('delete-message') }}
                                </div>
                            @endif
                            <x-admin.listing-toolbar :search="$search" :perPage="$perPage" :appliedFilters="$appliedFilters" />

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered dt-responsive nowrap"
                                       style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Start time</th>
                                    <th>End time</th>
                                    <th>Shift</th>
                                    <th>Action</th>
                                </tr>
                                </thead>


                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($time_slots as $time_slot)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ date('g:i a', strtotime($time_slot->from)) }}</td>
                                        <td>{{ date('g:i a', strtotime($time_slot->to)) }}</td>
                                        <td>{{ $time_slot->shift->shift_name }}</td>
                                        <td>
                                            <a href="{{ route('time_slots.edit', $time_slot->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center{{$time_slot->id}}">Delete</button>
                                        </td>
                                    </tr>

                                    <div class="modal fade bs-example-modal-center{{$time_slot->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5>Are you sure? You want to delete this?</h5>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open(['route' => ['time_slots.destroy', $time_slot->id ], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                                    {!! Form::submit('Yes', ['class' => 'btn btn-lg btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                    <button type="button" class="btn btn-lg btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center{{$time_slot->id}}"> No </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach




                                </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $time_slots->links() }}
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



