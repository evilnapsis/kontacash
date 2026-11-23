@extends('layouts.app')

@section('title', 'Categorías - KontaCash')
@section('page_title', 'Categorías')

@section('content')
<div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
    <h1 class="h3 fw-bold mb-0 d-flex align-items-center gap-2">
        <i class="bi bi-tags text-primary"></i>
        <span>Categorías</span>
    </h1>
    <button type="button" class="btn btn-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#newCategoryModal">
        <i class="bi bi-plus-circle me-2"></i>Nueva categoría
    </button>
</div>

<div class="kc-card p-4">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="text-muted small text-uppercase">
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th class="text-center">Movimientos</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td class="fw-semibold">{{ $category->name }}</td>
                        <td>
                            @if ($category->kind === 1)
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Ingreso</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Gasto</span>
                            @endif
                        </td>
                        <td class="text-center text-muted small">{{ $category->movements_count }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta categoría?');">
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
                        <td colspan="4" class="text-center py-4 text-muted">No hay categorías registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="newCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h2 class="modal-title h5 fw-bold">Nueva categoría</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nombre</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-semibold">Tipo</label>
                        <select name="kind" class="form-select @error('kind') is-invalid @enderror" required>
                            <option value="1" {{ old('kind', '1') == '1' ? 'selected' : '' }}>Ingreso</option>
                            <option value="2" {{ old('kind') == '2' ? 'selected' : '' }}>Gasto</option>
                        </select>
                        @error('kind')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary fw-semibold">Guardar categoría</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@if ($errors->any())
@push('scripts')
<script>new bootstrap.Modal(document.getElementById('newCategoryModal')).show();</script>
@endpush
@endif
