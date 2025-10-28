<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title }} - Mi Sitio Web</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <h1>{{ $page->title }}</h1>
        <nav>
            <ul>
                <li><a href="{{ route('home') }}">Inicio</a></li>
                <li><a href="{{ route('articles.index') }}">Artículos</a></li>
                <li><a href="{{ route('blog.index') }}">Blog</a></li>
                <li><a href="{{ route('pages.show', ['slug' => 'faq']) }}">Preguntas Frecuentes</a></li>
                <li><a href="{{ route('landing') }}">Landing</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>{{ $page->title }}</h2>
            <div>
                {!! $page->content !!}
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Mi Sitio Web. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
