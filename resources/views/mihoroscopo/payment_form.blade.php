<form action="{{ route('payment.create') }}" method="POST">
    @csrf
    <input type="email" name="email" placeholder="Tu correo electrónico" required>
    <input type="text" name="description" placeholder="Descripción del pago" required>
    <input type="number" name="amount" placeholder="Monto" required>
    <button type="submit">Pagar con Mercado Pago</button>
</form>
