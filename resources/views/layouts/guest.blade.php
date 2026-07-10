<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts (Source Sans 3) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" crossorigin="anonymous" />

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous" />

        <!-- AdminLTE CSS -->
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/adminlte.min.css') }}">
    </head>
    <body class="login-page bg-body-secondary">
        <div class="login-box" style="width: 400px; max-width: 100%;">
            <!-- Logo Header -->
            <div class="login-logo mb-4">
                <a href="/" class="text-decoration-none text-dark">
                    <b class="text-primary">Ekahal</b> Test
                </a>
            </div>

            <!-- Card Wrap -->
            <div class="card card-outline card-primary border-0 shadow rounded-3">
                <div class="card-body login-card-body p-4 p-md-5">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <!-- Required Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('vendor/adminlte/js/adminlte.js') }}"></script>
    </body>
</html>
