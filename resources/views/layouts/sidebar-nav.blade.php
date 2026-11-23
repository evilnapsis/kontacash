<ul class="nav flex-column gap-1">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-grid-1x2"></i>
            <span>Inicio</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('movements.*') ? 'active' : '' }}" href="{{ route('movements.index') }}">
            <i class="bi bi-arrow-left-right"></i>
            <span>Movimientos</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('accounts.*') ? 'active' : '' }}" href="{{ route('accounts.index') }}">
            <i class="bi bi-bank"></i>
            <span>Cuentas</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
            <i class="bi bi-tags"></i>
            <span>Categorías</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('payment-methods.*') ? 'active' : '' }}" href="{{ route('payment-methods.index') }}">
            <i class="bi bi-credit-card"></i>
            <span>Formas de pago</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('people.*') ? 'active' : '' }}" href="{{ route('people.index') }}">
            <i class="bi bi-people"></i>
            <span>Personas</span>
        </a>
    </li>
    <li class="nav-item mt-2 pt-2 border-top border-secondary border-opacity-25">
        <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
            <i class="bi bi-shield-lock"></i>
            <span>Administradores</span>
        </a>
    </li>
</ul>
