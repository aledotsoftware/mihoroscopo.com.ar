@extends('mihoroscopo.layouts.app')

@section('title', 'Pago Exitoso')

@section('content')
<div class="container text-center" style="padding: 150px 0 100px;">
    <h1>¡Gracias por tu pago!</h1>
    <p class="mt-4 mb-4">Tu suscripción ha sido activada.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Volver al inicio</a>
</div>
@endsection