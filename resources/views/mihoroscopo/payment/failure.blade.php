@extends('mihoroscopo.layouts.app')
@section('title', 'Pago Fallido')
@section('content')
<div class="happy-clients section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="naccs">
                    <div class="tabs">
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="nacc">
                                    <li class="active">
                                        <div>
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <h1>El pago ha fallado</h1>
                                                    <div class="line-dec"></div>
                                                    <p>Por favor, intenta nuevamente.</p>
                                                    <a href="/landing">Volver a intentar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
