@extends('layouts.app')

@section('title', 'Editar cuenta - KontaCash')
@section('page_title', 'Editar cuenta')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 fw-bold mb-0">Editar cuenta</h1>
    <a href="{{ route('accounts.index') }}" class="btn btn-outline-secondary btn-sm">Volver</a>
</div>

<div class="kc-card p-4">
    <form action="{{ route('accounts.update', $account) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Nombre</label>
                <input type="text" name="name" value="{{ old('name', $account->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Banco</label>
                <input type="text" name="bank_name" value="{{ old('bank_name', $account->bank_name) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">No. de cuenta</label>
                <input type="text" name="account_number" value="{{ old('account_number', $account->account_number) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Saldo inicial</label>
                <input type="number" step="0.01" name="initial_balance" value="{{ old('initial_balance', $account->initial_balance) }}" class="form-control @error('initial_balance') is-invalid @enderror" required>
                @error('initial_balance')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('accounts.index') }}" class="btn btn-light">Cancelar</a>
            <button type="submit" class="btn btn-primary fw-semibold">Actualizar</button>
        </div>
    </form>
</div>
@endsection
