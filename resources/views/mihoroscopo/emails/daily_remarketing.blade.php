<!DOCTYPE html>
<html lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Completa tu Suscripción</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
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
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #dee2e6;
        }
        .header {
            background-color: #5b03e4;
            color: #ffffff;
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
            color: #212529;
        }
        .content p {
            font-size: 18px;
            line-height: 1.6;
            color: #7a7a7a;
        }
        .cta {
            text-align: center;
            margin-top: 30px;
        }
        .cta a {
            background-color: #5b03e4;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
            border: 1px solid #c03afe;
        }
        .footer {
            background-color: #333333;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }
        .footer a {
            color: #c03afe;
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
                <h1>Hola, {{$content['name']}}!</h1>
                <p>Hemos notado que aún no has completado tu pago para activar tu suscripción al horóscopo diario.</p>
                <p>Si algo salió mal al procesar tu pago. Asegúrate de que el correo electrónico que intentas suscribir coincida con tu cuenta de Mercado Pago.</p>

                <div class="cta">
                    <a href="{{$content['payment_link']}}">Completar Pago</a>
                </div>
            </td>
        </tr>
        <tr>
            <td class="footer">
                <p>Recibes este mensaje porque has intentado suscribirte a nuestro servicio de horóscopo, pero aún no has completado el proceso de pago.</p>
                <p>&copy; {{date('Y')}} Tudex Networks. Todos los derechos reservados.</p>
            </td>
        </tr>
    </table>
</body>
</html>
