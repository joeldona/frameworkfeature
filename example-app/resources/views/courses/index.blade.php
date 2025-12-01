@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Lista de Cursos</h2>
    <a class="btn btn-primary" href="{{ route('courses.create') }}">Crear Nuevo Curso</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th width="280px">Acciones</th>
    </tr>
    @foreach ($courses as $course)
    <tr>
        <td>{{ $course->id }}</td>
        <td>{{ $course->name }}</td>
        <td>{{ \Illuminate\Support\Str::limit($course->description, 50) }}</td>
        <td>
            <a class="btn btn-info btn-sm" href="{{ route('courses.show', $course->id) }}">Ver</a>
            <a class="btn btn-warning btn-sm" href="{{ route('courses.edit', $course->id) }}">Editar</a>
            
            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="d-inline">
                @csrf 
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Borrar curso?')">Borrar</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

{{ $courses->links() }}
@endsection