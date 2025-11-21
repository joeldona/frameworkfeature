@extends('layouts.app') 

{{-- Define el título específico de la pestaña/página --}}
@section('title', $post->title)

@section('content')
    <div class="row mb-4">
        <div class="col-lg-12">
            {{-- Botón para volver al índice, flotando a la derecha --}}
            <a href="{{ route('posts.index') }}" class="btn btn-secondary float-end">
                ← Volver a la Lista
            </a>
            
            {{-- Título de la publicación --}}
            <h1 class="display-4">{{ $post->title }}</h1>
            
            {{-- Metadatos del post --}}
            <p class="text-muted">
                Publicado el: {{ $post->created_at->format('d M Y') }}
                {{-- Nota: El objeto $post tiene métodos de Carbon para formatear fechas --}}
            </p>
            <hr>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            {{-- Contenido de la publicación --}}
            <p class="lead">{{ $post->content }}</p>
        </div>
    </div>

    {{-- Opciones de edición/borrado (solo para desarrollo) --}}
    <div class="mt-5 pt-3 border-top">
        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">
            Editar Post
        </a>
        
        {{-- Formulario para eliminar (requiere POST/DELETE) --}}
        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este post?');">
                Eliminar Post
            </button>
        </form>
    </div>
@endsection