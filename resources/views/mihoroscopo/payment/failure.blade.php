@extends('mihoroscopo.layouts.app')

@section('title', 'Pago Fallido')

@section('content')
<div class="container text-center" style="padding: 150px 0 100px;">
    <h1>El pago ha fallado</h1>
    <p class="mt-4 mb-4">Por favor, intenta nuevamente.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Volver al inicio</a>
</div>
@endsection