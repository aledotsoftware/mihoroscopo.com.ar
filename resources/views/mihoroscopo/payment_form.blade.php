<style>
    .required-indicator { color: #dc3545; margin-left: 2px; }
    label { display: block; margin-bottom: 8px; font-weight: bold; font-size: 14px; font-family: sans-serif; }
    input { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
    button { width: 100%; padding: 12px; background-color: #009ee3; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; }
    button:hover:not(:disabled) { background-color: #007db8; }
    button:disabled { opacity: 0.7; cursor: not-allowed; background-color: #999; }
    form { max-width: 400px; margin: 40px auto; font-family: sans-serif; }
</style>

<form action="{{ route('payment.create') }}" method="POST">
    @csrf
    <label for="email">Tu correo electrónico<span class="required-indicator" aria-hidden="true">*</span></label>
    <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" required aria-required="true" autocomplete="email" inputmode="email">

    <label for="description">Descripción del pago<span class="required-indicator" aria-hidden="true">*</span></label>
    <input type="text" id="description" name="description" placeholder="Ej: Suscripción mensual" required aria-required="true">

    <label for="amount">Monto<span class="required-indicator" aria-hidden="true">*</span></label>
    <input type="number" id="amount" name="amount" placeholder="Ej: 1500" required aria-required="true" inputmode="numeric">

    <button type="submit" id="paymentSubmitBtn">Pagar con Mercado Pago</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const submitBtn = document.getElementById('paymentSubmitBtn');
        if (submitBtn) {
            const form = submitBtn.closest('form');
            if (form) {
                form.addEventListener('submit', function() {
                    submitBtn.disabled = true;
                    submitBtn.setAttribute('aria-busy', 'true');
                    submitBtn.setAttribute('aria-live', 'polite');
                    submitBtn.textContent = 'Procesando...';
                });
            }
        }
    });
</script>
