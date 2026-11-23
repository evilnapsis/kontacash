@extends('layouts.app')

@section('title', 'Cuentas bancarias - KontaCash')
@section('page_title', 'Cuentas bancarias')

@section('content')
<div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
    <h1 class="h3 fw-bold mb-0 d-flex align-items-center gap-2">
        <i class="bi bi-bank text-primary"></i>
        <span>Cuentas bancarias</span>
    </h1>
    <button type="button" class="btn btn-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#newAccountModal">
        <i class="bi bi-plus-circle me-2"></i>Nueva cuenta
    </button>
</div>

<div class="kc-card p-4">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="text-muted small text-uppercase">
                <tr>
                    <th>Nombre</th>
                    <th>Banco</th>
                    <th>No. de cuenta</th>
                    <th class="text-end">Saldo inicial</th>
                    <th class="text-end">Saldo actual</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($accounts as $account)
                    <tr>
                        <td class="fw-semibold">{{ $account->name }}</td>
                        <td class="text-muted">{{ $account->bank_name ?: '—' }}</td>
                        <td class="text-muted small">{{ $account->account_number ?: '—' }}</td>
                        <td class="text-end">${{ number_format((float) $account->initial_balance, 2) }}</td>
                        <td class="text-end fw-bold {{ $account->balance >= 0 ? 'text-primary' : 'text-danger' }}">
                            ${{ number_format($account->balance, 2) }}
                        </td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('accounts.edit', $account) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('accounts.destroy', $account) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta cuenta?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No hay cuentas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="newAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h2 class="modal-title h5 fw-bold">Nueva cuenta</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form action="{{ route('accounts.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nombre</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Banco (opcional)</label>
                        <input type="text" name="bank_name" value="{{ old('bank_name') }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">No. de cuenta (opcional)</label>
                        <input type="text" name="account_number" value="{{ old('account_number') }}" class="form-control">
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-semibold">Saldo inicial</label>
                        <input type="number" step="0.01" name="initial_balance" value="{{ old('initial_balance', '0.00') }}" class="form-control @error('initial_balance') is-invalid @enderror" required>
                        @error('initial_balance')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary fw-semibold">Guardar cuenta</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@if ($errors->any())
@push('scripts')
<script>new bootstrap.Modal(document.getElementById('newAccountModal')).show();</script>
@endpush
@endif
