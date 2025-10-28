@extends('mihoroscopo.layouts.app')

@section('title', $article->title)
@section('description', $article->description)
@section('keywords', $article->keywords)
@section('content')
    <div class="happy-clients section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="naccs">
                        <div class="tabs">
                            <div class="row">
                                <div class="col-lg-12">
                                    <ul class="nacc">
                                        <li class="active">
                                            <div>
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                        <h1>{{ $article->title }}</h1>
                                                        <div class="line-dec"></div>
                                                        <p> {!! $article->content !!}</p>
                                                    </div>
                                                    <div class="col-lg-5 align-self-center">
                                                        <div class="caption header-text">
                                                            <h6>Conecta con tu Destino</h6>
                                                            <div class="line-dec"></div>
                                                            <h4>Descubre tu <em>Horóscopo Diario</em> y <span>Guía
                                                                    Astrológica Gratis</span></h4>
                                                            <p>Recibe tu horóscopo personalizado cada día y descubre lo que
                                                                el universo tiene reservado para
                                                                ti.
                                                                Ofrecemos opciones de suscripción diaria, semanal o mensual
                                                                para que no te pierdas ninguna
                                                                revelación importante.
                                                                Explora nuestras opciones y encuentra la que mejor se adapte
                                                                a ti.</p>
                                                            <div class="main-button scroll-to-section"><a
                                                                    href="/landing">Ver Planes</a></div>
                                                            <span>o</span>
                                                            <div class="second-button"><a href="/landing">Suscríbete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
