<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suscripción</title>
    <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
    <style>
        .required-indicator { color: #dc3545; margin-left: 2px; }
    </style>
</head>
<body>
    <h1>Suscripción al Servicio</h1>
    <form id="subscriptionForm">
        <label for="email">Correo electrónico:<span class="required-indicator" aria-hidden="true">*</span></label>
        <input type="email" id="email" name="email" required aria-required="true" autocomplete="email" inputmode="email">

        <label for="cardToken">Token de tarjeta:</label>
        <input type="hidden" id="cardToken" name="card_token_id">

        <button type="submit">Suscribirse</button>
    </form>

    <script>
        const form = document.getElementById('subscriptionForm');
        const mp = new MercadoPago('{{ config('mercadopago.public_key') }}');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const email = document.getElementById('email').value;
            const cardToken = document.getElementById('cardToken').value;

            if (!cardToken) {
                alert('Token de tarjeta no generado');
                return;
            }

            const response = await fetch('/create-subscription', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    payer_email: email,
                    card_token_id: cardToken,
                    preapproval_plan_id: 'YOUR_PREAPPROVAL_PLAN_ID' // Reemplaza con tu plan
                })
            });

            const result = await response.json();

            if (result.status === 'authorized') {
                alert('Suscripción creada exitosamente');
            } else {
                alert('Error al crear la suscripción');
            }
        });

        // Código para generar el token de la tarjeta con MercadoPago
        // Asegúrate de configurar el token en el backend
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</body>
</html>


