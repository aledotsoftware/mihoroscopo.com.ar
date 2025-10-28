<!DOCTYPE html>
<html lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Suscripción al Horóscopo</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa; /* Color de fondo principal */
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff; /* Fondo de la caja principal */
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #dee2e6; /* Borde de la caja principal */
        }
        .header {
            background-color: #5b03e4; /* Color de fondo del encabezado */
            color: #ffffff; /* Color del texto en el encabezado */
            padding: 20px;
            text-align: center;
        }
        .header img {
            max-width: 150px;
        }
        .content {
            padding: 20px;
        }
        .content h1 {
            font-size: 24px;
            color: #212529; /* Color del texto del encabezado principal */
        }
        .content p {
            font-size: 18px;
            line-height: 1.6;
            color: #7a7a7a; /* Color del texto de los párrafos */
        }
        .horoscope {
            background-color: #f7f7f7; /* Color de fondo del horóscopo */
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            border: 1px solid #f3d7ff; /* Borde del horóscopo */
        }
        .horoscope h2 {
            color: #5b03e4; /* Color del encabezado del horóscopo */
            text-align: center;
            font-size: 22px;
        }
        .horoscope p {
            font-size: 18px;
            line-height: 1.6;
            color: #212529; /* Color del texto del horóscopo */
        }
        .cta {
            text-align: center;
            margin-top: 30px;
        }
        .cta a {
            background-color: #5b03e4; /* Color de fondo del botón CTA */
            color: #ffffff; /* Color del texto del botón CTA */
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
            border: 1px solid #c03afe; /* Borde del botón CTA */
        }
        .footer {
            background-color: #333333; /* Color de fondo del pie de página */
            color: #ffffff; /* Color del texto en el pie de página */
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }
        .footer a {
            color: #c03afe; /* Color del enlace en el pie de página */
            text-decoration: none;
        }
    </style>
</head>
<body>

    <table class="container">
    <tr>
        <td class="header">
            <img src="{{ route('logo', ['email' => $content['email_id']]) }}" alt="Logo">
        </td>
    </tr>
    <tr>
        <td class="content">
            <h1>Hola, Tu horóscopo de hoy está aquí!</h1>
            <p>Aquí está tu horóscopo para hoy {{ $content['date'] }}</p>
            <div class="horoscope">
                <h2>Horóscopo {{ $content['zodiac_sign'] }}</h2>
                <p>{{ $content['content_horoscope'] }}</p>
            </div>
        </td>
    </tr>
    @if ($content['subscription_payment_type'] == 'gaia')
    <tr>
        <td class="content">
            <h1>Actualiza tu Suscripción</h1>
            <p>Para acceder al contenido premium, por favor actualiza tu suscripción:</p>
            <div class="cta">
                <a href="{{ $content['upgrade_link'] }}">Actualizar Ahora</a>
                <br>
            </div>
        </td>
    </tr>
    @else
    @if (!empty($content['content_astral_guide']) || !empty($content['content_daily_astro_advice']) || !empty($content['content_love_prediction']) || !empty($content['content_love_ritual']) || !empty($content['content_lunar_ritual']) || !empty($content['content_prosperity_ritual']) || !empty($content['content_zodiac_compatibility']))
    <tr>
        <td class="content">
            <h1>Contenido Exclusivo</h1>
            <p>¡Aquí tienes más contenido exclusivo para los suscriptores premium!</p>
        </td>
    </tr>
    @endif
      @if (!empty($content['content_astral_guide']))
        <tr>
            <td class="content">
                <h2>Guía Astral</h2>
                <div class="horoscope">
                    <p>{{ \Illuminate\Support\Str::limit($content['content_astral_guide'], 50) }}... <a href="{{ $content['upgrade_link'] }}">Suscríbete a la opción premium para leer más</a></p>
                </div>
            </td>
        </tr>
        @endif
        @if (!empty($content['content_daily_astro_advice']))
        <tr>
            <td class="content">
                <h2>Consejo Diario</h2>
                <div class="horoscope">
                    <p>{{ \Illuminate\Support\Str::limit($content['content_daily_astro_advice'], 50) }}... <a href="{{ $content['upgrade_link'] }}">Suscríbete a la opción premium para leer más</a></p>
                </div>
            </td>
        </tr>
        @endif
        @if (!empty($content['content_love_prediction']))
        <tr>
            <td class="content">
                <h2>Amor</h2>
                <div class="horoscope">
                    <p>{{ \Illuminate\Support\Str::limit($content['content_love_prediction'], 50) }}... <a href="{{ $content['upgrade_link'] }}">Suscríbete a la opción premium para leer más</a></p>
                </div>
            </td>
        </tr>
        @endif
        @if (!empty($content['content_love_ritual']))
        <tr>
            <td class="content">
                <h2>Ritual del Amor</h2>
                <div class="horoscope">
                    <p>{{ \Illuminate\Support\Str::limit($content['content_love_ritual'], 50) }}... <a href="{{ $content['upgrade_link'] }}">Suscríbete a la opción premium para leer más</a></p>
                </div>
            </td>
        </tr>
        @endif
        @if (!empty($content['content_lunar_ritual']))
        <tr>
            <td class="content">
                <h2>Ritual Lunar</h2>
                <div class="horoscope">
                    <p>{{ \Illuminate\Support\Str::limit($content['content_lunar_ritual'], 50) }}... <a href="{{ $content['upgrade_link'] }}">Suscríbete a la opción premium para leer más</a></p>
                </div>
            </td>
        </tr>
        @endif
        @if (!empty($content['content_prosperity_ritual']))
        <tr>
            <td class="content">
                <h2>Ritual de Prosperidad</h2>
                <div class="horoscope">
                    <p>{{ \Illuminate\Support\Str::limit($content['content_prosperity_ritual'], 50) }}... <a href="{{ $content['upgrade_link'] }}">Suscríbete a la opción premium para leer más</a></p>
                </div>
            </td>
        </tr>
        @endif
        @if (!empty($content['content_zodiac_compatibility']))
        <tr>
            <td class="content">
                <h2>Compatibilidad Zodiacal</h2>
                <div class="horoscope">
                    <p>{{ \Illuminate\Support\Str::limit($content['content_zodiac_compatibility'], 50) }}... <a href="{{ $content['upgrade_link'] }}">Suscríbete a la opción premium para leer más</a></p>
                </div>
            </td>
        </tr>
        @endif
    @endif
    <tr>
        <td class="footer">
            <p>Gracias por suscribirte a nuestro horóscopo diario.</p>
            <p>
                <a href="{{ $content['unsubscribe_link'] }}">Darse de baja</a> |
                <a href="{{ $content['preferences_link'] }}">Gestionar Preferencias</a>
            </p>
            <p>&copy; {{ date('Y') }} Tudex Networks. Todos los derechos reservados.</p>
        </td>
    </tr>
</table>


</body>
</html>
