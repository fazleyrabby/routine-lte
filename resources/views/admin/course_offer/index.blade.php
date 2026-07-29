@extends('layouts.app')

@section('title', 'Course')

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
                                Course - List
                                <a href="{{ route('course_offers.create') }}"
                                   class="btn btn-sm btn-primary float-end">Add
                                    New</a>
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
                                    <th>Batch</th>
                                    <th>Session</th>
                                    <th>Courses</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($course_offers as $course_offer)

                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ "$course_offer->department_name".$course_offer->batch_no."-".$course_offer->slug }}</td>
                                        <td>{{ $course_offer->session_name."-".$course_offer->year }}</td>
                                        <td>
                                            <ul class="list-group">
                                                @php $sl = 1; @endphp
                                                @foreach(explode(',', $course_offer->course) as $key => $course)
                                                    <li class="list-group-item"> {{ $sl++ }} - {{ $course }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $course_offer->is_active == 'yes' ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                            <a href="{{ route('course_offers.edit', $course_offer->course_offer_id) }}"
                                               class="btn btn-sm btn-primary">Edit</a>

                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target=".bs-example-modal-center{{$course_offer->course_offer_id}}">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade bs-example-modal-center{{$course_offer->course_offer_id}}"
                                         tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5>Are you sure? You want to delete this?</h5>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open(['route' => ['course_offers.destroy', $course_offer->course_offer_id ], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                                    {!! Form::submit('Yes', ['class' => 'btn btn-lg btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                    <button type="button"
                                                            class="btn btn-lg btn-primary waves-effect waves-light"
                                                            data-bs-toggle="modal"
                                                            data-bs-target=".bs-example-modal-center{{$course_offer->course_offer_id}}">
                                                        No
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $course_offers->links() }}
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



