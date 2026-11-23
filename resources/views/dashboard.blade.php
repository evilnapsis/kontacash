@extends('layouts.app')

@section('title', 'Inicio - KontaCash')
@section('page_title', 'Inicio')

@section('content')
<div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
    <div>
        <h1 class="h3 fw-bold mb-0">Resumen financiero</h1>
    </div>
    <a href="{{ route('movements.index') }}" class="btn btn-primary fw-semibold">
        <i class="bi bi-plus-circle me-2"></i>Registrar movimiento
    </a>
</div>

<!-- KPIs -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="kc-card p-4 h-100 d-flex align-items-center justify-content-between">
            <div>
                <div class="text-muted small fw-semibold mb-1">Balance total en cuentas</div>
                <div class="h3 fw-bold mb-0 {{ $totalBalance >= 0 ? 'text-primary' : 'text-danger' }}">
                    ${{ number_format($totalBalance, 2) }}
                </div>
            </div>
            <div class="kc-icon-box bg-primary bg-opacity-10 text-primary">
                <i class="bi bi-wallet2 fs-4"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="kc-card p-4 h-100 d-flex align-items-center justify-content-between">
            <div>
                <div class="text-muted small fw-semibold mb-1">Ingresos del mes</div>
                <div class="h3 fw-bold mb-0 text-success">
                    +${{ number_format($monthIncome, 2) }}
                </div>
            </div>
            <div class="kc-icon-box bg-success bg-opacity-10 text-success">
                <i class="bi bi-arrow-down-left-circle fs-4"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="kc-card p-4 h-100 d-flex align-items-center justify-content-between">
            <div>
                <div class="text-muted small fw-semibold mb-1">Gastos del mes</div>
                <div class="h3 fw-bold mb-0 text-danger">
                    -${{ number_format($monthExpense, 2) }}
                </div>
            </div>
            <div class="kc-icon-box bg-danger bg-opacity-10 text-danger">
                <i class="bi bi-arrow-up-right-circle fs-4"></i>
            </div>
        </div>
    </div>
</div>

<!-- Saldo por cuenta -->
<div class="kc-card p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h5 fw-bold mb-0 d-flex align-items-center gap-2">
            <i class="bi bi-bank text-primary"></i>
            <span>Saldo por cuenta</span>
        </h2>
        <a href="{{ route('accounts.index') }}" class="btn btn-outline-secondary btn-sm">Ver cuentas</a>
    </div>

    @if ($accounts->isEmpty())
        <p class="text-muted small mb-0">No hay cuentas registradas.</p>
    @else
        <div class="row g-3">
            @foreach ($accounts as $account)
                <div class="col-md-6 col-xl-4">
                    <div class="p-3 rounded-3 border bg-light bg-opacity-50">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <span class="fw-semibold">{{ $account->name }}</span>
                            <span class="badge bg-secondary-subtle text-secondary">{{ $account->bank_name ?: 'General' }}</span>
                        </div>
                        <div class="h5 fw-bold mb-0 {{ $account->balance >= 0 ? 'text-dark' : 'text-danger' }}">
                            ${{ number_format($account->balance, 2) }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Últimos 10 movimientos -->
<div class="kc-card p-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h5 fw-bold mb-0 d-flex align-items-center gap-2">
            <i class="bi bi-clock-history text-primary"></i>
            <span>Movimientos recientes</span>
        </h2>
        <a href="{{ route('movements.index') }}" class="btn btn-outline-primary btn-sm">Ver todos</a>
    </div>

    @if ($recentMovements->isEmpty())
        <div class="text-center py-4 text-muted">
            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
            <p class="mb-0">No hay movimientos registrados.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="text-muted small text-uppercase">
                    <tr>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Cuenta</th>
                        <th>Forma de pago</th>
                        <th>Persona</th>
                        <th class="text-end">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentMovements as $movement)
                        <tr>
                            <td class="text-nowrap small text-muted">{{ $movement->movement_date->format('d/m/Y') }}</td>
                            <td class="fw-medium">{{ $movement->description }}</td>
                            <td>
                                <span class="badge {{ $movement->kind === 1 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                    {{ $movement->category->name }}
                                </span>
                            </td>
                            <td class="small">{{ $movement->account->name }}</td>
                            <td class="small text-muted">{{ $movement->paymentMethod->name }}</td>
                            <td class="small text-muted">{{ $movement->person?->name ?? '—' }}</td>
                            <td class="text-end fw-bold text-nowrap {{ $movement->kind === 1 ? 'text-success' : 'text-danger' }}">
                                {{ $movement->kind === 1 ? '+' : '-' }}${{ number_format((float) $movement->amount, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
