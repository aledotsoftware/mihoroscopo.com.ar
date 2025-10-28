@extends('layouts.admin')

@section('content')
    <h1>Crear Nuevo Artículo</h1>

    <form action="{{ route('articles.store') }}" method="POST">
        @csrf
        <label for="slug">Slug:</label>
        <input type="text" name="slug" required>

        <label for="title">Título:</label>
        <input type="text" name="title" required>

        <label for="content">Contenido:</label>
        <textarea name="content" required></textarea>

        <label for="author_id">Autor ID:</label>
        <input type="number" name="author_id">

        <button type="submit">Guardar Artículo</button>
    </form>
@endsection
