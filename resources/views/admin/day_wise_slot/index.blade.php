@extends('layouts.app')

@section('title', 'Day wise Slot')

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
                                Day Wise Time/Class Slot
{{--                                <a href="{{ route('time_slots.create') }}" class="btn btn-sm btn-primary float-end">Assign New</a>--}}
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
                                <table class="table table-bordered dt-responsive nowrap"
                                       style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr class="font-16">
                                    <th>#</th>
                                    <th width="15%">Days</th>
                                    <th class="text-center font-weight-bold">Time-range wise class slot</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach($days as $day)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td class="text-center font-24 font-weight-bold">{{ $day->day_title }}</td>
                                        <td>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="bg-primary text-light">Time Range</th>
                                                        <th class="bg-primary text-light">Class Slot</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($day->day_wise_slot->count() > 0)
                                                    @foreach($day->day_wise_slot as $day_wise_slot)
                                                    <tr>
                                                        <td class="font-14 font-weight-bold bg-dark text-light"><span> {{ date('g:i a', strtotime($day_wise_slot->time_slot->from )).'-'.date('g:i a', strtotime($day_wise_slot->time_slot->to )) }} </span></td>
                                                        <td class="font-14 font-weight-bold bg-dark text-light"><span>{{ ($day_wise_slot->class_slot != '' ? $day_wise_slot->class_slot : 'Not assigned') }}</span></td>
                                                    </tr>
                                                    @endforeach
                                                        @else
                                                        <tr>
                                                            <td> Not assigned </td>
                                                            <td> Not assigned </td>
                                                        </tr>
                                                    @endif

                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <a href="{{ route('day_wise_slot_create', $day->id) }}" class="btn btn-primary">Assign</a>
                                        </td>
                                    </tr>

                                    <div class="modal fade bs-example-modal-center{{$day->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5>Are you sure? You want to delete this?</h5>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open(['url' => ['day_wise_slot_destroy', $day->id ], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                                    {!! Form::submit('Yes', ['class' => 'btn btn-lg btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                    <button type="button" class="btn btn-lg btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center{{$day->id}}"> No </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $days->links() }}
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



