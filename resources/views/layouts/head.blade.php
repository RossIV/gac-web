<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
    <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
        <h3>{{ config('app.name') }}</h3>
    </a>

    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="/" class="nav-link px-2 link-secondary">Home</a></li>
        @if(count(Auth::user()->teams) > 0)
        <li><a href="/my-team" class="nav-link px-2 link-dark">My Team</a></li>
        @endif
        <li><a href="/team-registration" class="nav-link px-2 link-dark">Team Registration</a></li>
        @if(Auth::check() && Auth::user()->can('access-admin-panel'))
        <li><a href="/admin" class="nav-link px-2 link-dark">Admin</a></li>
        @endif
    </ul>

    <div class="col-md-3 text-end">
        @if(Auth::check())
        <span class="me-2">Welcome, <a href="/profile">{{ Auth::user()->name }}</a>!</span>
        <a role="button" class="btn btn-outline-primary me-2" href="/logout">Logout</a>
        @else
        <a role="button" class="btn btn-primary" href="/login">Log in</a>
        @endif
    </div>
</header>
