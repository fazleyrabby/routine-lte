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
                                <a href="{{ route('assign_courses.create') }}"
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
                                    <th>Teacher</th>
                                    <th>Courses</th>
                                    <th>Session</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($assign_courses as $assign_course)

                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $assign_course->firstname."-".$assign_course->lastname }}</td>
                                        <td>
                                            <ul class="list-group">
                                                @php $sl = 1; @endphp
                                                @foreach(explode(',', $assign_course->course) as $key => $course)
                                                    <li class="list-group-item"> {{ $sl++ }} - {{ $course }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $assign_course->session_name."-".$assign_course->year }}</td>
                                        <td>{{ $assign_course->is_active == 'yes' ? 'Active' : 'Inactive' }}</td>
                                        <td>
                                            <a href="{{ route('assign_courses.edit', $assign_course->assign_courses_id) }}"
                                               class="btn btn-sm btn-primary">Edit</a>

                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target=".bs-example-modal-center{{$assign_course->assign_courses_id}}">
                                                Delete
                                            </button>
                                        </td>

                                    </tr>
                                    <div class="modal fade bs-example-modal-center{{$assign_course->assign_courses_id}}"
                                         tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5>Are you sure? You want to delete this?</h5>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open(['route' => ['assign_courses.destroy', $assign_course->assign_courses_id ], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                                    {!! Form::submit('Yes', ['class' => 'btn btn-lg btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                    <button type="button"
                                                            class="btn btn-lg btn-primary waves-effect waves-light"
                                                            data-bs-toggle="modal"
                                                            data-bs-target=".bs-example-modal-center{{$assign_course->assign_courses_id}}">
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
                                {{ $assign_courses->links() }}
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



