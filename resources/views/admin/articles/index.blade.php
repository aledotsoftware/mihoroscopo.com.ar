@extends('admin.layouts.app')


@section('content')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet">
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
                                        class="feather feather-list">
                                        <line x1="8" y1="6" x2="21" y2="6"></line>
                                        <line x1="8" y1="12" x2="21" y2="12"></line>
                                        <line x1="8" y1="18" x2="21" y2="18"></line>
                                        <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                        <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                        <line x1="3" y1="18" x2="3.01" y2="18"></line>
                                    </svg></div>
                                Posts List
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                            <a class="btn btn-sm btn-light text-primary" href="{{ asset('admin/articles/create')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-plus me-1">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Crear nuevo articulo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-fluid px-4">
            <div class="card">
                <div class="card-body">
                    <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                        <div class="datatable-top">
                            <div class="datatable-dropdown">
                                <label>
                                    <select class="datatable-selector" name="per-page">
                                        <option value="5">5</option>
                                        <option value="10" selected="">10</option>
                                        <option value="15">15</option>
                                        <option value="20">20</option>
                                        <option value="25">25</option>
                                    </select> entries per page
                                </label>
                            </div>
                            <div class="datatable-search">
                                <input class="datatable-input" placeholder="Search..." type="search" name="search"
                                    title="Search within table" aria-controls="datatablesSimple">
                            </div>
                        </div>
                        <div class="datatable-container">
                            <table id="datatablesSimple" class="datatable-table">
                                <thead>

                                    <tr>
                                        <th data-sortable="true" style="width: 65.76576576576578%;">
                                            <button class="datatable-sorter">Post Title</button>
                                        </th>
                                        <th data-sortable="true" style="width: 11.29129129129129%;"><button
                                                class="datatable-sorter">Date</button></th>
                                        <th data-sortable="true" style="width: 13.813813813813812%;">
                                            <button class="datatable-sorter">Status</button>
                                        </th>
                                        <th data-sortable="true" style="width: 9.12912912912913%;"><button
                                                class="datatable-sorter">Actions</button></th>




                                    </tr>
                                </thead>
                                <tbody>



                                    @foreach ($articles as $article)
                                        <tr data-index="0">
                                            <td>{{ $article->title }} - {{ $article->slug }} - {{ $article->author_id }}
                                            </td>
                                            <td>20 Jun 2021</td>
                                            <td>
                                                <div class="badge bg-gray-200 text-dark">Draft</div>
                                            </td>
                                            <td>
                                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                                    href="blog-management-edit-post.html" aria-label="Edit Article"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-edit">
                                                        <path
                                                            d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                        </path>
                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                        </path>
                                                    </svg></a>
                                                <a class="btn btn-datatable btn-icon btn-transparent-dark"
                                                    href="#!" aria-label="Delete Article"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-trash-2">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path
                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                        </path>
                                                        <line x1="10" y1="11" x2="10"
                                                            y2="17"></line>
                                                        <line x1="14" y1="11" x2="14"
                                                            y2="17"></line>
                                                    </svg></a>

                                                <a href="/admin/articles/{{ $article->id }}/edit">Editar</a>
                                                <form action="" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este artículo?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit">Eliminar</button>
                                                </form>
                                            </td>
                                    @endforeach



{{--
                                    <tr data-index="0">
                                        <td>Boots on the Ground, Inclusive Thought Provoking Ideas</td>
                                        <td>20 Jun 2021</td>
                                        <td>
                                            <div class="badge bg-gray-200 text-dark">Draft</div>
                                        </td>
                                        <td>
                                            <a class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                                href="blog-management-edit-post.html" aria-label="Edit Article"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-edit">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                    </path>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                    </path>
                                                </svg></a>
                                            <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!" aria-label="Delete Article"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-trash-2">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                    </path>
                                                    <line x1="10" y1="11" x2="10" y2="17">
                                                    </line>
                                                    <line x1="14" y1="11" x2="14" y2="17">
                                                    </line>
                                                </svg></a>
                                        </td>




                                    </tr>
                                    <tr data-index="1">
                                        <td>Invest In Social Impact</td>
                                        <td>19 Jun 2021</td>
                                        <td>
                                            <div class="badge bg-yellow-soft text-yellow">Pending Approval</div>
                                        </td>
                                        <td>
                                            <a class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                                href="blog-management-edit-post.html" aria-label="Edit Article"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-edit">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                    </path>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                    </path>
                                                </svg></a>
                                            <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!" aria-label="Delete Article"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-trash-2">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                    </path>
                                                    <line x1="10" y1="11" x2="10" y2="17">
                                                    </line>
                                                    <line x1="14" y1="11" x2="14" y2="17">
                                                    </line>
                                                </svg></a>
                                        </td>
                                    </tr>
                                    <tr data-index="2">
                                        <td>Save the World, Social Entrepreneur</td>
                                        <td>18 Jun 2021</td>
                                        <td>
                                            <div class="badge bg-green-soft text-green">Published</div>
                                        </td>
                                        <td>
                                            <a class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                                href="blog-management-edit-post.html" aria-label="Edit Article"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-edit">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                    </path>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                    </path>
                                                </svg></a>
                                            <a class="btn btn-datatable btn-icon btn-transparent-dark" href="#!" aria-label="Delete Article"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-trash-2">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                    </path>
                                                    <line x1="10" y1="11" x2="10" y2="17">
                                                    </line>
                                                    <line x1="14" y1="11" x2="14" y2="17">
                                                    </line>
                                                </svg></a>
                                        </td>

--}}

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Post Title</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="datatable-bottom">
                            <div class="datatable-info">Showing x to x of x entries</div>
                            <nav class="datatable-pagination">
                                <ul class="datatable-pagination-list"></ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/panel/js/datatables/datatables-simple-demo.js') }}"></script>

    {{--

<h1>Listado de Artículos</h1>

@if (session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif

<table>
    <thead>
        <tr>
            <th>Título</th>
            <th>Slug</th>
            <th>Autor ID</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($articles as $article)
        <tr>
            <td>{{ $article->title }}</td>
            <td>{{ $article->slug }}</td>
            <td>{{ $article->author_id }}</td>
            <td>
                <a href="">Editar</a>
                <form action="" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este artículo?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table> --}}
@endsection
