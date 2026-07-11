@extends('mihoroscopo.layouts.app')

@section('title', 'Suscripción de Horóscopos Personalizados - Tu Guía Astrológica Gratis')

@section('content')


    <div class="main-banner" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="caption header-text">
                        <h6>Conecta con tu Destino</h6>
                        <div class="line-dec"></div>
                        <h5>Recibe tu Horóscopo Diario Gratis</h5>
                        <p>Recibe tu horóscopo personalizado cada día y descubre lo que el universo tiene reservado para
                            ti.
                            Ofrecemos opciones de suscripción gratuita para que no te pierdas ninguna
                            revelación importante.
                            Explora nuestras opciones pagas y encuentra la que mejor se adapte a ti.</p>
                        <div class="main-button scroll-to-section"><a href="/landing">Ver Planes</a></div>
                        <span aria-hidden="true">o</span>
                        <div class="second-button"><a href="/landing">Suscríbete</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--
<div class="main-banner" id="top">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="caption header-text">
                    <h6>Conéctate con tu Destino</h6>
                    <div class="line-dec"></div>
                    <h4>Descubre tu <em>Horóscopo Diario</em> y <span>Guía Astrológica Gratis</span></h4>
                    <p>
                        Recibe tu horóscopo personalizado cada día y descubre lo que el universo tiene reservado para ti.
                        Ofrecemos opciones de suscripción diaria, semanal o mensual para que no te pierdas ninguna revelación importante.
                        Explora nuestras opciones y encuentra la que mejor se adapte a ti.
                    </p>
                    <h5>Horóscopo Gratis</h5>
                    <ul>
                        <li>Guía Astral</li>
                        <li>Consejo Diario</li>
                        <li>Horóscopo Amor</li>
                        <li>Ritual Lunar</li>
                        <li>Ritual de Prosperidad</li>
                        <li>Compatibilidad Zodiacal</li>
                    </ul>
                    <div class="main-button scroll-to-section">
                        <a href="/landing">Ver Planes</a>
                    </div>
                    <span>o</span>
                    <div class="second-button">
                        <a href="/landing">Suscríbete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

    {{--
<ul>
    <li>Guía Astral</li>
    <li>Consejo Diario</li>
    <li>Horóscopo Amor</li>
    <li>Ritual Lunar</li>
    <li>Ritual de Prosperidad</li>
    <li>Compatibilidad Zodiacal</li>
</ul>
<div class="contact-us section" id="services">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 offset-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-heading">
                            <h2>Tambien puedes Descubrir Nuestras <em>Subscripcion Premium</em> &amp;
                                <span>Características Exclusivas</span>
                            </h2>
                            <div class="line-dec"></div>
                            <p>Explora nuestras opciones para obtener el horoscoopo que guiarán tu día, semana o
                                mes.</p>
                        </div>
                    </div>
                    <br>
                    <div class="col-lg-6 col-sm-6">
                    <div class="service-item">
                        <div class="icon">
                            <img src="./assets/images/services-01.jpg" alt="horóscopo diario" class="templatemo-feature">
                        </div>
                        <h4>Horóscopo Diario Personalizado</h4>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <div class="service-item">
                        <div class="icon">
                            <img src="./assets/images/services-02.jpg" alt="lectura semanal" class="templatemo-feature">
                        </div>
                        <h4>Lectura Astrológica Semanal</h4>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <div class="service-item">
                        <div class="icon">
                            <img src="./assets/images/services-03.jpg" alt="predicciones precisas" class="templatemo-feature">
                        </div>
                        <h4>Predicciones Precisas para tu Futuro</h4>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <div class="service-item">
                        <div class="icon">
                            <img src="./assets/images/services-04.jpg" alt="consejos astrológicos" class="templatemo-feature">
                        </div>
                        <h4>Consejos Astrológicos y Guía Espiritual</h4>
                    </div>
                </div> -->
                </div>
            </div>
        </div>
    </div>
</div> --}}




