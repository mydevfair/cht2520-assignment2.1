<nav class="navbar navbar-expand-lg navbar-dark py-2">
    <div class="container-fluid">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <div class="d-flex flex-row flex-wrap gap-2 me-auto py-2 py-lg-0">

                <a href="{{ route('dashboard') }}" class="btn btn-sm {{ request()->routeIs('dashboard') ? 'btn-light' : 'btn-outline-light' }}">
                    Home
                </a>

                @can('view-patients')
                    <a href="{{ route('patients.index') }}" class="btn btn-sm {{ request()->routeIs('patients.*') ? 'btn-light' : 'btn-outline-light' }}">
                        Patients
                    </a>
                @endcan

                @can('view-doctors')
                    <a href="{{ route('doctors.index') }}" class="btn btn-sm {{ request()->routeIs('doctors.*') ? 'btn-light' : 'btn-outline-light' }}">
                        Doctors
                    </a>
                @endcan

                @can('view-medications')
                    <a href="{{ route('medications.index') }}" class="btn btn-sm {{ request()->routeIs('medications.*') ? 'btn-light' : 'btn-outline-light' }}">
                        Medications
                    </a>
                @endcan

                @can('view-appointments')
                    <a href="{{ route('appointments.index') }}" class="btn btn-sm {{ request()->routeIs('appointments.*') ? 'btn-light' : 'btn-outline-light' }}">
                        Appointments
                    </a>
                @endcan

                @can('view-medical-records')
                    <a href="{{ route('medical-records.index') }}" class="btn btn-sm {{ request()->routeIs('medical-records.*') ? 'btn-light' : 'btn-outline-light' }}">
                        Medical Records
                    </a>
                @endcan

                @can('view-users')
                    <a href="{{ route('users.index') }}" class="btn btn-sm {{ request()->routeIs('users.*') ? 'btn-light' : 'btn-outline-light' }}">
                        Users
                    </a>
                @endcan

                @can('view-activity-log')
                    <a href="{{ route('activity-log.index') }}" class="btn btn-sm {{ request()->routeIs('activity-log.*') ? 'btn-light' : 'btn-outline-light' }}">
                        Activity Log
                    </a>
                @endcan

                @can('view-reports')
                    <a href="{{ route('reports.index') }}" class="btn btn-sm {{ request()->routeIs('reports.*') ? 'btn-light' : 'btn-outline-light' }}">
                        Reports
                    </a>
                @endcan

                @can('use-advanced-search')
                    <a href="{{ route('search.index') }}" class="btn btn-sm {{ request()->routeIs('search.*') ? 'btn-light' : 'btn-outline-light' }}">
                        Search
                    </a>
                @endcan
            </div>

            <div class="d-flex flex-row flex-wrap gap-2 align-items-center py-2 py-lg-0">
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
        </div>

    </div>
</nav>
