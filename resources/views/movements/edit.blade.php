@extends('layouts.app')

@section('title', 'Editar movimiento - KontaCash')
@section('page_title', 'Editar movimiento')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 fw-bold mb-0">Editar movimiento</h1>
    <a href="{{ route('movements.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Volver
    </a>
</div>

<div class="kc-card p-4">
    <form action="{{ route('movements.update', $movement) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-4">
                <label for="kind" class="form-label small fw-semibold">Tipo</label>
                <select name="kind" id="kind" class="form-select @error('kind') is-invalid @enderror" required>
                    <option value="1" {{ old('kind', $movement->kind) == 1 ? 'selected' : '' }}>Ingreso</option>
                    <option value="2" {{ old('kind', $movement->kind) == 2 ? 'selected' : '' }}>Gasto</option>
                </select>
                @error('kind')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4">
                <label for="amount" class="form-label small fw-semibold">Monto</label>
                <input type="number" step="0.01" min="0.01" name="amount" id="amount" value="{{ old('amount', $movement->amount) }}" class="form-control @error('amount') is-invalid @enderror" required>
                @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4">
                <label for="movement_date" class="form-label small fw-semibold">Fecha</label>
                <input type="date" name="movement_date" id="movement_date" value="{{ old('movement_date', $movement->movement_date->format('Y-m-d')) }}" class="form-control @error('movement_date') is-invalid @enderror" required>
                @error('movement_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-12">
                <label for="description" class="form-label small fw-semibold">Descripción</label>
                <input type="text" name="description" id="description" value="{{ old('description', $movement->description) }}" class="form-control @error('description') is-invalid @enderror" required>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label for="category_id" class="form-label small fw-semibold">Categoría</label>
                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" data-kind="{{ $category->kind }}" {{ old('category_id', $movement->category_id) == $category->id ? 'selected' : '' }}>
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
                        <option value="{{ $account->id }}" {{ old('account_id', $movement->account_id) == $account->id ? 'selected' : '' }}>
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
                        <option value="{{ $method->id }}" {{ old('payment_method_id', $movement->payment_method_id) == $method->id ? 'selected' : '' }}>
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
                        <option value="{{ $person->id }}" {{ old('person_id', $movement->person_id) == $person->id ? 'selected' : '' }}>
                            {{ $person->name }}
                        </option>
                    @endforeach
                </select>
                @error('person_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('movements.index') }}" class="btn btn-light">Cancelar</a>
            <button type="submit" class="btn btn-primary fw-semibold">Actualizar movimiento</button>
        </div>
    </form>
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
</script>
@endpush
