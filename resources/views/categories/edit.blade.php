@extends('layouts.app')

@section('title', 'Editar categoría - KontaCash')
@section('page_title', 'Editar categoría')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 fw-bold mb-0">Editar categoría</h1>
    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-sm">Volver</a>
</div>

<div class="kc-card p-4">
    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Nombre</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Tipo</label>
                <select name="kind" class="form-select" required>
                    <option value="1" {{ old('kind', $category->kind) == 1 ? 'selected' : '' }}>Ingreso</option>
                    <option value="2" {{ old('kind', $category->kind) == 2 ? 'selected' : '' }}>Gasto</option>
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('categories.index') }}" class="btn btn-light">Cancelar</a>
            <button type="submit" class="btn btn-primary fw-semibold">Actualizar</button>
        </div>
    </form>
</div>
@endsection
