@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Lista de Estudiantes</h2>
    {{-- 👇 Agrupamos los botones para que salgan juntos a la derecha --}}
    <div>
        <a class="btn btn-success" href="{{ route('students.export') }}">Exportar CSV</a>
        <a class="btn btn-primary" href="{{ route('students.create') }}">Nuevo Estudiante</a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Curso Asignado</th>
        <th width="280px">Acciones</th>
    </tr>
    @foreach ($students as $student)
    <tr>
        <td>{{ $student->id }}</td>
        <td>{{ $student->name }}</td>
        <td>{{ $student->email }}</td>
        <td>
            {{-- Accedemos al objeto curso y luego a su nombre --}}
            {{-- Usamos el operador ?? por si acaso se borró el curso --}}
            <span class="badge bg-secondary">{{ $student->course->name ?? 'Sin Curso' }}</span>
        </td>
        <td>
            <a class="btn btn-info btn-sm" href="{{ route('students.show', $student->id) }}">Ver</a>
            <a class="btn btn-warning btn-sm" href="{{ route('students.edit', $student->id) }}">Editar</a>
            
            <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Borrar estudiante?')">Borrar</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

{{ $students->links() }}
@endsection