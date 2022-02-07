<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
    <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
        <h3>{{ config('app.name') }}</h3>
    </a>

    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="#" class="nav-link px-2 link-secondary">Home</a></li>
        <li><a href="#" class="nav-link px-2 link-dark">My Team</a></li>
        <li><a href="#" class="nav-link px-2 link-dark">Team Registration</a></li>
        <li><a href="#" class="nav-link px-2 link-dark">Admin</a></li>
    </ul>

    <div class="col-md-3 text-end">
        @if(Auth::check())
        <span class="me-2">Welcome, {{ Auth::user()->name }}!</span>
        <button type="button" class="btn btn-outline-primary me-2">Logout</button>
        @else
        <button type="button" class="btn btn-primary">Log in</button>
        @endif
    </div>
</header>
