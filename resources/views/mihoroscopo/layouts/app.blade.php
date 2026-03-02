<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://unpkg.com/easymde/dist/easymde.min.css" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <title>@yield('title', 'Mi Sitio Web')</title>
    <meta name="description" content="@yield('description', 'Explora el mundo de la astrología y descubre tu horóscopo diario. Encuentra guías astrológicas, predicciones personalizadas y consejos sobre cómo mejorar tu vida a través de la astrología.')">
    <meta name="keywords" content="@yield('keywords', 'astrología, horóscopos, predicciones, tarot, signos zodiacales, compatibilidad, astrología diaria, consejos astrológicos')">

    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<!-- analitica web -->
    <script data-host="https://analiticaweb.com.ar" data-dnt="false" src="https://analiticaweb.com.ar/js/script.js"
        id="ZwSg9rf6GA" async defer></script>


    <!-- Google tag (gtag.js)  GOOGLE ADS-->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-16701477464"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'AW-16701477464');
    </script>


    <!-- Google tag (gtag.js)  Analytics-->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-5DNG5MFGZZ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-5DNG5MFGZZ');
    </script>

    <!-- Microsft Clarity-->
    <script type="text/javascript">
        (function(c, l, a, r, i, t, y) {
            c[a] = c[a] || function() {
                (c[a].q = c[a].q || []).push(arguments)
            };
            t = l.createElement(r);
            t.async = 1;
            t.src = "https://www.clarity.ms/tag/" + i;
            y = l.getElementsByTagName(r)[0];
            y.parentNode.insertBefore(t, y);
        })(window, document, "clarity", "script", "o5xaqvsgs8");
    </script>

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/templatemo-tale-seo-agency.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- ***** Pre-Header Area Start ***** -->
    <div class="pre-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="left-info">
                        <ul>
                            <li><a href="/landing"><i class="fa fa-star"></i>Horóscopo Gratis</a></li>
                            <li><a href="/landing"><i class="fa fa-star"></i>Guía Astral </a></li>
                            <li><a href="/landing"><i class="fa fa-star"></i>Consejo Diario</a></li>
                            <li><a href="/landing"><i class="fa fa-star"></i>Horóscopo Amor</a></li>
                            <li><a href="/landing"><i class="fa fa-star"></i>Ritual Lunar</a></li>
                            <li><a href="/landing"><i class="fa fa-star"></i>Ritual de Prosperidad</a></li>
                            <li><a href="/landing"><i class="fa fa-star"></i>Compatibilidad Zodiacal</a></li>

                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <a href="{{ route('home') }}" class="logo">
                            <img src="{{ asset('assets/images/logo.png') }}" alt="Mi Horóscopo Logo"
                                style="max-width: 112px;">
                        </a>
                        <ul class="nav">
                            {{-- <li class="scroll-to-section"><a href="#top" class="active">Inicio</a></li>
                            <li class="scroll-to-section"><a href="#horoscopes">Horóscopos</a></li>
                            <li class="scroll-to-section"><a href="#plans">Planes y Precios</a></li>
                            <li class="has-sub">
                                <a href="javascript:void(0)">Recursos</a>
                                <ul class="sub-menu">
                                    <li><a href="about.html">Quiénes Somos</a></li>
                                    <li><a href="faqs.html">Preguntas Frecuentes</a></li>
                                </ul>
                            </li>
                            <li class="scroll-to-section"><a href="#testimonials">Testimonios</a></li>
                            <li class="scroll-to-section"><a href="#contact">Contacto</a></li> --}}


                            <li class="scroll-to-section"><a href="{{ route('articles.index') }}">Artículos</a></li>
                            <li class="scroll-to-section"><a href="/landing">Suscríbete</a></li>
                            {{-- <li class="scroll-to-section"><a href="{{ route('pages.show', ['slug' => 'faq']) }}">Preguntas Frecuentes</a></li> --}}
                            {{-- <li class="scroll-to-section"><a href="{{ route('landing') }}">Landing</a></li> --}}

                        </ul>
                        <a class='menu-trigger' role="button" tabindex="0" aria-label="Abrir menú" aria-expanded="false">
                            <span>Menú</span>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </header>




    <!-- Contenido principal -->

    @yield('content') <!-- Aquí se inyectará el contenido de las vistas -->






    <footer>
        <!-- terminos y condiciones  -->
        <div class="terms-conditions">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p class="terms-text">Al utilizar nuestros servicios, aceptas nuestros <a href="/blog/terminos-y-condiciones-de-servicio">Términos y Condiciones</a> y nuestra <a href="/blog/politica-de-privacidad">Política de Privacidad</a>. Mi Horóscopo es un servicio de suscripción que puede incluir cargos recurrentes. Para más información sobre precios y facturación, consulta nuestros términos de servicio.</p>
                        <p>¿Necesitas ayuda? Soporte técnico y asistencia al usuario: <a href="mailto:info@tudexnetworks.com">info@tudexnetworks.com</a></p>

                        <p>Copyright © {{ date('Y') }} <a href="#">{{ config('app.name') }}</a>.
                    </div>
                </div>
            </div>
        </div>

    </footer>


    <!-- Scripts -->
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('assets/js/isotope.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl-carousel.js') }}"></script>
    <script src="{{ asset('assets/js/tabs.js') }}"></script>
    <script src="{{ asset('assets/js/popup.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script src="https://unpkg.com/easymde/dist/easymde.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/panel/js/markdown.js') }}"></script>

</body>

</html>