@extends('layouts.app')

@section('title', 'Editar administrador - KontaCash')
@section('page_title', 'Editar administrador')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 fw-bold mb-0">Editar administrador</h1>
    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">Volver</a>
</div>

<div class="kc-card p-4">
    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Nombre</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Correo electrónico</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Nueva contraseña (opcional)</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Dejar vacío para mantener">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Confirmar nueva contraseña</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('users.index') }}" class="btn btn-light">Cancelar</a>
            <button type="submit" class="btn btn-primary fw-semibold">Actualizar</button>
        </div>
    </form>
</div>
@endsection
