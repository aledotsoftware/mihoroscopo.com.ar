@extends('admin.layouts.app')

@section('content')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-fluid px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="file-text"></i></div>
                                Crear Nuevo Artículo
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                            <a class="btn btn-sm btn-light text-primary" href="{{ route('articles.index') }}">
                                <i data-feather="arrow-left" class="me-1"></i>
                                Regresar a todos los articulos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-fluid px-4">
            <div class="card mb-4">
                <div class="card-body">
                    <form id="createArticleForm" action="{{ route('articles.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug: <span class="text-danger required-indicator" aria-hidden="true">*</span></label>
                            <input type="text" name="slug" id="slug" class="form-control" required aria-required="true">
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Título: <span class="text-danger required-indicator" aria-hidden="true">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" required aria-required="true">
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Contenido: <span class="text-danger required-indicator" aria-hidden="true">*</span></label>
                            <textarea name="content" id="content" class="form-control" rows="5" required aria-required="true"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="author_id" class="form-label">Autor ID:</label>
                            <input type="number" name="author_id" id="author_id" class="form-control">
                        </div>

                        <button id="submitBtn" class="btn btn-primary" type="submit">Guardar Artículo</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('createArticleForm');
            const submitBtn = document.getElementById('submitBtn');

            if (form && submitBtn) {
                form.addEventListener('submit', function() {
                    submitBtn.disabled = true;
                    submitBtn.setAttribute('aria-busy', 'true');
                    submitBtn.innerHTML = 'Guardando...';
                    submitBtn.style.opacity = '0.7';
                    submitBtn.style.cursor = 'not-allowed';
                });
            }
        });
    </script>
@endsection
