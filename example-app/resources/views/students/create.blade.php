@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Registrar Estudiante</h2>
    <a class="btn btn-secondary" href="{{ route('students.index') }}"> Volver</a>
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

<form action="{{ route('students.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label">Nombre:</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email:</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <!-- ➡️ DESPLEGABLE DE CURSOS -->
    <div class="mb-3">
        <label class="form-label">Asignar Curso:</label>
        <select name="course_id" class="form-control" required>
            <option value="">-- Selecciona un Curso --</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Guardar Estudiante</button>
</form>
@endsection