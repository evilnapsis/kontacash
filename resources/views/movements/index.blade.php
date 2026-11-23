@extends('layouts.app')

@section('title', 'Movimientos - KontaCash')
@section('page_title', 'Movimientos')

@section('content')
<div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
    <h1 class="h3 fw-bold mb-0 d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left-right text-primary"></i>
        <span>Ingresos y Gastos</span>
    </h1>

    <button type="button" class="btn btn-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#newMovementModal">
        <i class="bi bi-plus-circle me-2"></i>Nuevo movimiento
    </button>
</div>

<!-- Filtros -->
<div class="kc-card p-3 mb-4">
    <form action="{{ route('movements.index') }}" method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label small fw-semibold text-muted mb-1">Buscar descripción</label>
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                <input type="search" name="q" value="{{ $search }}" class="form-control" placeholder="Ej. Venta, Renta...">
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold text-muted mb-1">Tipo</label>
            <select name="kind" class="form-select form-select-sm">
                <option value="">Todos</option>
                <option value="1" {{ (string) $kind === '1' ? 'selected' : '' }}>Ingresos</option>
                <option value="2" {{ (string) $kind === '2' ? 'selected' : '' }}>Gastos</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold text-muted mb-1">Cuenta</label>
            <select name="account_id" class="form-select form-select-sm">
                <option value="">Todas las cuentas</option>
                @foreach ($accounts as $account)
                    <option value="{{ $account->id }}" {{ (string) $accountId === (string) $account->id ? 'selected' : '' }}>
                        {{ $account->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-sm flex-grow-1">Filtrar</button>
            @if ($search !== '' || $kind || $accountId)
                <a href="{{ route('movements.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Tabla -->
<div class="kc-card p-4">
    @if ($movements->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
            <p class="mb-0">No hay movimientos registrados.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="text-muted small text-uppercase">
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Cuenta</th>
                        <th>Forma de pago</th>
                        <th>Persona</th>
                        <th class="text-end">Monto</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($movements as $movement)
                        <tr>
                            <td class="text-nowrap small text-muted">{{ $movement->movement_date->format('d/m/Y') }}</td>
                            <td>
                                @if ($movement->kind === 1)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Ingreso</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Gasto</span>
                                @endif
                            </td>
                            <td class="fw-medium">{{ $movement->description }}</td>
                            <td class="small">{{ $movement->category->name }}</td>
                            <td class="small">{{ $movement->account->name }}</td>
                            <td class="small text-muted">{{ $movement->paymentMethod->name }}</td>
                            <td class="small text-muted">{{ $movement->person?->name ?? '—' }}</td>
                            <td class="text-end fw-bold text-nowrap {{ $movement->kind === 1 ? 'text-success' : 'text-danger' }}">
                                {{ $movement->kind === 1 ? '+' : '-' }}${{ number_format((float) $movement->amount, 2) }}
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('movements.edit', $movement) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('movements.destroy', $movement) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este movimiento?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $movements->links() }}
        </div>
    @endif
</div>

<!-- Modal Nuevo Movimiento -->
<div class="modal fade" id="newMovementModal" tabindex="-1" aria-labelledby="newMovementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h2 class="modal-title h5 fw-bold" id="newMovementModalLabel">Nuevo movimiento</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form action="{{ route('movements.store') }}" method="POST" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="kind" class="form-label small fw-semibold">Tipo</label>
                            <select name="kind" id="kind" class="form-select @error('kind') is-invalid @enderror" required>
                                <option value="1" {{ old('kind', '1') == '1' ? 'selected' : '' }}>Ingreso</option>
                                <option value="2" {{ old('kind') == '2' ? 'selected' : '' }}>Gasto</option>
                            </select>
                            @error('kind')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label for="amount" class="form-label small fw-semibold">Monto</label>
                            <input type="number" step="0.01" min="0.01" name="amount" id="amount" value="{{ old('amount') }}" class="form-control @error('amount') is-invalid @enderror" placeholder="0.00" required>
                            @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label for="movement_date" class="form-label small fw-semibold">Fecha</label>
                            <input type="date" name="movement_date" id="movement_date" value="{{ old('movement_date', date('Y-m-d')) }}" class="form-control @error('movement_date') is-invalid @enderror" required>
                            @error('movement_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label small fw-semibold">Descripción</label>
                            <input type="text" name="description" id="description" value="{{ old('description') }}" class="form-control @error('description') is-invalid @enderror" placeholder="Concepto del ingreso o gasto" required>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="category_id" class="form-label small fw-semibold">Categoría</label>
                            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" data-kind="{{ $category->kind }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ $category->kind === 1 ? 'Ingreso' : 'Gasto' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="account_id" class="form-label small fw-semibold">Cuenta bancaria</label>
                            <select name="account_id" id="account_id" class="form-select @error('account_id') is-invalid @enderror" required>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                        {{ $account->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('account_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="payment_method_id" class="form-label small fw-semibold">Forma de pago</label>
                            <select name="payment_method_id" id="payment_method_id" class="form-select @error('payment_method_id') is-invalid @enderror" required>
                                @foreach ($paymentMethods as $method)
                                    <option value="{{ $method->id }}" {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>
                                        {{ $method->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_method_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="person_id" class="form-label small fw-semibold">Persona (opcional)</label>
                            <select name="person_id" id="person_id" class="form-select @error('person_id') is-invalid @enderror">
                                <option value="">— Ninguna —</option>
                                @foreach ($people as $person)
                                    <option value="{{ $person->id }}" {{ old('person_id') == $person->id ? 'selected' : '' }}>
                                        {{ $person->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('person_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary fw-semibold">Guardar movimiento</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const kindSelect = document.getElementById('kind');
    const categorySelect = document.getElementById('category_id');

    function filterCategoriesByKind() {
        const selectedKind = kindSelect.value;
        let firstVisible = null;
        Array.from(categorySelect.options).forEach(opt => {
            const match = opt.dataset.kind === selectedKind;
            opt.hidden = !match;
            opt.disabled = !match;
            if (match && !firstVisible) firstVisible = opt;
        });
        if (categorySelect.selectedOptions[0]?.disabled && firstVisible) {
            categorySelect.value = firstVisible.value;
        }
    }

    kindSelect.addEventListener('change', filterCategoriesByKind);
    filterCategoriesByKind();

    @if ($errors->any())
        new bootstrap.Modal(document.getElementById('newMovementModal')).show();
    @endif
</script>
@endpush
