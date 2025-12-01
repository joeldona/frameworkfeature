@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="d-flex justify-content-between mb-3">
            <h2> Detalles del Estudiante</h2>
            <a class="btn btn-secondary" href="{{ route('students.index') }}"> Volver</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        Estudiante #{{ $student->id }}
    </div>
    <div class="card-body">
        <h5 class="card-title">{{ $student->name }}</h5>
        <p class="card-text"><strong>Email:</strong> {{ $student->email }}</p>
        <hr>
        <p class="card-text">
            <strong>Curso Matriculado:</strong> 
            {{ $student->course->name }} 
            (ID: {{ $student->course_id }})
        </p>
    </div>
</div>
@endsection