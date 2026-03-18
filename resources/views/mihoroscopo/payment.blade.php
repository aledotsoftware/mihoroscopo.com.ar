<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Token de Tarjeta</title>
    <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
    <style>
        .required-indicator { color: #dc3545; margin-left: 2px; }
    </style>
</head>
<body>
    <h1>Pago con Tarjeta</h1>
    <form id="paymentForm">
        <label for="cardNumber">Número de tarjeta:<span class="required-indicator" aria-hidden="true">*</span></label>
        <input type="text" id="cardNumber" name="cardNumber" required aria-required="true" autocomplete="cc-number" inputmode="numeric">
        
        <label for="expirationDate">Fecha de expiración:<span class="required-indicator" aria-hidden="true">*</span></label>
        <input type="text" id="expirationDate" name="expirationDate" required aria-required="true" autocomplete="cc-exp" inputmode="text">

        <label for="cardholderName">Nombre del titular:<span class="required-indicator" aria-hidden="true">*</span></label>
        <input type="text" id="cardholderName" name="cardholderName" required aria-required="true" autocomplete="cc-name" autocapitalize="words">

        <label for="cardToken">Token de tarjeta:</label>
        <input type="hidden" id="cardToken" name="cardToken">

        <button type="submit">Generar Token</button>
    </form>

    <script>
        const form = document.getElementById('paymentForm');
        const mp = new MercadoPago('{{ config('mercadopago.public_key') }}');
        // Reemplaza con tu clave pública

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const cardData = {
                cardNumber: document.getElementById('cardNumber').value,
                expirationDate: document.getElementById('expirationDate').value,
                cardholderName: document.getElementById('cardholderName').value,
                // Otros datos necesarios
            };

            // Generar el token de la tarjeta
            mp.createToken(cardData).then(response => {
                const cardToken = response.id;
                document.getElementById('cardToken').value = cardToken;
                form.submit(); // Ahora puedes enviar el formulario para la suscripción
            }).catch(error => {
                console.error('Error al generar el token', error);
            });
        });
    </script>
</body>
</html>
