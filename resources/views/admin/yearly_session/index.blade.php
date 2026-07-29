@extends('layouts.app')

@section('title', 'Yearly Session')

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




                            <div class="mt-0 header-title mb-4">
                                Yearly Session - List
                                <a href="{{ route('yearly_sessions.create') }}" class="btn btn-sm btn-primary float-end">Add New</a>
                            </div>

                            <x-admin.listing-toolbar :search="$search" :perPage="$perPage" :filters="[['field' => 'is_active', 'label' => 'Status', 'options' => ['yes' => 'Active', 'no' => 'Inactive']]]" :appliedFilters="$appliedFilters" />

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered dt-responsive nowrap"
                                       style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Session</th>
                                    <th>Years</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i = 1; @endphp
                                @foreach($yearly_sessions as $yearly_session)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $yearly_session->session->session_name }}</td>
                                        <td>{{ $yearly_session->year }}</td>
                                        <td> {{ $yearly_session->is_active == 'yes' ? 'Active' : 'Inactive' }} </td>
                                        <td> <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center{{$yearly_session->id}}"> Status change </button>
                                        </td>

                                    </tr>
                                    <div class="modal fade bs-example-modal-center{{$yearly_session->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5>Do you want to {{ $yearly_session->is_active == 'yes' ? 'Deactive' : 'Activate' }} this ?</h5>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open([ 'route' => ['yearly_sessions.update' , $yearly_session->id], 'method' => 'put', 'style' => 'display:inline']) !!}
{{--                                                    <input type="hidden" name="is_active" value="{{ $yearly_session->is_active == 'yes' ? 'no' : 'yes' }}">--}}
                                                    {!! Form::submit('Yes', ['class' => 'btn btn-lg btn-danger']) !!}
                                                    {!! Form::close() !!}

                                                    <button type="button" class="btn btn-lg btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center{{ $yearly_session->id }}"> No </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $yearly_sessions->links() }}
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



