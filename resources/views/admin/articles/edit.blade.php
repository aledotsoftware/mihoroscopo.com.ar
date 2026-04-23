@extends('admin.layouts.app')

@section('content')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-fluid px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-file-text">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg></div>
                                Editar articulo
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                            <a class="btn btn-sm btn-light text-primary" href="blog-management-posts-list.html">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-arrow-left me-1">
                                    <line x1="19" y1="12" x2="5" y2="12"></line>
                                    <polyline points="12 19 5 12 12 5"></polyline>
                                </svg>
                                Regresar a todos los articulos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->




        <form action="{{ route('articles.update', $article->id) }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $article->id }}">
            @method('PUT')
            <div class="container-fluid px-4">
                <div class="row gx-4">
                    <div class="col-lg-8">

                        <div class="card mb-4">
                            <div class="card-header">Slug</div>
                            <div class="card-body">
                                <input class="form-control" id="postTitleInput" type="text" placeholder="slug" name="slug"
                                    value="{{ $article->slug }}">
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">Titulo del articulo</div>
                            <div class="card-body">
                                <input class="form-control" id="postTitleInput" type="text"
                                    placeholder="Enter your post title..." name="title" value="{{ $article->title }}">
                            </div>
                        </div>
                        <div class="card card-header-actions mb-4">
                            <div class="card-header">
                                meta
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-info text-muted" data-bs-toggle="tooltip"
                                    data-bs-placement="left" title="" data-bs-original-title="">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                </svg>
                            </div>
                            <div class="card-body">
                                <textarea class="lh-base form-control" type="text" placeholder="Enter your post preview text..." rows="4"></textarea>
                            </div>
                        </div>
                        <div class="card card-header-actions mb-4 mb-lg-0">
                            <div class="card-header">
                                Contenido del articulo
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-info text-muted" data-bs-toggle="tooltip"
                                    data-bs-placement="left" title=""
                                    data-bs-original-title="Markdown is supported within the post content editor."
                                    aria-label="Markdown is supported within the post content editor.">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                </svg>
                            </div>
                            <div class="card-body">
                                <textarea id="postEditor" name="content"   style="display: none;">{{ $article->content }}</textarea>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card card-header-actions">
                            <div class="card-header">
                                Publish
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-info text-muted" data-bs-toggle="tooltip"
                                    data-bs-placement="left" title=""
                                    data-bs-original-title="Your updates will be live once a moderator approves the changes."
                                    aria-label="Your updates will be live once a moderator approves the changes.">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                </svg>
                            </div>
                            <div class="card-body">

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary" id="updateArticleBtn">Submit Updates</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>

    <script>
        document.getElementById('updateArticleBtn').closest('form').addEventListener('submit', function(e) {
            const btn = e.submitter || document.getElementById('updateArticleBtn');
            const originalText = btn.innerHTML;

            setTimeout(() => {
                btn.disabled = true;
                btn.setAttribute('aria-busy', 'true');
                btn.innerHTML = 'Actualizando...';
            }, 0);
        });
    </script>

@endsection

