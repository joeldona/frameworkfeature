@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Crear Nuevo Curso</h2>
    <a class="btn btn-secondary" href="{{ route('courses.index') }}"> Volver</a>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>¡Ups!</strong> Hubo problemas con los datos.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('courses.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Nombre del Curso:</label>
        <input type="text" name="name" class="form-control" placeholder="Ej: Matemáticas Avanzadas" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Descripción:</label>
        <textarea class="form-control" style="height:150px" name="description" placeholder="Detalles del curso..." required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Guardar Curso</button>
</form>
@endsection