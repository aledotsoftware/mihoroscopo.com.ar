<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas Frecuentes - Mi Sitio Web</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <h1>Preguntas Frecuentes</h1>
        <nav>
            <ul>
                <li><a href="{{ route('home') }}">Inicio</a></li>
                <li><a href="{{ route('articles.index') }}">Artículos</a></li>
                <li><a href="{{ route('blog.index') }}">Blog</a></li>
                <li><a href="{{ route('faq.index') }}">Preguntas Frecuentes</a></li>
                <li><a href="{{ route('landing') }}">Landing</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>¿Tienes alguna pregunta?</h2>
            <dl>
                <dt>¿Cómo puedo contactarlos?</dt>
                <dd>Puedes contactarnos a través de nuestro formulario de contacto en la página de contacto.</dd>

                <dt>¿Dónde puedo encontrar información sobre mi pedido?</dt>
                <dd>Toda la información sobre tu pedido está disponible en tu cuenta de usuario, sección de pedidos.</dd>

                <dt>¿Qué métodos de pago aceptan?</dt>
                <dd>Aceptamos varios métodos de pago, incluyendo tarjetas de crédito, PayPal y transferencia bancaria.</dd>

                <dt>¿Puedo devolver un artículo?</dt>
                <dd>Sí, aceptamos devoluciones dentro de los 30 días posteriores a la compra. Consulta nuestra política de devoluciones para más detalles.</dd>
            </dl>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Mi Sitio Web. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
