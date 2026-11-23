<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KontaCash')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --kc-bg: #f8fafc;
            --kc-border: #e2e8f0;
            --kc-sidebar: #0f172a;
            --kc-sidebar-hover: #1e293b;
            --kc-accent: #2563eb;
        }
        body {
            background-color: var(--kc-bg);
            color: #0f172a;
            min-height: 100vh;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .kc-sidebar {
            width: 250px;
            background-color: var(--kc-sidebar);
            min-height: 100vh;
            flex-shrink: 0;
        }
        .kc-sidebar .nav-link {
            color: #94a3b8;
            border-radius: 0.5rem;
            padding: 0.6rem 0.9rem;
            font-size: 0.925rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            transition: background-color 0.15s, color 0.15s;
        }
        .kc-sidebar .nav-link:hover {
            background-color: var(--kc-sidebar-hover);
            color: #f8fafc;
        }
        .kc-sidebar .nav-link.active {
            background-color: var(--kc-accent);
            color: #ffffff;
        }
        .kc-card {
            background-color: #ffffff;
            border: 1px solid var(--kc-border);
            border-radius: 0.75rem;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
        }
        .kc-topbar {
            background-color: #ffffff;
            border-bottom: 1px solid var(--kc-border);
        }
        .kc-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 0.65rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .table > :not(caption) > * > * {
            padding-top: 0.85rem;
            padding-bottom: 0.85rem;
            border-bottom-color: var(--kc-border);
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar Desktop -->
        <aside class="kc-sidebar d-none d-lg-flex flex-column p-3">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-2 text-white text-decoration-none px-2 py-2 mb-4">
                <span class="kc-icon-box bg-primary text-white" style="width: 36px; height: 36px;">
                    <i class="bi bi-cash-coin fs-5"></i>
                </span>
                <span class="fs-5 fw-bold tracking-tight">KontaCash</span>
            </a>

            @include('layouts.sidebar-nav')

            <div class="mt-auto pt-3 border-top border-secondary border-opacity-25">
                <div class="px-2 text-secondary small mb-2 text-truncate">
                    <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm w-100 d-flex align-items-center justify-content-center gap-2 opacity-75">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Cerrar sesión</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Offcanvas Sidebar Mobile -->
        <div class="offcanvas offcanvas-start kc-sidebar text-white" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
            <div class="offcanvas-header border-bottom border-secondary border-opacity-25">
                <div class="d-flex align-items-center gap-2" id="mobileSidebarLabel">
                    <span class="kc-icon-box bg-primary text-white" style="width: 34px; height: 34px;">
                        <i class="bi bi-cash-coin"></i>
                    </span>
                    <span class="fs-5 fw-bold">KontaCash</span>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column p-3">
                @include('layouts.sidebar-nav')
                <div class="mt-auto pt-3 border-top border-secondary border-opacity-25">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm w-100">
                            <i class="bi bi-box-arrow-right me-1"></i>Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 d-flex flex-column min-vh-100" style="min-width: 0;">
            <header class="kc-topbar px-4 py-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-outline-secondary btn-sm d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <span class="fw-semibold text-secondary small text-uppercase">@yield('page_title', 'Panel Administrativo')</span>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <span class="small text-muted d-none sm-inline d-sm-inline">{{ Auth::user()->email }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-lg-none">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </header>

            <main class="container-fluid px-4 py-4 flex-grow-1">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center border-0 shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center border-0 shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
