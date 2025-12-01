@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="d-flex justify-content-between mb-3">
            <h2> Detalles del Curso</h2>
            <a class="btn btn-secondary" href="{{ route('courses.index') }}"> Volver</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <strong>{{ $course->name }}</strong>
    </div>
    <div class="card-body">
        <h5 class="card-title">Descripción del Curso:</h5>
        <p class="card-text">{{ $course->description }}</p>
    </div>
    <div class="card-footer text-muted">
        Creado el: {{ $course->created_at->format('d/m/Y') }}
    </div>
</div>
<h3>Estudiantes Matriculados ({{ $course->students->count() }})</h3>

@if($course->students->isEmpty())
    <div class="alert alert-warning">
        No hay estudiantes en este curso todavía.
    </div>
@else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($course->students as $student)
            <tr>
                <td>{{ $student->id }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
{{-- 👆 FIN DEL HASMANY 👆 --}}

@endsection