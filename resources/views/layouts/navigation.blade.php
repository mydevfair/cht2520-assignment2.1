<nav class="d-flex justify-content-between align-items-center gap-2 py-2">
    <div class="d-flex gap-2">
        {{-- Home / Dashboard --}}
        <a href="{{ route('dashboard') }}" class="btn btn-sm {{ request()->routeIs('dashboard') ? 'btn-light' : 'btn-outline-light' }}">
            Home
        </a>

        {{-- Patient Management --}}
        @can('view-patients')
            <a href="{{ route('patients.index') }}" class="btn btn-sm {{ request()->routeIs('patients.*') ? 'btn-light' : 'btn-outline-light' }}">
                Patients
            </a>
        @endcan

        {{-- Doctor Management --}}
        @can('view-doctors')
            <a href="{{ route('doctors.index') }}" class="btn btn-sm {{ request()->routeIs('doctors.*') ? 'btn-light' : 'btn-outline-light' }}">
                Doctors
            </a>
        @endcan

        {{-- Medications --}}
        @can('view-medications')
            <a href="{{ route('medications.index') }}" class="btn btn-sm {{ request()->routeIs('medications.*') ? 'btn-light' : 'btn-outline-light' }}">
                Medications
            </a>
        @endcan

        {{-- Appointments --}}
        @can('view-appointments')
            <a href="{{ route('appointments.index') }}" class="btn btn-sm {{ request()->routeIs('appointments.*') ? 'btn-light' : 'btn-outline-light' }}">
                Appointments
            </a>
        @endcan

        {{-- Medical Records --}}
        @can('view-medical-records')
            <a href="{{ route('medical-records.index') }}" class="btn btn-sm {{ request()->routeIs('medical-records.*') ? 'btn-light' : 'btn-outline-light' }}">
                Medical Records
            </a>
        @endcan

        {{-- User Management --}}
        @can('view-users')
            <a href="{{ route('users.index') }}" class="btn btn-sm {{ request()->routeIs('users.*') ? 'btn-light' : 'btn-outline-light' }}">
                Users
            </a>
        @endcan

        {{-- Activity Log --}}
        @can('view-activity-log')
            <a href="{{ route('activity-log.index') }}" class="btn btn-sm {{ request()->routeIs('activity-log.*') ? 'btn-light' : 'btn-outline-light' }}">
                Activity Log
            </a>
        @endcan

        {{-- Reports --}}
        @can('view-reports')
            <a href="{{ route('reports.index') }}" class="btn btn-sm {{ request()->routeIs('reports.*') ? 'btn-light' : 'btn-outline-light' }}">
                Reports
            </a>
        @endcan

        {{-- Advanced Search --}}
        @can('use-advanced-search')
            <a href="{{ route('search.index') }}" class="btn btn-sm {{ request()->routeIs('search.*') ? 'btn-light' : 'btn-outline-light' }}">
                Search
            </a>
        @endcan
    </div>

    {{-- Authentication --}}
    <div class="d-flex gap-2 align-items-center">
        @auth
            <span class="text-white">{{ Auth::user()->name }}</span>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-sm btn-outline-light">
                Logout
            </a>
            <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                @csrf
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light">Login</a>
        @endauth
    </div>
</nav>
