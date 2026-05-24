@extends('layouts.admin')

@section('content')
    <h1>Crear Nuevo Artículo</h1>

    <form action="{{ route('articles.store') }}" method="POST">
        @csrf
        <label for="slug">Slug:<span class="required-indicator" aria-hidden="true">*</span></label>
        <input type="text" name="slug" id="slug" required aria-required="true">

        <label for="title">Título:<span class="required-indicator" aria-hidden="true">*</span></label>
        <input type="text" name="title" id="title" required aria-required="true">

        <label for="content">Contenido:<span class="required-indicator" aria-hidden="true">*</span></label>
        <textarea name="content" id="content" required aria-required="true"></textarea>

        <label for="author_id">Autor ID:</label>
        <input type="number" name="author_id" id="author_id">

        <button type="submit" id="submitArticleBtn">Guardar Artículo</button>
    </form>

    <script>
        document.getElementById('submitArticleBtn').closest('form').addEventListener('submit', function(e) {
            const btn = e.submitter || document.getElementById('submitArticleBtn');
            const originalText = btn.innerHTML;

            setTimeout(() => {
                btn.disabled = true;
                btn.setAttribute('aria-busy', 'true');
                btn.innerHTML = 'Guardando...';
            }, 0);
        });
    </script>
@endsection
