<header class="navbar navbar-expand-xl navbar-dark d-print-none" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark pe-0 pe-md-3">
            <a href="{{ route('admin') }}" class="text-reset text-decoration-none">Routine Management System</a>
        </h1>

        <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown d-none d-md-flex me-3">
                <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications" data-bs-auto-close="outside" aria-expanded="false">
                    <i class="fas fa-bell icon icon-1"></i>
                    <span class="badge bg-red"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Notifications</h3>
                        </div>
                        <div class="list-group list-group-flush list-group-hoverable">
                            @php $count = 0 @endphp
                            @if(!empty($requests))
                                @foreach($requests as $request)
                                    @if($request->request_status == 'active')
                                        @php($count++)
                                    @endif
                                @endforeach
                            @endif
                            <div class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="status-dot status-dot-animated bg-red d-block"></span>
                                    </div>
                                    <div class="col text-truncate">
                                        <span class="text-body d-block">{{ $count }} Notifications</span>
                                    </div>
                                </div>
                            </div>
                            @if(!empty($requests))
                                @foreach($requests as $request)
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="status-dot d-block"></span>
                                            </div>
                                            <div class="col text-truncate">
                                                <a href="javascript:void(0);" class="text-body d-block">Entry Data</a>
                                                <div class="d-block text-secondary text-truncate mt-n1">
                                                    Invited at: {{ date('d-m-Y h:i:s a', strtotime($request->created_at)) }}
                                                </div>
                                                <div class="d-block text-secondary text-truncate mt-n1">
                                                    Expires: {{ date('d-m-Y h:i:s a', strtotime($request->expired_date)) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                    <i class="fas fa-user-circle icon icon-1"></i>
                    <span class="d-none d-xl-inline ms-2">{{ Auth::user()->firstname ?? '' }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a class="dropdown-item" href="{{ route('users.show', Auth::user()->id) }}">
                        <i class="fas fa-user me-2"></i> Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<header class="navbar-expand-xl">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar navbar-dark d-print-none" data-bs-theme="dark">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin') }}">
                            <span class="nav-link-icon">
                                <i class="fas fa-home"></i>
                            </span>
                            <span class="nav-link-title">Home</span>
                        </a>
                    </li>

                    @if ((Auth::user()->role) == 'superadmin' || (Auth::user()->role) == 'admin')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-settings" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                            <span class="nav-link-icon">
                                <i class="fas fa-cogs"></i>
                            </span>
                            <span class="nav-link-title">{{ __('Application Settings') }}</span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('departments.index') }}">{{ __('Department') }}</a>
                            <a class="dropdown-item" href="{{ route('shifts.index') }}">{{ __('Shift') }}</a>
                            <a class="dropdown-item" href="{{ route('courses.index') }}">{{ __('Courses') }}</a>
                            <a class="dropdown-item" href="{{ route('rooms.index') }}">{{ __('Rooms') }}</a>
                            <a class="dropdown-item" href="{{ route('batches.index') }}">{{ __('Batch') }}</a>
                            <a class="dropdown-item" href="{{ route('sessions.index') }}">{{ __('Session') }}</a>
                            <a class="dropdown-item" href="{{ route('yearly_sessions.index') }}">{{ __('Yearly Session') }}</a>
                            <a class="dropdown-item" href="{{ route('sections.index') }}">{{ __('Sections') }}</a>
                            <a class="dropdown-item" href="{{ route('ranks.index') }}">{{ __('Ranks') }}</a>
                            <a class="dropdown-item" href="{{ route('time_slots.index') }}">{{ __('Time Slots') }}</a>
                            <a class="dropdown-item" href="{{ route('day_wise_slots') }}">Day Wise Slot</a>
                            <a class="dropdown-item" href="{{ route('roles') }}">Roles</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-teachers" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                            <span class="nav-link-icon">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </span>
                            <span class="nav-link-title">{{ __('Teachers') }}</span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('teachers.index') }}">{{ __('Teachers') }}</a>
                            <a class="dropdown-item" href="{{ route('assign_courses.index') }}">{{ __('Workload') }}</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('students.index') }}">
                            <span class="nav-link-icon">
                                <i class="fas fa-user-graduate"></i>
                            </span>
                            <span class="nav-link-title">{{ __('Students') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('course_offers.index') }}">
                            <span class="nav-link-icon">
                                <i class="fas fa-book"></i>
                            </span>
                            <span class="nav-link-title">{{ __('Course Offers') }}</span>
                        </a>
                    </li>
                    @endif

                    @if (Auth::check())
                    <li class="nav-item dropdown dropdown-arrow">
                        <a class="nav-link dropdown-toggle" href="#navbar-view-routine" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                            <span class="nav-link-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <span class="nav-link-title">{{ __('View routine') }}</span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropend">
                                <a class="dropdown-item dropdown-toggle" href="#navbar-routine-view" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">{{ __('View routine') }}</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('teacher_search') }}">Teacher Wise</a>
                                    <a class="dropdown-item" href="{{ route('batch_search') }}">Batch Wise</a>
                                </div>
                            </div>
                            <div class="dropend">
                                <a class="dropdown-item dropdown-toggle" href="#navbar-routine-list" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">{{ __('Routine List') }}</a>
                                <div class="dropdown-menu">
                                    @if(!empty($y_session))
                                        @foreach($y_session as $session)
                                            <a class="dropdown-item" href="{{ route('routine_list',$session->id) }}">
                                                {{ $session->session_name. '-' . $session->year}}
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#navbar-generate" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false">
                            <span class="nav-link-icon">
                                <i class="fas fa-plus-circle"></i>
                            </span>
                            <span class="nav-link-title">{{ __('Generate Routine') }}</span>
                        </a>
                        <div class="dropdown-menu">
                            @if(!empty($y_session))
                                @foreach($y_session as $session)
                                    <a class="dropdown-item" href="{{ route('full_routine',$session->id) }}">
                                        {{ $session->session_name. '-' . $session->year}}
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</header>
