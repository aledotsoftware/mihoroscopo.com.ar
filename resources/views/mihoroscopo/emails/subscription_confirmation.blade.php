<!DOCTYPE html>
<html>
<head>
    <title>¡Gracias por suscribirte a Mi Horóscopo!</title>
</head>
<body>
    <h1>¡Gracias por suscribirte a Mi Horóscopo!</h1>
    <p>Nos alegra confirmarte que tu suscripción con ID <strong>{{ $subscription['id'] }}</strong> ha sido activada con éxito.</p>
    <p><strong>Aquí tienes los detalles de tu suscripción:</strong></p>
    <ul>
        <li><strong>Estado:</strong> {{ $subscription['status'] }}</li>
            <li><strong>Monto:</strong> {{ $subscription['last_charged_amount'] }} {{ $subscription['currency_id'] }}</li>
            <li><strong>Próximo pago programado para:</strong> {{ $subscription['next_payment_date'] }}</li>
    </ul>
    <p class="footer">Si tienes alguna pregunta o necesitas ayuda, no dudes en visitar nuestra <a href="https://mihoroscopo.com.ar/faq">sección de preguntas frecuentes</a>.</p>
</body>
</html>
