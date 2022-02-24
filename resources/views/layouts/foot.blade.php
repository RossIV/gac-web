<div class="container">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <div class="col-md-4 d-flex align-items-center">
            <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
                © Copyright {{ date('Y') }} {{ config('app.name') }}
            </a>
        </div>

        <div class="col-md-4 justify-content-end d-flex text-muted">
            Need Help? Contact&nbsp;<a href="mailto:{{ config('app.admin_email') }}">{{ config('app.admin_name') }}</a>.
        </div>
    </footer>
</div>
