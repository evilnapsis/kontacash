@extends('layouts.app')

@section('title', 'Personas - KontaCash')
@section('page_title', 'Personas')

@section('content')
<div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
    <h1 class="h3 fw-bold mb-0 d-flex align-items-center gap-2">
        <i class="bi bi-people text-primary"></i>
        <span>Personas</span>
    </h1>
    <button type="button" class="btn btn-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#newPersonModal">
        <i class="bi bi-plus-circle me-2"></i>Nueva persona
    </button>
</div>

<div class="kc-card p-4">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="text-muted small text-uppercase">
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Notas</th>
                    <th class="text-center">Movimientos</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($people as $person)
                    <tr>
                        <td class="fw-semibold">{{ $person->name }}</td>
                        <td class="text-muted small">{{ $person->email ?: '—' }}</td>
                        <td class="text-muted small">{{ $person->phone ?: '—' }}</td>
                        <td class="text-muted small">{{ $person->notes ?: '—' }}</td>
                        <td class="text-center text-muted small">{{ $person->movements_count }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('people.edit', $person) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('people.destroy', $person) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta persona?');">
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
                        <td colspan="6" class="text-center py-4 text-muted">No hay personas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="newPersonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h2 class="modal-title h5 fw-bold">Nueva persona</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form action="{{ route('people.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nombre</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Correo (opcional)</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Teléfono (opcional)</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-semibold">Notas (opcional)</label>
                        <textarea name="notes" rows="2" class="form-control">{{ old('notes') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary fw-semibold">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@if ($errors->any())
@push('scripts')
<script>new bootstrap.Modal(document.getElementById('newPersonModal')).show();</script>
@endpush
@endif
