@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Editar Curso</h2>
    <a class="btn btn-secondary" href="{{ route('courses.index') }}"> Volver</a>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('courses.update', $course->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Nombre del Curso:</label>
        <input type="text" name="name" value="{{ $course->name }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Descripción:</label>
        <textarea class="form-control" style="height:150px" name="description" required>{{ $course->description }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar Curso</button>
</form>
@endsection