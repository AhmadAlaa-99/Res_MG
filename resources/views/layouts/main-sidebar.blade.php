<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="dropdown header-profile">
                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                    <img src="{{ URL::asset('dashboard/images/profile/pic1.jpg') }}" width="20" alt="">
                    <div class="header-info ms-3">
                        <span class="font-w600 ">Hi,<b>{{ Auth::user()->name }}</b></span>
                        <small class="text-end font-w400">{{ Auth::user()->email }}</small>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="{{ route('staff_profile') }}" class="dropdown-item ai-icon">
                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18"
                            height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span class="ms-2">Profile </span>
                    </a>
                    <a href="page-error-404.html" class="dropdown-item ai-icon" href="{{ route('logout') }}"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18"
                            height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4">

                            </path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12">

                            </line>
                        </svg>
                        Logout

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                            <span class="ms-2">Logout </span>
                        </form>
                    </a>
                </div>
            </li>
            @can('statistics(admin)')
                <li>
                    <a href="{{ route('statistics') }}" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-025-dashboard"></i>
                        <span class="nav-text">Statistics</span>
                    </a>
                </li>
            @endcan
            @can('statistics(staff)') 
                <li>
                    <a href="{{ route('staff_statistics') }}" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-025-dashboard"></i>
                        <span class="nav-text">Statistics</span>
                    </a>
                </li>
             @endcan 
            <li>
                @can('Browse Resturants')
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-archive"></i>
                        <span class="nav-text">Resturants</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('resturants.index') }}">Resturants Browse</a></li>
                        @can('Crud Resturants')
                            <li><a href="{{ route('resturants.create') }}">Resturant Add</a></li>
                        @endcan
                    </ul>
                @endcan
            </li>
            
            @can('Users Management')
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-user-2"></i>
                        <span class="nav-text">Users Management</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="index.html"></a></li>
                        <li><a href="{{ route('staff_all') }}">Resturant_staff</a></li>
                        <li><a href="{{ route('customers') }}">Customers</a></li>
                        <li><a href="{{ route('users.index') }}">Managers</a></li>
                        <li><a href="{{ route('roles.index') }}">Roles</a></li>
                    </ul>
                </li>
            @endcan
            @can('Browse Cuisines')
                <li>
                    <a href="{{ route('cuisines.index') }}" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-381-archive"></i>
                        <span class="nav-text">Cuisines</span>
                    </a>
                </li>
            @endcan
            <li>
                <a href="{{ route('all_notifications') }}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-381-notification"></i>
                    <span class="nav-text">Notifications</span>
                </a>
            </li>
            {{-- @endif --}}
            {{-- @if (Auth::user()->role_name == 'staff') --}}
            {{-- @can('Browse Reservation')
                <li>
                    <a href="{{ route('today_reservations') }}" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-381-archive"></i>
                        <span class="nav-text">Reservations</span>
                    </a>
                </li>
            @endcan --}}
            {{-- @can('browse Reservation_Records')
                <li>
                    <a href="{{ route('records_reservations') }}" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-381-archive"></i>
                        <span class="nav-text">Reservations Records</span>
                    </a>
                </li>
            @endcan --}}
            {{-- @can('Browse Tables(staff)')
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-id-card"></i>
                        <span class="nav-text">Tables</span>
                    </a>
                    <ul aria-expanded="false">
                        {{-- @can('Crud Tables')
                            <li><a href="{{ route('tables.create') }}">Table Add</a></li>
                            <li><a href="{{ route('tables.index') }}">Tables Browse</a></li>
                        @endcan --}}
                        {{-- <li><a href="{{ route('tables.index') }}">Tables Browse</a></li>
                    </ul>
                <li>
                @endcan --}}

            </li>
            </li>
            {{-- <li>
			<a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
				<i class="flaticon-013-checkmark"></i>
				<span class="nav-text">Reservations</span>
			</a>
			<ul aria-expanded="false">
				<li><a href="">Reservation Add</a></li>
				<li><a href="">Today Reservations</a></li>
			</ul>
		</li> --}}
            {{-- @endif --}}
        </ul>
        <div class="copyright">
            <p><strong>Resturant Management</strong> © 2023 All Rights Reserved</p>
            <p class="fs-12">Made with <span class="heart"></span> by HDR</p>
        </div>
    </div>
</div>
