<!-- Header Navbar -->
<nav class="app-header navbar navbar-expand bg-body border-bottom">
    <div class="container-fluid">
        <!-- Start Navbar Links -->
        <ul class="navbar-nav align-items-center">
            <li class="nav-item">
                <a class="nav-link text-muted" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list fs-4"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-inline-block ms-2">
                <a href="{{ route('products.index') }}" class="nav-link fw-semibold">Catalog Dashboard</a>
            </li>
        </ul>

        <!-- End Navbar Links -->
        <ul class="navbar-nav ms-auto align-items-center">
            <!-- User Dropdown Menu -->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle fs-4 text-muted"></i>
                    <span class="d-none d-md-inline fw-semibold">{{ Auth::user()->name }}</span>
                    @if(Auth::user()->isAdmin())
                        <span class="badge bg-danger rounded-pill px-2.5 py-1 text-xs fw-bold">Admin</span>
                    @else
                        <span class="badge bg-secondary rounded-pill px-2.5 py-1 text-xs fw-bold">User</span>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end border-0 shadow mt-2">
                    <!-- User Header -->
                    <li class="user-header text-bg-primary text-center p-4">
                        <i class="bi bi-person-circle display-4 text-white mb-2 d-block"></i>
                        <p class="fs-5 mb-1">{{ Auth::user()->name }}</p>
                        <small class="text-white-50 d-block mb-2">{{ Auth::user()->email }}</small>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer d-flex justify-content-between p-3 bg-light">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-flat rounded">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-flat rounded">
                                Sign out
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<!-- Main Sidebar Container -->
<aside class="app-sidebar bg-dark shadow" data-bs-theme="dark">
    <!-- Sidebar Brand -->
    <div class="sidebar-brand border-bottom border-secondary py-3 px-4 d-flex align-items-center">
        <a href="{{ route('products.index') }}" class="brand-link text-decoration-none d-flex align-items-center gap-2">
            <span class="brand-text fw-bold text-white fs-4">Ekahal Test</span>
        </a>
    </div>

    <!-- Sidebar Wrapper -->
    <div class="sidebar-wrapper">
        <nav class="mt-4 px-2">
            <!-- Sidebar Menu -->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active bg-primary text-white' : 'text-light' }} d-flex align-items-center gap-2.5 py-2 px-3 rounded">
                        <i class="nav-icon bi bi-grid-fill"></i>
                        <p class="mb-0">Product Catalog</p>
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active bg-primary text-white' : 'text-light' }} d-flex align-items-center gap-2.5 py-2 px-3 rounded">
                        <i class="nav-icon bi bi-person-fill"></i>
                        <p class="mb-0">My Account</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
