@extends('layouts.app')

@section('title', 'Editar forma de pago - KontaCash')
@section('page_title', 'Editar forma de pago')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 fw-bold mb-0">Editar forma de pago</h1>
    <a href="{{ route('payment-methods.index') }}" class="btn btn-outline-secondary btn-sm">Volver</a>
</div>

<div class="kc-card p-4">
    <form action="{{ route('payment-methods.update', $paymentMethod) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label small fw-semibold">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $paymentMethod->name) }}" class="form-control @error('name') is-invalid @enderror" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('payment-methods.index') }}" class="btn btn-light">Cancelar</a>
            <button type="submit" class="btn btn-primary fw-semibold">Actualizar</button>
        </div>
    </form>
</div>
@endsection
