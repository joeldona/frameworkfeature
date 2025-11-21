@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Post List</h2>
    <a class="btn btn-primary" href="{{ route('posts.create') }}">Create Post</a>
</div>
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Action</th>
    </tr>
    @foreach ($posts as $post)
    <tr>
        <td>{{ $post->id }}</td>
        <td>{{ $post->title }}</td>
        <td>
            <a class="btn btn-info btn-sm" href="{{ route('posts.show', $post) }}">Show</a>
            <a class="btn btn-warning btn-sm" href="{{ route('posts.edit', $post) }}">Edit</a>
            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
{{ $posts->links() }}
@endsection