<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts (Source Sans 3) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" crossorigin="anonymous" />

        <!-- OverlayScrollbars Plugin CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" crossorigin="anonymous" />

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous" />

        <!-- AdminLTE CSS -->
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/adminlte.min.css') }}">

        @stack('styles')
    </head>
    <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
        <div class="app-wrapper">
            <!-- Navigation Header & Sidebar -->
            @include('layouts.navigation')

            <!-- App Main Content Area -->
            <main class="app-main">
                <!-- Content Header -->
                <div class="app-content-header py-3 border-bottom bg-body mb-4">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                @isset($header)
                                    {{ $header }}
                                @else
                                    <h3 class="mb-0">Dashboard</h3>
                                @endisset
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-end mb-0 bg-transparent p-0 small">
                                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Body -->
                <div class="app-content">
                    <div class="container-fluid">
                        <!-- Success Alert -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-left: 4px solid #198754 !important;">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <span>{{ session('success') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Error Alert -->
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-left: 4px solid #dc3545 !important;">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <span>{{ session('error') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{ $slot }}
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="app-footer border-top py-3 text-center text-muted small">
                <div class="float-end d-none d-sm-inline">
                    Version 1.0.0
                </div>
                <strong>
                    Copyright &copy; {{ date('Y') }} <a href="{{ route('products.index') }}" class="text-indigo text-decoration-none">Ekahal Test</a>.
                </strong>
                All rights reserved.
            </footer>
        </div>

        <!-- Required Scripts -->
        <!-- OverlayScrollbars -->
        <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
        <!-- Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
        <!-- Bootstrap 5 -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
        <!-- AdminLTE App JS -->
        <script src="{{ asset('vendor/adminlte/js/adminlte.js') }}"></script>

        <!-- Configure OverlayScrollbars for sidebar -->
        <script>
            const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
            const Default = {
                scrollbarTheme: 'os-theme-light',
                scrollbarAutoHide: 'leave',
                scrollbarClickScroll: true,
            };
            document.addEventListener('DOMContentLoaded', function () {
                const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
                const isMobile = window.innerWidth <= 992;

                if (sidebarWrapper && typeof OverlayScrollbarsGlobal !== 'undefined' && !isMobile) {
                    OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                        scrollbars: {
                            theme: Default.scrollbarTheme,
                            autoHide: Default.scrollbarAutoHide,
                            clickScroll: Default.scrollbarClickScroll,
                        },
                    });
                }
            });
        </script>

        @stack('scripts')
    </body>
</html>
