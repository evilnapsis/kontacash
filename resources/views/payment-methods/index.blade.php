@extends('layouts.app')

@section('title', 'Formas de pago - KontaCash')
@section('page_title', 'Formas de pago')

@section('content')
<div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
    <h1 class="h3 fw-bold mb-0 d-flex align-items-center gap-2">
        <i class="bi bi-credit-card text-primary"></i>
        <span>Formas de pago</span>
    </h1>
    <button type="button" class="btn btn-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#newMethodModal">
        <i class="bi bi-plus-circle me-2"></i>Nueva forma de pago
    </button>
</div>

<div class="kc-card p-4">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="text-muted small text-uppercase">
                <tr>
                    <th>Nombre</th>
                    <th class="text-center">Movimientos</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($paymentMethods as $method)
                    <tr>
                        <td class="fw-semibold">{{ $method->name }}</td>
                        <td class="text-center text-muted small">{{ $method->movements_count }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('payment-methods.edit', $method) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('payment-methods.destroy', $method) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta forma de pago?');">
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
                        <td colspan="3" class="text-center py-4 text-muted">No hay formas de pago registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="newMethodModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h2 class="modal-title h5 fw-bold">Nueva forma de pago</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form action="{{ route('payment-methods.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <label class="form-label small fw-semibold">Nombre</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
<script>new bootstrap.Modal(document.getElementById('newMethodModal')).show();</script>
@endpush
@endif
