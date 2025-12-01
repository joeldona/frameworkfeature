@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Editar Estudiante</h2>
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

<form action="{{ route('students.update', $student->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Nombre:</label>
        <input type="text" name="name" value="{{ $student->name }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email:</label>
        <input type="email" name="email" value="{{ $student->email }}" class="form-control" required>
    </div>

    <!-- ➡️ DESPLEGABLE DE CURSOS (Con selección automática) -->
    <div class="mb-3">
        <label class="form-label">Curso:</label>
        <select name="course_id" class="form-control" required>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ $student->course_id == $course->id ? 'selected' : '' }}>
                    {{ $course->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar Estudiante</button>
</form>
@endsection