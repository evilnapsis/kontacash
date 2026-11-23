@extends('layouts.app')

@section('title', 'Administradores - KontaCash')
@section('page_title', 'Administradores')

@section('content')
<div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
    <h1 class="h3 fw-bold mb-0 d-flex align-items-center gap-2">
        <i class="bi bi-shield-lock text-primary"></i>
        <span>Administradores</span>
    </h1>
    <button type="button" class="btn btn-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#newUserModal">
        <i class="bi bi-plus-circle me-2"></i>Nuevo administrador
    </button>
</div>

<div class="kc-card p-4">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="text-muted small text-uppercase">
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Alta</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="fw-semibold">
                            {{ $user->name }}
                            @if ($user->id === Auth::id())
                                <span class="badge bg-primary-subtle text-primary ms-1">Tú</span>
                            @endif
                        </td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td class="text-muted small">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            @if ($user->id !== Auth::id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este administrador?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="newUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h2 class="modal-title h5 fw-bold">Nuevo administrador</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nombre</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Correo electrónico</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Contraseña</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-semibold">Confirmar contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
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
<script>new bootstrap.Modal(document.getElementById('newUserModal')).show();</script>
@endpush
@endif