{{--
    <div class="contact-us section" id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 offset-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-heading">
                                <h2>También puedes Descubrir Nuestras <em>Subscripciones Premium</em> &amp;
                                    <span>Características Exclusivas</span></h2>
                                <div class="line-dec"></div>
                                <p>Explora nuestras opciones para obtener el horóscopo que guiará tu día, semana o mes.</p>
                            </div>
                        </div>
                        <br>
                        <div class="col-lg-6 col-sm-6">
                            <div class="service-item">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/GuiaAstral.png') }}" alt="horóscopo diario"
                                        class="templatemo-feature">
                                </div>
                                <h4>Guía Astral</h4>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="service-item">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/ConsejoDiario.png') }}" alt="lectura semanal"
                                        class="templatemo-feature">
                                </div>
                                <h4>Consejo Diario</h4>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="service-item">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/HoroscopodeAmor.png') }}" alt="consejos astrológicos"
                                        class="templatemo-feature">
                                </div>
                                <h4>Horóscopo de Amor</h4>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="service-item">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/RitualLunar.png') }}" alt="consejos astrológicos"
                                        class="templatemo-feature">
                                </div>
                                <h4>Ritual Lunar</h4>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-6">
                            <div class="service-item">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/RitualdeProsperidad.png') }}" alt="consejos astrológicos"
                                        class="templatemo-feature">
                                </div>
                                <h4>Ritual de Prosperidad</h4>

                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="service-item">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/CompatibilidadZodiacal.png') }}" alt="consejos astrológicos"
                                        class="templatemo-feature">
                                </div>
                                <h4>Compatibilidad Zodiacal</h4>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="contact-us section" id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 offset-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-heading">
                                <h2>También puedes Descubrir Nuestras <em>Subscripciones Premium</em> &amp; <span>Características Exclusivas</span></h2>
                                <div class="line-dec"></div>
                                <p>Explora nuestras suscripciones "Mi Horóscopo Gratis" y "Mi Horóscopo Premium" para recibir contenido astrológico que guiará tus días. ¡Recibe todo esto directamente en tu correo electrónico cada día! </p>

                            </div>
                        </div>
                        <br>
                        <div class="col-lg-6 col-sm-6">
                            <div class="service-item">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/GuiaAstral.png') }}" alt="Guía Astral" class="templatemo-feature">
                                </div>
                                <h4>Guía Astral</h4>
                                <p>Obtén una visión profunda y detallada de las influencias astrológicas que afectan tu vida diaria.</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="service-item">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/ConsejoDiario.png') }}" alt="Consejo Diario" class="templatemo-feature">
                                </div>
                                <h4>Consejo Diario</h4>
                                <p>Recibe valiosos consejos diarios basados en tu signo zodiacal para tomar mejores decisiones.</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="service-item">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/HoroscopodeAmor.png') }}" alt="Horóscopo de Amor" class="templatemo-feature">
                                </div>
                                <h4>Horóscopo de Amor</h4>
                                <p>Descubre qué depara el destino en el amor y mejora tus relaciones con predicciones precisas.</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="service-item">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/RitualLunar.png') }}" alt="Ritual Lunar" class="templatemo-feature">
                                </div>
                                <h4>Ritual Lunar</h4>
                                <p>Sigue nuestros rituales lunares para alinearte con las fases de la luna y potenciar tus intenciones.</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="service-item">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/RitualdeProsperidad.png') }}" alt="Ritual de Prosperidad" class="templatemo-feature">
                                </div>
                                <h4>Ritual de Prosperidad</h4>
                                <p>Implementa rituales de prosperidad para atraer abundancia y éxito financiero en tu vida.</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="service-item">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/CompatibilidadZodiacal.png') }}" alt="Compatibilidad Zodiacal" class="templatemo-feature">
                                </div>
                                <h4>Compatibilidad Zodiacal</h4>
                                <p>Consulta la compatibilidad entre signos para fortalecer tus relaciones personales y profesionales.</p>
                            </div>
                        </div>

                        <p>*Los contenidos Guía Astral, Consejo Diario, Horóscopo de Amor, Ritual Lunar,Ritual de Prosperidad y Compatibilidad Zodiacal son exclusivos de nuestra suscripción premium no está disponible en la opción gratuita, así que asegúrate de aprovechar nuestras ofertas premium para disfrutar de todos los beneficios.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{--
<div class="projects section" id="projects">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>Explora los <em>Signos</em> &amp; <span>Del Zodiaco</span></h2>
                    <div class="line-dec"></div>
                    <p>Conoce más sobre las características y energías de cada signo del zodiaco. Descubre qué hace
                        único a cada uno de ellos.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="owl-features owl-carousel">
                    <div class="item">
                        <img src="./assets/images/aries.jpg" alt="Aries">
                        <div class="down-content">
                            <h4>Aries</h4>
                            <p>Valiente, decidido y apasionado.</p>
                            <a href="{{ asset('blog/aries') }}" aria-label="Leer más sobre Aries"><i class="fa fa-link" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="item">
                        <img src="./assets/images/tauro.jpg" alt="Tauro">
                        <div class="down-content">
                            <h4>Tauro</h4>
                            <p>Confiable, paciente y devoto.</p>
                            <a href="{{ asset('blog/tauro') }}" aria-label="Leer más sobre Tauro"><i class="fa fa-link" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="item">
                        <img src="./assets/images/geminis.jpg" alt="Géminis">
                        <div class="down-content">
                            <h4>Géminis</h4>
                            <p>Curioso, adaptable y comunicativo.</p>
                            <a href="{{ asset('blog/geminis') }}" aria-label="Leer más sobre Géminis"><i class="fa fa-link" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="item">
                        <img src="./assets/images/cancer.jpg" alt="Cáncer">
                        <div class="down-content">
                            <h4>Cáncer</h4>
                            <p>Emotivo, protector y perspicaz.</p>
                            <a href="{{ asset('blog/cancer') }}" aria-label="Leer más sobre Cáncer"><i class="fa fa-link" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="item">
                        <img src="./assets/images/leo.jpg" alt="Leo">
                        <div class="down-content">
                            <h4>Leo</h4>
                            <p>Generoso, alegre y de gran corazón.</p>
                            <a href="{{ asset('blog/leo') }}" aria-label="Leer más sobre Leo"><i class="fa fa-link" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="item">
                        <img src="./assets/images/virgo.jpg" alt="Virgo">
                        <div class="down-content">
                            <h4>Virgo</h4>
                            <p>Meticuloso, leal y trabajador.</p>
                            <a href="{{ asset('blog/virgo') }}" aria-label="Leer más sobre Virgo"><i class="fa fa-link" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="item">
                        <img src="./assets/images/libra.jpg" alt="Libra">
                        <div class="down-content">
                            <h4>Libra</h4>
                            <p>Diplomático, justo y sociable.</p>
                            <a href="{{ asset('blog/libra') }}" aria-label="Leer más sobre Libra"><i class="fa fa-link" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="item">
                        <img src="./assets/images/escorpio.jpg" alt="Escorpio">
                        <div class="down-content">
                            <h4>Escorpio</h4>
                            <p>Apasionado, valiente e ingenioso.</p>
                            <a href="{{ asset('blog/escorpio') }}" aria-label="Leer más sobre Escorpio"><i class="fa fa-link" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="item">
                        <img src="./assets/images/sagitario.jpg" alt="Sagitario">
                        <div class="down-content">
                            <h4>Sagitario</h4>
                            <p>Aventurero, optimista y honesto.</p>
                            <a href="{{ asset('blog/sagitario') }}" aria-label="Leer más sobre Sagitario"><i class="fa fa-link" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="item">
                        <img src="./assets/images/capricornio.jpg" alt="Capricornio">
                        <div class="down-content">
                            <h4>Capricornio</h4>
                            <p>Disciplinado, responsable y ambicioso.</p>
                            <a href="{{ asset('blog/capricornio') }}" aria-label="Leer más sobre Capricornio"><i class="fa fa-link" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="item">
                        <img src="./assets/images/acuario.jpg" alt="Acuario">
                        <div class="down-content">
                            <h4>Acuario</h4>
                            <p>Progresista, original y humanitario.</p>
                            <a href="{{ asset('blog/acuario') }}" aria-label="Leer más sobre Acuario"><i class="fa fa-link" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="item">
                        <img src="./assets/images/piscis.jpg" alt="Piscis">
                        <div class="down-content">
                            <h4>Piscis</h4>
                            <p>Compasivo, artístico e intuitivo.</p>
                            <a href="{{ asset('blog/piscis') }}" aria-label="Leer más sobre Piscis"><i class="fa fa-link" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

    {{-- <div class="infos section" id="infos">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-content">
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="section-heading">
                                    <h2>Descubre Más <em>Sobre Nosotros</em> &amp; Lo Que <span>Ofrecemos</span></h2>
                                    <div class="line-dec"></div>
                                    <p>En nuestro sitio web, ofrecemos un servicio integral de horóscopos que te ayudará
                                        a comprender mejor tu signo zodiacal y cómo sus energías influyen en tu vida
                                        diaria. Aprovecha nuestros horóscopos detallados y personalizados para tomar
                                        decisiones informadas y encontrar equilibrio.</p>
                                </div>

                                <p class="more-info">Nuestra misión es proporcionar horóscopos precisos y perspicaces
                                    que te ayuden a navegar por los desafíos de la vida y aprovechar las oportunidades
                                    que el universo tiene para ofrecerte. Únete a nuestra comunidad y recibe tus
                                    horóscopos directamente en tu correo para mantenerte al tanto de cómo las estrellas
                                    afectan tu vida.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}



    {{-- <div class="suscripciones section" id="suscripciones">
<div class="container">
    <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 900px;">
        <h4 class="text-primary">Planes de Suscripción</h4>
        <h1 class="display-5 mb-4">¿No Sabés Qué Plan de pagosElegir?</h1>
        <p class="mb-0">Elegí el plan que mejor se adapte a vos y recibí tu horóscopo de manera regular. ¡Accedé a contenido exclusivo y descubrí lo que los astros tienen para decirte!</p>
    </div>
    <div class="row g-5 justify-content-center">
        <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.1s">
            <div class="plan-item bg-light rounded text-center">
                <div class="text-center text-dark border-bottom d-flex flex-column justify-content-center p-4" style="width: 100%; height: 160px;">
                    <p class="fs-2 fw-bold text-uppercase mb-0">Diario</p>
                    <div class="d-flex justify-content-center">
                        <strong class="align-self-start">ARS</strong>
                        <p class="mb-0"><span class="display-5">48,71</span>/día</p>
                    </div>
                </div>
                <div class="text-start p-5">
                    <p><i class="fas fa-check text-success me-1" aria-hidden="true"></i> Horóscopo Diario</p>
                    <p><i class="fas fa-check text-success me-1" aria-hidden="true"></i> Acceso a Contenido Exclusivo</p>
                    <p><i class="fas fa-check text-success me-1" aria-hidden="true"></i> Notificaciones Personalizadas</p>
                    <a href="{{ route(\'index\') }}" role="button" class="btn btn-light rounded-pill py-2 px-5" aria-label="Elegir plan Diario">Elegir Plan</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.3s">
            <div class="plan-item bg-light rounded text-center">
                <div class="text-center text-primary border-bottom d-flex flex-column justify-content-center p-4" style="width: 100%; height: 160px;">
                    <p class="fs-2 fw-bold text-uppercase mb-0">Semanal</p>
                    <div class="d-flex justify-content-center">
                        <strong class="align-self-start">ARS</strong>
                        <p class="mb-0"><span class="display-5">341,00</span>/semana</p>
                    </div>
                </div>
                <div class="text-start p-5">
                    <p><i class="fas fa-check text-success me-1" aria-hidden="true"></i> Horóscopo Semanal</p>
                    <p><i class="fas fa-check text-success me-1" aria-hidden="true"></i> Acceso a Contenido Exclusivo</p>
                    <p><i class="fas fa-check text-success me-1" aria-hidden="true"></i> Notificaciones Personalizadas</p>
                    <a href="{{ route(\'index\') }}" role="button" class="btn btn-light rounded-pill py-2 px-5" aria-label="Elegir plan Semanal">Elegir Plan</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.5s">
            <div class="plan-item bg-light rounded text-center">
                <div class="text-center text-secondary border-bottom d-flex flex-column justify-content-center p-4" style="width: 100%; height: 160px;">
                    <p class="fs-2 fw-bold text-uppercase mb-0">Mensual</p>
                    <div class="d-flex justify-content-center">
                        <strong class="align-self-start">ARS</strong>
                        <p class="mb-0"><span class="display-5">1461,30</span>/mes</p>
                    </div>
                </div>
                <div class="text-start p-5">
                    <p><i class="fas fa-check text-success me-1" aria-hidden="true"></i> Horóscopo Mensual</p>
                    <p><i class="fas fa-check text-success me-1" aria-hidden="true"></i> Acceso a Contenido Exclusivo</p>
                    <p><i class="fas fa-check text-success me-1" aria-hidden="true"></i> Notificaciones Personalizadas</p>
                    <a href="{{ route(\'index\') }}" role="button" class="btn btn-light rounded-pill py-2 px-5" aria-label="Elegir plan Mensual">Elegir Plan</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div> --}}


    <div class="contact-us section" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact-us-content">
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="section-heading">
                                    <h2><em>Suscríbete</em> &amp; <span>Gestiona Tu Suscripción</span></h2>
                                    <div class="line-dec"></div>
                                    <p>Estamos encantados de que estés interesado en nuestras suscripciones de
                                        horóscopos. Aquí te mostramos cómo puedes suscribirte y gestionar tu suscripción
                                        para recibir horóscopos personalizados directamente en tu correo.</p>
                                </div>

                                <div class="main-button scroll-to-section"><a href="/landing">Ver Planes</a></div>

                                <div class="second-button"><a href="/landing">Suscríbete</a></div>
                                {{-- <form id="contact-form" action="" method="post">
                                <div class="row">

                                    <div class="col-lg-12">
                                        <fieldset>
                                            <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*"
                                                placeholder="Tu Correo Electrónico..." required>
                                        </fieldset>
                                    </div>

                                    <div class="col-lg-3">
                                        <fieldset>
                                            <button type="submit" id="form-submit"
                                                class="orange-button">Subscribirse</button>
                                        </fieldset>
                                    </div>
                                </div>
                            </form> --}}
                                {{-- <div class="more-info">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="info-item">
                                            <i class="fa fa-phone" aria-hidden="true"></i>
                                            <h4><a href="#">010-020-0340</a></h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="info-item">
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                            <h4><a href="#">info@horoscopos.com</a></h4>
                                            <h4><a href="#">support@horoscopos.com</a></h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="info-item">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <h4><a href="#">123 Calle del Zodiaco, Ciudad de los Astros, 45678,
                                                    País</a></h4>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
