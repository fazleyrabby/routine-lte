<!-- Navbar -->
<nav class="navbar navbar-expand-md navbar-light navbar-white">
    <div class="container-fluid">
      <a href="{{ route('admin') }}" class="navbar-brand">
        <span class="font-weight-bold">Routine Management System</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">

        <li class="nav-item">
            <a href="{{ url("/admin") }}" class="nav-link">{{ __('Dashboard') }}</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('users.show', Auth::user()->id) }}" class="nav-link">{{ __('Profile') }}</a>
        </li>
        @if ((Auth::user()->role) == 'superadmin' || (Auth::user()->role) == 'admin')

       
          <li class="nav-item dropdown">
            <a id="application" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">{{ __('Application Settings') }}</a>
            <ul aria-labelledby="application" class="dropdown-menu border-0 shadow">
                {{-- <li class="nav-item"><a class="nav-link" href="{{ route('departments.index') }}">View All</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('departments.create') }}">Add New</a>
                </li> --}}
              <!--  Department -->
              <li class="dropdown-submenu dropdown-hover">
                <a id="departments" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">{{ __('Department') }}</a>
                <ul aria-labelledby="departments" class="dropdown-menu border-0 shadow">
                    <li class="nav-item"><a class="nav-link" href="{{ route('departments.index') }}">View All</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('departments.create') }}">Add New</a>
                    </li>
                </ul>
              </li>
              <!-- End Department -->

              <!--  shifts -->
              <li class="dropdown-submenu dropdown-hover">
                <a id="shifts" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">{{ __('Shift') }}</a>
                <ul aria-labelledby="shifts" class="dropdown-menu border-0 shadow">
                    <li class="nav-item"><a class="nav-link" href="{{ route('shifts.index') }}">View All</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('shifts.create') }}">Add New</a>
                    </li>
                </ul>
              </li>
              <!-- End shifts -->

               <!--  courses -->
               <li class="dropdown-submenu dropdown-hover">
                <a id="courses" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">{{ __('Shift') }}</a>
                <ul aria-labelledby="courses" class="dropdown-menu border-0 shadow">
                    <li class="nav-item"><a class="nav-link" href="{{ route('courses.index') }}">View All</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('courses.create') }}">Add New</a>
                    </li>
                </ul>
              </li>
              <!-- End courses -->

              <!--  rooms -->
              <li class="dropdown-submenu dropdown-hover">
                <a id="rooms" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">{{ __('Rooms') }}</a>
                <ul aria-labelledby="rooms" class="dropdown-menu border-0 shadow">
                    <li class="nav-item"><a class="nav-link" href="{{ route('rooms.index') }}">View All</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('rooms.create') }}">Add New</a>
                    </li>
                </ul>
              </li>
              <!-- End rooms -->

               <!--  batches -->
               <li class="dropdown-submenu dropdown-hover">
                <a id="batches" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">{{ __('Batch') }}</a>
                <ul aria-labelledby="batches" class="dropdown-menu border-0 shadow">
                    <li class="nav-item"><a class="nav-link" href="{{ route('batches.index') }}">View All</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('batches.create') }}">Add New</a>
                    </li>
                </ul>
              </li>
              <!-- End batches -->

               <!--  session -->
               <li class="dropdown-submenu dropdown-hover">
                <a id="sessions" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">{{ __('Session') }}</a>
                <ul aria-labelledby="sessions" class="dropdown-menu border-0 shadow">
                    <li class="nav-item"><a class="nav-link" href="{{ route('sessions.index') }}">View All</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('sessions.create') }}">Add New</a>
                    </li>
                </ul>
              </li>
              <!-- End session -->

               <!--  yearly session -->
               <li class="dropdown-submenu dropdown-hover">
                <a id="yearly_session" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">{{ __('Yearly Session') }}</a>
                <ul aria-labelledby="yearly_session" class="dropdown-menu border-0 shadow">
                    <li class="nav-item"><a class="nav-link" href="{{ route('yearly_sessions.index') }}">View All</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('yearly_sessions.create') }}">Add New</a>
                    </li>
                </ul>
              </li>
              <!-- End  yearly session -->

              <!--  Section -->
              <li class="dropdown-submenu dropdown-hover">
                <a id="sections" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">{{ __('Sections') }}</a>
                <ul aria-labelledby="sections" class="dropdown-menu border-0 shadow">
                    <li class="nav-item"><a class="nav-link" href="{{ route('sections.index') }}">View All</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('sections.create') }}">Add New</a>
                    </li>
                </ul>
              </li>
              <!-- End  Section -->

              <!--  ranks -->
              <li class="dropdown-submenu dropdown-hover">
                <a id="ranks" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">{{ __('Ranks') }}</a>
                <ul aria-labelledby="ranks" class="dropdown-menu border-0 shadow">
                    <li class="nav-item"><a class="nav-link" href="{{ route('ranks.index') }}">View All</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('ranks.create') }}">Add New</a>
                    </li>
                </ul>
              </li>
              <!-- End  ranks -->


              <!--  roles -->
              <li class="nav-item"><a class="nav-link" href="{{ route('roles') }}">Roles</a>
              </li>
              <!-- End  roles -->
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a id="teachers" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">{{ __('Teachers') }}</a>
            <ul aria-labelledby="teachers" class="dropdown-menu border-0 shadow">
                <li class="nav-item"><a class="nav-link" href="{{ route('teachers.index') }}">View All</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('teachers.create') }}">Add New</a>
                </li>
              <!--  Department -->
              <li class="dropdown-submenu dropdown-hover">
                <a id="assign_courses" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">{{ __('Workload') }}</a>
                <ul aria-labelledby="assign_courses" class="dropdown-menu border-0 shadow">
                    <li class="nav-item"><a class="nav-link" href="{{ route('assign_courses.index') }}">View All</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('assign_courses.create') }}">Add New</a>
                    </li>
                </ul>
              </li>
              <!-- End Department -->

            </ul>
          </li>

          @endif
        </ul>

       
      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <!-- Messages Dropdown Menu -->

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">@php $count = 0 @endphp
                @if(!empty($requests))
                    @foreach($requests as $request)
                        @if($request->request_status == 'active')
                            @php($count++)
                        @endif
                    @endforeach
                @endif
                {{ $count ?? '' }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">{{ $count  }} Notifications</span>
            <div class="dropdown-divider"></div>
           
            @if(!empty($requests))
            @foreach($requests as $request)
                <a href="javascript:void(0);" class="dropdown-item">
                    <div class="notify-icon bg-success"><i class="mdi mdi-cart-outline"></i>
                    </div>
                    <p class="notify-details">You are invited to entry data in routine at: <span
                            class="text-muted">{{ date('d-m-Y h:i:s a', strtotime($request->created_at)) }}</span>
                        <span
                            class="text-muted">Expire at : {{ date('d-m-Y h:i:s a', strtotime($request->expired_date)) }}</span>
                    </p>
                </a>
            @endforeach
        @endif
          </div>
        </li>
        <li class="ml-2 nav-item">
            <a href="{{ route('logout') }}" class="nav-link btn btn-danger text-light">Logout</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->