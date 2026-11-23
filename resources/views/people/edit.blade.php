@extends('layouts.app')

@section('title', 'Editar persona - KontaCash')
@section('page_title', 'Editar persona')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 fw-bold mb-0">Editar persona</h1>
    <a href="{{ route('people.index') }}" class="btn btn-outline-secondary btn-sm">Volver</a>
</div>

<div class="kc-card p-4">
    <form action="{{ route('people.update', $person) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Nombre</label>
                <input type="text" name="name" value="{{ old('name', $person->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Correo</label>
                <input type="email" name="email" value="{{ old('email', $person->email) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Teléfono</label>
                <input type="text" name="phone" value="{{ old('phone', $person->phone) }}" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label small fw-semibold">Notas</label>
                <textarea name="notes" rows="3" class="form-control">{{ old('notes', $person->notes) }}</textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('people.index') }}" class="btn btn-light">Cancelar</a>
            <button type="submit" class="btn btn-primary fw-semibold">Actualizar</button>
        </div>
    </form>
</div>
@endsection
