@extends('mihoroscopo.layouts.app')

@section('title', 'Pago Pendiente')

@section('content')
<div class="container text-center" style="padding: 150px 0 100px;">
    <h1>Tu pago está en espera</h1>
    <p class="mt-4 mb-4">Estamos esperando la confirmación del pago.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Volver al inicio</a>
</div>
@endsection