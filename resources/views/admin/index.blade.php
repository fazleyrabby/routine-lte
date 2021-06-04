@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary mini-stat position-relative">
                    <div class="card-body">
                        <div class="mini-stat-desc">
                            <div class="text-white">
                                <h6 class="text-uppercase mt-0 text-white-50">Teachers</h6>
                                <h3 class="mb-3 mt-0">{{ $data['teacher'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary mini-stat position-relative">
                    <div class="card-body">
                        <div class="mini-stat-desc">
                            <div class="text-white">
                                <h6 class="text-uppercase mt-0 text-white-50">Students</h6>
                                <h3 class="mb-3 mt-0">{{ $data['student'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary mini-stat position-relative">
                    <div class="card-body">
                        <div class="mini-stat-desc">
                            <div class="text-white">
                                <h6 class="text-uppercase mt-0 text-white-50">Courses</h6>
                                <h3 class="mb-3 mt-0">{{ $data['course'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary mini-stat position-relative">
                    <div class="card-body">
                        <div class="mini-stat-desc">
                            <div class="text-white">
                                <h6 class="text-uppercase mt-0 text-white-50">Batches</h6>
                                <h3 class="mb-3 mt-0">{{ $data['batch'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 header-title mb-4">Teachers</h4>
                            <div class="table-responsive">
                                <table id="datatable-buttons"
                                       class="table table-striped table-bordered dt-responsive nowrap"
                                       style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Teacher Name</th>
                                        <th>Department</th>
                                        <th>Rank</th>
                                        <th>Email</th>
                                        <th>Join Date</th>
                                        <th>Contact</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>


                                    <tbody>
                                    @foreach($teachers as $teacher)
                                        <tr>
                                        <td>{{ $loop->iteration }}</td>
                                            <td>{{ $teacher->user->firstname." ".$teacher->user->lastname }}</td>
                                            <td>{{ $teacher->department->department_name }}</td>
                                            <td>{{ $teacher->rank->rank }}</td>
                                            <td>{{ $teacher->user->email }}</td>
                                            <td>{{ $teacher->join_date }}</td>
                                            <td>{{ ucwords($teacher->user->contact) }}</td>
                                            <td>{{ $teacher->is_active == 'yes' ? 'Active' : 'Inactive' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 header-title mb-4">Rooms</h4>
                            <div class="table-responsive order-table">
                                <table id="datatable-buttons"
                                       class="table table-striped table-bordered dt-responsive nowrap"
                                       style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Building</th>
                                        <th>Room No</th>
                                        <th>Room Type</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>


                                    <tbody>
                                    @foreach($rooms as $room)
                                        <tr>
                                        <td>{{ $loop->iteration }}</td>
                                            <td>{{ $room->building }}</td>
                                            <td>{{ $room->room_no }}</td>
                                            <td>{{ $room->room_type == '0' ? 'Theory' : 'Lab' }}</td>
                                            <td>{{ $room->is_active == 'yes' ? 'Active' : 'Inactive' }}</td>
                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 header-title mb-4">Courses</h4>
                            <div class="table-responsive">
                                <table id="datatable-buttons"
                                       class="table table-striped table-bordered dt-responsive nowrap"
                                       style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Course Name</th>
                                        <th>Course Code</th>
                                        <th>Credit</th>
                                        <th>Course Type</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>


                                    <tbody>
                                    @foreach($courses as $course)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $course->course_name }}</td>
                                            <td>{{ $course->course_code }}</td>
                                            <td>{{ $course->credit }}</td>
                                            <td>{{ $course->course_type == 0 ? 'Theory' : 'Sessional' }}</td>
                                            <td>{{ $course->is_active == 'yes' ? 'Active' : 'Inactive' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- end row -->
        </div>
    </div><!-- /.container-fluid -->
  </div>
    <!-- page wrapper start -->

@endsection
